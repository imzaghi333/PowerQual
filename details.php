<?php
require_once("./js/conf.php");
header("Content-Type:text/html;charset=UTF-8");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");

$current_id = $_GET["id"];
$check = mysqli_query($con, "SELECT * FROM DQA_Test_Main WHERE RecordID='$current_id' ");
$row = mysqli_fetch_array($check,MYSQLI_BOTH);
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <link rel="shortcut icon" href="images/favior.ico">
    <script type="text/javascript" src="js/dqa_main.js"></script>
    <title>Detals Test Records</title>
</head>
<body>
<div class="header">
    <a href="index.php"><img class="wistron_logo" src="./images/logo.svg" width="180" /></a>&nbsp;&nbsp;
    <div class="title"><a href="javascript:layer.msg('Have a good time O(∩_∩)O',{icon:6});">DQA Power Query</a></div>
</div>
<div class="container">
    <div class="left">
        <div class="action">
            <div><a href="index.php">Getting Start&nbsp;&nbsp;<span><img src="./images/book.svg" height="12" /></span><span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=start">New Test<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=data">All Data<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=export">Export Data<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=upload">DropBox Upload<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=edit">DropBox Edit<span class="p_right">&#10148</span></a></div><br>
            <a href=mailto:felix_qian@wistron.com><img id="logo" src="./images/logo.svg" width="160" /></a>
        </div>
    </div>
    <div class="right">
        <p class="info">Detai Test Records</p>
        <div id="wrapper">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="active">選項1</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="inactive">選項2</button>
            <form id="form4" name="form4" method="POST" action="">
                <div style="display:block;">
                    <table class="form4">
                        <tr>
                            <td>Stage</td>
                            <td>
                                <select name="stage">
                                    <option value="NPI" <?php if($row['Stages']=='NPI'){echo "selected = 'selected'";} ?> >NPI</option>
                                    <option value="Sus" <?php if($row['Stages']=='Sus'){echo "selected = 'selected'";} ?> >Sus</option>
                                    <option value="Others" <?php if($row['Stages']=='Others'){echo "selected = 'selected'";} ?> >其他</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Verification Type</td>
                            <td>
                                <select name="vt">
                                    <option value="ORT" <?php if($row['VT']=='ORT'){echo "selected = 'selected'";} ?> >ORT</option>
                                    <option value="DQA" <?php if($row['VT']=='DQA'){echo "selected = 'selected'";} ?> >DQA</option>
                                    <option value="ENG (in spec)" <?php if($row['VT']=='ENG (in spec)'){echo "selected = 'selected'";} ?> >ENG (in spec)</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Product</td>
                            <td>
                                <select name="product">
                                <?php
                                $pt = $row["Products"];
                                $opts = mysqli_query($con, "SELECT Product FROM dropbox_product");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    if($info[0]==$pt){
                                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                                    }
                                    else{
                                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    }
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>SKU</td>
                            <td>
                                <select name="sku">
                                <?php
                                $sk = $row["SKUS"];
                                $opts = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    if($info[0]==$sk){
                                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                                    }
                                    else{
                                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    }
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Year (<font color="#be0f2d">read only</font>)</td><td><input name="year" type="text" value="<?php echo $row['Years']; ?>" readonly /></td></tr>
                        <tr><td>Month (<font color="#be0f2d">read only</font>)</td><td><input name="month" type="text" value="<?php echo $row['Months']; ?>" readonly /></td></tr>
                        <tr>
                            <td>Phase</td>
                            <td>
                                <select name="phase">
                                <?php
                                $phase = $row["Phases"];
                                $opts = mysqli_query($con, "SELECT Phase FROM dropbox_phase");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    if($info[0]==$phase){
                                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                                    }
                                    else{
                                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    }
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr><td>Serial NO</td><td><input name="sn" type="text" value="<?php echo $row['SN']; ?>" /></td></tr>
                        <tr><td>Unit# (<font color="#be0f2d">read only</font>)</td><td><input name="unit" type="text" value="<?php echo $row['Units']; ?>" readonly /></td></tr>
                        <tr><td>Group (<font color="#be0f2d">read only</font>)</td><td><input name="group" type="text" value="<?php echo $row['Groups']; ?>" readonly /></td></tr>
                        <tr>
                            <td>Test Item</td>
                            <td>
                                <select name="items">
                                <?php
                                $tc_item = $row['Testitems'];
                                $opts = mysqli_query($con, "SELECT Testitem FROM dropbox_test_item");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    if($info[0]==$tc_item){
                                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                                    }
                                    else{
                                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    }
                                }
                                ?>
                                </select>
                            </td>
                        </tr>                        
                    </table>
                </div>
                <div>
                    <table class="form4">
                        <tr>
                            <td>Test Condition</td>
                            <td>
                                <?php
                                echo "<select name='condition'>";
                                echo "<option value=''>请选择</option>";
                                $tc = $row["Testcondition"];
                                $opts = mysqli_query($con, "SELECT Testcondition FROM dropbox_test_condition");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    //echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    if($info[0]==$tc){
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
                        <tr><td>Start Day</td><td><input name="start" type="date" value="<?php echo $row['Startday']; ?>" /></td></tr>
                        <tr><td>Complete</td><td><input name="complete" type="date" value="<?php echo $row['Endday']; ?>" /></td></tr>
                        <tr>
                            <td>Result</td>
                            <td>
                                <select name="result" id="result" onchange="//printResult(<?php //echo $current_id ?>);">
                                <?php                               
                                echo "<option value=''>请选择</option>";
                                $res = $row["Results"];
                                $opts = mysqli_query($con, "SELECT Result FROM dropbox_result");
                                while ($info = mysqli_fetch_array($opts,MYSQLI_NUM)) {
                                    if($info[0]==$res){
                                        echo "<option value="."'$info[0]'"." selected >".$info[0]."</option>";
                                    }
                                    else{
                                        echo "<option value="."'$info[0]'".">".$info[0]."</option>";
                                    }
                                }
                                ?>
                                </select>                             
                            </td>
                        </tr>
                        <tr><td>Boot <font color="#be0f2d">read only</font></td><td><input name="boot" type="text" value="<?php echo $row['Boot']; ?>" readonly  /></td></tr>
                        <tr><td>Test LAB <font color="#be0f2d">read only</font></td><td><input name="lab" type="text" value="<?php echo $row['Testlab']; ?>" readonly  /></td></tr>
                        <tr><td>MFG Site <font color="#be0f2d">read only</font></td><td><input name="mfg" type="text" value="<?php echo $row['Mfgsite']; ?>" readonly  /></td></tr>
                        <tr><td>Tester</td><td><input name="tester" type="text" value="<?php echo $row['Testername']; ?>" /></td></tr>
                        
                        <tr><td>Issue opened duration</td><td><input name="duration" type="text" value="<?php echo $row['IssueDuration']; ?>" placeholder="不用填,系统自动生成" /></td></tr>
                        <tr><td>Today</td><td><input name="today" type="date" value="<?php echo date('Y-m-d'); ?>" /></td></tr>
                        <tr><td>Remark</td><td><input name="remark" type="text" value="<?php echo $row['Remarks']; ?>" /></td></tr>
                        
                        <tr>
                            <td colspan="2" align="center"><input type="submit" name="sub" value="确认(Confirm)" /></td>
                            <input type="hidden" name="confirm" value="confirm_do" />
                        </tr>
                    </table>
                    <!-- ######################### 分割线 #################################### -->
                </div>
            </form>
            <?php
            if(isset($_POST["confirm"]) && $_POST["confirm"]=="confirm_do"){
                $stage = $_POST["stage"];
                $vt = $_POST["vt"];
                $product = $_POST["product"];
                $sku = $_POST["sku"];
                $phase = $_POST["phase"];
                $items = $_POST["items"];
                $sn = $_POST["sn"];    //添加的SN
                $condition = $_POST["condition"];
                $start_day = $_POST["start"];            //测试开始时间
                $end_day = $_POST["complete"];           //测试结束时间
                $test_result = $_POST["result"];
                $tester = $_POST["tester"];
                $duration = $_POST["duration"];           //issue opened duration
                $today = $_POST["today"];
                $remark = $_POST["remark"];
                //update  表名 set 列名1= 'value1', 列名2= 'value2', 列名3= 'value3' where 条件;

                $sql_update = "UPDATE DQA_Test_Main SET Stages='$stage',VT='$vt',Products='$product',SKUS='$sku',Phases='$phase',Testitems='$items',SN='$sn',Testcondition='$condition',Startday='$start_day',Endday='$end_day',";
                $sql_update.= "Results='$test_result',Testername='$tester',IssueDuration='$duration',Today='$today',Remarks='$remark' WHERE RecordID='$current_id'  ";
                mysqli_query($con, $sql_update);      //更新记录

                $url = "index.php";
                $message = urlencode("数据保存完成 :)");
                header("location:success.php?url=$url&message=$message");
                mysqli_close($con);
            }
            ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="footer"><span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?></div>
</body>
</html>