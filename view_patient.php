<?php
session_start();
include 'db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Check if the patient_id is provided in the URL
if (!isset($_GET['patient_id'])) {
    die("Error: No patient selected.");
}

$patient_user_id = $_GET['patient_id']; // Since patient_id is actually user_id

// Fetch patient details
$stmt = $conn->prepare("SELECT p.id, p.email, p.phone, p.age, p.gender, p.medical_history, u.name AS patient_name 
                        FROM patients p
                        INNER JOIN users u ON p.user_id = u.id
                        WHERE p.user_id = ?");
$stmt->bind_param("i", $patient_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Patient not found.");
}

$patient = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Patient Details</h2>
    <table>
        <tr><th>Name:</th><td><?php echo htmlspecialchars($patient['patient_name']); ?></td></tr>
        <tr><th>Email:</th><td><?php echo htmlspecialchars($patient['email']); ?></td></tr>
        <tr><th>Phone:</th><td><?php echo htmlspecialchars($patient['phone']); ?></td></tr>
        <tr><th>Age:</th><td><?php echo htmlspecialchars($patient['age']); ?></td></tr>
        <tr><th>Gender:</th><td><?php echo htmlspecialchars($patient['gender']); ?></td></tr>
        <tr><th>Medical History:</th><td><?php echo nl2br(htmlspecialchars($patient['medical_history'])); ?></td></tr>
    </table>
    <a href="view_patients.php">Back to Patient List</a>
</div>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    width: 50%;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    padding: 10px;
    border: 1px solid #ccc;
}
table th {
    background-color: #f4f7fa;
}
a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #4CAF50;
    font-weight: bold;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
}
</style>

</body>
</html>

