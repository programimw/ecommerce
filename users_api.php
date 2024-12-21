<?php
session_start();
require_once "connect.php";
require_once "functions.php";
// TODO CHECK IF THE USER IS LOOGGED IN.
// iF USER NOT LOGGED IN, THE REQUEST IS 403 unauthorized


if ($_POST['action'] == "delete_user") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    // vetem admini mund te fshije te dhenat
//    if ($_SESSION['role_name'] != 'admin'){
//        http_response_code(403);
//        echo json_encode(
//            array(
//                "message" => "Unathorized"
//            ));
//        exit;
//    }


    // kontrollojme nese ekziston nje user me kete ID.
    $query_check = "SELECT 
                           id 
                    FROM users
                    WHERE id = '" . $id . "'  ";

    $result_check = mysqli_query($conn, $query_check);

    if (!$result_check) {
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    if (mysqli_num_rows($result_check) == 0) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Fshirja nuk u realizua",
            ));
        exit;
    }


    // fshirja e userit
    $query_delete = "DELETE FROM users where id = '" . $id . "'";
    $result_delete = mysqli_query($conn, $query_delete);

    if (!$result_delete) {
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
                "message" => "Useri u fshi me sukses!",
            ));
        exit;
    }
} if ($_POST['action'] == "get_user_data"){
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // vetem admini mund te fshije te dhenat
//    if ($_SESSION['role_name'] != 'admin'){
//        http_response_code(403);
//        echo json_encode(
//            array(
//                "message" => "Unathorized"
//            ));
//        exit;
//    }

    // kontrollojme nese ekziston nje user me kete ID.
    $query_check = "SELECT id,
                           name,
                           surname,
                           email
                    FROM users
                    WHERE id = '" . $id . "'  ";

    $result_check = mysqli_query($conn, $query_check);

    if (!$result_check) {
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    if (mysqli_num_rows($result_check) == 0) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Ndodhi nje gabim",
            ));
        exit;
    }

    $data = mysqli_fetch_assoc($result_check);

    http_response_code(200);
    echo json_encode(
        array(
            "message" => "Users Data!",
            "data"=> $data
        ));
    exit;


} else if ($_POST['action'] == 'edit_user'){
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // vetem admini mund te fshije te dhenat
//    if ($_SESSION['role_name'] != 'admin'){
//        http_response_code(403);
//        echo json_encode(
//            array(
//                "message" => "Unathorized"
//            ));
//        exit;
//    }

    // TODO VALIDATE USERS DATA

    // kontrollojme nese ekziston nje user me kete ID.
    $query_check = "SELECT 
                           id 
                    FROM users
                    WHERE id = '" . $id . "'  ";

    $result_check = mysqli_query($conn, $query_check);

    if (!$result_check) {
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal Server Error",
                "error" => mysqli_error($conn)
            ));
        exit;
    }

    if (mysqli_num_rows($result_check) == 0) {
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Ndodhi nje gabim",
            ));
        exit;
    }

    // nese useri ekziston dhe kalon validimet duhet te perditesojme te dhenat
    $query_update = "UPDATE users set 
                        name = '".$name."', 
                        surname = '".$surname."', 
                        email = '".$email."'
                     WHERE id = '".$id."'";

    $result_update = mysqli_query($conn, $query_update);

    if (!$result_update) {
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
                "message" => "Te dhenat u perditesuan me sukses",
                "name" =>$name,
                "surname" =>$surname,
                "email" =>$email
            ));
        exit;
    }

}
?>