<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");

//---------------------------------------------------
$row_no    = $_GET["rowid"];           //选了fail那一行的编号
$select_id = $_GET["cellid"];          //一行最后一个单元格编号
$number    = $_GET["count"];          //测试机数量
$currentid = $_GET["currentid"];      //一行最后一个单元格RecordID
$rows      = $_GET["rows"];           //测试总行数 
//echo "<p class='txt_for_check'>当前行号：".$row_no."(从0开始计数) ,总行数：".$rows." ,测试机数量：".$number." ,最后一个单元格ID：".$currentid."</p>";
// --------------------------------------------------
$cells = array();        //一行的每个单元格编号
$record_ids = array();   //一行的每个测试记录的RecordID
for($i=$number; $i>0; $i--){
    $cell_id = $select_id-$i+1;
    echo "第".$row_no."行每个单元格编号: ".$cell_id."<br>";
    array_push($cells,$cell_id);
}

for($i=($number-1); $i>=0; $i--){
    $tmp_id = $currentid-$rows*$i;
    echo "第".$row_no."行每个单元格测试ID: ".$tmp_id."<br>";
    array_push($record_ids,$tmp_id);
}
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <script type="text/javascript" src="./js/failinfo.js"></script>
    <link rel="shortcut icon" href="./images/favior.ico">
    <title>Failure info.</title>
</head>
<body>
<table id="unit_table" class="unit_table" border="1" cellpadding="3" cellspacing="3">
    <thead>
    <tr>
    <?php
    for($i=0; $i<$number; $i++){
        echo "<th>Unit# ".($i+1)."</th>";
    }
    ?>
    </tr>
    </thead>
    <tbody>
    <tr>
    <?php
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
        echo "<td><a href='fail.php?cell=$cell&id=$id&rowid=$row_no&unit=$unit_name'>".$ll."</a></td>";
    }
    ?>
    </tr>
    </tbody>
</table>

