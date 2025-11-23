<?php
include 'includes/db.php';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Insert user
    $user_sql = "INSERT INTO users (name, email, password, role) 
                 VALUES ('$name','$email','$password','patient')";

    if (mysqli_query($conn, $user_sql)) {
        $user_id = mysqli_insert_id($conn);

        // Insert patient info
        $patient_sql = "INSERT INTO patients (user_id, age, gender, phone, address) 
                        VALUES ('$user_id','$age','$gender','$phone','$address')";
        mysqli_query($conn, $patient_sql);

        $success = "Registration successful! <a href='index.php'>Login now</a>";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration - HMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <h2><i class="fa-solid fa-user-plus"></i> Patient Registration</h2>
        <form method="POST" class="register-form">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-calendar"></i>
                <input type="number" name="age" placeholder="Age" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-venus-mars"></i>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-location-dot"></i>
                <textarea name="address" placeholder="Address" required></textarea>
            </div>
            <button type="submit" name="register">Register</button>
        </form>
        <?php
            if (isset($error)) echo "<p class='error'>$error</p>";
            if (isset($success)) echo "<p class='success'>$success</p>";
        ?>
        <p class="login-link">Already have an account? <a href="index.php">Login here</a></p>
    </div>
</body>
</html>
