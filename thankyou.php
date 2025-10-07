<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: form.html', true, 303);
  exit;
}

$firstName = $_POST['first-name'] ?? '';
$lastName  = $_POST['last-name']  ?? '';
$email     = $_POST['email']      ?? '';
$phone     = $_POST['phone']      ?? '';
$message   = $_POST['message']    ?? '';

try {
 
  $pdo = new PDO('mysql:host=127.0.0.1;dbname=contact_app;charset=utf8mb4', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare(
    'INSERT INTO contact_messages (first_name, last_name, email, phone, message)
     VALUES (?, ?, ?, ?, ?)'
  );

  $stmt->execute([$firstName, $lastName, $email, $phone, $message]);

} catch (PDOException $e) {

  error_log('DB insert failed: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank you</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="contact-form">
    <h2>Thank you for submitting your message!</h2>
    <p>Here are the details provided:</p>

    <div class="form-group">
      <label>First Name:</label>
      <p><?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="form-group">
      <label>Last Name:</label>
      <p><?= htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="form-group">
      <label>Email Address:</label>
      <p><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="form-group">
      <label>Phone Number:</label>
      <p><?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <div class="form-group">
      <label>Your Message:</label>
      <p style="white-space: pre-wrap;"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <p><a href="form.html">Back to form</a></p>
  </div>
</body>
</html>
