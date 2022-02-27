<?php
include_once "./api/base.php";
if(!isset($_SESSION['login'])){
    to("login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="#" type="image/x-icon">
</head>
<body>
    <h1>TODO 工作表</h1>
    
</body>
</html>
