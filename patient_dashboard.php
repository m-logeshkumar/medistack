<?php
session_start();

// Check if the user is logged in and is a patient
if ($_SESSION['role'] != 'patient') {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="dashboard-container">
        <h1 class="dashboard-title">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>

        <div class="dashboard-grid">
            <div class="card" onclick="window.location.href='view_prescriptions.php'">
                <i class="fas fa-file-medical"></i>
                <h3>Prescriptions</h3>
                <p>Check your prescribed medications.</p>
            </div>
            <div class="card" onclick="window.location.href='request_appointment.php'">
                <i class="fas fa-calendar-check"></i>
                <h3>Appointments</h3>
                <p>Schedule or view your appointments.</p>
            </div>
            <div class="card" onclick="window.location.href='chat.php'">
                <i class="fas fa-comment-medical"></i>
                <h3>Chat with Doctor</h3>
                <p>Ask medical queries directly.</p>
            </div>
            <div class="card logout" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i>
                <h3>Logout</h3>
                <p>Securely exit your account.</p>
            </div>
        </div>
    </div>
    <style>
        /* Reset & General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f7fa;
}

/* Dashboard Container */
.dashboard-container {
    text-align: center;
    width: 90%;
    max-width: 700px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Title */
.dashboard-title {
    font-size: 28px;
    color: #333;
    margin-bottom: 20px;
}

/* Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 10px;
}

/* Card Styling */
.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card i {
    font-size: 32px;
    margin-bottom: 12px;
    color: #007BFF;
}

.card h3 {
    margin: 10px 0;
    font-size: 20px;
}

.card p {
    font-size: 14px;
    color: #555;
}

/* Card Hover Effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Logout Card */
.card.logout {
    background:rgb(224, 81, 95);
    color: white;
}

.card.logout i {
    color: white;
}

.card.logout:hover {
    background:rgb(247, 122, 135);
}

    </style>
</body>
</html>


