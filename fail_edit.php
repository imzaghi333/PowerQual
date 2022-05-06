<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");

if(isset($_GET["id"])){
    $fail_id = $_GET["id"];
    $unit_not = $_GET["unit"];
    $check = mysqli_query($con, "SELECT * FROM fail_infomation WHERE FID='$fail_id' ");  //query one fail item
    $row = mysqli_fetch_array($check,MYSQLI_BOTH);
    $record_id = $row[21];
    $oneRowRecord = mysqli_query($con,"SELECT Testitems FROM DQA_Test_Main WHERE RecordID='$record_id' ");//get test item
    $test_item = mysqli_fetch_array($oneRowRecord,MYSQLI_BOTH)[0];
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
    <title>View Failure Info</title>
</head>
<body>
<div class="fail">
    <p class="info_title">Viewing Unit<?php echo $unit_not."'s ".$test_item;  ?> Failure Information <span class="icon">f</span></p>
    <!-- ----- Existed failure is here :) ----- -->
    <form id="fail_edit" name="fail_edit" method="POST" action="">
        <table align="center" class="form_fail">
            <tbody>
            <tr>
                <td>Fail類型</td>
                <td>
                    <select name="ff" required>
                        <option value="Fail" <?php if($row["Results"]=="Fail"){echo "selected = 'selected'";} ?> >Fail</option>
                        <option value="Known Fail (Open)" <?php if($row["Results"]=="Known Fail (Open)"){echo "selected = 'selected'";} ?>  >Known Fail (Open)</option>
                        <option value="Known Fail (Close)" <?php if($row["Results"]=="Known Fail (Close)"){echo "selected = 'selected'";} ?> >Known Fail (Close)</option>
                        <option value="EC Fail" <?php if($row["Results"]=="EC Fail"){echo "selected = 'selected'";} ?> >EC Fail</option>
                        <option value="Pass" <?php if($row["Results"]=="Pass"){echo "selected = 'selected'";} ?> >Pass</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Defect Mode(Symptom)</td>
                <td>
                <?php
                echo "<select name='df1'>";
                echo "<option value=''>请选择</option>";
                $df1 = $row[1];
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
                $df2 = $row[2];
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
            <!-- MD -->
            <tr>
                <td colspan="2" align="center">
                    <button class="btn_sub" type="submit">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" onClick="history.go(-1);">返回</button>
                    <input type="hidden" name="fail_edit" value="fail_edit_do" />
                </td>
            </tr>
            </tbody>    
        </table>
    </form>
    <!-- update data database begins here -->
    <?php
    if(isset($_POST["fail_edit"]) && $_POST["fail_edit"]=="fail_edit_do"){
        $df1 = $_POST["df1"];//Defect Mode symbol
        $df2 = $_POST["df2"];//Defect Mode symbol+Finding
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
        $tt_result = $_POST["ff"];

        if($rcca){
            $rcca_txt = str_replace(PHP_EOL, " ", $rcca);//去掉RCCA换行
        }
        // fail symptom string
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
        }
        echo "<script type='text/javascript'>returnvalue9(".($select_id-1).",'".$temp."')</script>";           //TEMP
        echo "<script type='text/javascript'>returnvalue18(".($select_id-1).",'".$tt_result."')</script>";
        echo "<script type='text/javascript'>returnvalue19(".$row_no.",'".$clicked_unit.":".$fail_symptom."')</script>";
        echo "<script type='text/javascript'>returnvalue20(".$row_no.",'".$clicked_unit.":".$rcca_txt."')</script>";
        
        //update SQL
        $sql_update = "UPDATE fail_infomation SET Defectmode1='$df1',Defectmode2='$df2',RCCA='$rcca_txt',Issuestatus='$issue_status',";
        $sql_update.= "Category='$category',PIC='$pic',JIRANO='$jira',SPR='$spr',TEMP='$temp',Dropcycles='$drop_cycle',Drops='$drops',";
        $sql_update.= "Dropside='$drop_side',HIT='$hit_tumble',NextCheckpointDate='$checkpoint',IssuePublished='$publish',ORTMFGDate='$mfg_date',";
        $sql_update.= "ReportedDate='$report_date',Results='$tt_result' WHERE FID='$fail_id'";
        
        mysqli_query($con,$sql_update);
        sleep(1);
        mysqli_close($con);
        echo "<script type='text/javascript'>window.history.go(-2);</script>";
    }
    ?>   
</div>

</body>
</html>