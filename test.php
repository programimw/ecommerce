<?php
require_once "functions.php";

$result = sendEmail("This is a test E-Mail");
var_dump($result);
exit;