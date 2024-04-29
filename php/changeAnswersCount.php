<?php
require("conn.php");
$company_id = $_POST['company_id'];
$max_count = $_POST['max_answers'];

$conn->query("UPDATE Companies SET max_answers = $max_count WHERE id = $company_id");

header("Location: ../pages/_admin/companies.php");