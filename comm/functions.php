<?php
/* *********************************************************
 *
 *                    .::::.
 *                  .::::::::.
 *                 :::::::::::  shall we have dinner tonight
 *             ..:::::::::::'
 *           '::::::::::::'
 *             .::::::::::
 *        '::::::::::::::..
 *             ..::::::::::::.
 *           ``::::::::::::::::
 *            ::::``:::::::::'        .:::.
 *           ::::'   ':::::'       .::::::::.
 *         .::::'      ::::     .:::::::'::::.
 *        .:::'       :::::  .:::::::::' ':::::.
 *       .::'        :::::.:::::::::'      ':::::.
 *      .::'         ::::::::::::::'         ``::::.
 *  ...:::           ::::::::::::'              ``::.
 * ```` ':.          ':::::::::'                  ::::..
 *                    '.:::::'                    ':'````..
*********************************************************** */

require_once("../js/conf.php");

/**
 * 根据传入的SQL语句查询MySQL结果集; 一个通用的方法: 参数1是数据库名,参数2是SQL语句
 */
function getData($db,$sql){
    $resource = mysqli_query($db, $sql);//get a resource type
    $res = array();
    /**
     * mysqli_fetch_array, mysqli_fetch_assco的参数就是mysqli_query()返回的数据指针
    */
    while($row=mysqli_fetch_array($resource)){
        $res[] = $row;//二维数组
    }
    return $res;
}

/**
 * 获取DQA_Test_Main中所有测试项,即Raw All -C;
 */
function getRawAllComm($db){
    /*
    $raw_all = "SELECT * FROM DQA_Test_Main WHERE Units!='' ";
    $res = getData($db,$raw_all);
    return $res;
    */
    $raw_all = "SELECT DQA_Test_Main.RecordID,DQA_Test_Main.Stages,DQA_Test_Main.VT,DQA_Test_Main.Products,DQA_Test_Main.SKUS,DQA_Test_Main.Years,";
    $raw_all.= "DQA_Test_Main.Months,DQA_Test_Main.Phases,DQA_Test_Main.SN,DQA_Test_Main.Units,DQA_Test_Main.Groups,DQA_Test_Main.Testitems,";
    $raw_all.= "DQA_Test_Main.Testcondition,DQA_Test_Main.Startday,DQA_Test_Main.Endday,DQA_Test_Main.Testdays,DQA_Test_Main.Teststatus,";
    $raw_all.= "DQA_Test_Main.Results,DQA_Test_Main.Temp,DQA_Test_Main.Boot,DQA_Test_Main.Testlab,DQA_Test_Main.Mfgsite,DQA_Test_Main.Testername,";
    $raw_all.= "DQA_Test_Main.Today,DQA_Test_Main.Remarks,DQA_Test_Main.Failinfo,DQA_Test_Main.Unitsno,DQA_Test_Main.FAA,";
    $raw_all.= "fail_infomation.Defectmode1,fail_infomation.Defectmode2,fail_infomation.RCCA,fail_infomation.Issuestatus,fail_infomation.Category,";
    $raw_all.= "fail_infomation.PIC,fail_infomation.JIRANO,fail_infomation.SPR,fail_infomation.Temp,fail_infomation.Dropcycles,fail_infomation.Drops,";
    $raw_all.= "fail_infomation.Dropside,fail_infomation.HIT,fail_infomation.NextCheckpointDate,fail_infomation.IssuePublished,fail_infomation.ORTMFGDate,";
    $raw_all.= "fail_infomation.ReportedDate,fail_infomation.IssueDuration,fail_infomation.Today,fail_infomation.Unitsno,fail_infomation.Results ";
    $raw_all.= "FROM DQA_Test_Main LEFT JOIN fail_infomation ON DQA_Test_Main.RecordID=fail_infomation.TestID WHERE Units!='' ORDER BY DQA_Test_Main.RecordID ASC";
    $res = getData($db,$raw_all);
    return $res;
}

/**
 * 
 */
