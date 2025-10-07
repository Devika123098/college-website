<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: add_student.html', true, 303);
  exit;
}

$name = $_POST['name'] ?? '';
$roll_no = $_POST['roll_no'] ?? '';
$department = $_POST['department'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';

try {
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=contact_app;charset=utf8mb4', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare(
    'INSERT INTO students (name, roll_no, department, email, phone)
     VALUES (?, ?, ?, ?, ?)'
  );
  $stmt->execute([$name, $roll_no, $department, $email, $phone]);
} catch (PDOException $e) {
  error_log('DB insert failed: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Added</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="student-form">
    <h2>Student Details Added Successfully!</h2>
    <p>Here’s what you entered:</p>
    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Roll No:</strong> <?= htmlspecialchars($roll_no) ?></p>
    <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>

    <a href="add_student.html">Add Another Student</a><br>
    <a href="search_student.html">Search Students</a>
  </div>
</body>
</html>
