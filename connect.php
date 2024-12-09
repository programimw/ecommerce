<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$conn = mysqli_connect($host,$username,$password, $database );
if (!$conn) {
    die(json_encode([
        "status" => "error",
        "message" => "Error në lidhjen me bazën e të dhënave: " . mysqli_connect_error()
    ]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    if (empty($name) || !preg_match('/^[a-zA-Z ]{3,20}$/', $name)) {
        echo json_encode([
            "status" => "error",
            "message" => "Emri duhet të jetë mes 3 dhe 20 karaktere dhe të përmbajë vetëm shkronja dhe hapësira."
        ]);
        exit;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Formati i email-it është i pavlefshëm."
        ]);
        exit;
    }

    if (empty($password) || strlen($password) < 4) {
        echo json_encode([
            "status" => "error",
            "message" => "Fjalëkalimi duhet të ketë të paktën 4 karaktere."
        ]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode([
            "status" => "error",
            "message" => "Fjalëkalimet nuk përputhen."
        ]);
        exit;
    }

    $checkEmail = "SELECT id FROM users WHERE email = ?";
    $checkStmt = mysqli_prepare($conn, $checkEmail);
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Ky email është tashmë i regjistruar."
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode([
                "status" => "success",
                "message" => "Regjistrimi u krye me sukses."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Ndodhi një gabim gjatë regjistrimit: " . mysqli_error($conn)
            ]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Gabim gjatë përgatitjes së deklaratës: " . mysqli_error($conn)
        ]);
    }
}

mysqli_close($conn);
?>