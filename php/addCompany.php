<?php 
require("conn.php");

$conn->query("INSERT INTO Companies (name, is_anon, max_answers) VALUES ('".$_POST['name']."', 0, 3)");

header("Location: ../pages/_admin/companies.php");