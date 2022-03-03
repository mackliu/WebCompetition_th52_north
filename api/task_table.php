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
    $start=$task['start'];
    $end=$task['end'];
    $duration=$end-$start;
    for($i=0;$i<$duration;$i++){
        if(isset($hoursTasks[sprintf("%02d",($start+$i-1))])){
            $prev=array_search($task['id'],$hoursTasks[sprintf("%02d",($start+$i-1))]);
            if($prev!=false){
                $hoursTasks[sprintf("%02d",($start+$i))][$prev]=$task['id'];
            }else{
                $hoursTasks[sprintf("%02d",($start+$i))][]=$task['id'];
            }
        }else{
            $hoursTasks[sprintf("%02d",($start+$i))][]=$task['id'];
        }

    }
}


//dd($hoursTasks);
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
            $hour=sprintf("%02d",$i);

            //間隔兩小時加一條底線
            $bottom=($i%2==1)?'border-bottom':'';
        ?>
        <div data-hours="<?=$hour;?>" class="time-line d-100 border-right <?=$bottom;?> border-gray position-relative" style="height:3.25vh">
        <?php
            //判斷此時間段有沒有工作項目在
            if(in_array($hour,$hoursKey)){
                
                //將此時間段的工作項目逐一列出
                foreach($taskList[$hour] as $task){
                    $width="150px";

                    //依此工作項目的時數來計算區塊會佔用的高度
                    $height=($task['end']-$task['start'])*3.25;

                    //依此工作項目在此小時區段佔第幾項目工作來決定橫向的位置
                    $left=array_search($task['id'],$hoursTasks[$task['start']])*150;

                    //在畫面上建立工作區塊，需加入可拖曳的設定
                    echo "<div draggable='true' class='task-block border bg-success text-light position-absolute overflow-hidden' style='z-index:10;left:{$left}px;width:{$width};height:{$height}vh' data-id='{$task['id']}' data-start='{$task['start']}'>";
                    echo "  <div class='job-duration'>{$task['start']}-{$task['end']}</div>";
                    echo "  <div class='job-name'>{$task['name']}</div>";
                    echo "  <div class='job-status'>{$Task->status($task['status'])}</div>";
                    echo "  <div class='job-priority'>{$Task->priority($task['priority'])}</div>";
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
<script>
$(".task-block").on("click",function(e){
    let id=$(this).data("id")
    //暫停事件傳遞，避免觸發新增工作功能
    e.stopPropagation()
    editTask(id)
})
$(".time-line").on("click",function(e){
    addTask();
})


//工作項目的拖曳事件監聽
$(".task-block").on({
    'dragstart':(e)=>{
        dragInfo.block=$(e.currentTarget);
        dragInfo.hours=$(e.currentTarget).data("start")
        dragInfo.position=$(e.currentTarget).offset()
        dragInfo.shift={
            x:dragInfo.position.left-e.pageX,
            y:dragInfo.position.top-e.pageY
        }
        dragInfo.duration=Math.abs(eval($(e.currentTarget).children('div').eq(0).text()))
        //建立一個空白的圖形資源
        img = new Image();
        //把空白圖形資源寫入到拖曳事件中的預設替代圖片中，讓下方的元素資訊可以顯示出來
        e.originalEvent.dataTransfer.setDragImage(img,0,0)
        
    },
    'drag':(e)=>{
       //let dom=document.getElementsByClassName('task-block')[$(dragInfo.block).index()]
        //console.log(e.dataTransfer)
       // 根據滑鼠當前位置來決定工作區塊的新位置
        let pos={ 
                  top:e.pageY+dragInfo.shift.y,
                  left:e.pageX+dragInfo.shift.x
                }
        dragInfo.position=pos        
        //先隱藏工作區塊來讓下方的時間區塊成為可見的狀態                
        $(dragInfo.block).hide()                  

        //利用document.elementFromPoint來找到目前區塊上緣中心的位置屬於那個時間區塊
        let timeLine=document.elementFromPoint((pos.left+75),pos.top)

        //判斷這個區塊是不是時間區塊
        if($(timeLine).hasClass("time-line")){
            //如果是時間區塊則把這個時間區塊的小時更新到dragInfo中
            dragInfo.hours=$(timeLine).data("hours")
        }

        //重新顯示工作區塊
        $(dragInfo.block).show()

        //計算工作區塊移動後的新結束時間
        dragInfo.end=parseInt(dragInfo.hours)+dragInfo.duration

        //更新工作區塊中的時間資訊
        $(dragInfo.block).find('.job-duration').text(`${dragInfo.hours}-${dragInfo.end}`)

       //更新區塊在畫面上的位置
        $(dragInfo.block).offset(pos)

    },
    'dragend':(e)=>{
        //先隱藏工作區塊來讓下方的時間區塊成為可見的狀態                
        $(dragInfo.block).hide()                  

        //利用document.elementFromPoint來找到目前區塊上緣中心的位置屬於那個時間區塊
        let timeLine=document.elementFromPoint((dragInfo.position.left+75),dragInfo.position.top)

        //判斷這個區塊是不是時間區塊
        if($(timeLine).hasClass("time-line")){
            //如果是時間區塊
            //1.先把區塊的top屬性設為0，用來對齊每個小時的區塊上緣
            $(dragInfo.block).css({top:0})

            //2.把這個工作區塊放到這個時間區塊中
            $(dragInfo.block).appendTo(timeLine)
            
        }

        //重新顯示工作區塊
        $(dragInfo.block).show()
    }
})

//每小時時間線的拖曳監聽事件
$(".time-line").on({
    'dragenter':(e)=>{
        //e.stopPropagation()
        e.preventDefault()
       
      // console.log($(e.currentTarget).offset())
    },
    'dragover':(e)=>{
       e.preventDefault()
    },
    'drop':(e)=>{

    }
})
</script>