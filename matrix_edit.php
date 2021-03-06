<?php
/*
                          (  ) (@@) ( )  (@)  ()    @@    O     @     O     @      O
                     (@@@)
                 (    )
              (@@@@)

            (   )
         ====        ________                ___________
     _D _|  |_______/        \__I_I_____===__|_________|
      |(_)---  |   H\________/ |   |        =|___ ___|      _________________
      /     |  |   H  |  |     |   |         ||_| |_||     _|                \_____A
     |      |  |   H  |__--------------------| [___] |   =|                        |
     | ________|___H__/__|_____/[][]~\_______|       |   -|     Felix Qian 钱暾     |
     |/ |   |-----------I_____I [][] []  D   |=======|____|________________________|_
   __/ =| o |=-O=====O=====O=====O \ ____Y___________|__|__________________________|_
    |/-=|___|=    ||    ||    ||    |_____/~\___/          |_D__D__D_|  |_D__D__D_|
     \_/      \__/  \__/  \__/  \__/      \_/               \_/   \_/    \_/   \_/
*/

require_once("./js/conf.php");
header("Content-Type:text/html;charset=UTF-8");

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
    $sql_unique_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting'";
    $tc_array = mysqli_query($con,$sql_unique_tc);
    $testitem_num = mysqli_num_rows($tc_array);
    if($testitem_num){
        $number = $counts/$testitem_num;
    }
    else{
        echo "好像没有查询到Test Items";
    }
    echo "<p class='txt_for_check'>Product Name: ".$product." ,Tester: ".$tester." ,Start time: ".substr($starting,0,10)." ,Total test units: ".$number." ,Total test items: ".$testitem_num." ,Click Input SN to import SN, Click Wistron Logo to home page</p>";
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
        <?php echo $title." ".$tester." ".$product; ?> - Test Matrix Auto-transforming
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
                <th rowspan="2">Test Conditions</th>
                <th colspan="<?php echo $number; ?>" >
                    <a href="matrix_edit_sn.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>">Input SN</a>
                </th>
                <th colspan="2">Test Schedule</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Test Result</th>
                <th rowspan="2">More Info</th>
                <th rowspan="2">Fail Symptom</th>
                <th rowspan="2">RCCA</th>
                <th rowspan="2">Remark</th>
                <th rowspan="2">ORT MFG Date</th>
                <!-- <th rowspan="2">Add&Delete</th> -->
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
                $sql_one_row = "SELECT DISTINCT `Groups`,Testitems,Terminal,Testcondition,RCCA,Teststatus,Startday,Endday,Requests,Failinfo,Remarks,FAA,ORTMFGDate ";
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
                    <?php
                    $w++;
                    $gp_txt = $groups[$i];
                    $opts = mysqli_query($con, "SELECT `Groups` FROM dropbox_group");
                    echo"<select name=group[] id=group"."$w"." onchange=groupchange($w)>";
                    echo "<option value=Select_Group>Select_Group</option>";
                    while($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        if($info[0]==$gp_txt){
                            echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                        }
                        else{
                            echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                        }
                    }
                    ?>
                    </select>
                </td>
                <td>
                    <?php
                    $q++;
                    $gp_txt = $groups[$i];
                    $opts = mysqli_query($con, "SELECT Testitem,Grouped FROM dropbox_test_item");
                    echo"<select name=test_item[] id=test_item"."$q"." class=selbox >";
                    echo "<option value=Select_Item class=select_item>Select_Item</option>";

                    while($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
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
                <!-- test condition -->
                <td>
                    <textarea name='conditions[]' id='conditions' rows="1" class="text-adaption"><?php echo $row["Testcondition"]; ?></textarea>
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

                        echo "<input class='temp_txt' type='text' name='subject9[".$selectid."]' id='subject9[".$selectid."]' value='".$row_result[11]."'>";//TEMP
                        echo "<input class='result_txt' type='text' name='subject18[".$selectid."]' id='subject18[".$selectid."]' value='$result_record'>";//Restlt
                        echo "<input class='order_txt' type='text' name='test_order[]' id='test_order[".$selectid."]' type='text' value="."'$info[0]'"." />";    //Test order A,B,C....Z
                        $selectid += 1;    //Table cell by row: 1,2,3......
		                echo "<input type='text' style='width:30px;display:none;' name='record_id[]' value="."'$info[1]'"." readonly />";   //RecordID
                        //echo " ".$selectid;
                    }
                    echo "</td>";
                }
                ?>
                <!-- -------Unit Distribution End------- -->

                <!-- 填写开始日期和结束日期 -->
                <td><input type='date' name='starting[]' id='starting' value="<?php echo $row["Startday"]; ?>" /></td>
                <td><input type='date' name='ending[]' id='ending' value="<?php echo $row["Endday"]; ?>" /></td>
                
                <!-- Test status更加测试结果自动写入 -->
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
                    $status = "";//一行结果的status
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
                    echo "<input style='width:70px;' name='status[]' id='status$rowid' type='text' value='$status' readonly />";
                    ?>
                </td>

                <!-- Result根据测试结果按要求判断显示在页面 -->
                <td>
                    <?php
                    //rowid是表格行编号,selectid是单元格编号,number是机台数量,unit_id是RecordID,$tc_num是总行数,TMD参数越传越多
                    $row_result = "TBD";//一行结果TBD>EC Fail>Fail>Known Fail (open)>Known Fail (close)
                    $num1 = 0;
                    for($k=0; $k<$len_results;$k++){
                        //echo $result_one_row[$k];                   
                        if($results_array[$k]=="Pass"){
                            $num1++;
                            if($num1 == $len_results){
                                $row_result = "Pass";
                            }
                        }
                        else if(in_array("TBD",$results_array)){
                            $row_result = "TBD";
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
                    echo "<input style='width:110px;' name='result' id='result$rowid' type='text' value='$row_result' readonly />";
                    ?>
                </td>
                <!-- Add additional informaton -->
                <td>
                    <input type="button" class="add_info" name="FF<?php echo $rowid; ?>" id="FF<?php echo $rowid; ?>" value="Info" onclick='printResult(<?php echo $rowid; ?>,<?php echo $selectid; ?>,<?php echo $number; ?>,<?php echo $unit_id; ?>,<?php echo $tc_num; ?>);'>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <input type="button" class="add_info" name="PP<?php echo $rowid; ?>" id="PP<?php echo $rowid; ?>" value="Set" onclick='oneRowAllPass(<?php echo $rowid; ?>,<?php echo $number; ?>);'> 
                </td>
                <!-- Fail symptom, RCCA, Remark -->
                <td><textarea name="fail[<?php echo $rowid; ?>]" id="fail[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["Failinfo"]; ?></textarea></td>
                <td><textarea name="rcca[<?php echo $rowid; ?>]" id="rcca[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["FAA"]; ?></textarea></td>
                <td><textarea name="remarks[<?php echo $rowid; ?>]" id="remarks[<?php echo $rowid; ?>]" rows="1" class="text-adaption"><?php echo $row["Remarks"]; ?></textarea></td>
                <td><input type="date" value="<?php echo $row["ORTMFGDate"] ?>" readonly /></td>
            </tr>
            <?php 
            $rowid = $rowid+1;
            }
            ?>
            </tbody>
        </table>
        <!-- submit&hidden area from created matrix -->
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
                    <span style="color: #cc2229;font-size:14px">Tap Export button to save matrix as Excel to Download folder</span>
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

<!-- Footer div to add a simple note -->
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistron">
</div>  
</body>
<!--
嘿嘿嘿
      \                    / \  //\
       \    |\___/|      /   \//  \\
            /0  0  \__  /    //  | \ \
           /     /  \/_/    //   |  \  \
           @_^_@'/   \/_   //    |   \   \
           //_^_/     \/_ //     |    \    \
        ( //) |        \///      |     \     \
      ( / /) _|_ /   )  //       |      \     _\
    ( // /) '/,_ _ _/  ( ; -.    |    _ _\.-~        .-~~~^-.
  (( / / )) ,-{        _      `-.|.-~-.           .~         `.
 (( // / ))  '/\      /                 ~-. _ .-~      .-~^-.  \
 (( /// ))      `.   {            }                   /      \  \
  (( / ))     .----~-.\        \-'                 .~         \  `. \^-.
             ///.----..>        \             _ -~             `.  ^-`  ^-_
               ///-._ _ _ _ _ _ _}^ - - - - ~                     ~-- ,.-~
                                                                  /.-~
-->
</html>