<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT image FROM student WHERE id = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

if ($student) {
    // Delete the image file
    if (file_exists('uploads/' . $student['image'])) {
        unlink('uploads/' . $student['image']);
    }

    // Delete the student record
    $sql = "DELETE FROM student WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Student not found.";
}

$conn->close();
?>
