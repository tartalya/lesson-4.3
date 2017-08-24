<?php

require_once 'functions.php';
require_once 'config.php';

$helloText = 'Введите данные для регистрации или войдите, если уже регистрировались:';
$errorText = '';




if (isset($_POST['register'])) {

    if (empty($_POST['login']) || empty($_POST['password'])) {

        $errorText = 'Логин и пароль не могут быть пустыми !!!';
    } else {

        $login = mysqli_real_escape_string($link, $_POST['login']);
        $password = md5($_POST['password']);

        if (userExist($link, $login)) {

            $errorText = 'Такой пользователь уже существует';
        } else {


            $query = "INSERT INTO user (`login`, `password`) VALUES ('$login' , '$password')";

            mysqli_query($link, $query);

            echo 'Регистрация успешно завершена';
        }
    }
}


if (isset($_POST['sign_in'])) {

    $login = mysqli_real_escape_string($link, $_POST['login']);
    $password = md5($_POST['password']);

    if ($user = userAuth($link, $login, $password)) {

        session_start();
        $_SESSION['user'] = $user;

        echo '<meta http-equiv="refresh" content="0; url=index.php">';
    } else {

        $errorText = 'Ошибка авторизации';
    }
}

include 'logintemplate.php';




