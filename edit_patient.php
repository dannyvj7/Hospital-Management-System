<?php
include 'includes/auth.php';
include 'includes/db.php';

check_login();
check_role('admin');

// Get patient ID
if (!isset($_GET['id'])) {
    header("Location: manage_patients.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch patient info
$query = "
    SELECT u.id, u.name, u.email, p.age, p.gender, p.phone, p.address
    FROM users u
    JOIN patients p ON u.id = p.user_id
    WHERE u.id = '$id'
";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    die("Patient not found!");
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update_user = "UPDATE users SET name='$name', email='$email' WHERE id='$id'";
    $update_patient = "UPDATE patients SET age='$age', gender='$gender', phone='$phone', address='$address' WHERE user_id='$id'";

    if (mysqli_query($conn, $update_user) && mysqli_query($conn, $update_patient)) {
        $success = "Patient information updated successfully.";
        // Refresh data
        $result = mysqli_query($conn, $query);
        $patient = mysqli_fetch_assoc($result);
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Patient - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Patient</h2>
        <?php
            if (isset($success)) echo "<p class='success'>$success</p>";
            if (isset($error)) echo "<p class='error'>$error</p>";
        ?>
        <form method="POST">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" value="<?php echo $patient['name']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" value="<?php echo $patient['email']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-calendar"></i>
                <input type="number" name="age" value="<?php echo $patient['age']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-venus-mars"></i>
                <select name="gender" required>
                    <option value="Male" <?php if($patient['gender']=='Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($patient['gender']=='Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if($patient['gender']=='Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="phone" value="<?php echo $patient['phone']; ?>" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-location-dot"></i>
                <textarea name="address" required><?php echo $patient['address']; ?></textarea>
            </div>
            <button type="submit" name="update"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

        <p class="back-link">
            <a href="manage_patients.php"><i class="fa-solid fa-arrow-left"></i> Back to Manage Patients</a>
        </p>
    </div>
</body>
</html>
