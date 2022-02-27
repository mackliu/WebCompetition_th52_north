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
    <script src="./js/jquery-3.6.0.min.js"></script>
    <style>
        table{
            height:90vh;
        }
        table th{
            background:blue;
            color:white;
        }
        table td:nth-child(1){
            background:lightblue;
        }

    </style>
</head>
<body>
    <div class="container">

        <h1>TODO 工作表</h1>
        <table class="table table-bordered table-hover" id="daliy">
            <tr>
                <th width="20%">時間</th>
                <th width="80%">工作計畫</th>
            </tr>
            <tr>
                <td>00-02</td>
                <td></td>
            </tr>
            <tr>
                <td>02-04</td>
                <td></td>
            </tr>
            <tr>
                <td>04-06</td>
                <td></td>
            </tr>
            <tr>
                <td>06-08</td>
                <td></td>
            </tr>
            <tr>
                <td>08-10</td>
                <td></td>
            </tr>
            <tr>
                <td>10-12</td>
                <td></td>
            </tr>
            <tr>
                <td>12-14</td>
                <td></td>
            </tr>
            <tr>
                <td>14-16</td>
                <td></td>
            </tr>
            <tr>
                <td>16-18</td>
                <td></td>
            </tr>
            <tr>
                <td>18-20</td>
                <td></td>
            </tr>
            <tr>
                <td>20-22</td>
                <td></td>
            </tr>
            <tr>
                <td>22-24</td>
                <td></td>
            </tr>
        </table>
    </div>


    <script src="./js/bootstrap.js"></script>     
</body>
</html>
