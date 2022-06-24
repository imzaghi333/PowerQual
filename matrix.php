<?php
/*
                          (  ) (@@) ( )  (@)  ()    @@    O     @     O     @      O
                     (@@@)
                 (    )
              (@@@@)

            (   )
         ====        ________                ___________
     _D _|  |_______/        \__I_I_____===__|_________|
      |(_)---  |   H\________/ |   |        =|___ ___|      _________________
      /     |  |   H  |  |     |   |         ||_| |_||     _|                \_____A
     |      |  |   H  |__--------------------| [___] |   =|                        |
     | ________|___H__/__|_____/[][]~\_______|       |   -|                        |
     |/ |   |-----------I_____I [][] []  D   |=======|____|________________________|_
   __/ =| o |=-O=====O=====O=====O \ ____Y___________|__|__________________________|_
    |/-=|___|=    ||    ||    ||    |_____/~\___/          |_D__D__D_|  |_D__D__D_|
     \_/      \__/  \__/  \__/  \__/      \_/               \_/   \_/    \_/   \_/
*/

require_once("./js/conf.php");
if(isset($_POST["action"]) && $_POST["action"]=="next"){
    $title = $_POST["title"];
    $stage = $_POST["stage"];          //NPI Sus...
    $vt = $_POST["vt"];                //verification type
    $product = $_POST["product"];      //Mufasa,Thunder......`
    $sku = $_POST["sku"];              //WWLAN WLAN......
    $nn = substr($_POST["ym"],0,4);    //年 2021
    $yy = substr($_POST["ym"],5,2);    //月 01~12
    $phases = $_POST["phases"];        // MV EV.......
    $number = $_POST["unit"];          //測試機數量
    $testlab = $_POST["testlab"];      //WKS WHQ......
    $mfgsite = $_POST["mfgsite"];      //WKS WHQ......
    $tester = $_POST["tester"];        //英文名
    $ort_date = $_POST["ort_date"];    //ORT MFG Date
}

echo '<script type="text/javascript" src="./js/js_matrix.js"></script>';
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <link rel="shortcut icon" href="images/favior.ico">
    <script type="text/javascript" src="./js/js_matrix.js"></script>
    <title>Testing Matrix Creating</title>
</head>

