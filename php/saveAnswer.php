<?php
session_start();
require('conn.php');
if(isset($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
} else 
{
    $user_id = $_GET['user_id'];
}

foreach ($_GET['answer_id'] as $key => $value) {
    $sql = "INSERT INTO UserAnswers (user_id, answer_id, answer_priority) 
    VALUES (".$user_id.", ".$value.", ".$_GET['answer_priority'][$key].");";
    $conn->query($sql);
}

header("Location: ../pages/endTest.php");