function getRawAllCommByPeriod($db,$start,$end){
    /*
    $raw_all = "SELECT * FROM DQA_Test_Main WHERE Units!='' AND (Timedt>='$start' and Timedt<='$end') ";
    $res = getData($db,$raw_all);
    return $res;
    */
    $raw_all = "SELECT DQA_Test_Main.RecordID,DQA_Test_Main.Stages,DQA_Test_Main.VT,DQA_Test_Main.Products,DQA_Test_Main.SKUS,DQA_Test_Main.Years,";
    $raw_all.= "DQA_Test_Main.Months,DQA_Test_Main.Phases,DQA_Test_Main.SN,DQA_Test_Main.Units,DQA_Test_Main.Groups,DQA_Test_Main.Testitems,";
    $raw_all.= "DQA_Test_Main.Testcondition,DQA_Test_Main.Startday,DQA_Test_Main.Endday,DQA_Test_Main.Testdays,DQA_Test_Main.Teststatus,";
    $raw_all.= "DQA_Test_Main.Results,DQA_Test_Main.Temp,DQA_Test_Main.Boot,DQA_Test_Main.Testlab,DQA_Test_Main.Mfgsite,DQA_Test_Main.Testername,";
    $raw_all.= "DQA_Test_Main.Today,DQA_Test_Main.Remarks,DQA_Test_Main.Failinfo,DQA_Test_Main.Unitsno,DQA_Test_Main.FAA,";
    $raw_all.= "fail_infomation.Defectmode1,fail_infomation.Defectmode2,fail_infomation.RCCA,fail_infomation.Issuestatus,fail_infomation.Category,";
    $raw_all.= "fail_infomation.PIC,fail_infomation.JIRANO,fail_infomation.SPR,fail_infomation.Temp,fail_infomation.Dropcycles,fail_infomation.Drops,";
    $raw_all.= "fail_infomation.Dropside,fail_infomation.HIT,fail_infomation.NextCheckpointDate,fail_infomation.IssuePublished,fail_infomation.ORTMFGDate,";
    $raw_all.= "fail_infomation.ReportedDate,fail_infomation.IssueDuration,fail_infomation.Today,fail_infomation.Unitsno,fail_infomation.Results ";
    $raw_all.= "FROM DQA_Test_Main LEFT JOIN fail_infomation ON DQA_Test_Main.RecordID=fail_infomation.TestID WHERE Units!='' AND (Timedt>='$start' and Timedt<='$end') ORDER BY DQA_Test_Main.RecordID ASC";
    $res = getData($db,$raw_all);
    return $res;
}

/**
 * 获取测试数据表中Product,返回一个数组
 */
function getDistinctProduct($db){
    $product_name = array();
    $check_product = mysqli_query($db, "SELECT DISTINCT Products FROM DQA_Test_Main");
    while($row=mysqli_fetch_array($check_product)){
        array_push($product_name,$row["Products"]);
    }
    return $product_name;
}

/**
 * 根据时间段获取Product名为一个数组
 */
function getDistinctProductByPeriod($db,$start,$end){
    $product_name = array();
    $check_product = mysqli_query($db, "SELECT DISTINCT(Products) FROM DQA_Test_Main WHERE Timedt>='$start' and Timedt<='$end' ");
    while($row=mysqli_fetch_assoc($check_product)){
        array_push($product_name,$row["Products"]);
    }
    return $product_name;
}

/**
 * 根据传入的product查询数据
 */
