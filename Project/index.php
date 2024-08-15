<?php
include 'db.php';

$sql = "SELECT student.*, classes.name AS class_name FROM student 
        LEFT JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Student List</h1>
    <a href="create.php" class="btn btn-success mb-3">Add Student</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Creation Date</th>
                <th>Class Name</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
<td>
    <img src="uploads/<?php echo $row['image']; ?>" alt="Image" width="50"></td>
                <td>
                    <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
