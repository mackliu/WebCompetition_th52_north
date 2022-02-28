<?php
include_once "../api/base.php";

$task=$Task->find($_POST['id']);
?>
<div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="editTaskLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTaskLabel">工作編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <ul class="list-group col-md-11 m-auto">
        <li class="list-group-item d-flex">
          <label for="name" class="col-md-2 px-0">工作名稱：</label>
          <input type="text" name='name' id='name' value="<?=$task['name'];?>" class="col-md-10">
        </li>
        <li class="list-group-item d-flex">
          <label for="status" class="col-md-2 px-0">處理情形：</label>
          <select name="status" id="status" class="col-md-3">
            <option value="1" <?=($task['status']==1)?'selected':'';?>>未處理</option>
            <option value="2" <?=($task['status']==2)?'selected':'';?>>處理中</option>
            <option value="3" <?=($task['status']==3)?'selected':'';?>>已完成</option>
          </select>
          <div class="col-md-1">&nbsp;</div>
          <label for="priority" class="col-md-2 px-0">優先情形：</label>
          <select name="priority" id="priority" class="col-md-3">
            <option value="1" <?=($task['priority']==1)?'selected':'';?>>普通件</option>
            <option value="2" <?=($task['priority']==2)?'selected':'';?>>速件</option>
            <option value="3" <?=($task['priority']==3)?'selected':'';?>>最速件</option>
          </select>
        </li>
        <li class="list-group-item d-flex">
        <label for="start" class="col-md-2 px-0">開始時間：</label>
          <select name="start" id="start" class="col-md-3">
          <?php
            for($i=1;$i<=24;$i++){
              $zero=sprintf("%02d",$i);
              $selected=($task['start']==($zero.":00"))?'selected':'';
              echo "<option value='$zero:00' $selected>$zero:00</option>";
            }
          ?>
          </select>
          <div class="col-md-1">&nbsp;</div>
          <label for="end" class="col-md-2 px-0">結束時間：</label>
          <select name="end" id="end" class="col-md-3">
          <?php
            for($i=1;$i<=24;$i++){
              $zero=sprintf("%02d",$i);
              $selected=($task['end']==($zero.":00"))?'selected':'';
              echo "<option value='$zero:00' $selected>$zero:00</option>";
            }
          ?>
          </select>
        </li>
        <li class="list-group-item">
          <div>工作內容：</div>
          <textarea name="description" id="description" class="col-md-12" style="height:100px"><?=$task['description'];?></textarea>
        </li>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submit(<?=$task['id'];?>)">確定</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>

<script>
function submit(id){
  let data={
    id,
    name:$("#name").val(),
    status:$("#status").val(),
    priority:$("#priority").val(),
    start:$("#start").val(),
    end:$("#end").val(),
    description:$("#description").val(),
  }
  $.post("api/edit_task.php",data,(res)=>{
    console.log(res)
      alert("工作修改完成");
      $("#editTask").modal("hide")
      $("#editTask").on("hidden.bs.modal",()=>{
        $("#editTask").modal("dispose")
        $("#modal").html("")
        loadTaskList();
      })
  })
}

</script>