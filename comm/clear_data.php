<?php
require_once("../js/conf.php");
header("Content-Type:text/html;charset=UTF-8");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/main_dqa.css">
    <link rel="shortcut icon" href="../images/favior.ico">
    <script type="text/javascript" src="../js/dqa_main.js"></script>
    <title>清空數據表數據</title>
</head>
<body>
<div class="dropbox">
    <p class="txt_info">清空數據表數據</p>
    <form name="clear" id="clear" method="POST" action="">
        <table width="70%" cellpadding="5" border="0">
            <tr>
                <td>Data Table Name：</td>
                <td>
                    <select name="dropbox" class="sel_del_add">
                        <option value="">請選擇</option>
                        <option value="DQA_Test_Main">DQA_Test_Main</option>
                        <option value="FialInfo">Fail Info Table</option>
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
            $sql = "DELETE FROM dropbox_product";
            $result = mysqli_query($con,$sql);
            if($result){
                echo "<h1 style='color:#ffb800;'>Pruduct menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //2. SKU
        case 'SKU':
            $sql = "DELETE FROM dropbox_sku";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>SKU menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //3.phases
        case 'phases':
            $sql = "DELETE FROM dropbox_phase";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Phase menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //4.Group
        case 'Group':
            $sql = "DELETE FROM dropbox_group";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Group menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //5.Testitem
        case 'Testitem':
            $sql = "DELETE FROM dropbox_test_item";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Test Item menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //6.Mefect Mode Symbol
        case 'df1':
            $sql = "DELETE FROM dropbox_df1";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Defect Mode(Symptom) menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //7.Mefect Mode Symbol+Finding
        case 'df2':
            $sql = "DELETE FROM dropbox_df2";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Defect Mode (Symptom) + (Finding) menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //8.Dropside
        case 'Dropside':
            $sql = "DELETE FROM dropbox_dropside";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Drop side menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //9.Result
        case 'Result':
            $sql = "DELETE FROM dropbox_result";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Result menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //10.Issue_Status
        case 'Issue_Status':
            $sql = "DELETE FROM dropbox_issue_status";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Issue_Status menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //11.Testcondition
        case 'Testcondition':
            $sql = "DELETE FROM dropbox_test_condition";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Test Condition menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        //12.LAB
        case 'LAB':
            $sql = "DELETE FROM dropbox_lab_site";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>LAB menu table Data cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;

        //13. DQA_Test_Main
        case 'DQA_Test_Main':
            $sql = "DELETE FROM DQA_Test_Main";
            $result = mysqli_query($con,$sql);
            
            if($result){
                echo "<h1 style='color:#ffb800;'>Records table Data are all cleared :)</h1>";
            }
            else{
                echo "<h1 style='color:#a94442;'>Fail :(</h1>";
            }
            break;
        
        //14. FialInfo
        case 'FialInfo':
            $sql = "DELETE FROM fail_infomation";
            $result = mysqli_query($con,$sql);
            if($result){
                echo "<h1 style='color:#ffb800;'>Fail Info table Data are all cleared :)</h1>";
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
    青玉案·元夕 辛弃疾<br>
    东风夜放花千树。更吹落、星如雨。宝马雕车香满路。凤箫声动，玉壶光转，一夜鱼龙舞。<br>
    蛾儿雪柳黄金缕。笑语盈盈暗香去。众里寻他千百度。蓦然回首，那人却在，灯火阑珊处。<br>
    <br>
    念奴娇·赤壁怀古 苏轼<br>
    大江东去，浪淘尽，千古风流人物。故垒西边，人道是，三国周郎赤壁。<br>
    乱石穿空，惊涛拍岸，卷起千堆雪。江山如画，一时多少豪杰。<br>
    遥想公瑾当年，小乔初嫁了，雄姿英发。羽扇纶巾，谈笑间，樯橹灰飞烟灭。<br>
    故国神游，多情应笑我，早生华发。人生如梦，一尊还酹江月<br>
    <br>
    忆秦娥·娄山关 毛澤東<br>
    西风烈,长空雁叫霜晨月。 霜晨月,马蹄声碎,喇叭声咽。<br>雄关漫道真如铁,而今迈步从头越。 从头越,苍山如海,残阳如血。<br>
    <br>
    卜算子·咏梅 毛澤東<br>
    风雨送春归，飞雪迎春到，已是悬崖百丈冰，犹有花枝俏。<br>
    俏也不争春，只把春来报。待到山花烂漫时，她在丛中笑。
    </div>
</div>
 
</body>
</html>