function getDataByProduct($db,$product){
    /*
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Units!='' ";
    $res = getData($db,$sql);
    return $res;
    */
    $sql = "SELECT DQA_Test_Main.RecordID,DQA_Test_Main.Stages,DQA_Test_Main.VT,DQA_Test_Main.Products,DQA_Test_Main.SKUS,DQA_Test_Main.Years,";
    $sql.= "DQA_Test_Main.Months,DQA_Test_Main.Phases,DQA_Test_Main.SN,DQA_Test_Main.Units,DQA_Test_Main.Groups,DQA_Test_Main.Testitems,";
    $sql.= "DQA_Test_Main.Testcondition,DQA_Test_Main.Startday,DQA_Test_Main.Endday,DQA_Test_Main.Testdays,DQA_Test_Main.Teststatus,";
    $sql.= "DQA_Test_Main.Results,DQA_Test_Main.Temp,DQA_Test_Main.Boot,DQA_Test_Main.Testlab,DQA_Test_Main.Mfgsite,DQA_Test_Main.Testername,";
    $sql.= "DQA_Test_Main.Today,DQA_Test_Main.Remarks,DQA_Test_Main.Failinfo,DQA_Test_Main.Unitsno,DQA_Test_Main.FAA,";
    $sql.= "fail_infomation.Defectmode1,fail_infomation.Defectmode2,fail_infomation.RCCA,fail_infomation.Issuestatus,fail_infomation.Category,";
    $sql.= "fail_infomation.PIC,fail_infomation.JIRANO,fail_infomation.SPR,fail_infomation.Temp,fail_infomation.Dropcycles,fail_infomation.Drops,";
    $sql.= "fail_infomation.Dropside,fail_infomation.HIT,fail_infomation.NextCheckpointDate,fail_infomation.IssuePublished,fail_infomation.ORTMFGDate,";
    $sql.= "fail_infomation.ReportedDate,fail_infomation.IssueDuration,fail_infomation.Today,fail_infomation.Unitsno,fail_infomation.Results ";
    $sql.= "FROM DQA_Test_Main LEFT JOIN fail_infomation ON DQA_Test_Main.RecordID=fail_infomation.TestID WHERE Products='$product' AND Units!='' ORDER BY DQA_Test_Main.RecordID ASC";
    $res = getData($db,$sql);
    return $res;
}

/**
 * 根据传入的product,時間段查询数据
 */
function getDataByProductAndPeriod($db,$product,$start,$end){
    /*
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND (Timedt>='$start' and Timedt<='$end') AND Units!='' ";
    $res = getData($db,$sql);
    return $res;
    */
    $sql = "SELECT DQA_Test_Main.RecordID,DQA_Test_Main.Stages,DQA_Test_Main.VT,DQA_Test_Main.Products,DQA_Test_Main.SKUS,DQA_Test_Main.Years,";
    $sql.= "DQA_Test_Main.Months,DQA_Test_Main.Phases,DQA_Test_Main.SN,DQA_Test_Main.Units,DQA_Test_Main.Groups,DQA_Test_Main.Testitems,";
    $sql.= "DQA_Test_Main.Testcondition,DQA_Test_Main.Startday,DQA_Test_Main.Endday,DQA_Test_Main.Testdays,DQA_Test_Main.Teststatus,";
    $sql.= "DQA_Test_Main.Results,DQA_Test_Main.Temp,DQA_Test_Main.Boot,DQA_Test_Main.Testlab,DQA_Test_Main.Mfgsite,DQA_Test_Main.Testername,";
    $sql.= "DQA_Test_Main.Today,DQA_Test_Main.Remarks,DQA_Test_Main.Failinfo,DQA_Test_Main.Unitsno,DQA_Test_Main.FAA,";
    $sql.= "fail_infomation.Defectmode1,fail_infomation.Defectmode2,fail_infomation.RCCA,fail_infomation.Issuestatus,fail_infomation.Category,";
    $sql.= "fail_infomation.PIC,fail_infomation.JIRANO,fail_infomation.SPR,fail_infomation.Temp,fail_infomation.Dropcycles,fail_infomation.Drops,";
    $sql.= "fail_infomation.Dropside,fail_infomation.HIT,fail_infomation.NextCheckpointDate,fail_infomation.IssuePublished,fail_infomation.ORTMFGDate,";
    $sql.= "fail_infomation.ReportedDate,fail_infomation.IssueDuration,fail_infomation.Today,fail_infomation.Unitsno,fail_infomation.Results ";
    $sql.= "FROM DQA_Test_Main LEFT JOIN fail_infomation ON DQA_Test_Main.RecordID=fail_infomation.TestID WHERE Products='$product' AND Units!='' AND (Timedt>='$start' and Timedt<='$end') ORDER BY DQA_Test_Main.RecordID ASC";
    $res = getData($db,$sql);
    return $res;
}

/**
 * 根据传入的测试人名查询数据
 */
