<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<div class='alert alert-danger'>Invalid note ID.</div>";
    exit();
}

if ($DB_TYPE === 'mysql') {
    $conn = mysqli_connect($MYSQL['server'], $MYSQL['username'], $MYSQL['password'], $MYSQL['database']);
    if(!$conn) {
        die("<div class='alert alert-danger'>Error in connecting to MySQL: ".mysqli_connect_error()."</div>");
    }
    $delSql = "DELETE FROM `notes` WHERE `notes`.`sn` = $id";
    $result = mysqli_query($conn, $delSql);
    if($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error in deleting this note: ".mysqli_error($conn)."</div>";
    }
    mysqli_close($conn);
} else if ($DB_TYPE === 'pgsql') {
    require_once __DIR__ . '/pgsql_helper.php';
    $pdo = pgsql_connect($PGSQL);
    try {
        $stmt = $pdo->prepare('DELETE FROM notes WHERE sn = :id');
        $result = $stmt->execute(['id' => $id]);
        if($result) {
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error in deleting this note.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: ".$e->getMessage()."</div>";
    }
}
?>