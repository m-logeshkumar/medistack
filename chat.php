<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Fetch current user role (doctor or patient)
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];  // doctor or patient

// Fetch all previous messages
$sql = "SELECT * FROM chats WHERE user_id = '$user_id' OR role = 'doctor' OR role = 'patient' ORDER BY timestamp ASC";
$messages = $conn->query($sql);

// Handle message submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    if (!empty($message)) {
        // Insert new message into the database
        $sql = "INSERT INTO chats (user_id, message, role) VALUES ('$user_id', '$message', '$role')";
        $conn->query($sql);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
            margin-bottom: 10px;
        }
        .message {
            padding: 5px;
            margin: 5px;
            border-radius: 5px;
        }
        .message-doctor {
            background-color: #d1e7dd;
            text-align: left;
        }
        .message-patient {
            background-color: #f8d7da;
            text-align: right;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="chat-container">
        <h2>Chat with your Doctor/Patient</h2>

        <div class="chat-box">
            <?php
            // Display all messages
            while ($message = $messages->fetch_assoc()) {
                $message_class = ($message['role'] == 'doctor') ? 'message-doctor' : 'message-patient';
                echo "<div class='message $message_class'>";
                echo "<strong>" . ucfirst($message['role']) . ":</strong> " . htmlspecialchars($message['message']);
                echo "</div>";
            }
            ?>
        </div>

        <form action="chat.php" method="POST">
            <input type="text" name="message" placeholder="Type your message here..." required>
            <button type="submit">Send</button>
        </form>

        <a href="logout.php">Logout</a>
    </div>

</body>
</html>
