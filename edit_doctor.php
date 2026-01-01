<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();
check_role('admin');

// Get doctor ID
if (!isset($_GET['id'])) {
    header("Location: manage_doctors.php");
    exit();

}

$id = intval($_GET['id']);

// Fetch doctor info
$query = "
    SELECT u.id, u.name, u.email, d.specialization, d.phone
    FROM users u
    JOIN doctors d ON u.id = d.user_id
    WHERE u.id = '$id'
";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    die("Doctor not found!");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);

    $update_user = "UPDATE users SET name='$name', email='$email' WHERE id='$id'";
    $update_doctor = "UPDATE doctors SET phone='$phone', specialization='$specialization' WHERE user_id='$id'";

    if (mysqli_query($conn, $update_user) && mysqli_query($conn, $update_doctor)) {
        $success = "Doctor information updated successfully.";
        // Refresh data
        $result = mysqli_query($conn, $query);
        $doctor = mysqli_fetch_assoc($result);
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Doctor - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Doctor</h2>
        <?php
            if (isset($success)) echo "<p class='success'>$success</p>";
            if (isset($error)) echo "<p class='error'>$error</p>";
        ?>
        <form method="POST">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" value="<?php echo $doctor['name']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" value="<?php echo $doctor['email']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="phone" value="<?php echo $doctor['phone']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-stethoscope"></i>
                <input type="text" name="specialization" value="<?php echo $doctor['specialization']; ?>" required>
            </div>
            <button type="submit" name="update"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

        <p class="back-link">
            <a href="manage_doctors.php"><i class="fa-solid fa-arrow-left"></i> Back to Manage Doctors</a>
        </p>
    </div>
</body>
</html>
