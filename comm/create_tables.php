<?php
date_default_timezone_set("Asia/Shanghai");
require_once "../js/conf.php";
mysqli_query($con,"set names utf8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="Text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/main_dqa.css">
    <link rel="shortcut icon" href="../images/favior.ico">
    <title>Create Dropbox Data Tables</title>
</head>
<body>
<div class="dropbox">
    <p class="txt_info">创建数据表</p>
    <div>
        <form name="dropbox_cc" method="POST" action="">
            <table width="70%" cellpadding="5" border="0">
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dropbox Name：</td>
                    <td>
                        <select name="dropbox" style="padding: 4px 4px;border: 1px solid #e2e2e2;width: 70%;border-radius: 4px;">
                            <option value="">請選擇</option>
                            <option value="Main_Record">测试记录数据表</option>
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
                $sql = "CREATE TABLE dropbox_product(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Product VARCHAR(30) UNIQUE DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                if($result){
                    echo "<h1 style='color:#337ab7;'>Pruduct menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //2. SKU
            case 'SKU':
                $sql = "CREATE TABLE dropbox_sku(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    SKUS VARCHAR(20) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>SKU menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //3.phases
            case 'phases':
                $sql = "CREATE TABLE dropbox_phase(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Phase VARCHAR(20) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Phase menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //4.Group
            case 'Group':
                $sql = "CREATE TABLE dropbox_group(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `Groups` VARCHAR(20) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Group menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //5.Testitem
            case 'Testitem':
                $sql = "CREATE TABLE dropbox_test_item(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Testitem VARCHAR(500) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Test Item menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //6.Mefect Mode Symbol
            case 'df1':
                $sql = "CREATE TABLE dropbox_df1(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    DefectMode VARCHAR(500) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Defect Mode(Symptom) menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //7.Mefect Mode Symbol+Finding
            case 'df2':
                $sql = "CREATE TABLE dropbox_df2(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    DefectMode VARCHAR(500) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Defect Mode (Symptom) + (Finding) menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //8.Dropside
            case 'Dropside':
                $sql = "CREATE TABLE dropbox_dropside(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Dropside VARCHAR(50) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Drop side menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //9.Result
            case 'Result':
                $sql = "CREATE TABLE dropbox_result(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Result VARCHAR(20) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Result menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //10.Issue_Status
            case 'Issue_Status':
                $sql = "CREATE TABLE dropbox_issue_status(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Issue_Status VARCHAR(20) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Issue_Status menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //11.Testcondition
            case 'Testcondition':
                $sql = "CREATE TABLE dropbox_test_condition(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Testcondition TEXT DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Test Condition menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //12.LAB
            case 'LAB':
                $sql = "CREATE TABLE dropbox_lab_site(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    LAB_SITE VARCHAR(15) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>LAB menu table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //13.Order
            case 'Order':
                $sql = "CREATE TABLE dropbox_test_order(
                    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Testorder VARCHAR(5) DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Test order table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;
            //14.Main_Record
            //2022-01-10新增了Title, Requests, Terminal三个字段
            case 'Main_Record':
                $sql = "CREATE TABLE DQA_Test_Main(
                    RecordID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    Stages VARCHAR(10) DEFAULT NULL,
                    VT VARCHAR(15) DEFAULT NULL,  #verification Type
                    Products VARCHAR(20) DEFAULT NULL,
                    SKUS VARCHAR(20) DEFAULT NULL,
                    Years VARCHAR(4) DEFAULT NULL,
                    Months VARCHAR(2) DEFAULT NULL,
                    Phases VARCHAR(15) DEFAULT NULL,
                    SN VARCHAR(20) DEFAULT NULL,
                    Units CHAR(1) DEFAULT NULL,  #Unit,填A B C D......X Y Z
                    `Groups` VARCHAR(15) DEFAULT NULL,
                    Testitems VARCHAR(500) DEFAULT NULL,
                    Testcondition TEXT DEFAULT NULL,
                    Startday VARCHAR(15) DEFAULT NULL,
                    Endday VARCHAR(15) DEFAULT NULL,
                    Testdays VARCHAR(5) DEFAULT NULL,
                    Defectmode1 TEXT DEFAULT NULL,    #Symptom
                    Defectmode2 TEXT DEFAULT NULL,    #Symptom+Findings
                    RCCA TEXT DEFAULT NULL,
                    Teststatus VARCHAR(15) DEFAULT NULL,
                    Results VARCHAR(20) DEFAULT 'TBD',
                    Issuestatus VARCHAR(15) DEFAULT NULL,
                    Category VARCHAR(20) DEFAULT NULL,
                    PIC VARCHAR(20) DEFAULT NULL,
                    JIRANO VARCHAR(15) DEFAULT NULL,
                    SPR VARCHAR(15) DEFAULT NULL,
                    Temp VARCHAR(10) DEFAULT NULL,
                    Dropcycles VARCHAR(3) DEFAULT NULL,
                    Drops VARCHAR(3) DEFAULT NULL,
                    Dropside VARCHAR(20) DEFAULT NULL,
                    Hit VARCHAR(4) DEFAULT NULL,
                    Boot VARCHAR(4) DEFAULT 'NO',
                    Testlab VARCHAR(10) DEFAULT NULL,
                    Mfgsite VARCHAR(10) DEFAULT NULL,
                    Testername VARCHAR(20) DEFAULT NULL,
                    NextCheckpointDate VARCHAR(30) DEFAULT NULL,
                    IssuePublished VARCHAR(30) DEFAULT NULL,
                    ORTMFGDate VARCHAR(30) DEFAULT NULL,
                    ReportedDate VARCHAR(20) DEFAULT NULL,
                    IssueDuration VARCHAR(10) DEFAULT NULL,
                    Today VARCHAR(15) DEFAULT NULL,
                    Remarks VARCHAR(500) DEFAULT NULL,
                    Timedt VARCHAR(30) DEFAULT NULL,
                    Failinfo TEXT DEFAULT NULL,          #Fail symptom
                    Unitsno VARCHAR(3) DEFAULT NULL,    #Unit1 Unit2 Unit3....
                    Titles VARCHAR(300) DEFAULT NULL,
                    Requests VARCHAR(3) DEFAULT 'Yes',
                    Terminal VARCHAR(50) DEFAULT NULL,   #With / Without Terminal
                    FAA TEXT DEFAULT NULL
                )";
                $result = mysqli_query($con,$sql);
                
                if($result){
                    echo "<h1 style='color:#337ab7;'>Test Records table created successfully :)</h1>";
                }
                else{
                    echo "<h1 style='color:#a94442;'>Fail :(</h1>";
                }
                break;

            default:
                break;
        }
        ?>
    </div>
    <div class="xqq">
        沁园春·长沙 - 毛泽东<br>
        独立寒秋，湘江北去，橘子洲头。<br>
        看万山红遍，层林尽染；漫江碧透，百舸争流。<br>
        鹰击长空，鱼翔浅底，万类霜天竞自由。<br>
        怅寥廓，问苍茫大地，谁主沉浮？<br>
        携来百侣曾游。忆往昔峥嵘岁月稠。<br>
        恰同学少年，风华正茂；书生意气，挥斥方遒。<br>
        指点江山，激扬文字，粪土当年万户侯。<br>
        曾记否，到中流击水，浪遏飞舟？<br>
        <br>
        永遇乐·京口北固亭怀古 - 辛弃疾<br>
        千古江山，英雄无觅、孙仲谋处。<br>
        舞榭歌台，风流总被、雨打风吹去。<br>
        斜阳草树，寻常巷陌，人道寄奴曾住。<br>
        想当年，金戈铁马，气吞万里如虎。<br>
        元嘉草草，封狼居胥，赢得仓皇北顾。<br>
        四十三年，望中犹记，烽火扬州路。<br>
        可堪回首，佛狸祠下，一片神鸦社鼓。<br>
        凭谁问，廉颇老矣，尚能饭否
    </div>
</div>
</body>
</html>