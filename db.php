<?php
$conn = new mysqli("localhost", "root", "root", "medi_stack");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
