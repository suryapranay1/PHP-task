<?php
include 'db.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_POST['current_image'];

    if ($_FILES['image']['name']) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
    }

    $sql = "UPDATE student SET name='$name', email='$email', address='$address', 
            class_id='$class_id', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM student WHERE id = $id";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$classResult = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Student</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="<?php echo $student['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="<?php echo $student['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" id="address"><?php echo $student['address']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="class" class="form-label">Class</label>
            <a href="classes.php" class="btn btn-primary mb-2">Edit Class</a>
            <select name="class_id" class="form-control" id="class">
                <?php while($row = $classResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['class_id']; ?>" <?php if ($row['class_id'] == $student['class_id']) echo 'selected'; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="image" accept=".jpg, .png">
            <input type="hidden" name="current_image" value="<?php echo $student['image']; ?>">
            <p>Current Image: <img src="uploads/<?php echo $student['image']; ?>" alt="Image" width="50"></p>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
