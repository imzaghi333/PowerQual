<?php
require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("Asia/Shanghai");

if(isset($_POST["del_opt"]) && $_POST["del_opt"]=="del_opt_do"){
    $del_table = $_POST["del_table"];
    $del_id = $_POST["del_id"];
    //echo $del_table." ".$del_id;
    $sql_del = "DELETE FROM {$del_table} WHERE ID={$del_id}";
    if(mysqli_query($con, $sql_del)){
        echo "<script>window.alert('刪除記錄成功！~~~');</script>";
        echo "<meta http-equiv='refresh' content='1; url=../index.php?dowhat=edit'>";
    }
    else{
        echo "<script>window.alert('执行SQL出错啦！~~~');</script>";
        echo "<meta http-equiv='refresh' content='1; url=../index.php?dowhat=edit'>";
    }
}
?>