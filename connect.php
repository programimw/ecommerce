<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$conn = mysqli_connect($host,$username,$password, $database );

if (!$conn){
    echo "Error ne lidhjen me DB: ".mysqli_connect_error();
}


// TODO:: Validimet tek requesti perkates sepse connect.php do perfshihet tek te gjithe filet
// Nese ka nje error, te nderpritet ekzekutimi me poshte.
//
//$action = isset($_POST['action']) ? $_POST['action'] : '';
//$name = isset($_POST['name']) ? trim($_POST['name']) : '';
//$email = isset($_POST['email']) ? trim($_POST['email']) : '';
//$password = isset($_POST['password']) ? $_POST['password'] : '';
//$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
//
//$errors = [];
//if (empty($name) || !preg_match('/^[a-zA-Z ]{3,20}$/', $name)) {
//    $errors['name'] = "Emri duhet te jete mes 3 dhe 20 karaktere dhe te permbaje vetem shkronja dhe hapësira.";
//}
//
//
//if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//    $errors['email'] = "Formati i email-it eshte i pavlefshem.";
//}
//if (empty($password) || strlen($password) < 4) {
//    $errors['password'] = "Fjalekalimi duhet te kete te pakten 4 karaktere.";
//}
//if ($password !== $confirmPassword) {
//    $errors['confirmPassword'] = "Fjalekalimet nuk perputhen.";
//}
//
//if (!empty($errors)) {
//    echo json_encode([
//        "status" => "error",
//        "message" => "Deshtim ne verifikim.",
//        "errors" => $errors
//    ]);
//    exit;
//}
//
//$checkEmail = "SELECT id FROM users WHERE email = ?";
//$checkStmt = mysqli_prepare($conn, $checkEmail);
//mysqli_stmt_bind_param($checkStmt, "s", $email);
//mysqli_stmt_execute($checkStmt);
//mysqli_stmt_store_result($checkStmt);
//
//if (mysqli_stmt_num_rows($checkStmt) > 0) {
//    echo json_encode([
//        "status" => "error",
//        "message" => "Ky email eshte tashme i regjistruar."
//    ]);
//    exit;
//}
//
//$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
//$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
//$stmt = mysqli_prepare($conn, $sql);
//
//if ($stmt) {
//    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);
//    if (mysqli_stmt_execute($stmt)) {
//        echo json_encode([
//            "status" => "success",
//            "message" => "Regjistrimi u krye me sukses."
//        ]);
//    } else {
//        echo json_encode([
//            "status" => "error",
//            "message" => "Ndodhi nje gabim gjate regjistrimit: " . mysqli_error($conn)
//        ]);
//    }
//    mysqli_stmt_close($stmt);
//} else {
//    echo json_encode([
//        "status" => "error",
//        "message" => "Gabim gjate pergatitjes se deklarates: " . mysqli_error($conn)
//    ]);
//}
//
//mysqli_close($conn);
?>
