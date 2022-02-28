<?php
include_once "base.php";

$user=$User->find(['acc'=>$_SESSION['login']]);

//預設排序方式為由小到大
$col=$_GET['col']??'start';
$sort=$_GET['sort']??'asc';
if(isset($_GET['col']) && isset($_GET['sort'])){
    //根據前端取得的排序值來決定排序方式
    switch($_GET['sort']){
        case 'none':
            $sort="asc";
        break;
        case 'asc':
            $sort='desc';
        break;
        case 'desc':
            $sort='asc';
        break;
    }
}

$tasks=$Task->all(['user_id'=>$user['id'],'date'=>date("Y-m-d")]," order by `$col` $sort ");

?>
<ul class="list-group">
    <li class="list-group-item list-group-item-action d-flex text-center align-items-center">
        <span class="col-md-2">時間&nbsp;<i class="fas fa-sort" data-name="start" data-sort="<?=(isset($_GET['col']) && $_GET['col']=='start')?$sort:'asc';?>"></i></span>
        <span class="col-md-2">工作名稱&nbsp;<i class="fas fa-sort" data-name="name" data-sort="<?=(isset($_GET['col']) && $_GET['col']=='name')?$sort:'none';?>"></i></span>
        <span class="col-md-2">處理狀態&nbsp;<i class="fas fa-sort" data-name="status" data-sort="<?=(isset($_GET['col']) && $_GET['col']=='status')?$sort:'none';?>"></i></span>
        <span class="col-md-2">優先順序&nbsp;<i class="fas fa-sort" data-name="priority" data-sort="<?=(isset($_GET['col']) && $_GET['col']=='priority')?$sort:'none';?>"></i></span>
        <span class="col-md-2">工作內容</span>
        <div class="col-md-2 text-center d-flex justify-content-around">操作</div>
    </li>
<?php
foreach($tasks as $task){
?>
    <li class="list-group-item list-group-item-action d-flex text-center align-items-center">
        <span class="col-md-2"><?=$task['start'];?> ~ <?=$task['end'];?></span>
        <span class="col-md-2"><?=$task['name'];?></span>
        <span class="col-md-2"><?=$Task->status($task['status']);?></span>
        <span class="col-md-2"><?=$Task->priority($task['priority']);?></span>
        <span class="col-md-2"><?=mb_substr($task['description'],0,10);?>...</span>
        <div class="col-md-2 text-center d-flex justify-content-around">
            <button class="btn btn-info" onclick="editTask(<?=$task['id'];?>)">編輯</button>
            <button class="btn btn-danger" onclick="delTask(<?=$task['id'];?>)">刪除</button>
        </div>
    </li>
<?php
}
?>
</ul>

<script>
$(".fas.fa-sort").on("click",function(){
    let data={
                col:$(this).data("name"),
                sort:$(this).data("sort")
             }
    $.get("api/task_list.php",data,(list)=>{
        $("#taskList").html(list)
    })
})

function delTask(id){
    let chk=confirm("確認要刪除工作項目嗎?")
    if(chk===true){
        $.post("api/del_task.php",{id},()=>{
            loadTaskList()
            loadTaskTable()
        })
    }

}

function editTask(id){
    $("#modal").load("modal/edit_task.php",{id},()=>{
        $("#editTask").modal("show")
    })
}
</script>