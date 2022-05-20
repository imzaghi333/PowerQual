<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");

$my_ip = $_SERVER ['REMOTE_ADDR'];

if(isset($_GET["product"])&&isset($_GET["user"])&&isset($_GET["starting"])){
    $product  = urldecode($_GET["product"]);
    $tester   = urldecode($_GET["user"]);
    $starting = urldecode($_GET["starting"]);
    
    $sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' ";
    $check = mysqli_query($con,$sql_query);
    //得到某一次测试的记录数量
    $counts = mysqli_num_rows($check);
    
    //----------- Stage,verification type,products,year,month -----------
    $user_info = mysqli_data_seek($check,0);               //每次测试这一部分内容相同(New Test页面),只要读取其中一行即可
    $user_one_row = mysqli_fetch_array($check,MYSQLI_BOTH);//一个关联素组:0->RecordID, 1->Stages,2->VT,3->Products,4->SKUS....
    $stage   = $user_one_row[1];      //NPI Sus...
    $vt      = $user_one_row[2];      //verification type
    $pr_name = $user_one_row[3];      //Mufasa,Thunder......
    $sku     = $user_one_row[4];      //WWLAN WLAN......
    $nn      = $user_one_row[5];      //年 2021
    $yy      = $user_one_row[6];      //月 01~12
    $phases  = $user_one_row[7];      // MV EV.......
    $testlab = $user_one_row[32];     //WKS WHQ......
    $mfgsite = $user_one_row[33];     //WKS WHQ......
    $tester  = $user_one_row[34];     //英文名
    $timedt  = $user_one_row[42];     //测试项录入的时间
    $title   = $user_one_row[45];
    //echo $stage."--".$vt."--".$pr_name."--".$sku."--".$nn."--".$yy."--".$phases."--".$testlab."--".$mfgsite."--".$tester."--".$timedt."--".$title;

    //獲取某一次測試的機台數量
    //$qty_query = mysqli_query($con,"SELECT COUNT(DISTINCT Unitsno) FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' ");
    //$qty_info = mysqli_fetch_array($qty_query,MYSQLI_NUM);
    //$number = $qty_info[0];
    $sql_unique_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting'";
    $tc_array = mysqli_query($con,$sql_unique_tc);
    $testitem_num = mysqli_num_rows($tc_array);
    $number = $counts/$testitem_num;
    echo "<p class='txt_for_check'>Product Name: ".$product." ,Tester: ".$tester." ,Start time: ".$starting." ,測試機數量: ".$number." ,測試項數量: ".$testitem_num." ,點擊Input SN可填入SN, 點擊Wistron Logo返回首頁</p>";
}
else{
    echo "<p style='color:#cc2229;font-size:30px;text-align:center'>未查詢任何條件,兩秒后返回首頁</p>";
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
    <script type="text/javascript" src="./js/Auto-transforming.js"></script>
    <title>Matrix Edit for <?php echo $tester." - ".$product; ?></title>
</head>
<body>
<div class="content">
    <h1>
        <span style="float: left;margin-left:20px;"><a href="index.php"><img src="./images/logo-small.svg" height="40" alt="Wistron"></a></span>
        <?php echo $title." ~ ".$tester." ~ ".$product; ?> - Test Matrix Auto-transforming
    </h1>
    <div id="preloder"><div class="loader"></div></div>
    <form form id="form8" name="form8" action="./matrix_edit_save.php" method="POST">
        <table id="customers" class="customers" border="1" rules="all">
            <?php
            $user_name = urlencode($tester);
            $product_name = urlencode($product);
            $start = urlencode($starting);
            $ss = $user_name."|".$$product_name."|".$start;
            ?>
            <thead>
            <tr>
                <th rowspan="2">Reque<br>-sted</th>
                <th rowspan="2">Group</th>
                <th rowspan="2">Test Items</th>
                <!-- <th rowspan="2">With/Without<br>Terminal</th> canceled on 2022-03-11 -->
                <th rowspan="2">Test Conditions</th>
                <th colspan="<?php echo $number; ?>" >
                    <a href="matrix_edit_sn.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>">Input SN</a>
                </th>
                <th colspan="2">Test Schedule</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Test Result</th>
                <th rowspan="2">Info for<br>failure</th>
                <th rowspan="2">One key<br>all pass</th>
                <th rowspan="2">Fail Symptom</th>
                <th rowspan="2">RCCA</th>
                <th rowspan="2">Remark</th>
                <th rowspan="2">Add&Delete</th>
            </tr>
            <tr>
                <?php
                for($i=0; $i<$number; $i++){
                    echo "<th>".($i+1)."</th>";
                }
                ?>
                <th>Start</th><th>Finish</th>
            </tr>
            </thead>
            <tbody>
            <!-- ----------- Matrix begin here ----------- -->
            <?php
            $groups = array();
            $test_items = array();
            $sql_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting'";
            $tc = mysqli_query($con,$sql_tc);
            while($tc_row = mysqli_fetch_array($tc,MYSQLI_BOTH)[0]){
                array_push($test_items,$tc_row);
            }//获取某次测试的test item
            $tc_num = count($test_items);    //行数
            $selectid=0;    //单元格编号 1,2,3....
            $rowid = 0;     //表格行编号
            //获取某次测试的Group
            for($j=0; $j<$tc_num; $j++){
                $tc_txt = $test_items[$j];
                $sql_one_gp = "SELECT DISTINCT `Groups` FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Testitems='$tc_txt' ";
                $gp_info = mysqli_query($con,$sql_one_gp);
                $gp_one = mysqli_fetch_array($gp_info,MYSQLI_BOTH)[0];
                array_push($groups,$gp_one);
            }
            //Table的内容
            for($i=0; $i<$tc_num; $i++){
                $tc_txt = $test_items[$i];
                //echo $tc_txt."<br>";
                $sql_one_row = "SELECT DISTINCT `Groups`,Testitems,Terminal,Testcondition,RCCA,Teststatus,Startday,Endday,Requests,Failinfo,Remarks,FAA ";
                $sql_one_row .="FROM DQA_Test_Main WHERE Testitems='$tc_txt' AND Testername='$tester' AND Products='$product' AND Timedt='$starting' ";
                $row_one_check = mysqli_query($con,$sql_one_row);
                $row = mysqli_fetch_array($row_one_check,MYSQLI_BOTH);    //根据某一个测试item和其他条件获取某一行的需要的内容
                //$rowid += 1;    //该行的行号
                //获取一行的测试结果
                $result_one_row = array();
                $sql_one_row_result = "SELECT Results,RecordID FROM DQA_Test_Main WHERE Testitems='$tc_txt' AND Testername='$tester' AND Products='$product' AND Timedt='$starting'";
                $one_row_result_check = mysqli_query($con, $sql_one_row_result);
                while($one_row_result = mysqli_fetch_array($one_row_result_check,MYSQLI_BOTH)){
                    array_push($result_one_row,$one_row_result[0]);
                }
                $len_result_one_row = count($result_one_row);
            ?>
            <tr>
                <td><input name='requests[]' id='requests' type='text' value='<?php echo $row["Requests"] ?>'></td>
                <td>
                    <!--select name='group[]' id='group1'-->
                    <?php
                    $w++;
                    $gp_txt = $groups[$i];
                    $opts = mysqli_query($con, "SELECT `Groups` FROM dropbox_group");
                    echo"<select name=group[] id=group"."$w"." onchange=groupchange($w)>";
                    while($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {

                        if($info[0]==$gp_txt){
                            echo "<option value="."'$info[0]'"."  selected >".$info[0]."</option>";
                        }
                        else{
                            echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                        }
                    }
                    ?>
                    </select>
                </td>
                <td>
                    <!--select name='test_item[]' id='test_item1' class='selbox'-->
                    <?php
                    $q++;;
                    $gp_txt = $groups[$i];
                    $opts = mysqli_query($con, "SELECT Testitem,Grouped FROM dropbox_test_item");
                    echo"<select name=test_item[] id=test_item"."$q"." class=selbox >";

                    while($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        echo $gp_txt;
                        if($info[0]==$tc_txt){
                            echo "<option value="."'$info[0]'"." class="."'$info[1]'" . "selected >".$info[0]."</option>";


                        }
                        else
                        {

                            if($info[1]==$gp_txt&&$info[0]!=$tc_txt){
                                echo "<option value="."'$info[0]'"." class="."'$info[1]'" . " >".$info[0]."</option>";
                            }
                            else
                            {
                                echo "<option value="."'$info[0]'"." class="."'$info[1]'" . " hidden=true >".$info[0]."</option>";
    
                            }
                        }



                    }
                    ?>
                    </select>
                </td>
                <!--<td><input name='terminal[]' id='terminal' type='text' value=""></td> canceled on 2022-03-11 -->
                <td>
                    <select name='conditions[]' id='conditions' class='selbox'>
                    <?php 
                    $opts = mysqli_query($con, "SELECT Testcondition FROM dropbox_test_condition");
                    echo "<option value=''>请选择Test Condition</option>";
                    while($info = mysqli_fetch_array($opts,MYSQLI_NUM)){
                        if($info[0]==$row["Testcondition"]){
                            echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                        }
                        else{
                            echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                        }
                    }
                    ?>
                    </select>
                </td>
                <!-- -------Unit Distribution------- -->
                <?php
                for($ii=0; $ii<$number; $ii++){
                    $no = $ii+1;    //Unit NO.(1,2,3,.....n)
                    $check = mysqli_query($con,"SELECT Units,RecordID,Unitsno FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Unitsno='$no' And `Groups`='$gp_txt' And Testitems='$tc_txt' ");
                    echo "<td>";
                    while($info=mysqli_fetch_array($check,MYSQLI_BOTH)){
                        $sql_result = "SELECT Results,RecordID,Defectmode1,Defectmode2,RCCA,Results,Issuestatus,Category,PIC,JIRANO,SPR,";
                        $sql_result.= "Temp,Dropcycles,Drops,Dropside,Hit,NextCheckpointDate,IssuePublished,ORTMFGDate,ReportedDate,Unitsno,FAA FROM DQA_Test_Main ";
                        $sql_result.="WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Unitsno='$no' And Testitems='$tc_txt'";
                        
                        $check_result = mysqli_query($con, $sql_result);
                        $row_result = mysqli_fetch_array($check_result,MYSQLI_NUM);
                        //----------- added on 2021-12-29 for fail informations -----------
                        $unit_id = $row_result[1];      //一个测试记录的ID
                        $result_record = $row_result[0];//一个测试记录的ID結果
                        
                        //echo "<input style='width:20px;display:none;' type='text' name='subject1[".$selectid."]' id='subject1[".$selectid."]' value='".$row_result[2]."'>";       //Defect Mode(Symptom)
                        //echo "<input style='width:20px;display:none;' type='text' name='subject2[".$selectid."]' id='subject2[".$selectid."]' value='".$row_result[3]."'>";       //Defect Mode(Symptom+Finding)
                        //echo "<input style='width:20px;display:none;' type='text' name='subject3[".$selectid."]' id='subject3[".$selectid."]' value='".$row_result[4]."'>";       //RCCA
                        //echo "<input style='width:20px;display:none;' type='text' name='subject4[".$selectid."]' id='subject4[".$selectid."]' value='".$row_result[6]."'>";       //Issuestatus
                        //echo "<input style='width:20px;display:none;' type='text' name='subject5[".$selectid."]' id='subject5[".$selectid."]' value='".$row_result[7]."'>";       //Category
                        //echo "<input style='width:20px;display:none;' type='text' name='subject6[".$selectid."]' id='subject6[".$selectid."]' value='".$row_result[8]."'>";       //PIC
                        //echo "<input style='width:20px;display:none;' type='text' name='subject7[".$selectid."]' id='subject7[".$selectid."]' value='".$row_result[9]."'>";       //JIRANO
                        //echo "<input style='width:20px;display:none;' type='text' name='subject8[".$selectid."]' id='subject8[".$selectid."]' value='".$row_result[10]."'>";      //SPR
                        //echo "<input style='width:20px;display:none;' type='text' name='subject9[".$selectid."]' id='subject9[".$selectid."]' value='".$row_result[11]."'>";      //TEMP
                        //echo "<input style='width:20px;display:none;' type='text' name='subject10[".$selectid."]' id='subject10[".$selectid."]' value='".$row_result[12]."'>";    //Dropcycles
                        //echo "<input style='width:20px;display:none;' type='text' name='subject11[".$selectid."]' id='subject11[".$selectid."]' value='".$row_result[13]."'>";    //Drops
                        //echo "<input style='width:20px;display:none;' type='text' name='subject12[".$selectid."]' id='subject12[".$selectid."]' value='".$row_result[14]."'>";    //Dropside
                        //echo "<input style='width:20px;display:none;' type='text' name='subject13[".$selectid."]' id='subject13[".$selectid."]' value='".$row_result[15]."'>";    //Hit
                        //echo "<input style='width:20px;display:none;' type='text' name='subject14[".$selectid."]' id='subject14[".$selectid."]' value='".$row_result[16]."'>";    //NextCheckpointDate
                        //echo "<input style='width:20px;display:none;' type='text' name='subject15[".$selectid."]' id='subject15[".$selectid."]' value='".$row_result[17]."'>";    //IssuePublished
                        //echo "<input style='width:20px;display:none;' type='text' name='subject16[".$selectid."]' id='subject16[".$selectid."]' value='".$row_result[18]."'>";    //ORTMFGDate
                        //echo "<input style='width:20px;display:none;' type='text' name='subject17[".$selectid."]' id='subject17[".$selectid."]' value='".$row_result[19]."'>";    //ReportedDate
                        echo "<input class='temp_txt' type='text' name='subject9[".$selectid."]' id='subject9[".$selectid."]' value='".$row_result[11]."'>";//TEMP

                        echo "<input class='result_txt' type='text' name='subject18[".$selectid."]' id='subject18[".$selectid."]' value='$result_record'>";
                        echo "<input class='order_txt' type='text' name='test_order[]' id='test_order' type='text' value="."'$info[0]'"." />";    //Test order A,B,C....Z
                        $selectid += 1;    //Table cell by row: 1,2,3......
		                echo "<input type='text' style='width:30px;display:none;' name='record_id[]' value="."'$info[1]'"." readonly />";   //RecordID
                        //echo "cell: ".$selectid;
                    }
                    echo "</td>";
                }//end of Unit Distribution
                ?>
                <td><input type='date' name='starting[]' id='starting' value="<?php echo $row["Startday"]; ?>" /></td>
                <td><input type='date' name='ending[]' id='ending' value="<?php echo $row["Endday"]; ?>" /></td>
                <!-- ------- Status select box------- -->
                <td>
                    <?php
                    $results_array = array();
                    $sql_each_result = "SELECT Results from DQA_Test_Main WHERE Testitems='$tc_txt' AND Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Units!='' ";
                    //echo $sql_each_result;
                    $one_row_result = mysqli_query($con, $sql_each_result);
                    while($info = mysqli_fetch_array($one_row_result,MYSQLI_BOTH)){
                        array_push($results_array,$info[0]);
                    }
                    $len_results = count($results_array);
                    $status = "";
                    $num = 0;
                    for($bb=0; $bb<$len_results; $bb++){
                        if($results_array[$bb]=="TBD"){
                            $num++;
                            if($num == $len_results){
                                $status = "Not start";
                            }
                            else if($num>0 && $num<$len_results){
                                $status = "In progress";
                            }
                        }
                    }
                    if(!in_array("TBD",$results_array)){
                        $status = "Complete";
                    }
                    echo "<input style='width:70px;' name='status[]' id='status' type='text' value='$status' readonly />";
                    ?>
                </td>
                <!-- -------Result select box ------- -->
                <td>
                    <?php
                    //rowid是表格行编号,selectid是单元格编号,number是机台数量,unit_id是RecordID,$tc_num是总行数,TMD参数越传越多
                    //echo "cell:".$selectid;
                    /*
                    $one_row_result = "";
                    for($k=0; $k<$len_result_one_row;$k++){
                        //echo $result_one_row[$k];
                        if($result_one_row[$k]=="Pass"){
                            $one_row_result = "Pass";
                        }
                    }

                    if(in_array("Fail",$result_one_row)){
                        $one_row_result = "Fail";
                    }
                    elseif(in_array("Known Fail (Open)",$result_one_row)){
                        $one_row_result = "Known Fail (Open)";
                    }
                    elseif(in_array("Known Fail (Close)",$result_one_row)){
                        $one_row_result = "Known Fail (Close)";
                    }
                    elseif(in_array("EC Fail",$result_one_row)){
                        $one_row_result = "EC Fail";
                    }
                    //echo "<select class='resultbox' name='result[".$selectid."]' id='result[".$selectid."]' onchange='printResult(".$rowid.",".$selectid.",".$number.",".$unit_id.",".$tc_num.");'>";
                    echo "<select class='resultbox' name='result[".$selectid."]' id='result[".$selectid."]'>";
                    $check_result_drop = mysqli_query($con, "SELECT Result FROM dropbox_result");
                    while ($row_result_drop = mysqli_fetch_array($check_result_drop,MYSQLI_NUM)) {
                        
                        if($one_row_result==$row_result_drop[0]){
                            echo "<option value="."'$row_result_drop[0]'"." selected >".$row_result_drop[0]."</option>";
                        }                       
                        else{
                            echo "<option value="."'$row_result_drop[0]'".">".$row_result_drop[0] . "</option>";
                        }
                    }
                    echo "</select>";
                    */
                    $row_result = "TBD";
                    $num1 = 0;
                    for($k=0; $k<$len_results;$k++){
                        //echo $result_one_row[$k];                   
                        if($results_array[$k]=="Pass"){
                            $num1++;
                            if($num1 == $len_results){
                                $row_result = "Pass";
                            }
                        }
                        else if(in_array("EC Fail",$results_array)){
                            $row_result = "EC Fail";
                        }
                        else if(in_array("Fail",$results_array)){
                            $row_result = "Fail";
                        }
                        else if(in_array("Known Fail (Open)",$results_array)){
                            $row_result = "Known Fail (Open)";
                        }
                        else if(in_array("Known Fail (Close)",$results_array)){
                            $row_result = "Known Fail (Close)";
                        }
                    }
                    echo "<input style='width:110px;' name='result' type='text' value='$row_result' readonly />";
                    ?>
                </td>
                <td>
                    <input type="button" class="add_info" name="FF<?php echo $rowid; ?>" id="FF<?php echo $rowid; ?>" value="Info" onclick='printResult(<?php echo $rowid; ?>,<?php echo $selectid; ?>,<?php echo $number; ?>,<?php echo $unit_id; ?>,<?php echo $tc_num; ?>);'>                  
                </td>
                <td>
                    <input type="button" class="all_pass" name="PP<?php echo $rowid; ?>" id="PP<?php echo $rowid; ?>" value="Pass" onclick='oneRowAllPass(<?php echo $rowid; ?>,<?php echo $number; ?>);'>                  
                </td>
                <td><textarea name="fail[<?php echo $rowid; ?>]" id="fail[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["Failinfo"]; ?></textarea></td>
                <td><textarea name="rcca[<?php echo $rowid; ?>]" id="rcca[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["FAA"]; ?></textarea></td>
                <td><textarea name="remarks[<?php echo $rowid; ?>]" id="remarks[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["Remarks"]; ?></textarea></td>
                <td>
                    <input class="btn_add" type="button" name="add" value="Add" id="add" />&nbsp;
                    <input class="btn_del" type="button" name="del" value="Del" id="del"/>
                </td>
            </tr>
            <?php 
            $rowid = $rowid+1;
            }
            ?>
            </tbody>
        </table>
        <!-- #################### 又是一道分割线 ############################### -->
        <div class="save_record">
            <input class="subit" type="submit" name="sub" value="Save" />
            &nbsp;&nbsp;<input class="back" type="button" value="Back" onClick="history.go(-1);">
            <!-- Add on 2021-12-16, hidden area -->
            <input name="stage" type="hidden" value="<?php echo $stage; ?>" />
            <input name="vt" type="hidden" value="<?php echo $vt; ?>" />
            <input name="pr_name" type="hidden" value="<?php echo $pr_name ?>" />
            <input name="sku" type="hidden" value="<?php echo $sku; ?>" />
            <input name="year" type="hidden" value="<?php echo $nn; ?>" />
            <input name="month" type="hidden" value="<?php echo $yy; ?>" />
            <input name="phase" type="hidden" value="<?php echo $phases; ?>"/>
            <input name="testlab" type="hidden" value="<?php echo $testlab; ?>"/>
            <input name="mfgsite" type="hidden" value="<?php echo $mfgsite; ?>"/>
            <input name="tester" type="hidden" value="<?php echo $tester; ?>"/>
            <input name="timedt" type="hidden" value="<?php echo $timedt; ?>" />
            <input name="title" type="hidden" value="<?php echo $title; ?>" />           
            <!-- -----------Ending----------- -->
            <input name="number" type="hidden" id ="units_qty" value="<?php echo $number; ?>" />
            <input name="matrix_edit" value="matrix_edit_do" type="hidden">
        </div>
    </form>
</div>
<!-- Add button to export matrix to excel begins here -->
<div>
    <form name="export" method="POST" action="./comm/Matrix_Excel.php">
        <table width="100%" cellpadding="3" border="0">
            <tr>
                <td>
                    <button class="btn_download">Export</button> <span class="export-icon"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="color: #cc2229;font-size:12px">Tap Export button to Excel and save to Download folder</span>
                    <input name="product" type="hidden" value="<?php echo $product; ?>" />
                    <input name="tester" type="hidden" value="<?php echo $tester; ?>" />
                    <input name="starting" type="hidden" value="<?php echo $starting; ?>" />
                    <input name="phase1" type="hidden" value="<?php echo $phases; ?>" />
                    <input name="vt1" type="hidden" value="<?php echo $vt; ?>">
                    <input name="number1" type="hidden" value="<?php echo $number; ?>" />
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- Add button to export matrix to excel end -->
<div>&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/bear.svg" height="200" /></div>
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistron">
</div>  
</body>
</html>