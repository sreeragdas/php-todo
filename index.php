<?php
session_start();
require_once __DIR__ . '/config.php';
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if ($DB_TYPE === 'mysql') {
    $conn = mysqli_connect($MYSQL['server'], $MYSQL['username'], $MYSQL['password'], $MYSQL['database']);
    if(!$conn) { die("Error in connecting to mySQL: ".mysqli_connect_error()); }
} else if ($DB_TYPE === 'pgsql') {
    require_once __DIR__ . '/pgsql_helper.php';
    $pdo = pgsql_connect($PGSQL);
}
?>
<?php
$success = false;
if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $note = $_POST['note'];
    if ($DB_TYPE === 'mysql') {
        $sql = "INSERT INTO `notes` (`title`, `note`, `date`) VALUES ('$title', '$note', current_timestamp());";
        $result = mysqli_query($conn, $sql);
        if($result) {
            $success = true;
            header("Location: index.php");
        } else {
            echo "data not inserted";
        }
    } else if ($DB_TYPE === 'pgsql') {
        $stmt = $pdo->prepare("INSERT INTO notes (title, note, date) VALUES (:title, :note, NOW())");
        $result = $stmt->execute(['title' => $title, 'note' => $note]);
        if($result) {
            $success = true;
            header("Location: index.php");
        } else {
            echo "data not inserted";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Modern Notes</title>
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
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
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
    <?php
    if($success)
    {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been saved successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    ?>
    <div class="container mt-5">
        <h4>Add Note</h4>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" required class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" required id="note" rows="3" name="note"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Note</button>
        </form>

    
    <div class="container mt-5 my-5">
    <table class="table" id="myTable">
    <thead class="table-dark">
        <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Title</th>
        <th scope="col">Note</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $i = 0;
        if ($DB_TYPE === 'mysql') {
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);
            if($result) {
                while($data = mysqli_fetch_assoc($result)) {
                    $i++;
                    $sn = $data['sn'];
                    $showtitle = $data['title'];
                    $shownote = $data['note'];
                    echo "<tr>
                            <th scope='row'>$i</th>
                            <td> $showtitle </td>
                            <td> $shownote </td>
                            <td>
                                <a class='btn btn-outline-success' href='edit.php?id=$sn'>Edit</a>
                                <a class='btn btn-outline-danger' href='delete.php?id=$sn'>Delete</a>
                            </td>
                        </tr>";         
                }
            }
        } else if ($DB_TYPE === 'pgsql') {
            $stmt = $pdo->query("SELECT * FROM notes");
            while($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $i++;
                $sn = $data['sn'];
                $showtitle = $data['title'];
                $shownote = $data['note'];
                echo "<tr>
                        <th scope='row'>$i</th>
                        <td> $showtitle </td>
                        <td> $shownote </td>
                        <td>
                            <a class='btn btn-outline-success' href='edit.php?id=$sn'>Edit</a>
                            <a class='btn btn-outline-danger' href='delete.php?id=$sn'>Delete</a>
                        </td>
                    </tr>";         
            }
        }
    ?>
    </tbody>
    </table>
    </div>




</body>
</html>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>