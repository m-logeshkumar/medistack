<?php
session_start();
include('db.php');

// Ensure the user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header('Location: login.html');
    exit();
}

// Get the doctor's ID from the session
$doctor_id = $_SESSION['user_id'];

// Fetch only name and email of the patients assigned to this doctor
$sql = "SELECT u.id, u.name, u.email
        FROM users u
        JOIN appointments a ON u.id = a.patient_id
        WHERE a.doctor_id = '$doctor_id'
        GROUP BY u.id"; // Group by patient ID to avoid duplicate entries

// Execute the query and check if it returns false (i.e., an error)
$patients = $conn->query($sql);

if (!$patients) {
    // If the query failed, print the error message
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Patients Assigned to You</h2>

    <?php if ($patients->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>View Details</th>
                </tr>
            <tbody>
                <?php while ($patient = $patients->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $patient['name']; ?></td>
                        <td><?php echo $patient['email']; ?></td>
                        <td><a href="view_patient.php?patient_id=<?php echo $patient['id']; ?>">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No patients are currently assigned to you.</p>
    <?php endif; ?>
</div>
<style>
    /* General body styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
}

/* Container for content */
.container {
    width: 80%;
    margin: 30px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ccc;
}

table th {
    background-color: #f4f7fa;
    color: #333;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Link Styles */
a {
    color: #4CAF50;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* No Patients Found */
p {
    font-size: 16px;
    color: #555;
    text-align: center;
}
</style>
</body>
</html>
