<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();
check_role('admin');

// Delete patient
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Delete from patients first due to foreign key
    mysqli_query($conn, "DELETE FROM patients WHERE user_id='$id'");
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    $msg = "Patient deleted successfully.";
}

// Search patients
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $patients = mysqli_query($conn, "
        SELECT u.id, u.name, u.email, p.age, p.gender, p.phone, p.address
        FROM users u
        JOIN patients p ON u.id = p.user_id
        WHERE u.name LIKE '%$search%' OR u.email LIKE '%$search%'
    ");
} else {
    $patients = mysqli_query($conn, "
        SELECT u.id, u.name, u.email, p.age, p.gender, p.phone, p.address
        FROM users u
        JOIN patients p ON u.id = p.user_id
        ORDER BY u.id DESC
    ");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Patients - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="page-container">
        <h2><i class="fa-solid fa-users"></i> Manage Patients</h2>

        <?php if (isset($msg)) echo "<p class='success'>$msg</p>"; ?>

        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search patient by name or email..." value="<?php echo $search; ?>">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
            <a href="manage_patients.php" class="reset-btn"><i class="fa-solid fa-rotate-left"></i> Reset</a>
        </form>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sn = 1;
                if (mysqli_num_rows($patients) > 0) {
                    while ($row = mysqli_fetch_assoc($patients)) {
                        echo "<tr>
                            <td>{$sn}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['address']}</td>
                            <td>
                                <a href='edit_patient.php?id={$row['id']}' class='edit-btn'><i class='fa-solid fa-pen'></i></a>
                                <a href='manage_patients.php?delete={$row['id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this patient?\")'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No patients found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="back-link">
            <a href="dashboard.php"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
