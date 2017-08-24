<?php

function taskAction($link, $query)
    {
    mysqli_query($link, $query);
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    }

function userExist($link, $login)
    {

    $query = "SELECT login FROM user WHERE login='$login'";
    mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {

        return true;
    } else {

        return false;
    }
    }

function userAuth($link, $login, $password)
    {

    $query = "SELECT * FROM user WHERE login='$login' AND password='$password'";

    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_assoc($result);


    if (mysqli_affected_rows($link) > 0) {

        return $result;
    } else {

        return false;
    }
    }
