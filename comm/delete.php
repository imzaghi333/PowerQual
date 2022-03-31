<?php
require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");

if(isset($_GET["id"])){
    $id = $_GET["id"];
    echo $id;
    //刪除一條記錄，仍然保留在數據庫，但是不會顯示在頁面
    $sql_delete = "UPDATE DQA_Test_Main SET Results='N/A',Units='N/A' WHERE RecordID='$id' ";
    //执行SQL语句
    if(mysqli_query($con,$sql_delete)){
        //echo "<meta http-equiv='refresh' content='1; url=../index.php?dowhat=data'>";
        $url = "index.php?dowhat=data";
        $message = urlencode("刪除成功");
        header("location:../success.php?url=$url&message=$message");
    }
    mysqli_close($con);
}

if(isset($_GET["username"])&&isset($_GET["product"])&&isset($_GET["starting"])){
    $product  = urldecode($_GET["product"]);
    $username = urldecode($_GET["username"]);
    $starting = urldecode($_GET["starting"]);
    //echo $product."---".$username."---".$starting;
    //刪除一TestMatrix,删了就没有了
    $sql_delete_matrix = "DELETE FROM DQA_Test_Main WHERE Products='$product' AND Testername='$username' AND Timedt='$starting' ";
    if(mysqli_query($con,$sql_delete_matrix)){
        $url = "index.php";
        $message = urlencode("Matrix ".$product."测试已删除");
        header("location:../success.php?url=$url&message=$message");
    }
}
?>