<body>
<div class="content">
    <h1><span style="float: left;margin-left:20px;"><a href="index.php?dowhat=start"><img src="./images/logo-small.svg" height="50" alt="Wistron"></a></span><?php echo $tester; ?> - Test Matrix Creating for <?php echo $product;?></h1>
    <div>
        <div id="preloder"><div class="loader"></div><!-- loading animation added on 2022-01-06 --></div>
        <form name="form2" id="form2" method="POST" action="">
            <table id="customers" class="customers" border="1" rules="all">
                <tr>
                    <th>Group</th><th>TestItem</th>
                    <?php
                    for($i=0; $i<$number;$i++){
                        echo "<th>Unit#".($i+1)."</th>";
                    }
                    ?>
                    <th>Action</th>
                </tr>
                <tr>
                    <td width="5%">
                        <?php
                        echo "<select name='group[]' id='group1'>";
                        echo "<option value=Select_Group>Select_Group</option>";
                        $check = mysqli_query($con, "SELECT Groups FROM dropbox_group");
                        while ($row = mysqli_fetch_array($check)) {
                            $v1 = $row["Groups"];
                            echo "<option value='$v1'>$v1</option>";
                        }
                        echo "</select>";
                        ?>
                    </td>
                    <td width="10%">
                        <?php
                        echo "<select name='test_item[]' class='selbox' id='test_item1'>";
                        echo "<option value=Select_Item class=select_item>Select_Item</option>";
                        
                        $check = mysqli_query($con, "SELECT Testitem,Grouped FROM dropbox_test_item");
                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                            echo "<option value=" ."'$row[0]'" . "class="."'$row[1]'" . " hidden=true>" . $row[0] . "</option>";
                        }
                        echo "</select>";
                        ?>
                    </td>
                    <?php
                    for($i=0; $i<$number; $i++){
                        $ii=$i+1;
                        echo "<td>";
                        echo "<select class='test_order'name='test_order[]' id='test_order1$ii' onchange='testchange(1,$ii)'>";
                        echo "<option>请选择</option>";
                        $check = mysqli_query($con, "SELECT Testorder FROM dropbox_test_order");
                        while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                            echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
                        }
                        echo "</select>";
                        echo "</td>";
                    }
                    ?>
                    <td width="6%">
                        <input class="btn_add" type="button" name="1add" value="Add" id="1add" />&nbsp;
                        <input class="btn_del" type="button" name="1del" value="Del" id="1del" />
                    </td>
                </tr>
            </table>
            <div class="save_record">
                <input class="subit" type="submit" name="sub" value="保 存" />
                <!-- ----------------- 需隐藏传递之数据 --------------------- -->
                <input name="stage" type="hidden" value="<?php echo $stage; ?>" />
                <input name="vt" type="hidden" value="<?php echo $vt; ?>" />
                <input name="product" type="hidden" value="<?php echo $product ?>" />
                <input name="sku" type="hidden" value="<?php echo $sku; ?>" />
                <input name="year" type="hidden" value="<?php echo $nn; ?>" />
                <input name="month" type="hidden" value="<?php echo $yy; ?>" />
                <input name="phase" type="hidden" value="<?php echo $phases; ?>"/>
                <input name="testlab" type="hidden" value="<?php echo $testlab; ?>"/>
                <input name="mfgsite" type="hidden" value="<?php echo $mfgsite; ?>"/>
                <input name="title" type="hidden" value="<?php echo $title; ?>"/>
                <input name="ort_date" type="hidden" value="<?php echo $ort_date; ?>"/>
                <input name="tester" type="hidden" value="<?php echo $tester; ?>"/>
                <input name="number" type="hidden" id ="units_qty" value="<?php echo $number; ?>" />
                <input name="matrix_do" type="hidden" value="matrix_save" />
                <!-- ---------------- End here ------------------- -->
            </div>
        </form>
        <!-- ----------------- PHP方法保存Matrix数据 ----------------- -->
        <?php
        if(isset($_POST["matrix_do"]) && $_POST["matrix_do"]=="matrix_save"){
            $number = $_POST["number"];
            $stage = $_POST["stage"];
            $vt = $_POST["vt"];
            $product = $_POST["product"];
            $sku = $_POST["sku"];
            $year = $_POST["year"];
            $month = $_POST["month"];
            $phase = $_POST["phase"];
            $testlab = $_POST["testlab"];
            $mfgsite = $_POST["mfgsite"];
            $title = $_POST["title"];
            $ort_date = $_POST["ort_date"];
            $tester = $_POST["tester"];
            $arr_group = $_POST["group"];        // group array
            $arr_items = $_POST["test_item"];    // test item array

            $arr_order = array();
            $order = $_POST["test_order"];   // test order array
            $len_order = count($order);

            for($loop=0; $loop<$len_order; $loop++){
                strtoupper($order[$loop]);
                //echo $loop."--->".$order[$loop]."<br>";
                if($order[$loop]=="请选择"){
                    $arr_order[$loop] = "";
                }
                else{
                    array_push($arr_order,$order[$loop]);
                }
            }
            // 有相同的Test item提示错误
            if(count($arr_items)!=count(array_unique($arr_items))){
                echo "<script>window.alert('有相同的Test Item!~點擊返回');history.back();</script>";
                exit();
            }

            /* Test order是一个二维数组,行是编号1,2,3...列是每个机台测试的项目，必须转置一下成每个机台对应几项测试的二维数组 */
            $tmp1 = array_chunk($arr_order,$number);
            $len1 = count($tmp1);
            $len2 = count($tmp1[0]);
            for($i=0; $i<$len1; $i++){
                for($j=0; $j<$len2; $j++){
                    $tmp2[$j][$i] = $tmp1[$i][$j];    //转置后安装unit1,2,3...顺序排列
                }
            }
            
            $len3 = count($tmp2); 
            $len4 = count($tmp2[0]);
            $timedt = date("Y-m-d H:i:s");
            $counter = 0;        //作为测试机编号 1,2,3.......N
            $title = preg_replace("/\'/","",$title);

            $get_test_name = urlencode($tester);
            $get_product_name = urlencode($product);
            $get_start_day = urlencode($timedt);

            for($i=0; $i<$len3; $i++){
                $counter++;
                for($j=0; $j<$len4; $j++){
                    $group     = $arr_group[$j];
                    $test_item = $arr_items[$j];
                    $unit      = $tmp2[$i][$j];     //test order
                    $sql_add = "INSERT INTO DQA_Test_Main(Titles,Stages,VT,Products,SKUS,Years,Months,Phases,Units,Groups,Testitems,Testlab,Mfgsite,ORTMFGDate,Testername,Timedt,Unitsno) ";
                    $sql_add .= "VALUES('$title','$stage','$vt','$product','$sku','$year','$month','$phase','$unit','$group','$test_item','$testlab','$mfgsite','$ort_date','$tester','$timedt','$counter')";
                    //echo $counter.". ".$sql_add."<br>";
                    mysqli_query($con,$sql_add);
                }
            }
            //echo "<h1 style='color:#4f7764; text-align:center; font-size:20px;'>数据保存完成:)</h1>";
            //echo "<meta http-equiv='refresh' content='1; url=index.php'>";
            mysqli_close($con);
            $url = "matrix_edit.php?user={$get_test_name}&product={$get_product_name}&starting={$get_start_day}";
            $message = urlencode("数据保存完成 :)");
            echo "<script>window.location.href='success.php?url=$url&message=$message'</script>";
        }
        ?>
        <!-- save matrix over -->
    </div>
</div>
<div>&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/bear.svg" height="200" /></div>
</body>
</html>