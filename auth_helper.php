
<?php
require_once __DIR__ . '/config.php';

function setup_db() {
    global $DB_TYPE, $MYSQL, $PGSQL;
    if ($DB_TYPE === 'mysql') {
        $conn = mysqli_connect($MYSQL['server'], $MYSQL['username'], $MYSQL['password']);
        if (!$conn) die('MySQL connect error: ' . mysqli_connect_error());
        $db_selected = mysqli_select_db($conn, $MYSQL['database']);
        if (!$db_selected) {
            $sql = "CREATE DATABASE `{$MYSQL['database']}`";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>Database created successfully.</div>";
                mysqli_select_db($conn, $MYSQL['database']);
            } else {
                die("<div class='alert alert-danger'>Error creating database: ".mysqli_error($conn)."</div>");
            }
        }
        // Create users table
        $sql_users = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";
        if (!mysqli_query($conn, $sql_users)) {
            echo "<div class='alert alert-danger'>Error creating users table: ".mysqli_error($conn)."</div>";
        }
        // Create notes table
        $sql_notes = "CREATE TABLE IF NOT EXISTS notes (
            sn INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            note TEXT NOT NULL,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if (!mysqli_query($conn, $sql_notes)) {
            echo "<div class='alert alert-danger'>Error creating notes table: ".mysqli_error($conn)."</div>";
        }
        mysqli_close($conn);
    } else if ($DB_TYPE === 'pgsql') {
        try {
            $dsn = "pgsql:host={$PGSQL['host']};port={$PGSQL['port']};";
            $pdo = new PDO($dsn, $PGSQL['username'], $PGSQL['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Create DB if not exists (Postgres usually needs manual DB creation, but try)
            $pdo->exec("CREATE DATABASE \"{$PGSQL['database']}\"");
            echo "<div class='alert alert-success'>Database created successfully.</div>";
        } catch (PDOException $e) {
            // Ignore 'database exists' error
        }
        // Now connect to the DB
        $dsn = "pgsql:host={$PGSQL['host']};port={$PGSQL['port']};dbname={$PGSQL['database']}";
        $pdo = new PDO($dsn, $PGSQL['username'], $PGSQL['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Create users table
        $sql_users = "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";
        try {
            $pdo->exec($sql_users);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error creating users table: ".$e->getMessage()."</div>";
        }
        // Create notes table
        $sql_notes = "CREATE TABLE IF NOT EXISTS notes (
            sn SERIAL PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            note TEXT NOT NULL,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        try {
            $pdo->exec($sql_notes);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error creating notes table: ".$e->getMessage()."</div>";
        }
    }
}

// Call setup_db() on every load
setup_db();
function get_db() {
    global $DB_TYPE, $MYSQL, $PGSQL;
    if ($DB_TYPE === 'mysql') {
        $conn = mysqli_connect($MYSQL['server'], $MYSQL['username'], $MYSQL['password'], $MYSQL['database']);
        if (!$conn) die('MySQL connect error: ' . mysqli_connect_error());
        return $conn;
    } else if ($DB_TYPE === 'pgsql') {
        // Connect using PDO
        $dsn = "pgsql:host={$PGSQL['host']};port={$PGSQL['port']};dbname={$PGSQL['database']}";
        try {
            $pdo = new PDO($dsn, $PGSQL['username'], $PGSQL['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $pdo;
        } catch (PDOException $e) {
            die('PostgreSQL connect error: ' . $e->getMessage());
        }
    }
    return null;
}


function find_user($email) {
    global $DB_TYPE;
    if ($DB_TYPE === 'mysql') {
        $conn = get_db();
        $stmt = mysqli_prepare($conn, "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $email, $hash);
        $user = null;
        if (mysqli_stmt_fetch($stmt)) {
            $user = ['id' => $id, 'name' => $name, 'email' => $email, 'password' => $hash];
        }
        mysqli_stmt_close($stmt);
        return $user;
    } else if ($DB_TYPE === 'pgsql') {
        $pdo = get_db();
        $stmt = $pdo->prepare('SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }
    return null;
}

function create_user($name, $email, $password) {
    global $DB_TYPE;
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($DB_TYPE === 'pgsql') {
        $pdo = get_db();
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password) RETURNING id');
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
        return $stmt->fetchColumn(); // return new user ID
    }
    // MySQL version
    $conn = get_db();
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hash);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($conn); // return new ID
    }
    return false;
}

