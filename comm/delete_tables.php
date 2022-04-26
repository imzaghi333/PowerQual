<?php
require_once("../js/conf.php");
header("Content-Type:text/html;charset=UTF-8");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/main_dqa.css">
    <link rel="shortcut icon" href="../images/favior.ico">
    <title>删除數據表</title>
</head>
<body>
<div class="dropbox">
    <p class="txt_info">删除数据表(没事别用，小心挨揍!)</p>
    <form name="clear" id="clear" method="POST" action="">
        <table width="70%" cellpadding="5" border="0">
            <tr>
                <td>Data Table Name：</td>
                <td>
                    <select name="dropbox" style="padding: 4px 4px;border: 1px solid #e2e2e2;width: 70%;border-radius: 4px;">
                        <option value="">請選擇</option>
                        <option value="DQA_Test_Main">DQA_Test_Main</option>
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
                        <option value="FialInfo">Fail Info Table</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button name="sub" type="submit" class="btn_update">提 交</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;<button><a href="../index.php">返回</a></button>
                </td>
            </tr>
        </table>
    </form>
    <?php
    $dropbox = $_POST["dropbox"];
    switch ($dropbox) {
        //1. Product
        case 'Product':
            $sql = "DROP TABLE dropbox_product";
            $result = mysqli_query($con,$sql);
            if($result){
                echo "<h1 style='color:#ffb800;'>Pruduct menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //2. SKU
        case 'SKU':
            $sql = "DROP TABLE dropbox_sku";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>SKU menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //3.phases
        case 'phases':
            $sql = "DROP TABLE dropbox_phase";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Phase menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //4.Group
        case 'Group':
            $sql = "DROP TABLE dropbox_group";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Group menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //5.Testitem
        case 'Testitem':
            $sql = "DROP TABLE dropbox_test_item";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Test Item menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //6.Mefect Mode Symbol
        case 'df1':
            $sql = "DROP TABLE dropbox_df1";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Defect Mode(Symptom) menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //7.Mefect Mode Symbol+Finding
        case 'df2':
            $sql = "DROP TABLE dropbox_df2";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Defect Mode (Symptom) + (Finding) menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //8.Dropside
        case 'Dropside':
            $sql = "DROP TABLE dropbox_dropside";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Drop side menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //9.Result
        case 'Result':
            $sql = "DROP TABLE dropbox_result";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Result menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //10.Issue_Status
        case 'Issue_Status':
            $sql = "DROP TABLE dropbox_issue_status";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Issue_Status menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //11.Testcondition
        case 'Testcondition':
            $sql = "DROP TABLE dropbox_test_condition";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Test Condition menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //12.LAB
        case 'LAB':
            $sql = "DROP TABLE dropbox_lab_site";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>LAB menu table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;

        //13. DQA_Test_Main
        case 'DQA_Test_Main':
            $sql = "DROP TABLE DQA_Test_Main";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Records table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //14.Test order(A,B,C.....)
        case 'Order':
            $sql = "DROP TABLE dropbox_test_order";
            $result = mysqli_query($con,$sql);
            if($result){
                echo "<h1 style='color:#ffb800;'>Test order table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //FialInfo table
        case 'FialInfo':
            $sql = "DROP TABLE fail_infomation";
            $result = mysqli_query($con,$sql);
            if($result){
                echo "<h1 style='color:#ffb800;'>Fail Info table is deleted :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;

        default:
            break;
    }
    ?>
    <div class="xqq">
    江城子·密州出猎 苏轼<br>
    老夫聊发少年狂，左牵黄，右擎苍，锦帽貂裘，千骑卷平冈。<br>为报倾城随太守，亲射虎，看孙郎。<br>
    酒酣胸胆尚开张，鬓微霜，又何妨！持节云中，何日遣冯唐？<br>会挽雕弓如满月，西北望，射天狼。<br>
    <br>
    江城子·江景 苏轼<br>
    凤凰山下雨初晴，水风清，晚霞明。一朵芙蕖，开过尚盈盈。<br>何处飞来双白鹭，如有意，慕娉婷。<br>
    忽闻江上弄哀筝，苦含情，遣谁听！烟敛云收，依约是湘灵。<br>欲待曲终寻问取，人不见，数峰青。<br>
    <br>
    西塞山怀古 刘禹锡<br>
    王濬楼船下益州，金陵王气黯然收。千寻铁锁沉江底，一片降幡出石头。<br>
    人世几回伤往事，山形依旧枕寒流。今逢四海为家日，故垒萧萧芦荻秋。<br>
    <br>
    赤壁·杜牧<br> 
    折戟沉沙铁未销,自将磨洗认前朝。 东风不与周郎便,铜雀春深锁二乔。 <br>
    <br>
    遣怀·杜牧<br>
    落魄江湖载酒行，楚腰纤细掌中轻。十年一觉扬州梦，赢得青楼薄幸名。<br>
    </div>
</div>  
</body>
</html>