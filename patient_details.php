<?php
session_start(); // Start session to access stored values
include 'db.php';

// Check if session variables are set
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    die("Error: Missing user information.");
}

$id = $_SESSION['id'];  // Fetch the user ID correctly
$email = $_SESSION['email'];  // Fetch the email correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $medical_history = $_POST['medical_history'];

    // Store patient details with the correct user_id reference
    $stmt = $conn->prepare("INSERT INTO patients (user_id, email, phone, age, gender, medical_history) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississ", $id, $email, $phone, $age, $gender, $medical_history);
    
    if ($stmt->execute()) {
        echo "<a href='patient_dashboard.php'>Login here</a>";
        exit();
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Enter Your Details</h2> <!-- Moved outside the container -->

    <div class="container">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <label for="phone">Phone:</label>
            <input type="text" name="phone" required>

            <label for="age">Age:</label>
            <input type="number" name="age" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="medical_history">Medical History:</label>
            <textarea name="medical_history"></textarea>

            <button type="submit">Save Details</button>
        </form>
    </div>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;  /* Align content in a column */
    align-items: center;
    height: 100vh;
}

/* Title Styling */
h2 {
    margin-top: 20px; /* Add space from the top */
    font-size: 24px;
    color: #333;
}

/* Form Container */
.container {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin-top: 20px; /* Pushes form below the title */
}

/* Form Styling */
label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #555;
}

input, select, textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
}
    </style>
</body>
</html>
