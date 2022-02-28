<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="addTaskLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTaskLabel">工作編輯</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <ul class="list-group col-md-11 m-auto">
        <li class="list-group-item d-flex">
          <label for="name" class="col-md-2 px-0">工作名稱：</label>
          <input type="text" name='name' id='name' class="col-md-10">
        </li>
        <li class="list-group-item d-flex">
          <label for="status" class="col-md-2 px-0">處理情形：</label>
          <select name="status" id="status" class="col-md-3">
            <option value="1">未處理</option>
            <option value="2">處理中</option>
            <option value="3">已完成</option>
          </select>
          <div class="col-md-1">&nbsp;</div>
          <label for="priority" class="col-md-2 px-0">優先情形：</label>
          <select name="priority" id="priority" class="col-md-3">
            <option value="1">普通件</option>
            <option value="2">速件</option>
            <option value="3">最速件</option>
          </select>
        </li>
        <li class="list-group-item d-flex">
        <label for="start" class="col-md-2 px-0">開始時間：</label>
          <select name="start" id="start" class="col-md-3">
          <?php
            for($i=1;$i<=24;$i++){
              $zero=sprintf("%02d",$i);
              echo "<option value='$zero:00'>$zero:00</option>";
            }
          ?>
          </select>
          <div class="col-md-1">&nbsp;</div>
          <label for="end" class="col-md-2 px-0">結束時間：</label>
          <select name="end" id="end" class="col-md-3">
          <?php
            for($i=1;$i<=24;$i++){
              $zero=sprintf("%02d",$i);
              echo "<option value='$zero:00'>$zero:00</option>";
            }
          ?>
          </select>
        </li>
        <li class="list-group-item">
          <div>工作內容：</div>
          <textarea name="description" id="description" class="col-md-12" style="height:100px"></textarea>
        </li>
      </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submit()">確定</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>

<script>
function submit(){
  let data={
    name:$("#name").val(),
    status:$("#status").val(),
    priority:$("#priority").val(),
    start:$("#start").val(),
    end:$("#end").val(),
    description:$("#description").val(),
  }
  $.post("api/add_task.php",data,(res)=>{
    console.log(res)
      alert("工作新增完成");
      $("#addTask").modal("hide")
      $("#addTask").on("hidden.bs.modal",()=>{
        $("#addTask").modal("dispose")
        $("#modal").html("")
      })
  })
}

</script>