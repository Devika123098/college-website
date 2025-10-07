<?php
$query = $_GET['query'] ?? '';

try {
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=contact_app;charset=utf8mb4', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare(
    'SELECT * FROM students WHERE roll_no LIKE ? OR name LIKE ?'
  );
  $stmt->execute(["%$query%", "%$query%"]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  error_log('DB search failed: ' . $e->getMessage());
  $results = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="results">
    <h2>Search Results for "<?= htmlspecialchars($query) ?>"</h2>

    <?php if (count($results) > 0): ?>
      <table border="1" cellpadding="10">
        <tr>
          <th>Name</th>
          <th>Roll No</th>
          <th>Department</th>
          <th>Email</th>
          <th>Phone</th>
        </tr>
        <?php foreach ($results as $student): ?>
          <tr>
            <td><?= htmlspecialchars($student['name']) ?></td>
            <td><?= htmlspecialchars($student['roll_no']) ?></td>
            <td><?= htmlspecialchars($student['department']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['phone']) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php else: ?>
      <p>No students found.</p>
    <?php endif; ?>

    <p><a href="search_student.html">Back to Search</a></p>
  </div>
</body>
</html>
