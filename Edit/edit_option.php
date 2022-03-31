<?php
require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("Asia/Shanghai");

if(isset($_POST["edit_opt"]) && $_POST["edit_opt"]=="edit_opt_do"){
    $tb_name = $_POST["tb_name"];
    $seg_name = $_POST["seg_name"];
    $cc_id = $_POST["cc_id"];
    /*
    echo $tb_name;
    echo "<br>";
    echo $seg_name;
    echo "<br>";
    echo $cc_id;
    */
    $check_one = "SELECT * FROM ".$tb_name." WHERE ID=".$cc_id;
    $result = mysqli_query($con,$check_one);
    $info = mysqli_fetch_array($result);
    $opt = $info[$seg_name];
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
    <title>Edit Dropbox</title>
</head>
<body>
<div class="container">
    <div class="right">
        <p class="info">DropBox Menu option edit</p>
        <form name="form3" action="" method="POST" onsubmit="return checkForm3();">
            <table align="center" width="70%" cellpadding="5" border="0">
                <tr>
                    <td>Option Text: </td>
                    <td><input name="opt_txt" type="text" value="<?php echo $opt; ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <button name="update_opt" class="btn_update" type="submit">Update</button>
                        <input type="hidden" name="opt_update" value="opt_update_do" />
                        
                        <input type="hidden" name="table" value="<?php echo $tb_name; ?>" />
                        <input type="hidden" name="segment" value="<?php echo $seg_name; ?>" />
                        <input type="hidden" name="id" value="<?php echo $cc_id; ?>" />
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($_POST["opt_update"]) && $_POST["opt_update"]=="opt_update_do"){
            $opt_txt = $_POST["opt_txt"];
            $id = $_POST["id"];
            $table = $_POST["table"];
            $segment = $_POST["segment"];
            $sql_update = "UPDATE {$table} SET {$segment} = '{$opt_txt}' WHERE ID={$id}";

            if(mysqli_query($con, $sql_update)){
                echo "<script>window.alert('更新成功！~~~');</script>";
                echo "<meta http-equiv='refresh' content='1; url=../index.php?dowhat=edit'>";
            }
            else{
                echo "<script>window.alert('执行SQL出错啦！~~~');</script>";
                echo "<meta http-equiv='refresh' content='1; url=../index.php?dowhat=edit'>";
            }
        }
        ?>
    </div>
</div>   
</body>
</html>