<div class="fail">
<?php
if(isset( $_GET["cell"])){
    $select_id = $_GET["cell"];     //一个单元格编号
    $current_id = $_GET["id"];      //一个测试记录ID
    $clicked_unit = $_GET["unit"];  //选择的手机编号
    //echo "你选择了".$clicked_unit." ,它的单元格编号是:".$select_id." ,测试记录ID是:".$current_id."<br>";
    $check = mysqli_query($con, "SELECT * FROM DQA_Test_Main WHERE RecordID='$current_id' ");
    $row = mysqli_fetch_array($check,MYSQLI_BOTH);
    ?>
    <p class="info_title">Add Failure Information <span class="icon">f</span></p>
    <form id="fain_info" name="fain_info" method="POST" action="">
        <table align="center" class="form_fail">
            <tbody>
            <tr>
                <td>Defect Mode(Symptom)</td>
                <td>
                <?php
                echo "<select name='df1'>";
                echo "<option value=''>请选择</option>";
                $df1 = $row[16];
                $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df1");
                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                    if($info[0]==$df1){
                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                    }
                    else{
                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                    }
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
                echo "<option value=''>请选择</option>";
                $df2 = $row[17];
                $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df2");
                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                    if($info[0]==$df2){
                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                    }
                    else{
                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                    }
                }
                echo "</select>"
                ?>
                </td>
            </tr>
            <tr>
                <td>RCCA</td>
                <td><textarea name="rcca" cols="50" rows="10" ><?php echo $row['RCCA']; ?></textarea></td>
            </tr>
            <tr>
                <td>Issue Status</td>
                <td>
                    <?php
                    echo "<select name='issue_status'>";
                    echo "<option value=''>请选择</option>";
                    $status = $row["Issuestatus"];
                    $opts = mysqli_query($con, "SELECT ISSUE_Status FROM dropbox_issue_status");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        if($info[0]==$status){
                            echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                        }
                        else{
                            echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                        }
                    }
                    echo "</select>"
                    ?>
                </td>
            </tr>
            <tr>
                <td>Category</td>
                <td>
                <select name="category">
                    <option value="">请选择</option>
                    <option value="Component" <?php if($row['Category']=='Component'){echo "selected = 'selected'";} ?> >Component</option>
                    <option value="Design" <?php if($row['Category']=='Design'){echo "selected = 'selected'";} ?> >Design</option>
                    <option value="Process" <?php if($row['Category']=='Process'){echo "selected = 'selected'";} ?> >Process</option>
                </select>
                </td>
            </tr>
            <tr><td>PIC</td><td><input name="pic" type="text" value="<?php echo $row['PIC']; ?>" /></td></tr>
            <tr><td>JIRA</td><td><input name="jira" type="text" value="<?php echo $row['JIRANO']; ?>" /></td></tr>
            <tr><td>SPR</td><td><input name="spr" type="text" value="<?php echo $row['SPR']; ?>" /></td></tr>
            <tr>
                <td>TEMP</td>
                <td>
                    <select name="temp">
                        <option value="">请选择</option>
                        <option value="Cold" <?php if($row['Temp']=='Cold'){echo "selected = 'selected'";} ?> >Cold</option>
                        <option value="Hot" <?php if($row['Temp']=='Hot'){echo "selected = 'selected'";} ?> >Hot</option>
                        <option value="Room" <?php if($row['Temp']=='Room'){echo "selected = 'selected'";} ?> >Room</option>
                    </select>
                </td>
            </tr>
            <tr><td>Drop Cycle</td><td><input name="drop_cycle" type="text" value="<?php echo $row['Dropcycles']; ?>" /></td></tr>
            <tr><td>Drops</td><td><input name="drops" type="number" min="1" max="100" value="<?php echo $row['Drops']; ?>"  /></td></tr>
            <tr>
                <td>Drop Side</td>
                <td>
                    <?php
                    echo "<select name='drop_side'>";
                    echo "<option value=''>请选择</option>";
                    $dp = $row["Dropside"];
                    $opts = mysqli_query($con, "SELECT Dropside FROM dropbox_dropside");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        if($info[0]==$dp){
                            echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                        }
                        else{
                            echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                        }
                    }
                    echo "</select>"
                    ?>
                </td>
            </tr>
            <tr><td>Hit (Tumble)</td><td><input name="hit" type="text" value="<?php echo $row['Hit']; ?>" /></td></tr>
            <tr><td>Next checkpoint date</td><td><input name="checkpoint" type="date" value="<?php echo $row['NextCheckpointDate']; ?>" /></td></tr>
            <tr>
                <td>Issue Published</td>
                <td>
                    <select name="publish">
                        <option value="">请选择</option>
                        <option value="Yes" <?php if($row['IssuePublished']=='Yes'){echo "selected = 'selected'";} ?> >Yes</option>
                        <option value="No" <?php if($row['IssuePublished']=='No'){echo "selected = 'selected'";} ?> >No</option>
                    </select>
                </td>
            </tr>
            <tr><td>ORT MFG Date</td><td><input name="mfg_date" type="date" value="<?php echo $row['ORTMFGDate']; ?>" /></td></tr>
            <tr><td>Reported Date</td><td><input name="report_date" type="date" value="<?php echo $row['ReportedDate']; ?>" /></td></tr>
            <!--<input name="ff" type="hidden" value="Fail" />-->
            <tr>
                <td>Fail類型</td>
                <td>
                    <select name="ff" required>
                        <option value="Pass">請選擇</option>
                        <option value="Fail">Fail</option>
                        <option value="Known Fail (Open)">Known Fail (Open)</option>
                        <option value="Known Fail (Close)">Known Fail (Close)</option>
                        <option value="EC Fail">EC Fail</option>
                    </select>
                </td>
            </tr>
            <!-- ######################### 分割线 ##################### -->
            <tr>
                <td colspan="2" align="center">
                    <button class="btn_sub" type="submit">確定</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="hidden" name="fail" value="fail_do" />
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
        $temp = $_POST["temp"];
        $drop_cycle = $_POST["drop_cycle"];
        $drops = $_POST["drops"];
        $drop_side = $_POST["drop_side"];
        $hit_tumble = $_POST["hit"];
        $checkpoint = $_POST["checkpoint"];
        $publish = $_POST["publish"];
        $mfg_date = $_POST["mfg_date"];
        $report_date = $_POST["report_date"];
        // ------------- 分割线 ----------------------
        if($rcca){
            $rcca_txt = str_replace(PHP_EOL, " ", $rcca);//去掉RCCA换行
        }
        
        $tt_result = $_POST["ff"];//修改Default result为fail
        $fail_symptom = "";
        if($df1){
            $fail_symptom .= $df1.". ";
        }
        /*
        if($df2){
            $fail_symptom .= "Defect Mode(Symptom+Finding):".$df2;
        }
        if($issue_status){
            $fail_symptom .= "Issue Status:".$issue_status;
        }
        if($category){
            $fail_symptom .= "Category:".$category;
        }
        if($pic){
            $fail_symptom .= "PIC:".$pic;
        }
        if($jira){
            $fail_symptom .= "JIRA:".$jira;
        }
        if($spr){
            $fail_symptom .= "SPR:".$spr;
        }
        */
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
        }
        /*
        if($checkpoint){
            $fail_symptom .= "Next checkpoint date".$checkpoint;
        }
        if($publish){
            $fail_symptom .= "Issue Published:".$publish;
        }
        if($mfg_date){
            $fail_symptom .= "ORT MFG Date".$mfg_date;
        }
        if($report_date){
            $fail_symptom .= "Reported Date:".$report_date;
        }
        */
        // ---------------------- MD,用了16个if --------------------------------

        echo "<script type='text/javascript'>returnvalue1(".($select_id-1).",'".$df1."')</script>";             //Defect Mode1
        echo "<script type='text/javascript'>returnvalue2(".($select_id-1).",'".$df2."')</script>";             //Defect Mode2
        echo "<script type='text/javascript'>returnvalue3(".($select_id-1).",'".$rcca_txt."')</script>";        //RCCA
        echo "<script type='text/javascript'>returnvalue4(".($select_id-1).",'".$issue_status."')</script>";    //Issue Status
        echo "<script type='text/javascript'>returnvalue5(".($select_id-1).",'".$category."')</script>";        //Category
        echo "<script type='text/javascript'>returnvalue6(".($select_id-1).",'".$pic."')</script>";             //PIC
        echo "<script type='text/javascript'>returnvalue7(".($select_id-1).",'".$jira."')</script>";            //JIRA
        echo "<script type='text/javascript'>returnvalue8(".($select_id-1).",'".$spr."')</script>";             //SPR NO
        echo "<script type='text/javascript'>returnvalue9(".($select_id-1).",'".$temp."')</script>";           //TEMP
        echo "<script type='text/javascript'>returnvalue10(".($select_id-1).",'".$drop_cycle."')</script>";
        echo "<script type='text/javascript'>returnvalue11(".($select_id-1).",'".$drops."')</script>";
        echo "<script type='text/javascript'>returnvalue12(".($select_id-1).",'".$drop_side."')</script>";
        echo "<script type='text/javascript'>returnvalue13(".($select_id-1).",'".$hit_tumble."')</script>";
        echo "<script type='text/javascript'>returnvalue14(".($select_id-1).",'".$checkpoint."')</script>";      //Next checkpoint date
        echo "<script type='text/javascript'>returnvalue15(".($select_id-1).",'".$publish."')</script>";         //Issue Published
        echo "<script type='text/javascript'>returnvalue16(".($select_id-1).",'".$mfg_date."')</script>";        //ORT MFG Date
        echo "<script type='text/javascript'>returnvalue17(".($select_id-1).",'".$report_date."')</script>";
        echo "<script type='text/javascript'>returnvalue18(".($select_id-1).",'".$tt_result."')</script>";
        // ----------- MD --------------
        echo "<script type='text/javascript'>returnvalue19(".$row_no.",'".$clicked_unit.":".$fail_symptom."')</script>";
        echo "<script type='text/javascript'>returnvalue20(".$row_no.",'".$clicked_unit.":".$rcca_txt."')</script>";

        echo "<script type='text/javascript'>window.history.go(-2);</script>";
        echo "<br><p style='color:#337ab7;font: size 16px;'>Info update complete, close it to continue.</p>";
        mysqli_close($con);
    }
    ?>
    <?php
}
?>
</div>
</body>
</html>