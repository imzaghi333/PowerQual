<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("Asia/Shanghai");

if(isset($_GET["product"])&&isset($_GET["user"])&&isset($_GET["starting"])){
    $product  = $_GET["product"];
    $tester   = $_GET["user"];
    $starting = $_GET["starting"];
    $sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' ";
    $check = mysqli_query($con,$sql_query);    //查询到某人某一次的测试记录
    $counts = mysqli_num_rows($check);    //得到某一次测试的记录数量
    //----------- Add on 2021-12-16 for Stage,verification type,products,year,month... total 11项-----------
    $user_info = mysqli_data_seek($check,0);        //每次测试这一部分内容相同(New Test页面),只要读取其中一行即可
    $user_one_row = mysqli_fetch_array($check,MYSQLI_BOTH);    //一个关联素组:0->RecordID, 1->Stages,2->VT,3->Products,4->SKUS....
    
    $stage   = $user_one_row[1];      //NPI Sus...
    $vt      = $user_one_row[2];      //verification type
    $pr_name = $user_one_row[3];      //Mufasa,Thunder......`
    $sku     = $user_one_row[4];      //WWLAN WLAN......
    $nn      = $user_one_row[5];      //年 2021
    $yy      = $user_one_row[6];      //月 01~12
    $phases  = $user_one_row[7];      // MV EV.......
    $testlab = $user_one_row[32];     //WKS WHQ......
    $mfgsite = $user_one_row[33];     //WKS WHQ......
    $tester  = $user_one_row[34];     //英文名
    $timedt  = $user_one_row[42];     //测试项录入的时间
    
    //----------- End here
    
    $qty_query = mysqli_query($con, "SELECT COUNT(DISTINCT(Unitsno)) FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' ");
    $qty_info = mysqli_fetch_array($qty_query,MYSQLI_NUM);
    $number = $qty_info[0];    //獲取某一次測試的機台數量
    if($counts){
        $rows = $counts/$number;
    }
    else{
        echo "<p style='color:be0f2d;font-size:40px;text-align:center'>No Data is Selected</p>";
        echo "<p style='color:00698f;font-size:24px;text-align:center'>Select your testing product and adding record date</p>";
        exit();
    }
}
else{
    echo "<p style='color:#cc2229;font-size:30px;text-align:center'>未选择任何查询条件,两秒后返回首页</p>";
    echo "<meta http-equiv='refresh' content='2; url=index.php'>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style/main_dqa.css">
    <link rel="shortcut icon" href="./images/favior.ico">
    <script type="text/javascript" src="./js/js_edit_matrix_inner.js"></script>
    <title>Raw Data of Matrix for <?php echo $tester." - ".$product; ?></title>
</head>
<body>
<div class="content">
    <h1>
        <span style="float: left;margin-left:20px;"><a href="index.php"><img src="./images/logo-small.svg" height="40" alt="Wistron"></a></span>
        <?php echo $tester." ~ ".$product; ?> - Add units serial NO
    </h1>
    
    <div id="preloder"><div class="loader"></div><!-- loading animation added on 2022-01-06 --></div>
    <div>
    <form id="form9" name="form9" action="" method="POST">
        <table class="input_sn" border="1" rules="all" align="center">
            <tr><th>NO</th><th>SN</th></tr>
            <?php
            for($i=0; $i<$number; $i++){
                echo "<tr>";
                echo "<td>Unit".($i+1)."</td>";
                $unit_no = $i+1;
                $sql_sn = mysqli_query($con,"SELECT DISTINCT(SN) FROM DQA_Test_Main WHERE Products='$product' AND Timedt='$timedt' AND Unitsno='$unit_no' ");
                $sn_info = mysqli_fetch_array($sql_sn,MYSQLI_NUM);
                $unit_sn = $sn_info[0];
                echo "<td><input type='text' name='sn[]' value='$unit_sn' /></td>";
                echo "</tr>";
            }
            ?>
            
        </table>
        <?php
            $groups = array();
            $test_items = array();
            $sql_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%'";
            $tc = mysqli_query($con,$sql_tc);
            while($tc_row = mysqli_fetch_array($tc,MYSQLI_BOTH)[0]){
                array_push($test_items,$tc_row);
            }
            $tc_num = count($test_items);    //表格行数
            for($j=0; $j<$tc_num; $j++){
                $tc_txt = $test_items[$j];
                $sql_one_gp = "SELECT DISTINCT `Groups` FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Testitems='$tc_txt' ";
                $gp_info = mysqli_query($con,$sql_one_gp);
                $gp_one = mysqli_fetch_array($gp_info,MYSQLI_BOTH)[0];
                array_push($groups,$gp_one);
            }
            
            $selectid=0;//
            for($i=0; $i<$tc_num; $i++){
                mysqli_data_seek($tc,$i);
                $row_tc = mysqli_fetch_array($tc);
                $gp_txt = $groups[$i];
                echo"<tr>";
                echo "<td width='50'>";
                echo "<input name='group[]' id='group' type='hidden' value='{$gp_txt}'  readonly />";
                echo "</td>";

                echo "<td width='120'>";
                $tc_txt = $row_tc[0];
                echo "<input name='test_item[]' id='test_item' type='hidden' value='{$tc_txt}'  readonly />";
                echo "</td>"; 
                
		        for($ii=0; $ii<$number; $ii++){
		            $no = $ii+1;
                    //获取一个test order,RecordID Unit no,比如: | P     |       67 | 2       |
		            $check = mysqli_query($con,"SELECT Units,RecordID,Unitsno FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Unitsno='$no' And `Groups`='$gp_txt'And Testitems='$tc_txt' ");                         
                    echo"<td width='200'>";
		            while($info=mysqli_fetch_array($check,MYSQLI_BOTH)){
                        $sql_result = "SELECT Results,RecordID,Defectmode1,Defectmode2,RCCA,Teststatus,Issuestatus,Category,PIC,JIRANO,SPR,";
                        $sql_result.= "Temp,Dropcycles,Drops,Dropside,Hit,NextCheckpointDate,IssuePublished,ORTMFGDate,ReportedDate FROM DQA_Test_Main ";
                        $sql_result.="WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Unitsno='$no' And `Groups`='$gp_txt'And Testitems='$tc_txt'";
                        $check_result = mysqli_query($con, $sql_result);
                        $row_result = mysqli_fetch_array($check_result,MYSQLI_NUM);
                        
                        echo "<input style='width:20px;display:none;' name='test_order[]' id='test_order' type='text' value="."'$info[0]'"." readonly />";
                        echo "<input style='width:20px;display:none;' name='result[".$selectid."]' id='result[".$selectid."]' type='text' value='{$row_result[0]}' readonly />";
		                echo "<input type='text' style='width:20px;display:none;' name='record_id[]' value="."'$info[1]'"." readonly />";
		                echo "<input type='text' style='width:20px;display:none;' name='uint_no[]' value="."'$info[2]'"." readonly />";
		            }
                    echo"</td>";
		        }
                ?>
                <?php       
            }
            ?>
        <div class="save_record">
            <input class="subit" type="submit" name="sub" value="Save" />
            &nbsp;&nbsp;<input class="back" type="button" value="Back" onClick="history.go(-1);">
            <!-- Add on 2021-12-16, hidden area -->
            <input name="pr_name" type="hidden" value="<?php echo $pr_name ?>" />
            <input name="tester" type="hidden" value="<?php echo $tester; ?>"/>
            <input name="timedt" type="hidden" value="<?php echo $timedt; ?>" />
            <!-- -----------Ending----------- -->
            <input name="number" type="hidden" id ="units_qty" value="<?php echo $number; ?>" />
            <input name="matrix_edit_sn" value="matrix_edit_sn_do" type="hidden">
        </div>
    </form>
    </div>
    <!--- 批量上传SN -->
    <div>
    <p class="txt_sn">
        Upload Serial NO.(請務必使用本站提供的Template), Dowload Template: 
        <a class="sn_template_link" href="./images/SNTemplate.xlsx">Template Download <span class="download-icon"></span></a>
    </p>
    <form id="form10" name="form10" action="" method="POST" enctype="multipart/form-data">
        <input name="sn_file" id="sn_file" type="file" style="width: 500px;background-color:#731717;color:#e6d999;" required />&nbsp;&nbsp;
        <button name="upload" type="submit" class="btn_query">Upload</button>
        <input name="sn_upload" value="sn_upload_do" type="hidden" />

        <?php
            $groups = array();
            $test_items = array();
            $sql_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%'";
            $tc = mysqli_query($con,$sql_tc);
            while($tc_row = mysqli_fetch_array($tc,MYSQLI_BOTH)[0]){
                array_push($test_items,$tc_row);
            }
            $tc_num = count($test_items);    //表格行数
            for($j=0; $j<$tc_num; $j++){
                $tc_txt = $test_items[$j];
                $sql_one_gp = "SELECT DISTINCT `Groups` FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Testitems='$tc_txt' ";
                $gp_info = mysqli_query($con,$sql_one_gp);
                $gp_one = mysqli_fetch_array($gp_info,MYSQLI_BOTH)[0];
                array_push($groups,$gp_one);
            }
            
            $selectid=0;//
            for($i=0; $i<$tc_num; $i++){
                mysqli_data_seek($tc,$i);
                $row_tc = mysqli_fetch_array($tc);
                $gp_txt = $groups[$i];
                echo"<tr>";
                echo "<td width='50'>";
                echo "<input name='group[]' id='group' type='hidden' value='{$gp_txt}'  readonly />";
                echo "</td>";

                echo "<td width='120'>";
                $tc_txt = $row_tc[0];
                echo "<input name='test_item[]' id='test_item' type='hidden' value='{$tc_txt}'  readonly />";
                echo "</td>"; 
                
		        for($ii=0; $ii<$number; $ii++){
		            $no = $ii+1;
                    //获取一个test order,RecordID Unit no,比如: | P     |       67 | 2       |
		            $check = mysqli_query($con,"SELECT Units,RecordID,Unitsno FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Unitsno='$no' And `Groups`='$gp_txt'And Testitems='$tc_txt' ");                         
                    echo"<td width='200'>";
		            while($info=mysqli_fetch_array($check,MYSQLI_BOTH)){
                        $sql_result = "SELECT Results,RecordID,Defectmode1,Defectmode2,RCCA,Teststatus,Issuestatus,Category,PIC,JIRANO,SPR,";
                        $sql_result.= "Temp,Dropcycles,Drops,Dropside,Hit,NextCheckpointDate,IssuePublished,ORTMFGDate,ReportedDate FROM DQA_Test_Main ";
                        $sql_result.="WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' AND Unitsno='$no' And `Groups`='$gp_txt'And Testitems='$tc_txt'";
                        $check_result = mysqli_query($con, $sql_result);
                        $row_result = mysqli_fetch_array($check_result,MYSQLI_NUM);
                        
                        echo "<input style='width:20px;display:none;' name='test_order[]' id='test_order' type='text' value="."'$info[0]'"." readonly />";
                        echo "<input style='width:20px;display:none;' name='result[".$selectid."]' id='result[".$selectid."]' type='text' value='{$row_result[0]}' readonly />";
		                echo "<input type='text' style='width:20px;display:none;' name='record_id[]' value="."'$info[1]'"." readonly />";
		                echo "<input type='text' style='width:20px;display:none;' name='uint_no[]' value="."'$info[2]'"." readonly />";
		            }
                    echo"</td>";
		        }
                ?>
                <?php       
            }
            ?>
        <div class="save_record">
            <!-- hidden area -->
            <input name="pr_name" type="hidden" value="<?php echo $pr_name ?>" />
            <input name="tester" type="hidden" value="<?php echo $tester; ?>"/>
            <input name="timedt" type="hidden" value="<?php echo $timedt; ?>" />
            <!-- -----------Ending----------- -->
            <input name="number" type="hidden" id ="units_qty" value="<?php echo $number; ?>" />
        </div>
    </form>
    </div>
    <!--- 批量上传End -->
</div>

<?php
if(isset($_POST["matrix_edit_sn"]) && $_POST["matrix_edit_sn"]=="matrix_edit_sn_do" ){
    $arr_sn = $_POST["sn"];//机台SN
    $unit_number = $_POST["uint_no"];//测试机编号unit1,unit2...
    $number = $_POST["number"];//测试机数量
    $tester_name = $_POST["tester"];
    $product_name = $_POST["pr_name"];
    $start_day = $_POST["timedt"];
    /*
    echo $tester_name."--".$product_name."--".$start_day."<br>";
    echo "<pre>";
    print_r($arr_sn);
    */
    $get_test_name = urlencode($tester_name);
    $get_product_name = urlencode($product_name);
    $get_start_day = urlencode($start_day);
    //echo $get_test_name."--".$get_product_name."--".$get_start_day;
    // ----------- Units编号需要转成二维数组 -----------
    $unitno_tmp1 = array_chunk($unit_number,$number);
    $len1 = count($unitno_tmp1);
    $len2 = count($unitno_tmp1[0]);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $unitno_tmp2[$j][$i] = $unitno_tmp1[$i][$j];    //转置后安装unit1,2,3...顺序排列
        }
    }

    //更新SN到数据库
    $loop = count($unitno_tmp2);
    $loop_inner = count($unitno_tmp2[0]);
    for($i=0; $i<$loop; $i++){
        for($j=0; $j<$loop_inner; $j++){
            $sn = $arr_sn[$i];
            $bh = $unitno_tmp2[$i][$j];
            $sql_sn = "UPDATE DQA_Test_Main SET SN='$sn' WHERE Testername='$tester_name' AND Products='$product_name' AND Timedt='$start_day' AND Unitsno='$bh' ";
            //echo $sql_sn."<br>";
            mysqli_query($con,$sql_sn);
        }
    }
    mysqli_close($con);
    $url = "matrix_edit.php?user={$get_test_name}&product={$get_product_name}&starting={$get_start_day}";

    $message = urlencode("数据保存完成 :)");
    header("location:success.php?url=$url&message=$message");
}

