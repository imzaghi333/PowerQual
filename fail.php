<?php
/**
 * _ooOoo_
 * o8888888o
 * 88" . "88
 * (| -_- |)
 *  O\ = /O
 * ___/`---'\____
 * .   ' \\| |// `.
 * / \\||| : |||// \
 * / _||||| -:- |||||- \
 * | | \\\ - /// | |
 * | \_| ''\---/'' | |
 * \ .-\__ `-` ___/-. /
 * ___`. .' /--.--\ `. . __
 * ."" '< `.___\_<|>_/___.' >'"".
 * | | : `- \`.;`\ _ /`;.`/ - ` : | |
 * \ \ `-. \_ __\ /__ _/ .-` / /
 * ======`-.____`-.___\_____/___.-`____.-'======
 * `=---='
 *      .............................................
 *                               佛曰：bug泛滥，我已瘫痪！
*/

require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");

$row_no    = $_GET["rowid"];           //选了fail那一行的编号
$select_id = $_GET["cellid"];          //一行最后一个单元格编号
$number    = $_GET["count"];          //测试机数量
$currentid = $_GET["currentid"];      //一行最后一个单元格RecordID
$rows      = $_GET["rows"];           //测试总行数 
echo "<p class='txt_for_check'>當前是第".($row_no+1)."行 ,表总行数：".$rows." ,测试机数量：".$number." ,最后一个单元格ID：".$currentid."</p>";

$cells = array();        //一行的每个单元格编号
$record_ids = array();   //一行的每个测试记录的RecordID
for($i=$number; $i>0; $i--){
    $cell_id = $select_id-$i+1;
    //echo "第".($row_no+1)."行每个单元格编号: ".$cell_id."<br>";
    array_push($cells,$cell_id);
}

for($i=($number-1); $i>=0; $i--){
    $tmp_id = $currentid-$rows*$i;
    //echo "第".($row_no+1)."行每个单元格测试ID: ".$tmp_id."<br>";
    array_push($record_ids,$tmp_id);
}
//echo "*********** 上述内容以後會刪除, 目前只是方便我使用而已 ***********<br>";
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style/main_dqa.css">
    <script type="text/javascript" src="./js/failinfo.js"></script>
    <link rel="shortcut icon" href="./images/favior.ico">
    <title>Failure Info</title>
</head>

