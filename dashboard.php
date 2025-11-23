<?php
include 'includes/auth.php';
include 'includes/db.php';

// Protect page: only admin can access
check_login();
check_role('admin');

// Fetch total patients
$patient_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_patients FROM patients"))['total_patients'];

// Fetch total doctors
$doctor_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_doctors FROM doctors"))['total_doctors'];

// Fetch total appointments
$appointment_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_appointments FROM appointments"))['total_appointments'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* NEW ADMIN DASHBOARD LAYOUT */

.layout {
  display: flex;
  width: 100%;
  min-height: 100vh;
  background: #f4f6f9;
}


/* SIDEBAR */
.sidebar {
  width: 260px;
  background: #009879;
  color: #fff;
  padding: 20px 0;
  position: fixed;
  left: 0;
  top: 0;
  height: 100vh;
}

.sidebar-header {
  text-align: center;
  margin-bottom: 40px;
}

.sidebar-header i {
  font-size: 50px;
  margin-bottom: 10px;
}

.sidebar-header h2 {
  font-size: 22px;
  font-weight: bold;
}

.sidebar-menu {
  list-style: none;
  padding-left: 0;
}

.sidebar-menu li {
  margin: 8px 0;
}

.sidebar-menu a {
  display: block;
  padding: 12px 25px;
  color: #fff;
  font-size: 16px;
  transition: 0.3s;
  text-decoration: none;
}

.sidebar-menu a:hover,
.sidebar-menu .active a {
  background: rgba(255, 255, 255, 0.2);
}

/* LOGOUT BUTTON */
.logout-btn a {
  margin-top: 30px;
  background: #dc3545;
}

.logout-btn a:hover {
  background: #b52a36;
}

/* MAIN CONTENT */
.main-content {
  margin-left: 260px;
  padding: 30px;
  width: calc(100% - 260px);
}

.page-title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 30px;
}

/* DASHBOARD STAT CARDS */
.dashboard-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
}

.stat-card {
  display: flex;
  align-items: center;
  padding: 20px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: 0.3s;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card .icon {
  font-size: 40px;
  margin-right: 15px;
  color: #009879;
}

.stat-card .info h3 {
  font-size: 18px;
  margin-bottom: 5px;
}

.stat-card .info p {
  font-size: 24px;
  font-weight: bold;
}

    </style>
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-hospital"></i>
            <h2>HMS Admin</h2>
        </div>

        <ul class="sidebar-menu">
            <li class="active">
                <a href="dashboard.php">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="manage_patients.php">
                    <i class="fa-solid fa-users"></i> Manage Patients
                </a>
            </li>

            <li>
                <a href="manage_doctors.php">
                    <i class="fa-solid fa-user-doctor"></i> Manage Doctors
                </a>
            </li>

            <li>
                <a href="appointments.php">
                    <i class="fa-solid fa-calendar-days"></i> View Appointments
                </a>
            </li>

            <li class="logout-btn">
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1 class="page-title"><i class="fa-solid fa-gauge-high"></i> Admin Dashboard</h1>

        <div class="dashboard-stats">

            <div class="stat-card">
                <div class="icon"><i class="fa-solid fa-user-injured"></i></div>
                <div class="info">
                    <h3>Total Patients</h3>
                    <p><?php echo $patient_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon"><i class="fa-solid fa-user-doctor"></i></div>
                <div class="info">
                    <h3>Total Doctors</h3>
                    <p><?php echo $doctor_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="info">
                    <h3>Total Appointments</h3>
                    <p><?php echo $appointment_count; ?></p>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
