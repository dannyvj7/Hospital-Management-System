<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();

// Safe session variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

$appointments = null;

// ========================
// Handle booking (patients only)
// ========================
if ($role == 'patient' && isset($_POST['book'])) {
    $doctor_user_id = intval($_POST['doctor_id']); // selected from dropdown
    $date = mysqli_real_escape_string($conn, $_POST['appointment_date']);

    if ($doctor_user_id && $date) {
        if (strtotime($date) < time()) {
            $error = "Appointment date must be in the future.";
        } else {
            // Get patient table ID
            $patient_res = mysqli_query($conn, "SELECT id FROM patients WHERE user_id='$user_id' LIMIT 1");
            $patient_row = mysqli_fetch_assoc($patient_res);
            $patient_id = $patient_row ? $patient_row['id'] : null;

            // Get doctor table ID
            $doctor_res = mysqli_query($conn, "SELECT id FROM doctors WHERE user_id='$doctor_user_id' LIMIT 1");
            $doctor_row = mysqli_fetch_assoc($doctor_res);
            $doctor_id = $doctor_row ? $doctor_row['id'] : null;

            if (!$patient_id) {
                $error = "Error: Patient record not found. Please contact admin.";
            } elseif (!$doctor_id) {
                $error = "Error: Doctor record not found.";
            } else {
                // Insert appointment safely
                $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $patient_id, $doctor_id, $date);

                if ($stmt->execute()) {
                    $success = "Appointment booked successfully!";
                } else {
                    $error = "Error booking appointment: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    } else {
        $error = "Please select a doctor and date/time.";
    }
}

// ========================
// Function to fetch appointments based on role
// ========================
function fetchAppointments($conn, $role, $user_id) {
    if ($role == 'admin') {
        $query = "
            SELECT a.id, pu.name AS patient, du.name AS doctor, a.appointment_date, a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN users pu ON p.user_id = pu.id
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users du ON d.user_id = du.id
            ORDER BY a.appointment_date DESC
        ";
    } elseif ($role == 'doctor') {
        // Get doctor table ID
        $doctor_res = mysqli_query($conn, "SELECT id FROM doctors WHERE user_id='$user_id' LIMIT 1");
        $doctor = mysqli_fetch_assoc($doctor_res);
        $doctor_id = $doctor ? $doctor['id'] : 0;

        $query = "
            SELECT a.id, pu.name AS patient, du.name AS doctor, a.appointment_date, a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN users pu ON p.user_id = pu.id
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users du ON d.user_id = du.id
            WHERE a.doctor_id='$doctor_id'
            ORDER BY a.appointment_date DESC
        ";
    } elseif ($role == 'patient') {
        // Get patient table ID
        $patient_res = mysqli_query($conn, "SELECT id FROM patients WHERE user_id='$user_id' LIMIT 1");
        $patient = mysqli_fetch_assoc($patient_res);
        $patient_id = $patient ? $patient['id'] : 0;

        $query = "
            SELECT a.id, pu.name AS patient, du.name AS doctor, a.appointment_date, a.status
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN users pu ON p.user_id = pu.id
            JOIN doctors d ON a.doctor_id = d.id
            JOIN users du ON d.user_id = du.id
            WHERE a.patient_id='$patient_id'
            ORDER BY a.appointment_date DESC
        ";
    } else {
        return null;
    }

    $result = mysqli_query($conn, $query);
    if (!$result) die("Error fetching appointments: " . mysqli_error($conn));
    return $result;
}

// ========================
// Fetch current appointments
// ========================
$appointments = fetchAppointments($conn, $role, $user_id);

// ========================
// Admin approve
// ========================
if ($role == 'admin' && isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    mysqli_query($conn, "UPDATE appointments SET status='approved' WHERE id='$id' AND status='pending'");
    header("Location: appointments.php");
    exit();
}

// ========================
// Doctor complete
// ========================
if ($role == 'doctor' && isset($_GET['complete'])) {
    $id = intval($_GET['complete']);
    mysqli_query($conn, "
        UPDATE appointments 
        SET status='completed' 
        WHERE id='$id' 
        AND status='approved' 
        AND doctor_id = (SELECT id FROM doctors WHERE user_id='$user_id' LIMIT 1)
    ");
    header("Location: appointments.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-pending { color: orange; font-weight: bold; }
        .status-approved { color: blue; font-weight: bold; }
        .status-completed { color: green; font-weight: bold; }
        .edit-btn { text-decoration: none; padding: 4px 8px; background: #007BFF; color: #fff; border-radius: 4px; }
        .edit-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="page-container">
    <h2><i class="fa-solid fa-calendar-check"></i> Appointments</h2>

    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <?php if ($role == 'patient'): ?>
    <div class="form-container">
        <h3><i class="fa-solid fa-plus"></i> Book Appointment</h3>
        <form method="POST" class="register-form">
            <div class="input-group">
                <i class="fa-solid fa-user-doctor"></i>
                <select name="doctor_id" required>
                    <option value="">Select Doctor</option>
                    <?php
                    $doctors = mysqli_query($conn, "
                        SELECT d.user_id, u.name, d.specialization 
                        FROM doctors d
                        JOIN users u ON d.user_id = u.id
                        ORDER BY u.name ASC
                    ");
                    if (mysqli_num_rows($doctors) > 0) {
                        while ($doc = mysqli_fetch_assoc($doctors)) {
                            echo "<option value='" . htmlspecialchars($doc['user_id']) . "'>" . htmlspecialchars($doc['name']) . " (" . htmlspecialchars($doc['specialization']) . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No doctors available</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-calendar-days"></i>
                <input type="datetime-local" name="appointment_date" required>
            </div>
            <button type="submit" name="book"><i class="fa-solid fa-calendar-plus"></i> Book</button>
        </form>
    </div>
    <?php endif; ?>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date & Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($appointments && mysqli_num_rows($appointments) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($appointments)) {
                    $status_class = 'status-' . strtolower($row['status']);
                    echo "<tr>
                        <td>{$sn}</td>
                        <td>" . htmlspecialchars($row['patient']) . "</td>
                        <td>" . htmlspecialchars($row['doctor']) . "</td>
                        <td>{$row['appointment_date']}</td>
                        <td class='{$status_class}'>" . htmlspecialchars($row['status']) . "</td>
                        <td>";
                    if ($role == 'admin' && $row['status'] == 'pending') {
                        echo "<a href='appointments.php?approve={$row['id']}' class='edit-btn'><i class='fa-solid fa-check'></i> Approve</a>";
                    } elseif ($role == 'doctor' && $row['status'] == 'approved') {
                        echo "<a href='appointments.php?complete={$row['id']}' class='edit-btn'><i class='fa-solid fa-check-double'></i> Complete</a>";
                    } else {
                        echo "-";
                    }
                    echo "</td></tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='6'>No appointments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="back-link">
        <a href="<?php echo $role == 'admin' ? 'dashboard.php' : ($role == 'doctor' ? 'doctor_dashboard.php' : 'patient_dashboard.php'); ?>">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
</div>
</body>
</html>