<body>
<?php
if(isset($_GET["count"])){
?>
<p class="txt_for_check">
    1.點擊Link标签可以為每個測試機添加failure;<br>
    2.溫度下拉菜單可以為每個測試機設置溫度Cold,Room,Hot;<br>
    3.Result下拉菜單為每個測試機单独設置Pass或TBD;<br>
    4.Set按鈕設置一行結果全部Pass;
</p>
<table id="unit_table" class="unit_table" border="1" cellpadding="3" cellspacing="3">
    <thead>
    <tr>
        <th>Description</th>
        <?php
        for($i=0; $i<$number; $i++){
            echo "<th>Unit# ".($i+1)."</th>";
        }
        ?>
        <th>A Key ALL Pass</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Add Fail</td>
        <?php
        /**
         * 添加failure的超链接
        */
        for($i=0; $i<$number; $i++){
            $cell = $cells[$i];
            $id = $record_ids[$i];
            $sql_order = mysqli_query($con,"SELECT Units FROM DQA_Test_Main WHERE RecordID='$id'");
            $order = mysqli_fetch_array($sql_order,MYSQLI_NUM)[0];
            $unit_name = "Unit".($i+1);
            $ll = "";
            if($order=="" || $order==" "){
            $ll = ""; 
            }else{
                $ll = "Link";
            }
            echo "<td><a style='font-weight: bold;' href='fail.php?cell=$cell&id=$id&rowid=$row_no&unit=$unit_name'>".$ll."</a></td>";
        }
        ?>
        <!-- One row all pass via pressing set button -->
        <td rowspan="3"><input class="all_pass" type="button" name="PP<?php echo ($row_no+1); ?>" id="PP<?php echo ($row_no+1); ?>" value="SET" onclick="oneRowAllPass(<?php echo $row_no+1; ?>,<?php echo $number; ?>);" /></td>
    </tr>
    <tr>
        <td>Set Temperature</td>
        <?php
        /**
         * 为每个测试设置温度
        */
        for($i=0; $i<$number; $i++){
            $cell = $cells[$i];
            $id = $record_ids[$i];
            $sql_order = mysqli_query($con,"SELECT Units FROM DQA_Test_Main WHERE RecordID='$id'");
            $order = mysqli_fetch_array($sql_order,MYSQLI_NUM)[0];
            $unit_name = "Unit".($i+1);
            $ll = "";
            if($order=="" || $order==" "){
            $ll = ""; 
            }else{
                $ll = "<select class='del_fail' id='temp$cell' onchange='setTemperature($cell);'>";
                $ll.= "<option value=''>Select</option>";
                $ll.= "<option value='Hot'>Hot</option>";
                $ll.= "<option value='Cold'>Cold</option>";
                $ll.= "<option value='Room'>Room</option>";
                $ll.= "</select>";
            }
            echo "<td>".$ll."</td>";
        }
        ?>
    </tr>
    <tr>
        <td>Singel unit result</td>
        <?php
        /**
         * 为单独的测试机添加Pass or TBD,这样不需要进入Failure Link去填写
        */
        for($i=0; $i<$number; $i++){
            $cell = $cells[$i];
            $id = $record_ids[$i];
            $sql_order = mysqli_query($con,"SELECT Units FROM DQA_Test_Main WHERE RecordID='$id'");
            $order = mysqli_fetch_array($sql_order,MYSQLI_NUM)[0];
            $unit_name = "Unit".($i+1);
            $ll = "";
            if($order=="" || $order==" "){
            $ll = ""; 
            }else{
                $ll = "<select class='del_fail' id='pt$cell' onchange='setPassOrTBD($cell);'>";
                $ll.= "<option value=''>Select</option>";
                $ll.= "<option value='Pass'>Pass</option>";
                //$ll.= "<option value='Fail'>Fail</option>";
                //$ll.= "<option value='EC Fail'>EC Fail</option>";
                //$ll.= "<option value='Known Fail (Open)'>Known Fail (Open)</option>";
                //$ll.= "<option value='Known Fail (Close)'>Known Fail (Close)</option>";
                $ll.= "<option value='TBD'>TBD</option>";
                $ll.= "</select>";
            }
            echo "<td>".$ll."</td>";
        }
        ?>
    </tr>
    </tbody>
</table>
<hr>
<?php
/**
* 显示failure的机台，如果是Pass的就不会运行这段代码 
*/
if(isset($_GET["rowid"])){
    $row_bh = $row_no+1;
    for($loop=0; $loop<$number; $loop++){
        //echo $record_ids[$loop]." ===> Cell: ".$cells[$loop]."<br>";
        $test_id = $record_ids[$loop];
        $cell_id = $cells[$loop];
        $unit_no = $loop+1;
        $sql_query = "SELECT FID FROM fail_infomation WHERE TestID='$test_id' and RowID='$row_bh' and CellID='$cell_id' and Unitsno='$unit_no' ";
        //echo $sql_query."<br>";
        $y_rowid    = $_GET["rowid"];           //选了fail那一行的编号
        $y_cellid = $_GET["cellid"];          //一行最后一个单元格编号
        $y_count    = $_GET["count"];          //测试机数量
        $y_currentid = $_GET["currentid"];      //一行最后一个单元格RecordID
        $y_rows      = $_GET["rows"];           //测试总行数 

        $check = mysqli_query($con,$sql_query);
        $row_nums = mysqli_num_rows($check);//該測試機failure info的數量
        if($row_nums>0){
            echo "<table class='unit_table' border='1' cellpadding='3' cellspacing='3'>";
            echo "<tr>";
            $sql_query0 = "SELECT Unitsno FROM fail_infomation WHERE TestID='$test_id' and RowID='$row_bh' and CellID='$cell_id' and Unitsno='$unit_no'";
            $check0 = mysqli_query($con,$sql_query0);

            $sql_query1 = "SELECT FID,TestID,RowID,CellID,Unitsno,Results FROM fail_infomation WHERE TestID='$test_id' and RowID='$row_bh' and CellID='$cell_id' and Unitsno='$unit_no'";
            $check1 = mysqli_query($con,$sql_query1);

            $unit_bh = mysqli_fetch_array($check0,MYSQLI_NUM)[0];

            echo "<th width='50'>Unit# $unit_bh</th>";
            while($info = mysqli_fetch_array($check1,MYSQLI_BOTH)){
                echo "<td width='120'><a href='fail_edit.php?id=$info[0]&unit=$info[4]&rowid=$y_rowid&cellid=$y_cellid&count=$y_count&currentid=$y_currentid&rows=$y_rows' >".$info[5]."</a></td>";
            }
            echo "<td width='120'>";
            echo "<select class='del_fail' id='del_fail' onchange='delOneFailure($y_rowid,$y_cellid,$y_count,$y_currentid,$y_rows);'>";
            echo "<option value=''>選擇删除记录</option>";
            for($i=0; $i<$row_nums; $i++){
                mysqli_data_seek($check1,$i);
                $info = mysqli_fetch_array($check1,MYSQLI_BOTH);
                echo "<option value='$info[0]'>".$info[5]."</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<tr></table>";
        }
    }
}
?>
<!-- Link 部分結束 -->
<?php
}
else if(isset( $_GET["cell"])){
    $select_id = $_GET["cell"];     //一个单元格编号
    $current_id = $_GET["id"];      //一个测试记录ID
    $clicked_unit = substr($_GET["unit"],4);  //选择的手机编号,'unit'字符被舍弃，只保留数字
    $row_id = $_GET["rowid"]+1;     //行編號
    echo "您選中了Unit".$clicked_unit."；它處於第".$row_id."行；它的单元格编号是:".$select_id." ,测试记录ID是:".$current_id."<br>";
?>
<!-- 默認是添加新的failure information -->
<div class="fail">
    <p class="info_title">Add New Failure Information</p>
    <form id="fain_info" name="fain_info" method="POST" action="">
        <table align="center" class="form_fail">
            <tbody>
            <tr>
                <td>Result<font color="#cc2229" size="1">*</font></td>
                <td>
                    <select name="ff" id="fail_result<?php echo $select_id; ?>" onchange="returnResult(<?php echo $row_id; ?>,<?php echo $select_id; ?>,<?php echo $clicked_unit; ?>);" required>
                        <option value="">請選擇</option>
                        <option value="Fail">Fail</option>
                        <option value="Known Fail (Open)">Known Fail (Open)</option>
                        <option value="Known Fail (Close)">Known Fail (Close)</option>
                        <option value="EC Fail">EC Fail</option>
                        <!--
                        <option value="Pass">Pass</option>
                        <option value="TBD">TBD</option>
                        -->
                    </select>
                </td>
            </tr>
            <tr>
                <td>Defect Mode(Symptom)</td>
                <td>
                <?php
                echo "<select name='df1' id='df1_$select_id' onchange='returnFailSympton($row_id,$select_id);'>";
                echo "<option value=''>請選擇</option>";
                $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df1");
                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                    echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                }
                echo "</select>"
                ?>
                </td>
            </tr>
            <tr>
                <td>Defect Mode(Symptom+Finding)</td>
                <td>
                <?php
                echo "<select name='df2'>";
                echo "<option value=''>請選擇</option>";
                $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df2");
                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                    echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                }
                echo "</select>"
                ?>
                </td>
            </tr>
            <tr>
                <td>RCCA</td>
                <td><textarea name="rcca" id="rcca<?php echo $select_id; ?>" cols="50" rows="10" onchange="returnRCCA(<?php echo $row_id; ?>,<?php echo $select_id; ?>,<?php echo $clicked_unit; ?>);" ></textarea></td>
            </tr>
            <tr>
                <td>Issue Status</td>
                <td>
                    <?php
                    echo "<select name='issue_status'>";
                    echo "<option value=''>請選擇</option>";
                    $opts = mysqli_query($con, "SELECT ISSUE_Status FROM dropbox_issue_status");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                    }
                    echo "</select>"
                    ?>
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                <select name="category">
                    <option value="">請選擇</option>
                    <option value="Component">Component</option>
                    <option value="Design">Design</option>
                    <option value="Process">Process</option>
                </select>
                </td>
            </tr>
            <tr><td>PIC</td><td><input name="pic" type="text" /></td></tr>
            <tr><td>JIRA</td><td><input name="jira" type="text" /></td></tr>
            <tr><td>SPR</td><td><input name="spr" type="text" /></td></tr>
            <tr>
                <td>TEMP<font color="#cc2229" size="1">*</font></td>
                <td>
                    <select name="temp" id="temp<?php echo $select_id; ?>" onchange="returnTEMP(<?php echo $row_id; ?>,<?php echo $select_id; ?>);">
                        <option value="">請選擇</option>
                        <option value="Cold">Cold</option>
                        <option value="Hot">Hot</option>
                        <option value="Room">Room</option>
                    </select>
                </td>
            </tr>
            <tr><td>Drop Cycle</td><td><input name="drop_cycle" id="drop_cycle<?php echo $select_id; ?>" type="text" onchange="returnDropCycle(<?php echo $row_id; ?>,<?php echo $select_id; ?>);" /></td></tr>
            <tr><td>Drops</td><td><input name="drops" id="drops<?php echo $select_id; ?>" type="number" min="1" max="100" onchange="retrunDrops(<?php echo $row_id; ?>,<?php echo $select_id; ?>);" /></td></tr>
            <tr>
                <td>Drop Side</td>
                <td>
                    <?php
                    echo "<select name='drop_side' id='drop_side$select_id' onchange='returnDropSide($row_id,$select_id);' >";
                    echo "<option value=''>請選擇</option>";
                    $opts = mysqli_query($con, "SELECT Dropside FROM dropbox_dropside");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                    }
                    echo "</select>"
                    ?>
                </td>
            </tr>
            <tr><td>Hit (Tumble)</td><td><input name="hit" id="hit<?php echo $select_id; ?>" type="text" onchange="returnHitTumble(<?php echo $row_id; ?>,<?php echo $select_id; ?>);" /></td></tr>
            <tr><td>Next checkpoint date</td><td><input name="checkpoint" type="date" /></td></tr>
            <tr>
                <td>Issue Published</td>
                <td>
                    <select name="publish">
                        <option value="">請選擇</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>ORT MFG Date</td><td><input name="mfg_date" type="date" /></td>
            </tr>
            <tr>
                <td>Reported Date</td><td><input name="report_date" type="date" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button class="btn_sub" type="submit">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" onClick="history.go(-1);">返回</button>
                    <input type="hidden" name="fail" value="fail_do" />
                    <!-- ----------- Hidden Area ----------- -->
                    <input type="hidden" name="cell_no" value="<?php echo $select_id; ?>" />
                    <input type="hidden" name="test_id" value="<?php echo $current_id; ?>" />
                    <input type="hidden" name="unit_no" value="<?php echo $clicked_unit ?>" />
                    <input type="hidden" name="row_no" value="<?php echo $row_id; ?>" />
                </td>
            </tr>
            </tbody>    
        </table>
    </form>
    <?php
    if(isset($_POST["fail"]) && $_POST["fail"]=="fail_do"){
        $df1 = $_POST["df1"];                    //Defect Mode symbol
        $df2 = $_POST["df2"];                    //Defect Mode symbol+Finding
        $rcca = $_POST["rcca"];
        $issue_status = $_POST["issue_status"];
        $category = $_POST["category"];
        $pic = $_POST["pic"];
        $jira = $_POST["jira"];
        $spr = $_POST["spr"];
        $temp = $_POST["temp"];    //Hot,Room,Cold
        $drop_cycle = $_POST["drop_cycle"];
        $drops = $_POST["drops"];
        $drop_side = $_POST["drop_side"];
        $hit_tumble = $_POST["hit"];
        $checkpoint = $_POST["checkpoint"];
        $publish = $_POST["publish"];
        $mfg_date = $_POST["mfg_date"];
        $report_date = $_POST["report_date"];
        // ----- import hidden text ------
        $cell_no = $_POST["cell_no"];
        $test_id = $_POST["test_id"];
        $unit_no = $_POST["unit_no"];
        $row_no = $_POST["row_no"];

        if($rcca){
            $rcca_txt = str_replace(PHP_EOL, " ", $rcca);//去掉RCCA换行
        }
        
        $tt_result = $_POST["ff"];//修改Default result
        /*
        $fail_symptom = "";
        if($df1){
            $fail_symptom .= $df1.". ";
        }
        if($temp){
            $fail_symptom .= $temp.". ";
        }
        if($drop_cycle){
            $fail_symptom .= $drop_cycle." cycles. ";
        }
        if($drops){
            $fail_symptom .= $drops." drops. ";
        }
        if($drop_side){
            $fail_symptom .= $drop_side." side. ";
        }
        if($hit_tumble){
            $fail_symptom .= $hit_tumble." hits.";
        }*/
        
        // ---------------------- MD  --------------------------------
        //echo "<script type='text/javascript'>returnvalue1(".($select_id-1).",'".$df1."')</script>";             //Defect Mode1
        //echo "<script type='text/javascript'>returnvalue2(".($select_id-1).",'".$df2."')</script>";             //Defect Mode2
        //echo "<script type='text/javascript'>returnvalue3(".($select_id-1).",'".$rcca_txt."')</script>";        //RCCA
        //echo "<script type='text/javascript'>returnvalue4(".($select_id-1).",'".$issue_status."')</script>";    //Issue Status
        //echo "<script type='text/javascript'>returnvalue5(".($select_id-1).",'".$category."')</script>";        //Category
        //echo "<script type='text/javascript'>returnvalue6(".($select_id-1).",'".$pic."')</script>";             //PIC
        //echo "<script type='text/javascript'>returnvalue7(".($select_id-1).",'".$jira."')</script>";            //JIRA
        //echo "<script type='text/javascript'>returnvalue8(".($select_id-1).",'".$spr."')</script>";             //SPR NO
        //echo "<script type='text/javascript'>returnvalue9(".($select_id-1).",'".$temp."')</script>";           //TEMP
        //echo "<script type='text/javascript'>returnvalue10(".($select_id-1).",'".$drop_cycle."')</script>";
        //echo "<script type='text/javascript'>returnvalue11(".($select_id-1).",'".$drops."')</script>";
        //echo "<script type='text/javascript'>returnvalue12(".($select_id-1).",'".$drop_side."')</script>";
        //echo "<script type='text/javascript'>returnvalue13(".($select_id-1).",'".$hit_tumble."')</script>";
        //echo "<script type='text/javascript'>returnvalue14(".($select_id-1).",'".$checkpoint."')</script>";      //Next checkpoint date
        //echo "<script type='text/javascript'>returnvalue15(".($select_id-1).",'".$publish."')</script>";         //Issue Published
        //echo "<script type='text/javascript'>returnvalue16(".($select_id-1).",'".$mfg_date."')</script>";        //ORT MFG Date
        //echo "<script type='text/javascript'>returnvalue17(".($select_id-1).",'".$report_date."')</script>";
        //echo "<script type='text/javascript'>returnvalue18(".($select_id-1).",'".$tt_result."')</script>";
        //echo "<script type='text/javascript'>returnvalue19(".$row_no.",'Unit".$clicked_unit.":".$fail_symptom."')</script>";//Fail symptom
        //echo "<script type='text/javascript'>returnvalue20(".$row_no.",'Unit".$clicked_unit.":".$rcca_txt."')</script>";//RCCA

        $sql_add = "INSERT INTO fail_infomation(Defectmode1,Defectmode2,RCCA,Issuestatus,Category,PIC,JIRANO,SPR,Temp,Dropcycles,Drops,Dropside,HIT,NextCheckpointDate,IssuePublished,ORTMFGDate,ReportedDate,Unitsno,TestID,RowID,CellID,Results) ";
        $sql_add.= "VALUES('$df1','$df2','$rcca_txt','$issue_status','$category','$pic','$jira','$spr','$temp','$drop_cycle','$drops','$drop_side','$hit_tumble','$checkpoint','$publish','$mfg_date','$report_date','$unit_no','$test_id','$row_no','$cell_no','$tt_result')";
        mysqli_query($con,$sql_add);
        sleep(1);
        mysqli_close($con);
        echo "<script type='text/javascript'>window.history.go(-2);</script>";
    }
    ?>
</div>
<!-- add new failure info end here -->
<?php
}
?>
</body>
</html>