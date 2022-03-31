<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");
header("Content-Type:text/html;charset=utf-8");

$fileInfo = $_FILES['myfile'];    //接收上传文件,二维数组
$Dropbox = $_POST["dropbox"];     //接收Dropbox name

$allowExt = array('xlsx','xls');    //检测扩展名
$ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));    //获取文件扩展名

if(!in_array($ext,$allowExt)){
    echo "<font color='#be0f2d' size='7'>文件擴展名錯誤</font><br>";
    echo "<img src='images/ku.jpg' width='200'>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
    exit();
}

$uploadPath = "upload";        //上传的文件存储到这里
if(!is_dir($uploadPath)){
    mkdir($uploadPath);
}
$basename = date("Ymd").$fileInfo["name"];    //上次成功后的文件名字(日期+原文件名)
$dest = $uploadPath.'/'.$basename;            //上傳文件路徑

if(move_uploaded_file($fileInfo['tmp_name'], $dest)){
    echo "<p style='color:#355386; text-align:left; font-size:14px;'>上传的文件：<a href='{$dest}'>{$fileInfo['name']}</a></p>";
    echo "<img src='images/xiao.jpg' width='200'><br>";
}
else{
    echo "<font color='#be0f2d' size='7'>上传失败</font><br>";
    echo "<img src='images/ku.jpg' width='200'>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// -------------------- upload file complete ----------------------------------------

require_once "Classes/PHPExcel.php";
require_once "Classes/PHPExcel/IOFactory.php";
header("Content-Type:text/html;charset=utf8");
header("Access-Control-Allow-Origin: *");      //解决跨域
header("Access-Control-Allow-Methods:GET");    //响应类型
header("Access-Control-Allow-Headers: *");
set_time_limit(0);
error_reporting(0);

$excel_path = "upload"."/".$basename;    //上传好的文件路径
$fileType = PHPExcel_IOFactory::identify($excel_path);    //获取文件类型

$objReader = PHPExcel_IOFactory::createReader($fileType);    //获取文件操作读取对象
$objPHPExcel = $objReader->load($excel_path);                //读取Excel
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();       //取得总行数
$highestCol = $sheet->getHighestColumn();    //取得总列数
++$highestCol;

// ------------------------读取excel内容打印在网页上------------------------------
echo "<br><br>";
foreach($objPHPExcel->getWorksheetIterator() as $sheet){
    foreach($sheet->getRowIterator() as $row){
        foreach($row->getCellIterator() as $cell){
            $data = $cell->getValue().' | ';
            echo "<span style='color:#337ab7;font-size:10px;'>".$data."</span>";
        }
        echo "<br>";
    }
    echo "<br>";
}

// ----------------------- 数据写入MySQL ---------------------------------------
/*
for($j=2; $j<=$highestRow; $j++){
    $str = "";
    for($k='A'; $k!=$highestCol; $k++){
        $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
    }
    $strs = explode("|",$str);    //Array
    $sql_add = "INSERT INTO dropbox_df1(DefectMode) VALUES('$strs[0]')";
    mysqli_query($con,$sql_add);
}
mysqli_close($con);
echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
*/

// 1.Product Menu
if($Dropbox == "Product"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_product(Product) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 2.SKU Menu
else if($Dropbox == "SKU"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_sku(SKUS) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 3.Phase Menu
else if($Dropbox == "phases"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_phase(Phase) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 4.Test items Menu
else if($Dropbox == "Testitem"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_test_item(Testitem) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 5.DefectMode(Symptom)
else if($Dropbox == "df1"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_df1(DefectMode) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 6.DefectMode(Symptom+Finding)
else if($Dropbox == "df2"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_df2(DefectMode) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 7.Dropside Menu
else if($Dropbox == "Dropside"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_dropside(Dropside) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 8. Result Menu
else if($Dropbox == "Result"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_result(Result) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 9. Issue statuss Menu
else if($Dropbox == "Issue_Status"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_issue_status(Issue_Status) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 10. Group Menu
else if($Dropbox == "Group"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_group(Groups) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
// 11. Test Condition Menu
else if($Dropbox == "Testcondition"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $comma = "/\'/";
        $replace = "\'";
        $condition = preg_replace($comma,$replace,$strs[0]);  
        $sql_add = "INSERT INTO dropbox_test_condition(Testcondition) VALUES('$condition')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
//12. Test Lab and MFG Site
else if($Dropbox == "LAB"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_lab_site(LAB_SITE) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
//12. Test Order
else if($Dropbox == "Order"){
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='A'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|';
        }
        $strs = explode("|",$str);    //Array
        $sql_add = "INSERT INTO dropbox_test_order(Testorder) VALUES('$strs[0]')";
        mysqli_query($con,$sql_add);
    }
    mysqli_close($con);
    echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>Excel数据导入MySQL完成:)</h1>";
    echo "<meta http-equiv='refresh' content='2; url=index.php?dowhat=upload'>";
}
//删除上传的Excel
sleep(1);
$arr_name = scandir("./upload");
foreach($arr_name as $name){
    $ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));//获取文件类型
    if($ext){
        $path = "upload/".$name;
        unlink($path);
    }
}
?>