<?php
session_start();
include('db.php');

// Check if user is logged in and is a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header('Location: login.html');
    exit();
}

// Fetch prescriptions for the logged-in user
$sql = "SELECT prescriptions.*, users.name AS doctor_name FROM prescriptions 
        INNER JOIN users ON prescriptions.doctor_id = users.id 
        WHERE prescriptions.patient_id = '{$_SESSION['user_id']}'";
$result = $conn->query($sql);

// Check if there are any prescriptions
if ($result->num_rows > 0) {
    echo "<h1>Your prescriptions</h1>";
    echo "<br>";
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>Doctor</th>
                <th>Medication</th>
                <th>Dosage</th>
                <th>Instructions</th>
                <th>Prescribed On</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['doctor_name'] . "</td>
                <td>" . $row['medication'] . "</td>
                <td>" . $row['dosage'] . "</td>
                <td>" . $row['instructions'] . "</td>
                <td>" . $row['date_issued'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No prescriptions found.";
}
?>

<a href="patient_dashboard.php">Back to Dashboard</a>
<style>
/* General body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 20px;
    text-align: center;
}

/* Container styling */
.container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Title styling */
h1 {
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ccc;
}

th {
    background-color: #4CAF50;
    color: white;
}

/* Alternate row colors */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Link styling */
a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: 0.3s;
}

a:hover {
    background-color: #0056b3;
}
</style>
