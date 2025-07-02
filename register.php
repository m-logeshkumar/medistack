<?php
session_start();  // Start the session
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        $_SESSION['id'] = $stmt->insert_id;  // Store `id` from `users` table in session
        $_SESSION['email'] = $email;  // Store email in session

        if ($role === 'doctor') {
            echo "Registration successful! <a href='login.html'>Login here</a>";
        } else if ($role === 'patient') {
            // Redirect to patient details page without exposing details in the URL
            header("Location: patient_details.php");
            exit();
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

