<?php
include_once "base.php";
if(!isset($_SESSION['login'])){
    to("login.html");
    exit();
}

