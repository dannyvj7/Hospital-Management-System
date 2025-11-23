<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();
check_role('patient');

// Safe session variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'patient';

// Fetch patient's name
$user_name = 'Patient';
if ($user_id) {
    $result = mysqli_query($conn, "SELECT name FROM users WHERE id='$user_id'");
    $user = mysqli_fetch_assoc($result);
    if ($user && isset($user['name'])) {
        $user_name = $user['name'];
    }
}

// Get patient table ID
$patient_res = mysqli_query($conn, "SELECT id FROM patients WHERE user_id='$user_id' LIMIT 1");
$patient_row = mysqli_fetch_assoc($patient_res);
$patient_id = $patient_row ? $patient_row['id'] : 0;

// Fetch patient's appointments
$query = "
    SELECT a.id, u.name AS doctor, a.appointment_date, a.status
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.id
    JOIN users u ON d.user_id = u.id
    WHERE a.patient_id = '$patient_id'
    ORDER BY a.appointment_date ASC
";
$appointments = mysqli_query($conn, $query);
if (!$appointments) die("Error fetching appointments: " . mysqli_error($conn));

// Summary counts
$total_appointments = mysqli_num_rows($appointments);
$pending_appointments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE patient_id='$patient_id' AND status='pending'"));
$completed_appointments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments WHERE patient_id='$patient_id' AND status='completed'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-pending { color: orange; font-weight: bold; }
        .status-approved { color: blue; font-weight: bold; }
        .status-completed { color: green; font-weight: bold; }
    </style>
</head>
<body>
<div class="page-container">
    <div class="dashboard-header">
        <div class="welcome">
            <h2><i class="fa-solid fa-user"></i> Welcome <?php echo htmlspecialchars($user_name); ?></h2>
            <p>Role: <?php echo ucfirst(htmlspecialchars($role)); ?></p>
        </div>
        <div class="logout">
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <h3><i class="fa-solid fa-calendar-check"></i> Your Appointments</h3>

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
                <th>Doctor</th>
                <th>Date & Time</th>
                <th>Status</th>
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
                        <td>" . htmlspecialchars($row['doctor']) . "</td>
                        <td>{$row['appointment_date']}</td>
                        <td class='{$status_class}'>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='4'>No appointments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="back-link">
        <a href="appointments.php"><i class="fa-solid fa-calendar-plus"></i> Book New Appointment</a> |
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>
</body>
</html>
