<?php
session_start();
// nese useri nuk eshte loguar, dergoje ne login
if (!isset($_SESSION['id']) && empty($_SESSION['id'])){
    header("Location:http://localhost/ecommerce");
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<div id="wrapper">