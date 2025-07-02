<?php
session_start();
include('db.php');

// Check if user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header('Location: login.html');
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all necessary form fields are provided
    if (isset($_POST['patient_id'], $_POST['medication'], $_POST['dosage'], $_POST['instructions']) &&
        !empty($_POST['patient_id']) && !empty($_POST['medication']) && !empty($_POST['dosage']) && !empty($_POST['instructions'])) {

        // Sanitize input to avoid SQL Injection
        $patient_id = (int) $_POST['patient_id'];  // Casting to integer
        $medication = mysqli_real_escape_string($conn, $_POST['medication']);
        $dosage = mysqli_real_escape_string($conn, $_POST['dosage']);
        $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);

        // Check if patient_id is valid
        if ($patient_id > 0) {
            // Prepare the SQL query
            $sql = "INSERT INTO prescriptions (patient_id, doctor_id, medication, dosage, instructions) 
                    VALUES ('$patient_id', '{$_SESSION['user_id']}', '$medication', '$dosage', '$instructions')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "Prescription added successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Invalid patient ID.";
        }
    } else {
        echo "All fields are required!";
    }
}
?>
<title>Form to add prescription</title>
<!-- Form to add a prescription -->
<form action="add_prescription.php" method="POST">
    <label for="patient_id">Patient ID:</label>
    <input type="number" name="patient_id" required><br>

    <label for="medication">Medication:</label>
    <input type="text" name="medication" required><br>

    <label for="dosage">Dosage:</label>
    <input type="text" name="dosage" required><br>

    <label for="instructions">Instructions:</label>
    <textarea name="instructions" required></textarea><br>

    <input type="submit" value="Add Prescription">
</form>
<style>
    /* General body styles */
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

/* Container for the entire form */
.form-container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 500px;
    width: 100%;
    box-sizing: border-box;
}

/* Heading for the form */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Input fields and labels */
label {
    font-size: 16px;
    color: #555;
    margin-bottom: 8px;
    display: inline-block;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus {
    outline: none;
    border-color: #4CAF50;
}

/* Submit button */
input[type="submit"] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 14px;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Error message */
.error-message {
    color: red;
    text-align: center;
    margin-bottom: 20px;
}

/* Success message */
.success-message {
    color: green;
    text-align: center;
    margin-bottom: 20px;
}
</style>