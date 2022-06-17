<!--
钟山风雨起苍黄 百万雄师过大江
虎踞龙盘今胜昔 天翻地覆慨而慷
宜将剩勇追穷寇 不可沽名学霸王
天若有情天亦老 人间正道是沧桑

王濬楼船下益州 金陵王气黯然收
千寻铁锁沉江底 一片降幡出石头
人世几回伤往事 山形依旧枕寒流
今逢四海为家日 故垒萧萧芦荻秋
-->
<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="images/favior.ico">
    <script type="text/javascript" src="js/dqa_main.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="./Filter/css/latin-ext.css" >

	<link rel="stylesheet" type="text/css" href="./Filter/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="./Filter/css/select2.min.css"  />
	<link rel="stylesheet" type="text/css" href="Filter/css/style.css">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <title>Power Query</title>
</head>
<body>
<?php
require_once("./js/conf.php"); 
?>
<!-- header部分 -->
<div class="header"><a href="index.php"><img class="wistron_logo" src="./images/logo.svg" width="180" /></a></div>

<div class="container">
    <!-- 左邊菜單欄 -->
    <div class="left">
        <div class="action">
            <div><a href="index.php">Query<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=start">Matrix Creating<span class="p_right">&#10148</span></a></div>
            <div><a href="index_filter.php?dowhat=export">Export Raw Data<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=data">All Data&nbsp;&nbsp;<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=upload">DropBox Upload<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=edit">DropBox Edit<span class="p_right">&#10148</span></a></div>
            <br>
            <a href=mailto:felix_qian@wistron.com><img id="logo" src="./images/logo.svg" width="150" /></a><br>
            <div><?php echo "Your IP: ".$_SERVER ['REMOTE_ADDR']; ?></div>
        </div>
    </div>
    <!-- 左邊菜單欄結束 -->
    <div class="right">
        <?php
        /**
         * Create test matrx; 1. Manually fill the form; 2. via upload .xls file, use the attached template
         */
        if($_GET['dowhat'] == 'start' || $_POST['dowhat'] == 'startdo'){
        ?>
            <p class="info">Add new task by filling form or uploading file</p>
            <div>
                <form id="form1" name="form1" method="POST" action="matrix.php" onsubmit="return checkForm1()">
                    <table align="center" class="form1">
                        <tr>
                            <td width="20%">Title</td>
                            <td><input name="title" type="text" placeholder="Descrition of your project" /></td>
                        </tr>
                        <tr>
                            <td width="20%">Stage</td>
                            <td>
                                <select name="stage">
                                    <option value="NPI">NPI</option>
                                    <option Value="Sus">Sus</option>
                                    <option Value="Others">其他</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Verification Type</td>
                            <td>
                                <select name="vt">                                    
                                    <option value="ORT">ORT</option>
                                    <option Value="QTP">QTP</option>
                                    <option Value="ENG (in spec)">ENG (in spec)</option>
                                    <option Value="Others">其他</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Product &nbsp;&nbsp;<span class="tablet-icon"></span></td>
                            <td>
                                <?php
                                echo "<select name='product'>";
                                $check = mysqli_query($con, "SELECT Product FROM dropbox_product");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["Product"]}'>{$row['Product']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>SKU</td>
                            <td>
                                <?php
                                echo "<select name='sku'>";
                                $check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["SKUS"]}'>{$row['SKUS']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr><td>Year/Month <font size="3" color="#be0f2d">*</font></td><td><input name="ym" type="month" placeholder="1949-10" /></td></tr>
                        <tr>
                            <td>Phase</td>
                            <td>
                                <?php
                                echo "<select name='phases'>";
                                $check = mysqli_query($con, "SELECT Phase FROM dropbox_phase");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["Phase"]}'>{$row['Phase']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Unit數量 <font size="3" color="#be0f2d">*</font></td>
                            <td><input name="unit" type="number" min="0" max="99" placeholder="測試機數量(如1，2，3...)" /></td>
                        </tr>
                        <!-- Calcel boot option on 2022-01-10
                        <tr>
                            <td>Boot</td>
                            <td>
                                <select name="boot">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </td>
                        </tr>
                        -->
                        <tr>
                            <td>Test LAB</td>
                            <td>
                                <?php
                                echo "<select name='testlab'>";
                                $check = mysqli_query($con, "SELECT LAB_SITE FROM dropbox_lab_site");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["LAB_SITE"]}'>{$row['LAB_SITE']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>MFG Site</td>                            
                            <td>
                                <?php
                                echo "<select name='mfgsite'>";
                                $check = mysqli_query($con, "SELECT LAB_SITE FROM dropbox_lab_site");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["LAB_SITE"]}'>{$row['LAB_SITE']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="icon">U</span> (測試人): <font size="3" color="#be0f2d">*</font> </td>
                            <td><input name="tester" type="text" placeholder="填寫測試人" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <button class="btn_sub" type="submit">下一步</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button name="reset" type="reset" class="btn-warning btn-lg">清&nbsp;&nbsp;空</button>
                                <input type="hidden" id="action" name="action" value="next" /><br>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <hr>
            <!-- upload .xls test matrix begins -->
            <div>
                <!-- save data animation -->
                <div id="preloder"><div class="loader"></div></div>
                <p style="color: #772953;margin-left:130px;">
                    Test Matrix上傳 (請務必使用本站提供的Template), 點擊此處下載Template: 
                    <a style="text-decoration:none; color:#002ea6;" href="./images/MatrixTemplate.xls">Template Download <span class="download-icon"></span></a>
                </p>
                <form id="form15" name="form15" action="" method="POST" enctype="multipart/form-data">
                    <input name="matrix_file" id="matrix_file" type="file" style="width: 400px;background-color:#772953;color:#e6d999;margin-left:130px;padding:5px;" required />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button name="matrix_upload" type="submit" class="btn_query">Upload</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="matrix_upload" type="reset" class="btn_reset">Clear</button>
                    <input name="upload_matrix" value="upload_matrix_do" type="hidden" />
                </form>
                <?php
                if(isset($_POST["upload_matrix"]) && $_POST["upload_matrix"]=="upload_matrix_do"){
                    $fileInfo = $_FILES['matrix_file'];    //接收上传文件,二维数组
                    $allowExt = array('xlsx','xls');    //检测扩展名,只允許Excel
                    $ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));    //获取文件扩展名
                    if(!in_array($ext,$allowExt)){
                        echo "<font color='#be0f2d' size='5'>文件擴展名錯誤,僅支持Excel文件. <a href='index.php?dowhat=start'>點擊返回</a></font>";
                        exit();
                    }
                    $uploadPath = "upload";        //上传的文件存储到这里
                    if(!is_dir($uploadPath)){
                        mkdir($uploadPath);
                    }
                    chmod($uploadPath, 0777);
                    $basename = date("Ymd").$fileInfo["name"];    //上次成功后的文件名字(日期+原文件名)
                    $dest = $uploadPath.'/'.$basename;            //上傳文件路徑
                    if(move_uploaded_file($fileInfo['tmp_name'], $dest)){
                        chmod($dest,0777);
                        echo "<p style='color:#355386; text-align:left; font-size:14px;'>導入Test Matrix：{$fileInfo['name']}</p>";
                    }
                    else{
                        echo "<font color='#be0f2d' size='7'>上传失败</font><br>";
                        echo "<img src='images/ku.jpg' width='200'>";
                        echo "<meta http-equiv='refresh' content='2; url=index.php'>";
                    }
                    
                    //讀取Excel内容
                    require_once "Classes/PHPExcel.php";
                    require_once "Classes/PHPExcel/IOFactory.php";
                    require_once "Classes/PHPExcel/Reader/Excel5.php"; 
                    require_once "Classes/PHPExcel/Reader/Excel2007.php";

                    set_time_limit(0);
                    error_reporting(0);

                    $excel_path = "upload"."/".$basename;    //上传好的文件路径
                    $fileType = PHPExcel_IOFactory::identify($excel_path);    //获取文件类型
                    $objReader = PHPExcel_IOFactory::createReader($fileType);    //获取文件操作读取对象
                    $objPHPExcel = $objReader->load($excel_path);                //读取Excel
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();       //取得总行数
                    $highestCol = $sheet->getHighestColumn();    //取得总列数
                    $LAST_COL_NO = PHPExcel_Cell::columnIndexFromString($highestCol);    //最后一列转成数字
                    define("OFFSET1",7);    //用于计算测试机数量
                    define("OFFSET2",4);    //用于获取最后一个测试机所在列的下一列的字符串

                    $title   = $sheet->getCell("B1")->getValue();
                    $stage   = $sheet->getCell("B2")->getValue();
                    $vt      = $sheet->getCell("B3")->getValue();
                    $product = $sheet->getCell("B4")->getValue();
                    $sku     = $sheet->getCell("B5")->getValue();
                    $year    = $sheet->getCell("B6")->getValue();
                    $month    = $sheet->getCell("B7")->getValue();
                    $phase   = $sheet->getCell("B8")->getValue();
                    $number  = $LAST_COL_NO-OFFSET1;    //避免有人在Excel填错数量
                    $testlab = $sheet->getCell("B10")->getValue();
                    $mfgsite = $sheet->getCell("B11")->getValue();
                    $tester  = $sheet->getCell("B12")->getValue();

                    $LAST_UNIT_COL_NO = $LAST_COL_NO-OFFSET2;
                    $lastUnitCol = PHPExcel_Cell::stringFromColumnIndex($LAST_UNIT_COL_NO);    //从0开始
                    if(!$stage){
                        echo '<script>window.alert("Excel文件沒有填寫Stage");</script>';
                        exit();
                    }
                    if(!$vt){
                        echo '<script>window.alert("Excel文件沒有填寫Verification Type");</script>';
                        exit();
                    }
                    if(!$product){
                        echo '<script>window.alert("Excel文件沒有填寫Product");</script>';
                        exit();
                    }
                    if(!$sku){
                        echo '<script>window.alert("Excel文件沒有填寫SKU");</script>';
                        exit();
                    }
                    if(!$year){
                        echo '<script>window.alert("Excel文件沒有填寫年份");</script>';
                        exit();
                    }
                    if(!$month){
                        echo '<script>window.alert("Excel文件沒有填寫月份");</script>';
                        exit();
                    }
                    if(!$phase){
                        echo '<script>window.alert("Excel文件沒有填寫Phase");</script>';
                        exit();
                    }
                    if(!$testlab){
                        echo '<script>window.alert("Excel文件沒有填寫Test LAB");</script>';
                        exit();
                    }
                    if(!$mfgsite){
                        echo '<script>window.alert("Excel文件沒有填寫MFG Site");</script>';
                        exit();
                    }
                    if(!$tester){
                        echo '<script>window.alert("Excel文件沒有填寫测试人名");</script>';
                        exit();
                    }
                    // ---------- -----------
                    echo "测试机数量：".$number.", 总行数：".$highestRow.", 总列数：".$highestCol."<br>";
                    echo "最后一列转数字: ".$LAST_COL_NO."<br>";
                    echo "最后一个机台所在列: ".$lastUnitCol."<br>";
                    // ------------ -----------
                    $arr_group = array();
                    $arr_items = array();
                    $order = array();        // test order array
                    $arr_order = array();    // 对空内容和小写字符处理后的新test order
                    $array_conditon = array();
                    
                    //PHPExcel行列从1开始计算，这里从第15行开始循环
                    for($i=15; $i<=$highestRow; $i++){
                        array_push($arr_group,$sheet->getCell("A".$i)->getValue());
                        array_push($arr_items,$sheet->getCell("B".$i)->getValue());
                        array_push($array_conditon,$sheet->getCell("C".$i)->getValue());
                    }
                    // 有相同的Test item提示错误
                    if(count($arr_items)!=count(array_unique($arr_items))){
                        echo "<script>window.alert('有相同的Test Item!~點擊返回');history.back();</script>";
                        exit();
                    }
                    //獲取test order
                    for($i=15; $i<=$highestRow; $i++){
                        for($j='D'; $j!=$lastUnitCol; $j++){
                            array_push($order,$sheet->getCell("$j$i")->getValue());
                        }
                    }
                    $len_order = count($order);
                    //如果有小写字符转换成大写,空内容用空格表示
                    for($loop=0; $loop<$len_order; $loop++){
                        strtoupper($order[$loop]);
                        //echo $loop."--->".$order[$loop]."<br>";
                        if($order[$loop]=="请选择"){
                            $arr_order[$loop] = ' ';
                        }
                        else{
                            array_push($arr_order,$order[$loop]);
                        }
                    }
                    /* Test order是一个二维数组,行是编号1,2,3...列是每个机台测试的项目，必须转置一下成每个机台对应几项测试的二维数组 */
                    $tmp1 = array_chunk($arr_order,$number);
                    $len1 = count($tmp1);
                    $len2 = count($tmp1[0]);
                    for($i=0; $i<$len1; $i++){
                        for($j=0; $j<$len2; $j++){
                            $tmp2[$j][$i] = $tmp1[$i][$j];    //转置后安装unit1,2,3...顺序排列
                        }
                    }
                    $len3 = count($tmp2); 
                    $len4 = count($tmp2[0]);
                    $timedt = date("Y-m-d H:i:s");
                    $counter = 0;        //作为测试机编号 1,2,3.......N

                    $get_test_name = urlencode($tester);
                    $get_product_name = urlencode($product);
                    $get_start_day = urlencode($timedt);
                    $title = preg_replace("/\'/","",$title);
                    
                    for($i=0; $i<$len3; $i++){
                        $counter++;
                        for($j=0; $j<$len4; $j++){
                            $group     = $arr_group[$j];
                            $test_item = $arr_items[$j];
                            $unit      = $tmp2[$i][$j];     //test order
                            //$condition = $array_conditon[$j];
                            $condition = preg_replace("/\'/","\'",$array_conditon[$j]);//单引号转义\'
                            //SQL for adding records
                            $sql_add = "INSERT INTO DQA_Test_Main(Titles,Stages,VT,Products,SKUS,Years,Months,Phases,Units,Groups,Testitems,Testcondition,Testlab,Mfgsite,Testername,Timedt,Unitsno) ";
                            $sql_add .= "VALUES('$title','$stage','$vt','$product','$sku','$year','$month','$phase','$unit','$group','$test_item','$condition','$testlab','$mfgsite','$tester','$timedt','$counter')";
                            //echo $counter."----->".$sql_add."<br>";
                            mysqli_query($con,$sql_add);
                        }
                    }
                    sleep(1);
                    mysqli_close($con);
                    //$url = "index.php";
                    $url = "matrix_edit.php?user={$get_test_name}&product={$get_product_name}&starting={$get_start_day}";
                    $message = urlencode("数据保存完成 :)");
                    //header("location:success.php?url=$url&message=$message");
                    echo "<script>window.location.href='success.php?url=$url&message=$message'</script>";
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
                }//end of uploading test matrix
                ?>
            </div>
            <!--br-->
            <!-- Upload test matrix file end -->
        <?php
        }
        /**
         * Export Raw Data to Excel, modified begins from 2022-05-09
         */
        else if($_GET['dowhat'] == 'export' || $_POST['dowhat'] == 'exportdo' || $_GET['dowhat'] == 'Export_search' ){
        ?>
            <p class="info">Export Raw Data to Excel&nbsp;&nbsp;<span class="icon"><img src="./images/logo_excel.svg" height="30" /></span></p>
            <div id="preloder"><div class="loader"></div></div>
            <!-- -->
            <!--form name="export_excel" id="export_excel" method="POST" action="./comm/Out_Excel_filter.php"-->
            <form action="index_filter.php?dowhat=Export_search" method="post">
            <table align="center" width="50%" cellpadding="10" border="0">
                    <tr>
                    <td>Product &nbsp;&nbsp;<span class="tablet-icon"></span></td>
                            <td>
                                <?php
                                echo "<select name='ary[]' class='js-select2' multiple='multiple'>";
                                $check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
                                if($_POST['ary']!="")
                                {
                              
                                    while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                        $flage=0;
                                        foreach($_POST['ary'] as $selected) 
                                        {

                                            if($selected==$row[0])
                                            {
                                                echo "<option value=" ."'$row[0]'" . "  data-badge=''selected='selected'>" . $row[0] . "</option>";
                                                $flage=1;
                                            }
                                        }
                                        if($flage==0)
                                        {
                                            echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
                                        }


                                    }

                                }
                                else
                                {
                                    while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                        echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
                                    } 
                                }
                                echo "</select>";
                            ?>
                            </td>
                    </tr>
                    <tr>
                    <td>SKU &nbsp;&nbsp;<!--span class="tablet-icon"></span--></td>
                            <td>
                                <?php
                                
                            echo "<select name='aryy[]' class='js-select2' multiple='multiple'>";
                            $check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
                            if($_POST['aryy']!="")
                            {
                                while ($row = mysqli_fetch_array($check)) {
                                    $flage=0;
                                    foreach($_POST['aryy'] as $selected) {
                                        if($selected==$row["SKUS"])
                                        {
                                            echo "<option value='{$row["SKUS"]}' data-badge='' selected='selected'>{$row['SKUS']}</option>";
                                            $flage=1;
                                        }
                                    
                                    }
                                    if($flage==0)
                                    {
                                        echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";

                                    }
                                }
                            }
                            else
                            {
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
                                }
                            }

                            echo "</select>";
                        ?>
                            </td>
                    </td>
                    </tr>
                    <td>Verification Type &nbsp;&nbsp;<!--span class="tablet-icon"></span--></td>
                            <td>
                                <?php
                                    echo "<select name='ary3[]' class='js-select2' multiple='multiple'>";
                                    $check = mysqli_query($con, "SELECT DISTINCT(VT) FROM DQA_Test_Main ORDER BY VT ASC ");
                                    if($_POST['ary3']!="")
                                    {
                                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                            $flage=0;
                                            foreach($_POST['ary3'] as $selected) {
                                                if($selected==$row[0])
                                                {
                                                    echo "<option value=" ."'$row[0]'" . "  data-badge='' selected='selected'>" . $row[0] . "</option>";
                                                    $flage=1;
                                                }
                                            }
                                            if($flage==0)
                                            {
                                                echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";

                                            }
                                        }
                                    }
                                    else
                                    {
                                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                            echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                ?>
                            </td>
                                </tr>
                            <tr>
                                <td>Stage &nbsp;&nbsp;<!--span class="tablet-icon"></span--></td>
                            <td>
                                <?php
                                    echo "<select name='ary4[]' class='js-select2' multiple='multiple'>";
                                    $check = mysqli_query($con, "SELECT DISTINCT(Stages) FROM DQA_Test_Main ORDER BY Stages ASC ");
                                    if($_POST['ary4']!="")
                                    {
                                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                            $flage=0;
                                            foreach($_POST['ary4'] as $selected) {
                                                if($selected==$row[0])
                                                {
                                                    echo "<option value=" ."'$row[0]'" . "  data-badge='' selected='selected'>" . $row[0] . "</option>";
                                                    $flage=1;
                                                }
                                            }
                                            if($flage==0)
                                            {
                                                echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";

                                            }
                                        }
                                    }
                                    else
                                    {
                                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                            echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
                                        }

                                    }

                                    echo "</select>";
                                ?>
                            </td>
                    </tr>
                    <tr>
                        <td>
                                </td>
                    <td align="center">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<input type="submit" name="submit" value=Search>
                                </td>
                    </tr>
                </table>
            </form>
