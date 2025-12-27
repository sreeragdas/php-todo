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

$data = null;
if ($DB_TYPE === 'mysql') {
    $conn = mysqli_connect($MYSQL['server'], $MYSQL['username'], $MYSQL['password'], $MYSQL['database']);
    if(!$conn) {
        die("<div class='alert alert-danger'>Error in connecting to MySQL: ".mysqli_connect_error()."</div>");
    }
    $sql = "SELECT * FROM `notes` WHERE `sn` = $id";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);
} else if ($DB_TYPE === 'pgsql') {
    require_once __DIR__ . '/pgsql_helper.php';
    $pdo = pgsql_connect($PGSQL);
    try {
        $stmt = $pdo->prepare('SELECT * FROM notes WHERE sn = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: ".$e->getMessage()."</div>";
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <title>Edit Note - Modern Notes</title>
  </head>
  <body>

  <div class="container mt-5">
        <h4>Edit Note</h4>
        <form method="POST" autocomplete="off">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" required class="form-control" id="title" name="title" value="<?php echo $data['title'];?>">
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" required id="note" rows="3" name="note"><?php echo $data['note'];?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>


    <?php
    if(isset($_POST['submit'])) {
        $title = $_POST['title'];
        $note = $_POST['note'];
        if ($DB_TYPE === 'mysql') {
            $editSql = "UPDATE `notes` SET `title` = '$title', `note` = '$note' WHERE `notes`.`sn` = $id;";
            $result = mysqli_query($conn, $editSql);
            if($result) {
                header("Location: index.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error in editing this note: ".mysqli_error($conn)."</div>";
            }
        } else if ($DB_TYPE === 'pgsql') {
            try {
                $stmt = $pdo->prepare('UPDATE notes SET title = :title, note = :note WHERE sn = :id');
                $result = $stmt->execute(['title' => $title, 'note' => $note, 'id' => $id]);
                if($result) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>Error in editing this note.</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: ".$e->getMessage()."</div>";
            }
        }
    }
    ?>
  </body>
</html>