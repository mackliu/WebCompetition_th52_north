<?php include_once "api/base.php";
if(!isset($_SESSION['login']) && $_SESSION['login']!=='admin'){
    to("index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1 class='text-center'>管理者功能</h1>
    <button class="btn btn-primary my-5">新增會員</button>

    <h2 class="text-primary m-3">會員列表</h2>
    <ul class="list-group m-5 col-md-10">
        <li class="list-group-item">
            <span>會員帳號</span>
            <span>會員修改</span>
            <span>權限修改</span>
            <span>登入驗證</span>
            <span>登入/登出紀錄</span>
            <span>刪除</span>
        </li>
        <?php
    $users=$User->all();
    foreach ($users as  $user) {
        if($user['acc']!=='admin'){

    ?>
        <li class="list-group-item d-flex">
            <div class="col-md-5"><?=$user['acc'];?></div>
            <div class="col-md-5">
                <button class='btn btn-primary'>會員修改</button>
                <button class='btn btn-success'>權限修改</button>
                <button class='btn btn-warning'>登入驗證</button>
                <button class='btn btn-info'>登入/登出紀錄</button>
                <button class='btn btn-danger'>刪除</button>
            </div>
        </li>
        <?php
        }
    }    
    ?>
    </ul>
    <script src="./js/bootstrap.js"></script>
</body>

</html>