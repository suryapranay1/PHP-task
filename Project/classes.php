<?php
include 'db.php';

// Handle form submission for adding or editing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (isset($_POST['class_id'])) {
        // Update existing class
        $class_id = $_POST['class_id'];
        $sql = "UPDATE classes SET name='$name' WHERE class_id=$class_id";
    } else {
        // Insert new class
        $sql = "INSERT INTO classes (name) VALUES ('$name')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $class_id = $_GET['delete_id'];
    $sql = "DELETE FROM classes WHERE class_id = $class_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: classes.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch classes for listing
$classResult = $conn->query("SELECT * FROM classes");

// Fetch class data if editing
$editMode = false;
if (isset($_GET['id'])) {
    $class_id = $_GET['id'];
    $editResult = $conn->query("SELECT * FROM classes WHERE class_id = $class_id");
    if ($editResult->num_rows > 0) {
        $editRow = $editResult->fetch_assoc();
        $editMode = true;
    } else {
        echo "Class not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1><?php echo $editMode ? 'Edit' : 'Add'; ?> Class</h1>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Class Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?php echo $editMode ? $editRow['name'] : ''; ?>" required>
            <?php if ($editMode): ?>
                <input type="hidden" name="class_id" value="<?php echo $editRow['class_id']; ?>">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $editMode ? 'Update' : 'Add'; ?> Class</button>
        <a href="classes.php" class="btn btn-secondary">Back</a>
    </form>

    <h2 class="mt-5">Class List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $classResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <a href="classes.php?id=<?php echo $row['class_id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="classes.php?delete_id=<?php echo $row['class_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
