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
            <div class="d-flex bg-primary">
                <div class="col-md-2  d-flex p-2 align-items-center justify-content-center text-light border-right border-light" style="height:5vh">時間</div>
                <div class="col-md-10 d-flex p-2 align-items-center justify-content-center text-light" style="height:5vh">工作計畫</div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom border-light' style='height:6.5vh'>00-02</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>02-04</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>04-06</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>06-08</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>08-10</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>10-12</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>12-14</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>14-16</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>16-18</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>18-20</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>20-22</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
            <div class="d-flex">
                <div class='col-md-2 d-flex p-2 align-items-center justify-content-center text-light bg-info border-right border-bottom  border-light' style='height:6.5vh'>22-24</div>
                <div class="col-md-10 d-flex flex-wrap p-0 bg-light border-bottom border-white">
                    <div class='w-100'></div>
                    <div class='w-100'></div>
                </div>
            </div>
        
    </div>

    <div id="modal"></div>
    <script src="./js/bootstrap.js"></script>     
</body>
</html>
<script>
loadTaskList()
function loadTaskList(){
    $("#taskList").load("api/task_list.php")
}
function addTask(){
    $("#modal").load("modal/add_task.php",()=>{
        $("#addTask").modal("show")
    })
}
</script>
