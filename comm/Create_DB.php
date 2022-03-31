<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="Text/html; charset=utf-8" />
    <title>Create Database</title>
</head>
<body>
    
</body>
</html>

<?php
date_default_timezone_set("Asia/Shanghai");
$my_host = "localhost:3306";
$my_user = "root";
$my_pwd = "Yale@0519";
$con = mysqli_connect($my_host,$my_user,$my_pwd);

if(!$con){
    die("Could not connect to MySQL".mysqli_connect_error());
}
$sql = "CREATE DATABASE DQA_Record CHARACTER SET utf8";
if(mysqli_query($con,$sql)){
    echo "<h1 style='color:#337ab7;'>DQA_Record Database created successfully!~~~</h1>";
}
else{
    echo "<h1 style='#a94442;'>Error of creating database".mysqli_connect()."</h1>";
}
?>