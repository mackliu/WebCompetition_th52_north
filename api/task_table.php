<?php 
include_once "base.php";

$user=$User->find(['acc'=>$_SESSION['login']]);
$tasks=$Task->all(['user_id'=>$user['id'],'date'=>date("Y-m-d")],"order by `start`");

//以小時為key建立一個新的資料陣列
$taskList=[];
foreach($tasks as $task){
    $taskList[$task['start']][]=$task;
}

//把有工作項目的小時字串獨立出一個陣列
$hoursKey=array_keys($taskList);

//建立一個紀錄每小時有多少工作的陣列，用來決定在每個區間的工作項目放置位置
$hoursTasks=[];
foreach($tasks as $task){
    $start=explode(":",$task['start'])[0];
    $end=explode(":",$task['end'])[0];
    $duration=$end-$start;
    for($i=0;$i<$duration;$i++){
        $hoursTasks[sprintf("%02d:00",($start+$i))][]=$task['id'];
    }
}
?>
<div class="task-table-head">
    <div class="d-flex bg-primary">
        <div class="col-md-2  d-flex p-2 align-items-center justify-content-center text-light border-right border-light" style="height:5vh">時間</div>
        <div class="col-md-10 d-flex p-2 align-items-center justify-content-center text-light" style="height:5vh">工作計畫</div>
    </div>
</div>
<div class="task-table-body d-flex">
    <!--左區時間軸-->
    <div class="task-table-left col-md-2 text-light bg-info p-0">
    <?php
        for($i=0;$i<24;$i=$i+2){
        $hours=sprintf("%02d - %02d",$i,($i+2));
    ?>
        <div style="height:6.5vh" class="d-flex align-items-center justify-content-center border-right border-bottom border-light"><?=$hours;?></div>
    <?php
        }
    ?>
    </div>
    <!--右區工作項目列表-->
    <div class="task-table-right col-md-10 p-0">
        <?php
        for($i=0;$i<24;$i++){
            $hour=sprintf("%02d:00",$i);

            //間隔兩小時加一條底線
            $bottom=($i%2==1)?'border-bottom':'';
        ?>
        <div data-hours="<?=$hour;?>" class="d-100 border-right <?=$bottom;?> border-gray position-relative" style="height:3.25vh">
        <?php
            //判斷此時間段有沒有工作項目在
            if(in_array($hour,$hoursKey)){
                
                //將此時間段的工作項目逐一列出
                foreach($taskList[$hour] as $task){
                    $width="150px";

                    //依此工作項目的時數來計算區塊會佔用的高度
                    $height=(explode(":",$task['end'])[0]-explode(":",$task['start'])[0])*3.25;

                    //依此工作項目在此小時區段佔第幾項目工作來決定橫向的位置
                    $left=array_search($task['id'],$hoursTasks[$task['start']])*150;

                    //在畫面上建立工作區塊
                    echo "<div class='border bg-success text-light position-absolute' style='z-index:10;left:{$left}px;width:{$width};height:{$height}vh'>";
                    echo $task['name'];
                    echo "</div>";
                }
            }
        ?>
        </div>
        <?php
        }
        ?>
    </div>
</div>
