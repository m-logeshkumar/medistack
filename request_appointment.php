<?php
session_start();
include('db.php');

// Check if user is logged in and is a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header('Location: login.html');
    exit();
}

// Fetch all doctors from the database
$sql = "SELECT * FROM users WHERE role = 'doctor'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    // Insert the appointment into the database
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date) 
            VALUES ('{$_SESSION['user_id']}', '$doctor_id', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Your appointment request has been submitted successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Appointment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="form-container">
    <h2>Request an Appointment</h2>

    <!-- Display error or success message -->
    <?php if (isset($error_message)) { echo "<div class='error-message'>$error_message</div>"; } ?>
    <?php if (isset($success_message)) { echo "<div class='success-message'>$success_message</div>"; } ?>

    <!-- Appointment Request Form -->
    <form action="request_appointment.php" method="POST">
        <label for="doctor_id">Choose Doctor:</label>
        <select name="doctor_id" required>
            <option value="">Select a doctor</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br>

        <label for="appointment_date">Choose Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" required><br>

        <input type="submit" value="Request Appointment">
    </form>
</div>
<style>
    /* General body styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container for the form */
.form-container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 500px;
    box-sizing: border-box;
    text-align: center;
}

/* Heading styles */
h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Label styles */
label {
    font-size: 16px;
    color: #555;
    display: block;
    margin-bottom: 8px;
    text-align: left;
}

/* Select box and input styles */
select, input[type="datetime-local"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: #f9f9f9;
    box-sizing: border-box;
    transition: all 0.3s ease-in-out;
}

/* Select and input focus effect */
select:focus, input[type="datetime-local"]:focus {
    border-color: #4CAF50;
    background-color: #fff;
    outline: none;
}

/* Submit button styles */
input[type="submit"] {
    width: 100%;
    padding: 14px;
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Error and success messages */
.error-message, .success-message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 14px;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
}

/* Additional link styles */
a {
    color: #4CAF50;
    text-decoration: none;
    font-size: 16px;
    margin-top: 20px;
    display: inline-block;
}

a:hover {
    text-decoration: underline;
}
</style>

</body>
</html>
