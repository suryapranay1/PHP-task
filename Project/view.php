<?php
include 'db.php';

// Get the student ID from the URL
$id = $_GET['id'];

// Fetch the student details along with the class name using a JOIN query
$sql = "SELECT student.*, classes.name AS class_name 
        FROM student 
        LEFT JOIN classes ON student.class_id = classes.class_id 
        WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found!";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>View Student</h1>
    <div class="card mt-4">
        <div class="row g-0">
            <div class="col-md-4">
                <!-- Image Display -->
                <img src="uploads/<?php echo $student['image']; ?>" class="img-fluid rounded-start" alt="Student Image">

                
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $student['name']; ?></h5>
                    <p class="card-text"><strong>Email:</strong> <?php echo $student['email']; ?></p>
                    <p class="card-text"><strong>Address:</strong> <?php echo $student['address']; ?></p>
                    <p class="card-text"><strong>Class:</strong> <?php echo $student['class_name']; ?></p>
                    <p class="card-text"><small class="text-muted">Created on: <?php echo $student['created_at']; ?></small></p>
                    <a href="index.php" class="btn btn-primary mt-3">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
