<?php
// Include database connection
include('db.php');

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Store user session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name']; // Store the user's name
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'doctor') {
            header('Location: doctor_dashboard.php');
            exit();
        } else if ($user['role'] == 'patient') {
            header('Location: patient_dashboard.php');
            exit();
        }
    } else {
        echo "<script>
                alert('Invalid email or password. Please try again.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
}
?>

