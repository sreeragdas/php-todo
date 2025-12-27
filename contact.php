<?php
session_start();
$appName = 'Modern Notes';
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Modern Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/notebook-2333053-1939355.png" alt="" width="35" height="35" class="d-inline-block align-top">
      <b class="ms-2">MODERN NOTES</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 200px;">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
      </ul>
      <?php if(!empty($_SESSION['user_id'])): ?>
        <div class="d-flex align-items-center text-white me-3">Hello, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></div>
        <a class="btn btn-outline-light me-2" href="logout.php">Logout</a>
      <?php else: ?>
        <a class="btn btn-outline-light me-2" href="login.php">Login</a>
        <a class="btn btn-outline-success" href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container mt-5">
  <h2>Contact Us</h2>
  <p>Have questions or feedback about Modern Notes? Reach out to us!</p>
  <ul>
    <li>Email: <a href="mailto:support@modernnotes.app">support@modernnotes.app</a></li>
    <li>GitHub: <a href="https://github.com/modernnotes" target="_blank">modernnotes</a></li>
  </ul>
  <p>We value your input and strive to make Modern Notes better for everyone.</p>
</div>
</body>
</html>
