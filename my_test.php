<?php
require_once("./js/conf.php");
$resource = mysqli_query($con, "SELECT * FROM dropbox_test_item");
$res = array();
while($row=mysqli_fetch_assoc($resource)){
    $res[] = $row;
}
echo "<br><pre>";
$LEN = count($res);
echo $LEN."<br>";
foreach($res as $k=>$v){
    foreach($v as $vk=>$vv){
        echo $vk."--->".$vv."<br>";
    }
    echo "<br>";
}
echo "<br>";
echo date("y/n/j");
echo "<hr>";
$arr1 = array('BBB','CCC','DDD');
echo "<pre>";
echo "原来的数组：<br>";
print_r($arr1);
array_unshift($arr1,'AAA');
echo "插入一个值：<br>";
print_r($arr1);

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;◢＼  ☆ 　／◣"."<br>"; 
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;∕    ﹨╰╮ ∕  ﹨"."<br>"; 
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▏  ～～′′～～  ｜"."<br>"; 
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;﹨ ／　 　 ＼ ∕"."<br>"; 
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;∕  ●　　 ●  ＼"."<br>"; 
echo "&nbsp;&nbsp;&nbsp;&nbsp;＝＝○　∴  ╰╯  ∴　○＝＝"."<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;╭ ── ╮　　　 　╭ ── ╮"."<br>";
echo "&nbsp;╔═ ∪∪∪═ 万事如意═ ∪∪∪═╗"."<br>";
?>