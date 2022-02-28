<?php
include_once "base.php";
$user=$User->find(['acc'=>$_SESSION['login']]);
$_POST['user_id']=$user['id'];
$_POST['date']=date("Y-m-d");

$Task->save($_POST);


?>