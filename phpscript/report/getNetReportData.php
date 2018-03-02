<?php
session_start();
//including the database connection file
include_once("../../classes/Crud.php");
include_once("netReportData.php");



$output=netReport($_POST['datefrom'], $_POST['dateto'], $_POST['category'], $_POST['report_type'],$_POST["search_by"]);
echo json_encode($output);

?>