<?php
require_once("./js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");
$current_id = $_GET["id"];
$select_id = $_GET["selecid"];
$check='N';

$check = mysqli_query($con, "SELECT * FROM DQA_Test_Main WHERE  RecordID='$current_id' ");
$row = mysqli_fetch_array($check,MYSQLI_BOTH);
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <script type="text/javascript" src="./js/failinfo_inner.js"></script>
    <link rel="shortcut icon" href="./images/favior.ico">
    <title>Failure info.</title>
</head>
<body>
<div class="fail">
    <p class="info_title">Add Failure Information <span class="icon">f</span></p>
    <form id="fain_info" name="fain_info" method="POST" action="">
        <table align="center" class="form_fail">
            <tr>
                <td>Defect Mode(Symptom)</td>
                <td>
                    <?php
                    echo "<select name='df1'>";
                    echo "<option value=''>请选择</option>";
                    $df1 = $row[16];    //DefectMode1,关联数组因为字段名里有数字,无法使用$row['DefectMode1']方式,可以使用索引数字
                    $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df1");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        //echo "<option value="."'$info[0]'".">".$info[0]."</option>";
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
                    $df2 = $row[17];    //DefectMode2,此时要用索引数组,因为字段名有数字
                    $opts = mysqli_query($con, "SELECT DefectMode FROM dropbox_df2");
                    while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                        //echo "<option value="."'$info[0]'".">".$info[0]."</option>";
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
                <td>Test Status</td>
                <td>
                    <select name="test_status">
                        <option value="">请选择</option>
                        <option value="Not start" <?php if($row['Teststatus']=='Not start'){echo "selected = 'selected'";} ?> >Not Start</option>
                        <option value="In progress" <?php if($row['Teststatus']=='In progress'){echo "selected = 'selected'";} ?>>In progress</option>
                        <option value="Completed" <?php if($row['Teststatus']=='Completed'){echo "selected = 'selected'";} ?>>Completed</option>
                    </select>
                </td>
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
                        //echo "<option value="."'$info[0]'".">".$info[0]."</option>";
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
            <!-- ######################### 分割线 ##################### -->
            <tr>
                <td colspan="2" align="center">
                    <button class="btn_sub" type="submit">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="hidden" name="fail" value="fail_do" />
                </td>
            </tr>
        </table>
    </form>
    <?php
    if(isset($_POST["fail"]) && $_POST["fail"]=="fail_do"){
        $df1 = $_POST["df1"];                    //Defect Mode symbol
        $df2 = $_POST["df2"];                    //Defect Mode symbol+Finding
        $rcca = $_POST["rcca"];
        $test_status = $_POST["test_status"];
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

        $rcca_txt = str_replace(PHP_EOL, " ", $rcca);    //去掉RCCA换行

        echo "<script type='text/javascript'>returnvalue1(".$select_id.",'".$df1."')</script>";             //Defect Mode1
        echo "<script type='text/javascript'>returnvalue2(".$select_id.",'".$df2."')</script>";             //Defect Mode2
        echo "<script type='text/javascript'>returnvalue3(".$select_id.",'".$rcca_txt."')</script>";        //RCCA
        echo "<script type='text/javascript'>returnvalue4(".$select_id.",'".$test_status."')</script>";     //Test status
        echo "<script type='text/javascript'>returnvalue5(".$select_id.",'".$issue_status."')</script>";    //Issue Status
        echo "<script type='text/javascript'>returnvalue6(".$select_id.",'".$category."')</script>";        //Category
        echo "<script type='text/javascript'>returnvalue7(".$select_id.",'".$pic."')</script>";             //PIC
        echo "<script type='text/javascript'>returnvalue8(".$select_id.",'".$jira."')</script>";            //JIRA
        echo "<script type='text/javascript'>returnvalue9(".$select_id.",'".$spr."')</script>";             //SPR NO
        echo "<script type='text/javascript'>returnvalue10(".$select_id.",'".$temp."')</script>";           //TEMP
        echo "<script type='text/javascript'>returnvalue11(".$select_id.",'".$drop_cycle."')</script>";
        echo "<script type='text/javascript'>returnvalue12(".$select_id.",'".$drops."')</script>";
        echo "<script type='text/javascript'>returnvalue13(".$select_id.",'".$drop_side."')</script>";
        echo "<script type='text/javascript'>returnvalue14(".$select_id.",'".$hit_tumble."')</script>";
        echo "<script type='text/javascript'>returnvalue15(".$select_id.",'".$checkpoint."')</script>";      //Next checkpoint date
        echo "<script type='text/javascript'>returnvalue16(".$select_id.",'".$publish."')</script>";         //Issue Published
        echo "<script type='text/javascript'>returnvalue17(".$select_id.",'".$mfg_date."')</script>";        //ORT MFG Date
        echo "<script type='text/javascript'>returnvalue18(".$select_id.",'".$report_date."')</script>";

        echo "<script type='text/javascript'>window.close();</script>";
        echo "<br><p style='color:#337ab7;font: size 16px;'>Info update complete, close it to continue.</p>";
        mysqli_close($con);
    }
    ?>
</div>
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistronits">
</div>
</body>
</html>