function getDataByTester($db,$name){
    /*
    $sql = "SELECT * FROM DQA_Test_Main WHERE Testername='$name' Units!='' ";
    $res = getData($db,$sql);
    return $res;
    */
    $sql = "SELECT DQA_Test_Main.RecordID,DQA_Test_Main.Stages,DQA_Test_Main.VT,DQA_Test_Main.Products,DQA_Test_Main.SKUS,DQA_Test_Main.Years,";
    $sql.= "DQA_Test_Main.Months,DQA_Test_Main.Phases,DQA_Test_Main.SN,DQA_Test_Main.Units,DQA_Test_Main.Groups,DQA_Test_Main.Testitems,";
    $sql.= "DQA_Test_Main.Testcondition,DQA_Test_Main.Startday,DQA_Test_Main.Endday,DQA_Test_Main.Testdays,DQA_Test_Main.Teststatus,";
    $sql.= "DQA_Test_Main.Results,DQA_Test_Main.Temp,DQA_Test_Main.Boot,DQA_Test_Main.Testlab,DQA_Test_Main.Mfgsite,DQA_Test_Main.Testername,";
    $sql.= "DQA_Test_Main.Today,DQA_Test_Main.Remarks,DQA_Test_Main.Failinfo,DQA_Test_Main.Unitsno,DQA_Test_Main.FAA,";
    $sql.= "fail_infomation.Defectmode1,fail_infomation.Defectmode2,fail_infomation.RCCA,fail_infomation.Issuestatus,fail_infomation.Category,";
    $sql.= "fail_infomation.PIC,fail_infomation.JIRANO,fail_infomation.SPR,fail_infomation.Temp,fail_infomation.Dropcycles,fail_infomation.Drops,";
    $sql.= "fail_infomation.Dropside,fail_infomation.HIT,fail_infomation.NextCheckpointDate,fail_infomation.IssuePublished,fail_infomation.ORTMFGDate,";
    $sql.= "fail_infomation.ReportedDate,fail_infomation.IssueDuration,fail_infomation.Today,fail_infomation.Unitsno,fail_infomation.Results ";
    $sql.= "FROM DQA_Test_Main LEFT JOIN fail_infomation ON DQA_Test_Main.RecordID=fail_infomation.TestID WHERE Testername='$name' Units!='' ORDER BY DQA_Test_Main.RecordID ASC";
    $res = getData($db,$sql);
    return $res;
}

/**
 * 根据需要的文件类型生成Excel到本机的下载目录
 */
function browser_excel($type,$filename){
    if($type=='Excel5'){
        header('Content-Type: application/vnd.ms-excel');    //告诉浏览器将要输出xls文件
    }
    else{
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');   //告诉浏览器将要输出xlsx文件
    }
    header('Content-Disposition: attachment;filename="'.$filename.'"');    //告诉浏览器将要输出文件的名称
    header('Cache-Control: max-age=0');    //禁止缓存
}

/**
 * 根据传入的product tester date查询某一次的测试记录
 */
function getDataForMatrixTransform($db,$product,$tester,$starting){
    $sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' ";
    $res = getData($db,$sql_query);
    return $res;
}

/**
 * 去掉月份,天数的前缀0; 比如05变成5, 10这样的月份还是显示10;
*/
function removeZeroPrefix($month){
    if(substr($month,0,1)==0 && strlen($month)>0){
        return substr($month,1,1);
    }
    else if(strlen($month)==0){
        return "";
    }
    else{
        return $month;1
    }
}

/**
 * 把默认的时间由2022-10-01改成2022/10/1, 2022-05-11变成2022/5/1
*/
function changeDatesFormatGreen($date){
    if(strlen($date)>0){
        $tmp = date_create_from_format("Y-m-d", $date);
        return date_format($tmp,"Y/n/j");
    }
    else{
        return "";
    }
}

/**
 * 把默认的时间由2022-10-01改成/10/1, 2022-05-11变成/5/1
*/
function changeDatesFormatBlack($date){
    if(strlen($date>0)){
        $tmp = date_create_from_format("Y-m-d", $date);
        return date_format($tmp,"n/j");
    }
    else{
        return "";
    }
}
?>