<!--form name="export_excel" id="export_excel" method="POST" action="checkbox.php"-->
<form name="export_excel" id="export_excel" method="POST" action="./comm/Out_Excel_filter.php">

<?php

if ($_POST) 
{ 
    if($_POST['ary']!="")
    {
        foreach($_POST['ary'] as $selected) {
            //echo "project list ".$selected."<br>";
            $filter_Pro[] = ' Products = '."'$selected'";
        }
    }
    else
    {
        $check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
            //echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
            $filter_Pro[] = ' Products = '."'$row[0]'";

        }
    }
      if($_POST['aryy']!="")
      {
        foreach($_POST['aryy'] as $selected) {
            //echo "SKU list ".$selected."<br>";
            $filter_SKU[] = ' SKUS = '."'$selected'";
        }
    }
    else
    {
        $check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
        while ($row = mysqli_fetch_array($check)) {
            //echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
            $filter_SKU[] = ' SKUS = '."'{$row['SKUS']}'";
        }
        

    }

    if($_POST['ary3']!="")
    {
      foreach($_POST['ary3'] as $selected) {
          //echo "VT list ".$selected."<br>";
          $filter_VT[] = ' VT = '."'$selected'";
      }
    }
    else
    {

            $check = mysqli_query($con, "SELECT DISTINCT(VT) FROM DQA_Test_Main ORDER BY VT ASC ");
            while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
            //echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
            $filter_VT[] = ' VT = '."'$row[0]'";
        }
        

    }

    if($_POST['ary4']!="")
    {
      foreach($_POST['ary4'] as $selected) {
          //echo "Stages list ".$selected."<br>";
          $filter_Sta[] = ' Stages = '."'$selected'";
      }
    }
    else
    {

        $check = mysqli_query($con, "SELECT DISTINCT(Stages) FROM DQA_Test_Main ORDER BY Stages ASC ");
        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
            //echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
            $filter_Sta[] = ' Stages = '."'$row[0]'";

        }

    }

    $cc = 0;
    $sql_tt = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE (". implode(" OR",$filter_Pro).")"." AND (".implode(" OR",$filter_SKU).")"." AND (".implode(" OR",$filter_VT).")"." AND (".implode(" OR",$filter_Sta).")";
    //echo $sql_tt;
    $rr_time = mysqli_query($con,$sql_tt);
    echo "<p class='query_desc'>您查询了".$tt."的测试记录</p>";
    echo "<table border='1' rules='all' class='query_table'>";
    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>CheckBox</th></tr>";
    while($row=mysqli_fetch_array($rr_time,MYSQLI_BOTH)){
        $cc++;
        $product = $row['Products'];
        $tester = $row['Testername'];
        $starting = $row['Timedt'];
        $user_name = urlencode($tester);
        $product_name = urlencode($product);
        $start = urlencode($starting);
    
    ?>
    
    <tr>
        <td><?php echo $cc; ?></td>
        <td><?php echo $row['Titles']; ?></td>
        <td><?php echo $row['Stages']; ?></td>
        <td><?php echo $row['VT']; ?></td>
        <td><?php echo $product ?></td>
        <td><?php echo $row['SKUS']; ?></td>
        <td><?php echo $tester ?></td>
        <td><?php echo substr($starting,0,10); ?></td>
        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
        <td align="center"><input type="checkbox" name="checkbox[]"id="ch_box<?php echo $cc; ?>" class="form" value="<?php echo $row['Titles']; ?>_<?php echo  $product ; ?>_<?php echo $row['SKUS']; ?>_<?php echo $row['VT']; ?>_<?php echo $row['Stages']; ?>"></td>
    </tr>
    <?php
                }
        echo "<tr>";
        echo "<td colspan ='11' align='center'> <button class='btn_download' type='submit' onclick='layer.msg('加载数据中,请耐心等待...',{icon:6,time:20000})'>Export</button><input name='to_excel' type='hidden' value='to_excel_do'></td>";    
        echo "</tr>";
        echo "</table>";

    }

    ?>
    </form>
        <?php
        }//Export Raw Data end here
        
        /**
         * upload Drop down menu excel file
         */
        else if($_GET['dowhat'] == 'upload' || $_POST['dowhat'] == 'uploaddo'){
        ?>
            <p class="info">DropBox Menu Upload <img src="./images/logo_excel.svg" height="20" /></p>
            <div>
                <form name="upload" action="upload.php" method="POST" enctype="multipart/form-data" onsubmit="return checkFormUpload()">
                    <table align="center" width="70%" cellpadding="5" border="0">
                        <tr>
                            <td>Dropbox update：</td>
                            <td>
                                <select name="dropbox" class="sel_edit">
                                    <option value="">請選擇</option>
                                    <option value="Product">Product Menu</option>
                                    <option value="SKU">SKU Menu</option>
                                    <option value="phases">Phase Menu(PT,MV...)</option>
                                    <option value="Group">Group Menu</option>
                                    <option value="Testitem">Test Item Menu</option>
                                    <option value="df1">DefectMode(Symptom) Menu</option>
                                    <option value="df2">DefectMode(Symptom+Finding) Menu</option>
                                    <option value="Dropside">Drop side Menu</option>
                                    <option value="Result">Result Menu(pass fail...)</option>
                                    <option value="Issue_Status">Issue Status Menu</option>
                                    <option value="Testcondition">Test Condition Menu</option>
                                    <option value="LAB">LAB&Site Menu</option>
                                    <option value="Order">Test Order(A,B,C...)</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td width="20%">选择文件 <span class="icon">F</span> : </td><td><input name="myfile" id="myfile" type="file" /></td></tr>
                        <tr>
                            <td colspan="2" align="center">
                                <button name="upload" type="submit" class="btn_update">上传文件</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_edit" name="reset" type="reset">清 空</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div class="note">
                    <p> 模板下载：<a href="images/Template.xls">Template (点击下载)</a></p>
                    <p> 1. 下载模板填写需要上传的数据，只需要填写最新的数据</p>
                    <p> 2. 日期必须存储为年月日格式,如1949-10-01样式</p>
                    <p> 3. 不要出现换行符(\n), 制表符(\t)，单引号(')等特殊字符,它们会引起数据丢失</p>
                    <p> 4. 此功能用于下拉菜单更新</p>
                </div>
                <div class="caution"><img src="images/Attention.JPG" width="230" alt="注意!~~" /></div>
                <div class="clear"></div>
            </div>
        <?php    
        }
        /**
         * 编辑, 删除, 新增 dropbox
         */
        else if($_GET['dowhat'] == 'edit' || $_POST['dowhat'] == 'editdo'){
        ?>
        <div>
            <p class="info">Add New Dropbox Menu</p>
            <form name="add_dropbox" action="" method="POST" onsubmit="return checkAddDropbox()">
                <table align="center" width="70%" cellpadding="5" border="0">
                    <tr>
                        <td>Dropbox Select: </td>
                        <td>
                            <select name="dropbox" class="sel_edit">
                                <option value="">請選擇</option>
                                <option value="Product">Product Menu</option>
                                <option value="SKU">SKU Menu</option>
                                <option value="phases">Phase Menu(PT,MV...)</option>
                                <option value="Group">Group Menu</option>
                                <option value="Testitem">Test Item Menu</option>
                                <option value="df1">DefectMode(Symptom) Menu</option>
                                <option value="df2">DefectMode(Symptom+Finding) Menu</option>
                                <option value="Dropside">Drop side Menu</option>
                                <option value="Result">Result Menu(pass fail...)</option>
                                <option value="Issue_Status">Issue Status Menu</option>
                                <option value="Testcondition">Test Condition Menu</option>
                                <option value="LAB">Lab & Site Menu</option>
                                <option value="Order">Test Order(A,B,C...)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Dropbox Content: </td>
                        <td><textarea name="added_txt" rows="5" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button name="add_btn" type="submit" class="btn_sub">添 加</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="reset" type="reset">清 空</button>
                            <input name="add_dropbox" type="hidden" value="add_dropbox_do" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            if(isset($_POST["add_dropbox"]) && $_POST["add_dropbox"]=="add_dropbox_do"){
                $dropbox = $_POST["dropbox"];
                $txt_input = $_POST["added_txt"];
                $comma = "/\'/";
                $replace = "\'";
                //$added_txt = $_POST["added_txt"];      
                $added_txt = preg_replace($comma,$replace,$txt_input);      
                switch ($dropbox) {
                    // 1.Product Menu
                    case 'Product':
                        $sql_add = "INSERT INTO dropbox_product(Product) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 2.SKU Menu                    
                    case 'SKU';
                        $sql_add = "INSERT INTO dropbox_sku(SKUS) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 3.Phase Menu
                    case 'phases':
                        $sql_add = "INSERT INTO dropbox_phase(Phase) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 4.Test items Menu
                    case 'Testitem':
                        $sql_add = "INSERT INTO dropbox_test_item(Testitem) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 5.DefectMode(Symptom)
                    case 'df1':
                        $sql_add = "INSERT INTO dropbox_df1(DefectMode) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 6.DefectMode(Symptom+Finding)
                    case 'df2':
                        $sql_add = "INSERT INTO dropbox_df2(DefectMode) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 7.Dropside Menu
                    case 'Dropside':
                        $sql_add = "INSERT INTO dropbox_dropside(Dropside) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 8. Result Menu
                    case 'Result':
                        $sql_add = "INSERT INTO dropbox_result(Result) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 9.Issue statuss Menu
                    case 'Issue_Status':
                        $sql_add = "INSERT INTO dropbox_issue_status(Issue_Status) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 10.Group Menu
                    case 'Group':
                        $sql_add = "INSERT INTO dropbox_group(`Groups`) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 11. Test condition
                    case 'Testcondition':
                        $sql_add = "INSERT INTO dropbox_test_condition(Testcondition) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 12. LAB
                    case 'LAB':
                        $sql_add = "INSERT INTO dropbox_lab_site(LAB_SITE) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 13. Test Order
                    case 'Order':
                        $sql_add = "INSERT INTO dropbox_test_order(Testorder) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;

                    default:
                        echo "<script>window.alert('出错啦！~~~');</script>";
                        break;
                }
            }
            ?>
            <br>
            <p class="info">Edit or Delete Dropbox Menu</p>
            <form name="del_dropbox" action="./Edit/edit_dropbox_option.php" method="POST" onsubmit="return checkDelDropbox()">
                <table align="center" width="70%" cellpadding="5" border="0">
                    <tr>
                        <td>Dropbox Select: </td>
                        <td>
                            <select name="dropbox" class="sel_edit">
                                <option value="">請選擇</option>
                                <option value="Product">Product Menu</option>
                                <option value="SKU">SKU Menu</option>
                                <option value="phases">Phase Menu(PT,MV...)</option>
                                <option value="Group">Group Menu</option>
                                <option value="Testitem">Test Item Menu</option>
                                <option value="df1">DefectMode(Symptom) Menu</option>
                                <option value="df2">DefectMode(Symptom+Finding) Menu</option>
                                <option value="Dropside">Drop side Menu</option>
                                <option value="Result">Result Menu(pass fail...)</option>
                                <option value="Issue_Status">Issue Status Menu</option>
                                <option value="Testcondition">Test Condition Menu</option>
                                <option value="LAB">Lab & Site Menu</option>
                                <option value="TO">Test Order(A,B,C...)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button name="del_btn" type="submit" class="btn_sub">确 定</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button name="reset" type="reset">清 空</button>
                            <input name="del_dropbox" type="hidden" value="del_dropbox_do" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
        }
        /**
         * 查看一條測試記錄, 你可以在這裏編輯一條測試記錄
         */
        else if($_GET['dowhat'] == 'data' || $_POST['dowhat'] == 'datado'){
        ?>
        <div>
            <p class="info">All Test Matrix Records</p>
            <?php
            $sql_index = "SELECT count(*) as total FROM DQA_Test_Main WHERE Results!='N/A' ";
            $result = mysqli_query($con,$sql_index);
            $info = mysqli_fetch_array($result);
            $total = $info['total'];
            if($total==0){
                echo "<p class='fail-info'>暫無任何數據</p>";
            }
            else{
            ?>
            <table align="center" class="my_table" id="my_table">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>Stage</th>
                    <th width="9%">VT.</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th width="5%">Year</th>
                    <th>Phase</th>
                    <th>SN</th>
                    <th>Unit</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Test Item</th>
                    <th>DEL</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $pagesize=50;    //设置每页显示记录數量
                if($total<=$pagesize){
                    $pagecount = 1;
                }
                else if(($total%$pagesize)!=0){
                    $pagecount=intval($total/$pagesize)+1;
                }
                else{
                    $pagecount=$total/$pagesize;
                }
                if((@ $_GET['page'])==""){
                    $page = 1;
                }
                else{
                    $page=intval($_GET['page']);
                }
                $counter = 0;
                $check = mysqli_query($con,"SELECT * FROM DQA_Test_Main ORDER BY Timedt DESC LIMIT ".($page-1)*$pagesize.",$pagesize ");
                while($row = mysqli_fetch_array($check,MYSQLI_BOTH)){
                    ++$counter;
                ?>
                    <tr>
                        <td><?php echo $counter+($page-1)*$pagesize; ?></td>
                        <td><?php echo $row["Stages"]; ?></td>
                        <td><?php echo $row["VT"]; ?></td>
                        <td><?php echo $row["Products"]; ?></td>
                        <td><?php echo $row["SKUS"]; ?></td>
                        <td><?php echo $row["Years"].".".$row["Months"]; ?></td>
                        <td><?php echo $row["Phases"]; ?></td>
                        <td><?php echo $row["SN"]; ?></td>
                        <td><?php echo $row["Units"]; ?></td>
                        <td><?php echo $row["Testername"]; ?></td>
                        <td><?php echo $row["Groups"]; ?></td>
                        <td class="items1">
                            <span class="qr_tip">点击查看或者编辑</span>
                            <a href="details.php?id=<?php echo $row["RecordID"]; ?>"><?php echo $row["Testitems"] ?></a>
                        </td>
                        <td><a href="javascript:void(0)" onClick="confirmDel(<?php echo $row['RecordID']; ?>)"><span class="trash-icon"></span></a></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="13" align="center">
                        <font size="2">共有数据 <?php echo $total;?>&nbsp;条，每页显示&nbsp;<?php echo $pagesize; ?>&nbsp;条，&nbsp;第&nbsp;
                        <?php echo $page;//显示当前页码；?>&nbsp;页/共&nbsp;<?php echo $pagecount; ?>&nbsp;页
                        <?php
                        if($page>=2){
                        //如果页码数大于等于2则执行下面程序index.php?dowhat=pic&page=1   index.php?dowhat=pic&id=
                        ?>
                            <a href="index.php?dowhat=data&page=1" title="首页"><font face="webdings"> 9 </font></a> / <a href="index.php?dowhat=data&id=<?php echo $id;?>&amp;page=<?php echo $page-1; ?>" title="前一页"><font face="webdings"> 7 </font></a>
                        <?php
                        }
                        if($pagecount<=4){
                            //如果页码数小于等于4执行下面程序
                            for($i=1;$i<=$pagecount;$i++){
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $i;?>"><?php echo $i;?></a>
                        <?php
                            }
                        }
                        else{
                            for($i=1;$i<=4;$i++){	 
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $i;?>">&nbsp;<?php echo $i;?>&nbsp;</a>
                        <?php 
                            }
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $page+1;?>" title="后一页"><font face="webdings"> 8 </font></a> <a href="index.php?dowhat=data&id=<?php echo $id;?>&amp;page=<?php echo $pagecount;?>" title="尾页"><font face="webdings"> : </font></a>
                        <?php 
                        }
                        ?>
                    </td>
                </tr>
                </tfoot>
            </table>
            <?php
            }   
            ?>
        </div>
        <?php
        }
        /**
         * 默認查詢Test Matrix, 2021-11-11添加, 可以選擇一個條件查詢, 也可以多條件查詢
         */
        else{
        ?>
        <div>
            <p class="info">Working Begins Here ... <img src="./images/getting_started.svg" height="25" />
            <div>
            <form id="form7" name="form7" method="POST" action="" onsubmit="return checkForm7();">
                <table align="center" class="form7">
                    <tr>
                        <td><span class="icon">U</span> (測試人): </td>
                        <td>
                            <select name="tester" id="tester">
                                <option value="">Select Tester</option>
                                <?php
                                $check = mysqli_query($con, "SELECT DISTINCT(Testername) FROM DQA_Test_Main ORDER BY Testername ASC");
                                while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                    echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Product: </td>
                        <td width="80%">
                            <select name="product">
                                <option value="">Select Product</option>
                                <?php
                                $check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
                                while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                    echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td>開始日期: </td><td><input name="starting" type="date" /></td></tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button class="btn_query" type="submit">查 詢&nbsp;&nbsp;&nbsp;<span class="icon">L</span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn_reset" type="reset">清&nbsp;&nbsp;空</button>
                        </td>
                        <input type="hidden" name="query" value="query_do" />
                    </tr>
                </table>
            </form>
            <?php
            /**
             * added on 2022-01-10 for DQA request
             * 查詢條件是否可擇一來進行篩選, 也可以多條件篩選, 篩選後的清單可用展開方式供選擇
             */
            if(isset($_POST["query"]) && $_POST["query"]=="query_do"){
                $user = $_POST["tester"];     //1.選取的測試人名
                $nickname = $_POST["product"];//2.選取的product
                $tt = $_POST["starting"];     //3.選取測試日期 Audi TT
                if($user && $nickname=="" && $tt==""){
                    $cc = 0;
                    $sql_user = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Testername='$user' ORDER BY Timedt DESC";
                    $rr_user = mysqli_query($con,$sql_user);
                    echo "<p class='query_desc'>您查询了".$user."测试的产品</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_user,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        //$starting = substr($row['Timedt'],0,10);
                        $starting = $row['Timedt'];
                        //echo $product."-".$tester."-".$starting."<br>";

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                        //echo $product_name."-".$user_name."-".$start."<br>";
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>

                        <td align="center"><input name="del_matrix1" id="del_matrix1" class="del_matrix1"  type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                else if($nickname && $user=="" && $tt==""){
                    $cc = 0;
                    $sql_product = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Products ='$nickname' ORDER BY Timedt DESC";
                    $rr_product = mysqli_query($con,$sql_product);
                    echo "<p class='query_desc'>您查询了由Wistron生产的".$nickname."</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_product,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        //$starting = substr($row['Timedt'],0,10);
                        $starting = $row['Timedt'];

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $tester; ?>&product=<?php echo $product; ?>&starting=<?php echo $starting ?>" >Matrix</a></td>
                        <td align="center"><input name="del_matrix2" id="del_matrix2" class="del_matrix1" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                else if($tt && $user=="" && $nickname==""){
                    $cc = 0;
                    $sql_tt = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' ORDER BY Timedt DESC";
                    $rr_time = mysqli_query($con,$sql_tt);
                    echo "<p class='query_desc'>您查询了".$tt."的测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_time,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td align="center"><input name="del_matrix2" id="del_matrix2" type="button" class="del_matrix1" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // added on 2022-03-25
                // 查詢用戶名+測試機名
                else if($user && $nickname && $tt==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Products ='$nickname' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_product_teser = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", ".$nickname."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th></tr>";
                    while($row=mysqli_fetch_array($rr_product_teser,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢用戶名+測試日期
                else if($user && $tt && $nickname==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_tt_teser = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", ".$tt."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_tt_teser,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢測試機名+測試日期
                else if($nickname && $tt && $user==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Products='$nickname' ORDER BY Timedt DESC";
                    $rr_tt_product = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$nickname.", ".$tt."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_tt_product,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td align="center"><input name="del_matrix2" id="del_matrix2" class="del_matrix1" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢測試人名+測試機名+測試日期
                else if($nickname && $tt && $user){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Products='$nickname' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_all = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", 在".$tt."測試的".$nickname."的记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_all,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td align="center"><input name="del_matrix2" id="del_matrix2" class="del_matrix1" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // ----------- End here -----------
            }
            ?>
            <div class="note">
                <p>1. Query any item. Tester, Product or start time</p>
                <p>2. Recommond Google Chrome <img src="./images/chrome.jpg" width="15" /> or Microsoft Edge <img src="./images/Edge.jpg" width="15" /></p>
                <p>
                    <?php
                    $days = date("z")+1;
                    echo "3. Today is ".date("l F jS, Y")."; Week ".ceil($days/7).", and Day ".$days;
                    ?>
                </p>
                <p>4. Think over before deleting a matrix. If it is deleted, it won't be recovered.</p>
                <p>5. When creating matrix, recommend uploading Excel by attached template if units >= 10  .</p>
                <p><img src="./images/HUAWEI.png" /></p>
            </div>
            </div>
        </div>
        
        <?php    
        }
        mysqli_close($con);
        ?>
    </div>
    <!-- 清除浮動 -->
    <div class="clear"></div>
</div>

<!-- 底部 footer -->
<br><br>
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistronits">
</div>

<script src="Filter/js/jquery.min.js"></script>
<script src="Filter/js/popper.js"></script>
<script src="Filter/js/bootstrap.min.js"></script>
<script src="./Filter/js/select2.min.js"></script>
<script src="Filter/js/main.js"></script>

</body>

<!--

                A CHINA C           CHINA CHI
            HINA CHINA CHINA    NA CHINA CHINA CH
          CHINA CHINA CHINA CHINA CHINA CHINA CHINA
         CHINA CHINA CHINA CHINA CHINA CHINA CHINA C
        CHINA CHINA CHINA CHINA CHINA CHINA CHINA CHI
        HINA CHINA CHINA CHINA CHINA CHINA CHINA CHIN
        INA CHINA CHINA CHINA CHINA CHINA CHINA CHINA
        NA CHINA CHINA CHINA CHINA CHINA CHINA CHINA
        A CHINA CHINA CHINA CHINA CHINA CHINA CHINA C
         CHINA CHINA CHINA CHINA CHINA CHINA CHINA CH
         HINA CHINA CHINA CHINA CHINA CHINA CHINA CH
          NA CHINA CHINA CHINA CHINA CHINA CHINA CH
          A CHINA CHINA CHINA CHINA CHINA CHINA CHI
            HINA CHINA CHINA CHINA CHINA CHINA CH
             NA CHINA CHINA CHINA CHINA CHINA CH
               CHINA CHINA CHINA CHINA CHINA CH
                INA CHINA CHINA CHINA CHINA C
                   CHINA CHINA CHINA CHINA
                    INA CHINA CHINA CHINA
                       CHINA CHINA CHI
                          A CHINA C
                             INA
                              A
-->
</html>