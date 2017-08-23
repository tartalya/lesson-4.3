<?php

$dbHost = 'kalopsia.ru';
$dbUser = 'netology';
$dbName = 'lesson43';
$dbPassword = "gfintn";

$arr = array();
$userList = array();

$link = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
mysqli_set_charset($link, "utf8");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    die();
}