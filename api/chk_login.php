<?php
include_once "base.php";
if(!isset($_SESSION['errtimes'])){
    $_SESSION['errtimes']=0;
}
//檢查驗證碼是否正確
$chk_ans=($_SESSION['ans']==$_POST['ans'])?1:0;

//檢查帳號是否存在
$chk_acc=$User->math("count","*",['acc'=>$_POST['acc']]);

if($chk_acc){
    //檢查密碼是否錯誤
    $chk_pw=$User->math("count","*",['acc'=>$_POST['acc'],'pw'=>$_POST['pw']]);
}

$msg='';
$code='';
if($chk_ans){
    $code.=$chk_ans;
}else{
    $msg.="驗證碼錯誤";
    $code.=$chk_ans;
}

if($chk_acc){
    $code.=$chk_acc;
    if($chk_pw){
        $code.=$chk_pw;
    }else{
        $msg.="密碼錯誤";
        $code.=$chk_pw;
    }
}else{
    $msg.="帳號錯誤";
    $code.=$chk_acc;
}

if($code=='111'){
    $_SESSION['login']=$_POST['acc'];
    unset($_SESSION['errtimes']);
}else{

    $_SESSION['errtimes']++;
}


echo json_encode(['code'=>$code,'msg'=>$msg,'errtimes'=>$_SESSION['errtimes']]);

?>