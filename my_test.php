<?php
/*
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
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>测试</title>
    <script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
    function getSelectGroup(){
        var sel_val = $("#group").val();
        if(sel_val == ""){
            window.alert("请选择Group");
            $("#group").focus();
            return false;
        }
        $.ajax({
            type:"POST",
            url:"./comm/delete.php",
            data:"group"+sel_val,
            success:function(msg){
                alert(msg)
            }
        });
    }
    </script>
</head>
<body>
<?php
require_once("./js/conf.php");
$gg = "";
echo "<select name='group[]' id='group' onchange='getSelectGroup()'>";
echo "<option value=''>Sel Group</option>";
$check = mysqli_query($con, "SELECT Groups FROM dropbox_group");
while ($row = mysqli_fetch_array($check)) {
    $v1 = $row["Groups"];
    echo "<option value='$v1'>$v1</option>";
}
echo "</select><br>";

echo "<select name='test_item[]' class='selbox' id='test_item'>";
$check = mysqli_query($con, "SELECT Testitem FROM dropbox_test_item");
while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
    echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
}
echo "</select>";
?>    
</body>
</html>