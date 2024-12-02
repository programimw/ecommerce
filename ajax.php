<?php

require_once "connect.php";

// Register User Data
if ($_POST["action"] == "register")
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);;
    $confirmPassword = mysqli_real_escape_string($conn,$_POST['confirmPassword']);
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

    // Validimi i emailit
    if (empty($email)){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Email nuk mund te jete bosh",
                "tagError" => "emailError",
                "tagElement" => "email"
            ));
        exit;
    }

    // Validimi i password
    // TODO VALIDATION OF PASSWORD

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
            ));
        exit;
    }

}


