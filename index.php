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
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/fontawesome.css">
    <script src="./js/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>TODO 工作表</h1>
        <button class='btn btn-success m-2 p-2' onclick="addTask()">新增工作</button>
        <div id="taskList"></div>
        <div id="taskTable"></div>     
    </div>

    <div id="modal"></div>
    <script src="./js/bootstrap.js"></script>     
</body>
</html>
<script>
//loadTaskList()
loadTaskTable()
function loadTaskTable(){
    $("#taskTable").load("api/task_table.php")
}
function loadTaskList(){
    $("#taskList").load("api/task_list.php")
}
function addTask(){
    $("#modal").load("modal/add_task.php",()=>{
        $("#addTask").modal("show")
    })
}
</script>