/*
Export SN by excel fiel, added from 2022-03-25
*/
if(isset($_POST["sn_upload"]) && $_POST["sn_upload"]=="sn_upload_do"){
    $unit_number = $_POST["uint_no"];    //测试机编号unit1,unit2...
    $number = $_POST["number"];          //测试机数量
    $tester_name = $_POST["tester"];
    $product_name = $_POST["pr_name"];
    $start_day = $_POST["timedt"];
    //echo $tester_name."--".$product_name."--".$start_day."<br><br>";
    $get_test_name = urlencode($tester_name);
    $get_product_name = urlencode($product_name);
    $get_start_day = urlencode($start_day);
    //echo $get_test_name."--".$get_product_name."--".$get_start_day;
    
    $fileInfo = $_FILES['sn_file'];    //接收上传文件,二维数组
    $allowExt = array('xlsx','xls');    //检测扩展名,只允許Excel
    $ext = strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));    //获取文件扩展名
    if(!in_array($ext,$allowExt)){
        echo "<font color='#be0f2d' size='7'>文件擴展名錯誤,僅支持Excel文件</font><br>";
        echo "<img src='./images/ku.jpg' width='200'>";
        echo "<meta http-equiv='refresh' content='2; url=index.php'>";
        exit();
    }
    $uploadPath = "upload";        //上传的文件存储到这里
    if(!is_dir($uploadPath)){
        mkdir($uploadPath);
    }
    $basename = date("Ymd").$fileInfo["name"];    //上次成功后的文件名字(日期+原文件名)
    $dest = $uploadPath.'/'.$basename;            //上傳文件路徑
    if(move_uploaded_file($fileInfo['tmp_name'], $dest)){
        echo "<p style='color:#355386; text-align:left; font-size:14px;'>您上傳的文件：<a href='{$dest}'>{$fileInfo['name']}</a></p>";
        //echo "<img src='images/xiao.jpg' width='200'><br>";
    }
    else{
        echo "<font color='#be0f2d' size='7'>上传失败</font><br>";
        echo "<img src='images/ku.jpg' width='200'>";
        echo "<meta http-equiv='refresh' content='2; url=index.php'>";
    }
    sleep(1);
    //讀取Excel内容
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

    sleep(1);
    // ----------------------- 数据写入MySQL ---------------------------------------
    $sn_str = array();
    for($j=2; $j<=$highestRow; $j++){
        $str = "";
        for($k='B'; $k!=$highestCol; $k++){
            $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
        }
        array_push($sn_str,$str);
    }
    //echo "<pre>";
    //print_r($sn_str);
    // ----------- Units编号需要转成二维数组 -----------
    $unitno_tmp1 = array_chunk($unit_number,$number);
    $len1 = count($unitno_tmp1);
    $len2 = count($unitno_tmp1[0]);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $unitno_tmp2[$j][$i] = $unitno_tmp1[$i][$j];    //转置后安装unit1,2,3...顺序排列
        }
    }

    //更新SN到数据库
    $loop = count($unitno_tmp2);
    $loop_inner = count($unitno_tmp2[0]);
    for($i=0; $i<$loop; $i++){
        for($j=0; $j<$loop_inner; $j++){
            $sn = $sn_str[$i];
            $bh = $unitno_tmp2[$i][$j];
            $sql_sn = "UPDATE DQA_Test_Main SET SN='$sn' WHERE Testername='$tester_name' AND Products='$product_name' AND Timedt='$start_day' AND Unitsno='$bh' ";
            //echo $sql_sn."<br>";
            mysqli_query($con,$sql_sn);
        }
    }
    mysqli_close($con);
    $url = "matrix_edit.php?user={$get_test_name}&product={$get_product_name}&starting={$get_start_day}";

    $message = urlencode("数据保存完成 :)");
    header("location:success.php?url=$url&message=$message");
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
}
// ------- End here of uploading excel ----------
?>
<div>&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/bear.svg" height="200" /></div>
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistronits">
</div>
</body>
</html>