<?php
function linkDB($db_host,$db_user,$db_pwd){
    $connect = mysqli_connect($db_host,$db_user,$db_pwd);
    if(mysqli_connect_error($connect)){
        die("Connect fail: ".mysqli_connect_error());
    }
    return $connect;
}
    
$my_host = "localhost:3306";
$my_user = "root";
$my_pwd = "Yale@0519";

$con = linkDB($my_host,$my_user,$my_pwd);
mysqli_select_db($con,"DQA_Record");
mysqli_query($con,"set names utf8;");
date_default_timezone_set("PRC");

$footer = "Copyright&nbsp;&nbsp;&copy;&nbsp;&nbsp;Wistron InfoComm CO.Ltd | All rights reserved | 2Q2L20 Fexlix Qian";

//定义错误处理器：发生错误就会被自动调用,而且会传入该4个实参数据
//该函数需要定义4个形参，分别代表：
//$errCode：代表错误代号（级别）
//$errMsg：	代表错误信息内容
//$errFile:	代表发生错误的文件名
//$errLine:	代表发生错误的行号
function my_error_handler($errCode, $errMsg, $errFile, $errLine){
	$str = "";
	$str .= "<p><font color='red'>大事不好,发生错误啦：</font>";
	$str .= "<br />错误代号为：" . $errCode;
	$str .= "<br />错误内容为：" . $errMsg;
	$str .= "<br />错误文件为：" . $errFile;
	$str .= "<br />错误行号为：" . $errLine;
	$str .= "<br />发生时间为：" . date("Y-d-m H:i:s");
	$str .= "</p >";
	echo $str;
}
?>