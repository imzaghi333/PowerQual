<?php
require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("Asia/Shanghai");

if(isset($_POST["del_dropbox"]) && $_POST["del_dropbox"]=="del_dropbox_do"){
    $dropbox = $_POST["dropbox"];
}
?>

<!DOCTYPE html>
<html lang="zh_cn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/main_dqa.css">
    <link rel="shortcut icon" href="../images/favior.ico">
    <script type="text/javascript" src="../js/dqa_main.js"></script>
    <title>编辑Dropbox選項</title>
</head>

<body>
<div class="header"><div class="title"><a href="index.php">DQA Power Query</a></div></div>
<div class="container">
    <div class="left">
        <div class="action">
            <div><a href="../index.php">首&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;頁<span class="p_right">&#10148</span></a></div>
            <div><a href="../index.php?dowhat=data">All Data<span class="p_right">&#10148</span></a></div>
            <div><a href="../index.php?dowhat=export">Export Data<span class="p_right">&#10148</span></a></div>
            <div><a href="../index.php?dowhat=start">New Test<span class="p_right">&#10148</span></a></div>
            <div><a href="../index.php?dowhat=upload">DropBox Upload<span class="p_right">&#10148</span></a></div>
            <div><a href="../index.php?dowhat=edit">DropBox Edit<span class="p_right">&#10148</span></a></div><br>
            <a href=mailto:felix_qian@wistron.com><img src="../images/logo.svg" width="160" /></a>
        </div>
    </div>
    <div class="right">
        <p class="info">Edit or Delete any option here</p>
        <?php
        switch ($dropbox) {
            //1.Product
            case 'Product':
                $tb_name = "dropbox_product";
                $seg_name = "Product";
                break;
            //2.SKU
            case 'SKU':
                $tb_name = "dropbox_sku";
                $seg_name = "SKUS";
                break;
            //3.Phase
            case 'phases':
                $tb_name = "dropbox_phase";
                $seg_name = "Phase";
                break;
            //4.Group
            case 'Group':
                $tb_name = "dropbox_group";
                $seg_name = "Groups";
                break;
            //5.Test item
            case 'Testitem':
                $tb_name = "dropbox_test_item";
                $seg_name = "Testitem";
                break;
            //6.Defect Mode(symbol)
            case 'df1':
                $tb_name = "dropbox_df1";
                $seg_name = "DefectMode";
                break;
            //7.Defect Mode(symbol+finding)
            case 'df2':
                $tb_name = "dropbox_df2";
                $seg_name = "DefectMode";
                break;
            //8.Drop side
            case 'Dropside':
                $tb_name = "dropbox_dropside";
                $seg_name = "Dropside";
                break;
            //9.Resutl
            case 'Result':
                $tb_name = "dropbox_result";
                $seg_name ="Result";
                break;
            //10.issue status
            case 'Issue_Status':
                $tb_name = "dropbox_issue_status";
                $seg_name = "Issue_Status";
                break;
            //11.Test Condition
            case 'Testcondition':
                $tb_name = "dropbox_test_condition";
                $seg_name = "Testcondition";
                break;
            //12.LAB
            case 'LAB':
                $tb_name = "dropbox_lab_site";
                $seg_name = "LAB_SITE";
                break;
            //13.Test order
            case 'TO':
                $tb_name = "dropbox_test_order";
                $seg_name = "Testorder";
                break;
            
            default:
                echo "<script>window.alert('出错啦！~~~');</script>";
                break;
        }
        
        $sql_menu = "SELECT count(*) as total FROM ".$tb_name;
        $result = mysqli_query($con,$sql_menu);
        $info = mysqli_fetch_array($result);
        $total = $info['total'];
        if($total==0){
            echo "<p class='fail-info'>暫無任何數據</p>";
        }
        else{
        ?>
        <table align="center" class="my_del_table" cellpadding="3">
            <thead><tr><th width="6%">序号</th><th>選項名</th><th width="15%" colspan="2">Action</th></tr></thead>
            <tbody>
            <?php
            $sql_opt = "SELECT * FROM ".$tb_name;
            $check = mysqli_query($con, $sql_opt);
            $counter = 0;
            while($row = mysqli_fetch_array($check)){
                ++$counter;
            ?>
                <tr>
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $row[$seg_name]; ?></td>
                    <td align="center">
                        <form name="form2" action="edit_option.php" method="POST" onsubmit="return checkForm2();">
                            <input type="hidden" name="tb_name" value="<?php echo $tb_name; ?>" />
                            <input type="hidden" name="seg_name" value="<?php echo $seg_name; ?>" />
                            <input type="hidden" name="cc_id" value="<?php echo $row['ID']; ?>" />
                            <button name="edit_btn" class="btn_edit" type="submit">Edit</button>
                            <input type="hidden" name="edit_opt" value="edit_opt_do" />
                        </form>
                    </td>
                    <td align="center">
                        <form name="form4" method="POST" action="edit_opt_del.php" onsubmit="return confirmDel();">
                            <input type="hidden" name="del_table" value="<?php echo $tb_name; ?>" />
                            <input type="hidden" name="del_id" value="<?php echo $row['ID']; ?>" />
                            <button name="del_btn" class="btn_delete" type="submit">Del</button>
                            <input type="hidden" name="del_opt" value="del_opt_do" />
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" align="center">
                    <font size="2">共有数据 <?php echo $total;?>&nbsp;条&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php"><button>返回</button></a></font>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    
</div>
<div class="footer"><span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?></div>
</body>
</html>