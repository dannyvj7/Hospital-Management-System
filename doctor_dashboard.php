<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();
check_role('doctor');

// Safe session variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'doctor';

// Fetch doctor's name
$user_name = 'Doctor';
if ($user_id) {
    $result = mysqli_query($conn, "SELECT name FROM users WHERE id='$user_id'");
    $user = mysqli_fetch_assoc($result);
    if ($user && isset($user['name'])) {
        $user_name = $user['name'];
    }
}

// Get doctor table ID
$doctor_res = mysqli_query($conn, "SELECT id FROM doctors WHERE user_id='$user_id' LIMIT 1");
$doctor_row = mysqli_fetch_assoc($doctor_res);
$doctor_id = $doctor_row ? $doctor_row['id'] : 0;

// Fetch doctor's appointments
$query = "
    SELECT a.id, u.name AS patient, a.appointment_date, a.status
    FROM appointments a
    JOIN patients p ON a.patient_id = p.id
    JOIN users u ON p.user_id = u.id
    WHERE a.doctor_id = '$doctor_id'
    ORDER BY a.appointment_date ASC
";
$appointments = mysqli_query($conn, $query);
if (!$appointments) die("Error fetching appointments: " . mysqli_error($conn));

// Summary counts
$total_appointments = mysqli_num_rows($appointments);
$pending_appointments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id='$doctor_id' AND status='pending'"));
$completed_appointments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id='$doctor_id' AND status='completed'"));

// Complete appointment
if (isset($_GET['complete'])) {
    $id = intval($_GET['complete']);
    mysqli_query($conn, "
        UPDATE appointments
        SET status='completed'
        WHERE id='$id' AND doctor_id='$doctor_id' AND status='approved'
    ");
    header("Location: doctor_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard - HMS</title>
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
    <div class="dashboard-header">
        <div class="welcome">
            <h2><i class="fa-solid fa-user-doctor"></i> Welcome Dr. <?php echo htmlspecialchars($user_name); ?></h2>
            <p>Role: <?php echo ucfirst(htmlspecialchars($role)); ?></p>
        </div>
        <div class="logout">
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <h3><i class="fa-solid fa-calendar-check"></i> Upcoming Appointments</h3>

    <div class="dashboard-summary">
        <div class="summary-card total">
            <h3><i class="fa-solid fa-calendar-days"></i> Total Appointments</h3>
            <p><?php echo $total_appointments; ?></p>
        </div>
        <div class="summary-card pending">
            <h3><i class="fa-solid fa-hourglass-half"></i> Pending</h3>
            <p><?php echo $pending_appointments; ?></p>
        </div>
        <div class="summary-card completed">
            <h3><i class="fa-solid fa-check-circle"></i> Completed</h3>
            <p><?php echo $completed_appointments; ?></p>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
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
                        <td>{$row['appointment_date']}</td>
                        <td class='{$status_class}'>" . htmlspecialchars($row['status']) . "</td>
                        <td>";
                    if ($row['status'] == 'approved') {
                        echo "<a href='doctor_dashboard.php?complete={$row['id']}' class='edit-btn'><i class='fa-solid fa-check-double'></i> Complete</a>";
                    } else {
                        echo "-";
                    }
                    echo "</td></tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='5'>No appointments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="back-link">
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>
</body>
</html>




<!-- ✅ Features Added

Doctor Dashboard

View only their appointments

Complete approved appointments

Patient Dashboard

View only their appointments

Book new appointments

Role-based Access Control

Admin, doctor, and patient can only access pages meant for their role.

Clean, professional UI using CSS + Font Awesome.

💡 Defense Tip

“Each dashboard shows relevant information based on the user’s role. Doctors see their appointments and can mark them completed. Patients see their appointments and can book new ones. This role-based approach ensures security, data integrity, and a clear workflow.” -->