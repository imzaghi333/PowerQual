<?php
require_once("./js/conf.php");
header("Content-Type:text/html;charset=UTF-8");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/main_dqa.css">
    <link rel="shortcut icon" href="images/favior.ico">
    <script type="text/javascript" src="js/dqa_main.js"></script>
    <title>Power Query</title>
</head>
<body>
<div class="header">
    <a href="index.php"><img class="wistron_logo" src="./images/logo.svg" width="180" /></a>&nbsp;
    <div class="title"><a href="javascript:layer.msg('推荐使用Chrome或MS Edge浏览器 ^(*￣(oo)￣)^',{icon:6});">DQA Power Qual<br>Matrix auto transforming</a></div>
    <div class="search_menu">
        <form name='search' action='./searched.php' target="_blank" method='POST' onsubmit='return checkSerch()'>                
            <li><button class='search_btn' type='submit' name='search_btn'><span class="icon">L</span>&nbsp;&nbsp;&nbsp;搜索</button></li>
            <li><input name='search' class='search' type='search' placeholder='Search Tester, SN, Product' /></li>
            <input type='hidden' name='searchit' value='searchdo' />
        </form>
    </div>
</div>
<div class="container">
    <div class="left">
        <div class="action">
            <div><a href="index.php">Query......&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="edit-icon"></span><span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=start">Matrix Creating&nbsp;&nbsp;<span class="tablet-icon"></span><span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=data">All Data&nbsp;&nbsp;<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=export">Export Raw Data<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=upload">DropBox Upload<span class="p_right">&#10148</span></a></div>
            <div><a href="index.php?dowhat=edit">DropBox Edit<span class="p_right">&#10148</span></a></div>
            <br>
            <a href=mailto:felix_qian@wistron.com><img id="logo" src="./images/logo.svg" width="150" /></a><br>
            <div><?php echo "Your IP: ".$_SERVER ['REMOTE_ADDR']; ?></div>
        </div>
    </div>
    <div class="right">
        <?php
        if($_GET['dowhat'] == 'start' || $_POST['dowhat'] == 'startdo'){
        ?>
            <p class="info">Add New Power Qual Task</p>
            <div>
                <form id="form1" name="form1" method="POST" action="matrix.php" onsubmit="return checkForm1()">
                    <table align="center" class="form1">
                        <tr>
                            <td width="20%">Title</td>
                            <td><input name="title" type="text" placeholder="Descrition of your project" /></td>
                        </tr>
                        <tr>
                            <td width="20%">Stage</td>
                            <td>
                                <select name="stage">
                                    <option value="NPI">NPI</option>
                                    <option Value="Sus">Sus</option>
                                    <option Value="Others">其他</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Verification Type</td>
                            <td>
                                <select name="vt">                                    
                                    <option value="ORT">ORT</option>
                                    <option Value="QTP">QTP</option>
                                    <option Value="ENG (in spec)">ENG (in spec)</option>
                                    <option Value="Others">其他</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Product</td>
                            <td>
                                <?php
                                echo "<select name='product'>";
                                $check = mysqli_query($con, "SELECT Product FROM dropbox_product");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["Product"]}'>{$row['Product']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>SKU</td>
                            <td>
                                <?php
                                echo "<select name='sku'>";
                                $check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["SKUS"]}'>{$row['SKUS']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr><td>Year/Month <font size="3" color="#be0f2d">*</font></td><td><input name="ym" type="month" /></td></tr>
                        <tr>
                            <td>Phase</td>
                            <td>
                                <?php
                                echo "<select name='phases'>";
                                $check = mysqli_query($con, "SELECT Phase FROM dropbox_phase");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["Phase"]}'>{$row['Phase']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Unit數量 <font size="3" color="#be0f2d">*</font></td>
                            <td><input name="unit" type="number" min="0" max="99" placeholder="測試機數量(如1，2，3...)" /></td>
                        </tr>
                        <!-- Calcel boot option on 2022-01-10
                        <tr>
                            <td>Boot</td>
                            <td>
                                <select name="boot">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </td>
                        </tr>
                        -->
                        <tr>
                            <td>Test LAB</td>
                            <td>
                                <?php
                                echo "<select name='testlab'>";
                                $check = mysqli_query($con, "SELECT LAB_SITE FROM dropbox_lab_site");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["LAB_SITE"]}'>{$row['LAB_SITE']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>MFG Site</td>                            
                            <td>
                                <?php
                                echo "<select name='mfgsite'>";
                                $check = mysqli_query($con, "SELECT LAB_SITE FROM dropbox_lab_site");
                                while ($row = mysqli_fetch_array($check)) {
                                    echo "<option value='{$row["LAB_SITE"]}'>{$row['LAB_SITE']}</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="icon">U</span> (測試人): <font size="3" color="#be0f2d">*</font> </td>
                            <td><input name="tester" type="text" placeholder="填寫測試人" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <button class="btn_sub" type="submit">下一步</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                <button name="reset" type="reset" class="btn-warning btn-lg">清&nbsp;&nbsp;空</button>
                                <input type="hidden" id="action" name="action" value="next" /><br>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php
        }
        
        else if($_GET['dowhat'] == 'export' || $_POST['dowhat'] == 'exportdo'){
        ?>
            <p class="info">Export Data to Excel&nbsp;&nbsp;<span class="icon"><img src="./images/logo_excel.svg" height="30" /></span></p>
            <div>
                <div id="preloder"><div class="loader"></div></div>
                <form name="export_excel" id="export_excel" method="POST" action="./comm/Out_Excel.php">
                    <table align="center" width="70%" cellpadding="5" border="0">
                        <tr>
                            <td>
                                From: <input style="width: 150px;" name="from" type="date" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                to: <input style="width: 150px;" name="to" type="date" />
                                &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_download" type="submit" onclick="layer.msg('加载数据中,请耐心等待...',{icon:6,time:20000})">Export</button>
                                <input name="to_excel" type="hidden" value="to_excel_do" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="note">
                <p> 1.如果未選擇時間段，導出所有數據到電腦的下載目錄</p>
                <p> 2.如果選擇時間範圍，導出這一時間段數據</p>
                <p> 3.如果選擇時間範圍，請一定要填寫開始時間和結束時間</p>
            </div>
        <?php
        }
        else if($_GET['dowhat'] == 'upload' || $_POST['dowhat'] == 'uploaddo'){
        ?>
            <p class="info">DropBox Menu Upload <img src="./images/logo_excel.svg" height="20" /></p>
            <div>
                <form name="upload" action="upload.php" method="POST" enctype="multipart/form-data" onsubmit="return checkFormUpload()">
                    <table align="center" width="70%" cellpadding="5" border="0">
                        <tr>
                            <td>Dropbox update：</td>
                            <td>
                                <select name="dropbox" style="padding: 4px 4px;border: 1px solid #e2e2e2;width: 70%;border-radius: 4px;">
                                    <option value="">請選擇</option>
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
                        <tr><td width="20%">选择文件 <span class="icon">F</span> : </td><td><input name="myfile" id="myfile" type="file" /></td></tr>
                        <tr>
                            <td colspan="2" align="center">
                                <button name="upload" type="submit" class="btn_update">上传文件</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn_edit" name="reset" type="reset">清 空</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div class="note">
                    <p> 模板下载：<a href="images/Template.xlsx">Template (点击下载)</a></p>
                    <p> 1. 下载模板填写需要上传的数据，只需要填写最新的数据</p>
                    <p> 2. 日期必须存储为年月日格式,如1949-10-01样式</p>
                    <p> 3. 不要出现换行符(\n), 制表符(\t)，单引号(')等特殊字符,它们会引起数据丢失</p>
                    <p> 4. 此功能用于下拉菜单更新</p>
                </div>
                <div class="caution"><img src="images/Attention.JPG" width="230" alt="注意!~~" /></div>
                <div class="clear"></div>
            </div>
        <?php    
        }
        else if($_GET['dowhat'] == 'edit' || $_POST['dowhat'] == 'editdo'){
        ?>
        <div>
            <p class="info">Add New Dropbox Menu</p>
            <form name="add_dropbox" action="" method="POST" onsubmit="return checkAddDropbox()">
                <table align="center" width="70%" cellpadding="5" border="0">
                    <tr>
                        <td>Dropbox Select: </td>
                        <td>
                            <select name="dropbox" style="padding: 4px 4px;border: 1px solid #e2e2e2;width: 70%;border-radius: 4px;">
                                <option value="">請選擇</option>
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
                                <option value="LAB">Lab & Site Menu</option>
                                <option value="Order">Test Order(A,B,C...)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Dropbox Content: </td>
                        <td><textarea name="added_txt" rows="10" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button name="add_btn" type="submit" class="btn_sub">添 加</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button name="reset" type="reset">清 空</button>
                            <input name="add_dropbox" type="hidden" value="add_dropbox_do" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            if(isset($_POST["add_dropbox"]) && $_POST["add_dropbox"]=="add_dropbox_do"){
                $dropbox = $_POST["dropbox"];
                $txt_input = $_POST["added_txt"];
                $comma = "/\'/";
                $replace = "\'";
                //$added_txt = $_POST["added_txt"];      
                $added_txt = preg_replace($comma,$replace,$txt_input);      
                switch ($dropbox) {
                    // 1.Product Menu
                    case 'Product':
                        $sql_add = "INSERT INTO dropbox_product(Product) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 2.SKU Menu                    
                    case 'SKU';
                        $sql_add = "INSERT INTO dropbox_sku(SKUS) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 3.Phase Menu
                    case 'phases':
                        $sql_add = "INSERT INTO dropbox_phase(Phase) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 4.Test items Menu
                    case 'Testitem':
                        $sql_add = "INSERT INTO dropbox_test_item(Testitem) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 5.DefectMode(Symptom)
                    case 'df1':
                        $sql_add = "INSERT INTO dropbox_df1(DefectMode) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 6.DefectMode(Symptom+Finding)
                    case 'df2':
                        $sql_add = "INSERT INTO dropbox_df2(DefectMode) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 7.Dropside Menu
                    case 'Dropside':
                        $sql_add = "INSERT INTO dropbox_dropside(Dropside) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 8. Result Menu
                    case 'Result':
                        $sql_add = "INSERT INTO dropbox_result(Result) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 9.Issue statuss Menu
                    case 'Issue_Status':
                        $sql_add = "INSERT INTO dropbox_issue_status(Issue_Status) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 10.Group Menu
                    case 'Group':
                        $sql_add = "INSERT INTO dropbox_group(`Groups`) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 11. Test condition
                    case 'Testcondition':
                        $sql_add = "INSERT INTO dropbox_test_condition(Testcondition) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 12. LAB
                    case 'LAB':
                        $sql_add = "INSERT INTO dropbox_lab_site(LAB_SITE) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;
                    // 13. Test Order
                    case 'Order':
                        $sql_add = "INSERT INTO dropbox_test_order(Testorder) VALUES('$added_txt')";
                        mysqli_query($con,$sql_add);
                        echo "<script>window.alert('添加完成！~~~');</script>";
                        break;

                    default:
                        echo "<script>window.alert('出错啦！~~~');</script>";
                        break;
                }
            }
            ?>
            <br>
            <p class="info">Edit or Delete Dropbox Option</p>
            <form name="del_dropbox" action="./Edit/edit_dropbox_option.php" method="POST" onsubmit="return checkDelDropbox()">
                <table align="center" width="70%" cellpadding="5" border="0">
                    <tr>
                        <td>Dropbox Select: </td>
                        <td>
                            <select name="dropbox" style="padding: 4px 4px;border: 1px solid #e2e2e2;width: 70%;border-radius: 4px;">
                                <option value="">請選擇</option>
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
                                <option value="LAB">Lab & Site Menu</option>
                                <option value="TO">Test Order(A,B,C...)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <button name="del_btn" type="submit" class="btn_sub">确 定</button>
                            <button name="reset" type="reset">清 空</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="del_dropbox" type="hidden" value="del_dropbox_do" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
        }
        else if($_GET['dowhat'] == 'data' || $_POST['dowhat'] == 'datado'){
        ?>
        <div>
            <p class="info">All Test Matrix Records</p>
            <?php
            $sql_index = "SELECT count(*) as total FROM DQA_Test_Main WHERE Results!='N/A' ";
            $result = mysqli_query($con,$sql_index);
            $info = mysqli_fetch_array($result);
            $total = $info['total'];
            if($total==0){
                echo "<p class='fail-info'>暫無任何數據</p>";
            }
            else{
            ?>
            <table align="center" class="my_table" id="my_table">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>Stage</th>
                    <th width="9%">Verify Type</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th width="5%">Year</th>
                    <th>Phase</th>
                    <th>SN</th>
                    <th>Unit#</th>
                    <th>Name</th>
                    <th>Group</th>
                    <th>Test Item</th>
                    <th>DEL</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $pagesize=30;    //设置每页显示记录數量
                if($total<=$pagesize){
                    $pagecount = 1;
                }
                else if(($total%$pagesize)!=0){
                    $pagecount=intval($total/$pagesize)+1;
                }
                else{
                    $pagecount=$total/$pagesize;
                }
                if((@ $_GET['page'])==""){
                    $page = 1;
                }
                else{
                    $page=intval($_GET['page']);
                }
                $counter = 0;
                $check = mysqli_query($con,"SELECT * FROM DQA_Test_Main WHERE Results!='N/A' ORDER BY Timedt DESC LIMIT ".($page-1)*$pagesize.",$pagesize ");
                while($row = mysqli_fetch_array($check,MYSQLI_BOTH)){
                    ++$counter;
                ?>
                    <tr>
                        <td><?php echo $counter+($page-1)*$pagesize; ?></td>
                        <td><?php echo $row["Stages"]; ?></td>
                        <td><?php echo $row["VT"]; ?></td>
                        <td><?php echo $row["Products"]; ?></td>
                        <td><?php echo $row["SKUS"]; ?></td>
                        <td><?php echo $row["Years"].".".$row["Months"]; ?></td>
                        <td><?php echo $row["Phases"]; ?></td>
                        <td><?php echo $row["SN"]; ?></td>
                        <td><?php echo $row["Units"]; ?></td>
                        <td><?php echo $row["Testername"]; ?></td>
                        <td><?php echo $row["Groups"]; ?></td>
                        <td class="items1">
                            <span class="qr_tip">点击查看或者编辑</span>
                            <a href="details.php?id=<?php echo $row["RecordID"]; ?>"><?php echo $row["Testitems"] ?></a>
                        </td>
                        <td><a href="javascript:void(0)" onClick="confirmDel(<?php echo $row['RecordID']; ?>)"><span class="trash-icon"></span></a></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="13" align="center">
                        <font size="2">共有数据 <?php echo $total;?>&nbsp;条，每页显示&nbsp;<?php echo $pagesize; ?>&nbsp;条，&nbsp;第&nbsp;
                        <?php echo $page;//显示当前页码；?>&nbsp;页/共&nbsp;<?php echo $pagecount; ?>&nbsp;页
                        <?php
                        if($page>=2){
                        //如果页码数大于等于2则执行下面程序index.php?dowhat=pic&page=1   index.php?dowhat=pic&id=
                        ?>
                            <a href="index.php?dowhat=data&page=1" title="首页"><font face="webdings"> 9 </font></a> / <a href="index.php?dowhat=data&id=<?php echo $id;?>&amp;page=<?php echo $page-1; ?>" title="前一页"><font face="webdings"> 7 </font></a>
                        <?php
                        }
                        if($pagecount<=4){
                            //如果页码数小于等于4执行下面程序
                            for($i=1;$i<=$pagecount;$i++){
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $i;?>"><?php echo $i;?></a>
                        <?php
                            }
                        }
                        else{
                            for($i=1;$i<=4;$i++){	 
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $i;?>">&nbsp;<?php echo $i;?>&nbsp;</a>
                        <?php 
                            }
                        ?>
                            <a href="index.php?dowhat=data&page=<?php echo $page+1;?>" title="后一页"><font face="webdings"> 8 </font></a> <a href="index.php?dowhat=data&id=<?php echo $id;?>&amp;page=<?php echo $pagecount;?>" title="尾页"><font face="webdings"> : </font></a>
                        <?php 
                        }
                        ?>
                    </td>
                </tr>
                </tfoot>
            </table>
            <?php
            }   
            ?>
        </div>
        <?php
        }
        else{
        //2021-11-15
        ?>
        <div>
            <p class="info">Auto Transforming Begins Here ... <img src="./images/getting_started.svg" height="25" />
            <div>
            <form id="form7" name="form7" method="POST" action="" onsubmit="return checkForm7();">
                <table align="center" class="form7">
                    <tr>
                        <td><span class="icon">U</span> (測試人): </td>
                        <td>
                            <select name="tester" id="tester">
                                <option value="">Select Tester</option>
                                <?php
                                $check = mysqli_query($con, "SELECT DISTINCT(Testername) FROM DQA_Test_Main ORDER BY Testername ASC");
                                while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                    echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
                                }
                                ?>
                            </select>
                            
                        </td>
                        
                    </tr>
                    <tr>
                        <td width="20%">Product: </td>
                        <td width="80%">
                            <select name="product">
                                <option value="">Select Product</option>
                                <?php
                                $check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
                                while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
                                    echo "<option value=" ."'$row[0]'" . ">" . $row[0] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td>開始日期: </td><td><input name="starting" type="date" /></td></tr>
                    <!--<tr><td>結束日期:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="3" color="#be0f2d">*</font></td><td><input name="ending" type="date" /></td></tr>-->
                    <tr>
                        <td colspan="2" align="center">
                            <button class="btn_query" type="submit">查 詢&nbsp;&nbsp;&nbsp;<span class="icon">L</span></button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn_reset" type="reset">清&nbsp;&nbsp;空</button>
                        </td>
                        <input type="hidden" name="query" value="query_do" />
                    </tr>
                </table>
            </form>
            <?php
            // added on 2022-01-10 for DQA request
            // 查詢條件是否可擇一來進行篩選
            // 篩選後的清單可用展開方式供選擇
            if(isset($_POST["query"]) && $_POST["query"]=="query_do"){
                $user = $_POST["tester"];     //1.選取的測試人名
                $nickname = $_POST["product"];//2.選取的product
                $tt = $_POST["starting"];     //3.選取測試日期 Audi TT
                if($user && $nickname=="" && $tt==""){
                    $cc = 0;
                    $sql_user = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Testername='$user' ORDER BY Timedt DESC";
                    $rr_user = mysqli_query($con,$sql_user);
                    echo "<p class='query_desc'>您查询了".$user."测试的产品</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_user,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        //$starting = substr($row['Timedt'],0,10);
                        $starting = $row['Timedt'];
                        //echo $product."-".$tester."-".$starting."<br>";

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                        //echo $product_name."-".$user_name."-".$start."<br>";
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>

                        <td><input name="del_matrix1" id="del_matrix1" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                else if($nickname && $user=="" && $tt==""){
                    $cc = 0;
                    $sql_product = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Products ='$nickname' ORDER BY Timedt DESC";
                    $rr_product = mysqli_query($con,$sql_product);
                    echo "<p class='query_desc'>您查询了由Wistron生产的".$nickname."</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_product,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        //$starting = substr($row['Timedt'],0,10);
                        $starting = $row['Timedt'];

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $tester; ?>&product=<?php echo $product; ?>&starting=<?php echo $starting ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                else if($tt && $user=="" && $nickname==""){
                    $cc = 0;
                    $sql_tt = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' ORDER BY Timedt DESC";
                    $rr_time = mysqli_query($con,$sql_tt);
                    echo "<p class='query_desc'>您查询了".$tt."的测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_time,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];

                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // added on 2022-03-25
                // 查詢用戶名+測試機名
                else if($user && $nickname && $tt==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Products ='$nickname' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_product_teser = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", ".$nickname."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_product_teser,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢用戶名+測試日期
                else if($user && $tt && $nickname==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_tt_teser = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", ".$tt."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_tt_teser,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢測試機名+測試日期
                else if($nickname && $tt && $user==""){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Products='$nickname' ORDER BY Timedt DESC";
                    $rr_tt_product = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$nickname.", ".$tt."测试记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_tt_product,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // 查詢測試人名+測試機名+測試日期
                else if($nickname && $tt && $user){
                    $cc = 0;
                    $sql_result = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE Timedt LIKE '$tt%' AND Products='$nickname' AND Testername='$user' ORDER BY Timedt DESC";
                    $rr_all = mysqli_query($con,$sql_result);
                    echo "<p class='query_desc'>您查询了".$user.", 在".$tt."測試的".$nickname."的记录</p>";
                    echo "<table border='1' rules='all' class='query_table'>";
                    echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th></tr>";
                    while($row=mysqli_fetch_array($rr_all,MYSQLI_BOTH)){
                        $cc++;
                        $product = $row['Products'];
                        $tester = $row['Testername'];
                        $starting = $row['Timedt'];
                        // ---------------------------------------------
                        $user_name = urlencode($tester);
                        $product_name = urlencode($product);
                        $start = urlencode($starting);
                    ?>
                    <tr>
                        <td><?php echo $cc; ?></td>
                        <td><?php echo $row['Titles']; ?></td>
                        <td><?php echo $row['Stages']; ?></td>
                        <td><?php echo $row['VT']; ?></td>
                        <td><?php echo $product ?></td>
                        <td><?php echo $row['SKUS']; ?></td>
                        <td><?php echo $tester ?></td>
                        <td><?php echo substr($starting,0,10); ?></td>
                        <td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
                        <td><input name="del_matrix2" id="del_matrix2" type="button" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
                    </tr>
                    <?php
                    }
                    echo "</table>";
                }
                // ----------- End here -----------
            }
            ?>
            <div class="note">
                <p>1. Query any item. Tester, Product or start time</p>
                <p>
                    <?php
                    $days = date("z")+1;
                    echo "2. Today is ".date("l F jS, Y")."; Week ".ceil($days/7).", and Day ".$days;
                    ?>
                </p>
            </div>
            </div>
        </div>
        <?php    
        }
        mysqli_close($con);
        ?>
    </div>
    <div class="clear"></div>
    
</div>
<div class="footer">
    <span class="icon">Z</span>&nbsp;&nbsp;<?php echo $footer ?>
    <img class="logo_white" src="./images/logo-small_white.svg" height="40" alt="Wistronits">
</div>
</body>
</html>