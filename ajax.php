<?php

require_once "connect.php";

// Register User Data
if ($_POST["action"] == "register")
{
    $name = mysqli_real_escape_string($conn,trim($_POST['name']));
    $email = mysqli_real_escape_string($conn,trim($_POST['email']));
    $password = mysqli_real_escape_string($conn,trim($_POST['password']));
    $password = mysqli_real_escape_string($conn,trim($_POST['password']));
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);;
    $confirmPassword = mysqli_real_escape_string($conn,trim($_POST['confirmPassword']));
    $nameRegex = "/^[a-zA-Z ]{3,20}$/";
    $passwordRegex = "/^[a-zA-Z0-9-_ ]{4,}$/";
    //Validimet
    // Validimi i emrit
    if (!preg_match($nameRegex, $name)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Emri vetem karaktere, minimumi 3",
                "tagError" => "nameError",
                "tagElement" => "name"
            ));
        exit;
    }

    // Validimi nese eshte email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Email nuk eshte i sakte",
                "tagError" => "emailError",
                "tagElement" => "email"
            ));
        exit;
    }

    // Validimi i password
    if (empty($password) || strlen($password) < 4) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi minimumi 4 karaktere.",
                "tagError" => "passwordError",
                "tagElement" => "password"
            ));
        exit;
    }

    if ($password !== $confirmPassword) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi dhe confirm password te barabarte.",
                "tagError" => "passwordError",
                "tagElement" => "password"
            ));
        exit;
    }

    // Validojme nese ekziston useri
    $query_check = "SELECT 
                           id 
                    FROM users
                    WHERE email = '".$email."'  ";


    $result_check = mysqli_query($conn, $query_check);

    if (!$result_check){
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    if (mysqli_num_rows($result_check)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Ekziston nje user me kete email",
                "tagError" => "emailError",
                "tagElement" => "email"
            ));
        exit;
    }


    // Ruatja e te dhenave
    $query_insert = "INSERT INTO users set
                     name = '".$name."', 
                     email = '".$email."', 
                     password = '".$passwordHashed."', 
                     created_at = '".date("Y-m-d H:i:s")."'
                       ";

    $resut_insert = mysqli_query($conn, $query_insert);

    if (!$resut_insert){
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    } else {
        http_response_code(200);
        echo json_encode(
            array(
                "message" => "Useri u ruajt me sukses",
                "location" => "/"
            ));
        exit;
    }

    mysqli_close($conn);

} elseif ($_POST['action'] == "login"){

    $email = mysqli_real_escape_string($conn,trim($_POST['email_number']));
    $password = mysqli_real_escape_string($conn,trim($_POST['password']));

    //Validimet
    // Validimi nese eshte email
    // add validation as a phone number and email
//
//    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
//        http_response_code(203);
//        echo json_encode(
//            array(
//                "message" => "Email ose nr i pasakte",
//                "tagError" => "emailError",
//                "tagElement" => "email"
//            ));
//        exit;
//    }

    // Validimi i password
    if (empty($password) || strlen($password) < 4) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi minimumi 4 karaktere.",
                "tagError" => "passwordError",
                "tagElement" => "password"
            ));
        exit;
    }


    // Kontrollojme nese useri ekziston ne db me email dhe pass
    $query_check = "SELECT id,email, password
                    FROM users
                    WHERE email = '".$email."'; ";

    $result_check = mysqli_query($conn, $query_check);

    if (!$result_check){
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    // nese nuk ekziston nje user me kete email
    if (mysqli_num_rows($result_check) == 0 ){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Nuk ka user me kete email/nr"
            ));
        exit;
    }

    $row = mysqli_fetch_assoc($result_check);
    $passwordHashed = $row['password'];

    // verifikimi i password
    if (!password_verify($password, $passwordHashed)) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi/Email te pasakte "
            ));
        exit;
    }

    session_start();

    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];

    mysqli_close($conn);

    http_response_code(200);
    echo json_encode(
        array(
            "message" => "Useri logged in",
            "location" => "profile.php"
        ));
    exit;
}


