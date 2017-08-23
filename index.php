<?php

require_once 'functions.php';
require_once 'config.php';

session_start();

if (empty($_SESSION['user'])) {
    
    header('location: auth.php');
    
}


if (!empty($_GET['action']) && !empty($_GET['id'])) {

    $id = intval($_GET['id']);

    switch ($_GET['action']) {

        case 'done':

            $query = 'UPDATE tasks SET is_done = 1 WHERE id =' . $id;
            break;


        case 'delete':

            $query = 'DELETE FROM tasks WHERE id =' . $id;
            break;


        case 'edit':

            $query = 'SELECT * FROM tasks WHERE id =' . $id;

            $result = mysqli_query($link, $query);
            $result = mysqli_fetch_assoc($result);

            if (empty($_POST['new_description'])) {

                include 'edittemplate.php';
                die;
            } else {

                $query = 'UPDATE tasks SET description ="' . $_POST['new_description'] . '" ' . 'WHERE id =' . $id;
            }
            break;
    }

    taskAction($link, $query);
}

$myUserId = $_SESSION['user']['id'];

$query = "SELECT tasks.id, user_id, assigned_user_id, description, is_done, date_added, user.login FROM tasks INNER JOIN user ON tasks.assigned_user_id = user.id WHERE user_id = '$myUserId'";  //выборка только своих задач




if (!empty($_POST['sort_by'])) {


    $query .= 'ORDER BY ' . mysqli_real_escape_string($link, $_POST['sort_by']);
}

$result = mysqli_query($link, $query);



while ($row = mysqli_fetch_assoc($result)) {
    $arr[] = $row;
}


if (!empty($_POST['add_description'])) {

    $newDescription = mysqli_real_escape_string($link, $_POST['add_description']);
    $query = "INSERT INTO tasks (description, date_added, user_id, assigned_user_id) VALUES ('$newDescription' , CURRENT_TIMESTAMP, '$myUserId', '$myUserId')";

    taskAction($link, $query);
}

$query = "SELECT id, login FROM user";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $userList[] = $row;
}

if (!empty($_POST['assign'])) {
    
    $tmp = explode('_', $_POST['user_id']);
    
    $task = $tmp[0];
    $newUserId = $tmp[1];
    
    
    $query = "UPDATE tasks SET user_id = '$newUserId', assigned_user_id = '$myUserId' WHERE id = $task";
    mysqli_query($link, $query);
   
    
    echo '<meta http-equiv="refresh" content="0; url=index.php">';
    
}

include 'template.php';
