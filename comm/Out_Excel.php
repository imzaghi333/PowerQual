<?php
//下载文件到客户端电脑的下载目录
require_once("../js/conf.php");
require_once("./functions.php");
require_once "../Classes/PHPExcel.php";
require_once "../Classes/PHPExcel/IOFactory.php";

mysqli_query($con,"set names utf8");
date_default_timezone_set("Asia/Shanghai");
header("Content-Type:text/html;charset=utf-8");

$today = date("Y-m-d");
mysqli_query($con, "UPDATE DQA_Test_Main SET Today='$today'");    //导出Excel更新当前日期 [added on 2021-11-11]

$current_date = date("Ymd");    //作为Excel文件名的一部分
$type = "Excel5";    //输出xlsx扩展名, Excel5输出xls扩展名
$filename = "QTP Raw Data record format_V4_".$current_date.".xls";

//导出Excel更新当前日期Issue opened duration [added on 2021-11-11]
mysqli_query($con, "UPDATE DQA_Test_Main SET IssueDuration='NA' WHERE Results='Pass' ");
mysqli_query($con, "UPDATE DQA_Test_Main SET Testdays=DATEDIFF(Endday,Startday)");
mysqli_query($con, "UPDATE DQA_Test_Main SET IssueDuration=DATEDIFF(NextCheckpointDate,ReportedDate) WHERE (Issuestatus='Closed' AND Issuestatus!='') ");
mysqli_query($con, "UPDATE DQA_Test_Main SET IssueDuration=DATEDIFF(Today,ReportedDate) WHERE Issuestatus!='Closed' AND Issuestatus!='' ");

if(isset($_POST["to_excel"]) && $_POST["to_excel"]=="to_excel_do"){
    $start = $_POST["from"];
    $end = $_POST["to"];

    if($start && $end){
        //$sql_data = "SELECT * FROM DQA_Test_Main WHERE Timedt>='$start' and Timedt<='$end'";
        $arr_product = getDistinctProductByPeriod($con,$start,$end);
        $NUM = count($arr_product);
        $objPHPExcel = new PHPExcel();    //默认有一个sheet,和实际的Excel默认三个sheet
        $objPHPExcel->getProperties()->setCreator("Felix Qian - 錢暾")->setTitle("Document For Exporting Data")->setDescription("Document generated via PHPExcel.");

        for($loop=0; $loop<$NUM; $loop++){
            if($loop>0){
                $objPHPExcel->createSheet();    //创建新的内置表
            }
            $objPHPExcel->setActiveSheetIndex($loop);
            $objSheet = $objPHPExcel->getActiveSheet();    //获取当前活动sheet
            $objSheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //设置文本居中
            $objSheet->getDefaultStyle()->getFont()->setName("Calibri")->setSize("12");    //设置默认字体及大小

            $objSheet->setTitle($arr_product[$loop]);    //给活动sheet起名
            $data = getDataByProductAndPeriod($con,$arr_product[$loop],$start,$end);
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array( //设置全部边框
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
        
                ),
            );    //边框格式
            
            //第一行, 即标题行
            $objSheet->getStyle('A1:AO1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");    //第一行背景色
            $objSheet->getStyle('A1:AO1')->getFont()->getColor()->setRGB("ffffff");    //第一行字体颜色
            $objSheet->getStyle('A1:AO1')->getAlignment()->setWrapText(true);
            $objSheet->setCellValue("A1","Stages")->setCellValue("B1","Verification\nType")->setCellValue("C1","Products")->setCellValue("D1","SKU")->setCellValue("E1","Year")->setCellValue("F1","Month")->setCellValue("G1","Phase");
            $objSheet->setCellValue("H1","SN")->setCellValue("I1","Unit#")->setCellValue("J1","Group")->setCellValue("K1","Test Item")->setCellValue("L1","Test Condition")->setCellValue("M1","Start")->setCellValue("N1","Complete");
            $objSheet->setCellValue("O1","Test days")->setCellValue("P1","Defect Mode\n(Symptom)")->setCellValue("Q1","Defect Mode\n(Symptom) + (Finding)")->setCellValue("R1","RCCA")->setCellValue("S1","Test Status")->setCellValue("T1","Result");
            $objSheet->setCellValue("U1","Issue Satus")->setCellValue("V1","Category")->setCellValue("W1","PIC")->setCellValue("X1","JIRA")->setCellValue("Y1","SPR")->setCellValue("Z1","TEMP")->setCellValue("AA1","Drop Cycle");
            $objSheet->setCellValue("AB1","Drops")->setCellValue("AC1","Drop side")->setCellValue("AD1","Hit\n(Tumble)")->setCellValue("AE1","Boot")->setCellValue("AF1","Test LAb")->setCellValue("AG1","Mfg site")->setCellValue("AH1","Tester");
            $objSheet->setCellValue("AI1","Next checkpoint date")->setCellValue("AJ1","Issue\nPublished")->setCellValue("AK1","ORT MFG\ndate")->setCellValue("AL1","Report Date")->setCellValue("AM1","Issue opened\nduration")->setCellValue("AN1","Today")->setCellValue("AO1","Remark");
            $objSheet->getStyle('A1:AO1')->applyFromArray($styleThinBlackBorderOutline);    //第一行边框
            $objSheet->getColumnDimension('B')->setWidth(12);
            $objSheet->getColumnDimension('C')->setWidth(15);
            $objSheet->getColumnDimension('H')->setWidth(15);
            $objSheet->getColumnDimension('K')->setWidth(30);
            $objSheet->getColumnDimension('L')->setWidth(30);
            $objSheet->getColumnDimension('M')->setWidth(11);
            $objSheet->getColumnDimension('N')->setWidth(11);
            $objSheet->getColumnDimension('P')->setWidth(35);
            $objSheet->getColumnDimension('Q')->setWidth(35);
            $objSheet->getColumnDimension('T')->setWidth(15);
            $objSheet->getColumnDimension('U')->setWidth(15);
            $objSheet->getColumnDimension('AC')->setWidth(20);
            $objSheet->getColumnDimension('AH')->setWidth(12);
            $objSheet->getColumnDimension('AI')->setWidth(15);
            $objSheet->getColumnDimension('AM')->setWidth(15);
            $objSheet->getColumnDimension('AN')->setWidth(11);

            $row=2;
            foreach($data as $key=>$val){
                $objSheet->setCellValue("A".$row,$val["Stages"])->setCellValue("B".$row,$val["VT"])->setCellValue("C".$row,$val["Products"])->setCellValue("D".$row,$val["SKUS"])->setCellValue("E".$row,$val["Years"])->setCellValue("F".$row,$val["Months"])->setCellValue("G".$row,$val["Phases"]);
                $objSheet->setCellValue("H".$row,$val["SN"])->setCellValue("I".$row,$val["Units"])->setCellValue("J".$row,$val["Groups"])->setCellValue("K".$row,$val["Testitems"])->setCellValue("L".$row,$val["Testcondition"])->setCellValue("M".$row,$val["Startday"])->setCellValue("N".$row,$val["Endday"]);
                $objSheet->setCellValue("O".$row,$val["Testdays"])->setCellValue("P".$row,$val["Defectmode1"])->setCellValue("Q".$row,$val["Defectmode2"])->setCellValue("R".$row,$val["RCCA"])->setCellValue("S".$row,$val["Teststatus"])->setCellValue("T".$row,$val["Results"])->setCellValue("U".$row,$val["Issuestatus"]);
                $objSheet->setCellValue("V".$row,$val["Category"])->setCellValue("W".$row,$val["PIC"])->setCellValue("X".$row,$val["JIRANO"])->setCellValue("Y".$row,$val["SPR"])->setCellValue("Z".$row,$val["Temp"])->setCellValue("AA".$row,$val["Dropcycles"])->setCellValue("AB".$row,$val["Drops"])->setCellValue("AC".$row,$val["Dropside"]);
                $objSheet->setCellValue("AD".$row,$val["Hit"])->setCellValue("AE".$row,$val["Boot"])->setCellValue("AF".$row,$val["Testlab"])->setCellValue("AG".$row,$val["Mfgsite"])->setCellValue("AH".$row,$val["Testername"])->setCellValue("AI".$row,$val["NextCheckpointDate"])->setCellValue("AJ".$row,$val["IssuePublished"]);
                $objSheet->setCellValue("AK".$row,$val["ORTMFGDate"])->setCellValue("AL".$row,$val["ReportedDate"])->setCellValue("AM".$row,$val["IssueDuration"])->setCellValue("AN".$row,$val["Today"])->setCellValue("AO".$row,$val["Remarks"]);
                $row++;
                $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
        //$objWriter->save("Demo.xlsx");    //保存文件到服务器当前目录
        browser_excel($type,$filename);
        $objWriter->save("php://output");   //下载到本地目录
    }

    else{
        /*
        $sql_data = "SELECT * FROM DQA_Test_Main";
        $result = mysqli_query($con, $sql_data);
        $counter = 0;
        while($row = mysqli_fetch_array($result,MYSQLI_BOTH)){
            $counter++;
            echo $counter.". ".$row[3]." ".$row[4]."<br>";
        }
        */
        $arr_product = getDistinctProduct($con);
        $NUM = count($arr_product);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Felix Qian - 錢暾")->setTitle("Document For Exporting Data")->setDescription("Document generated via PHPExcel");

        for($loop=0; $loop<$NUM; $loop++){
            if($loop>0){
                $objPHPExcel->createSheet();
            }
            $objPHPExcel->setActiveSheetIndex($loop);
            $objSheet = $objPHPExcel->getActiveSheet();
            $objSheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //设置文本居中
            $objSheet->getDefaultStyle()->getFont()->setName("Calibri")->setSize("12");    //设置默认字体及大小

            $objSheet->setTitle($arr_product[$loop]);    //给活动sheet起名
            $data = getDataByProduct($con,$arr_product[$loop]);
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array( //设置全部边框
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
        
                ),
            );    //边框格式
            
            //第一行背景色,第一行字体颜色
            $objSheet->getStyle('A1:AO1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");
            $objSheet->getStyle('A1:AO1')->getFont()->getColor()->setRGB("ffffff");
            //第一行内容, 即标题行内容
            $objSheet->getStyle('A1:AO1')->getAlignment()->setWrapText(true);
            $objSheet->setCellValue("A1","Stages")->setCellValue("B1","Verification\nType")->setCellValue("C1","Products")->setCellValue("D1","SKU")->setCellValue("E1","Year")->setCellValue("F1","Month")->setCellValue("G1","Phase");
            $objSheet->setCellValue("H1","SN")->setCellValue("I1","Unit#")->setCellValue("J1","Group")->setCellValue("K1","Test Item")->setCellValue("L1","Test Condition")->setCellValue("M1","Start")->setCellValue("N1","Complete");
            $objSheet->setCellValue("O1","Test days")->setCellValue("P1","Defect Mode\n(Symptom)")->setCellValue("Q1","Defect Mode\n(Symptom) + (Finding)")->setCellValue("R1","RCCA")->setCellValue("S1","Test Status")->setCellValue("T1","Result");
            $objSheet->setCellValue("U1","Issue Satus")->setCellValue("V1","Category")->setCellValue("W1","PIC")->setCellValue("X1","JIRA")->setCellValue("Y1","SPR")->setCellValue("Z1","TEMP")->setCellValue("AA1","Drop Cycle");
            $objSheet->setCellValue("AB1","Drops")->setCellValue("AC1","Drop side")->setCellValue("AD1","Hit\n(Tumble)")->setCellValue("AE1","Boot")->setCellValue("AF1","Test LAb")->setCellValue("AG1","Mfg site")->setCellValue("AH1","Tester");
            $objSheet->setCellValue("AI1","Next checkpoint date")->setCellValue("AJ1","Issue\nPublished")->setCellValue("AK1","ORT MFG\ndate")->setCellValue("AL1","Report Date")->setCellValue("AM1","Issue opened\nduration")->setCellValue("AN1","Today")->setCellValue("AO1","Remark");
            $objSheet->getStyle('A1:AO1')->applyFromArray($styleThinBlackBorderOutline);    //第一行边框
            $objSheet->getColumnDimension('B')->setWidth(12);
            $objSheet->getColumnDimension('C')->setWidth(15);
            $objSheet->getColumnDimension('H')->setWidth(15);
            $objSheet->getColumnDimension('K')->setWidth(30);
            $objSheet->getColumnDimension('L')->setWidth(30);
            $objSheet->getColumnDimension('M')->setWidth(11);
            $objSheet->getColumnDimension('N')->setWidth(11);
            $objSheet->getColumnDimension('P')->setWidth(35);
            $objSheet->getColumnDimension('Q')->setWidth(35);
            $objSheet->getColumnDimension('T')->setWidth(15);
            $objSheet->getColumnDimension('U')->setWidth(15);
            $objSheet->getColumnDimension('AC')->setWidth(20);
            $objSheet->getColumnDimension('AH')->setWidth(12);
            $objSheet->getColumnDimension('AI')->setWidth(15);
            $objSheet->getColumnDimension('AM')->setWidth(15);
            $objSheet->getColumnDimension('AN')->setWidth(11);

            $row=2;
            foreach($data as $key=>$val){
                $objSheet->setCellValue("A".$row,$val["Stages"])->setCellValue("B".$row,$val["VT"])->setCellValue("C".$row,$val["Products"])->setCellValue("D".$row,$val["SKUS"])->setCellValue("E".$row,$val["Years"])->setCellValue("F".$row,$val["Months"])->setCellValue("G".$row,$val["Phases"]);
                $objSheet->setCellValue("H".$row,$val["SN"])->setCellValue("I".$row,$val["Units"])->setCellValue("J".$row,$val["Groups"])->setCellValue("K".$row,$val["Testitems"])->setCellValue("L".$row,$val["Testcondition"])->setCellValue("M".$row,$val["Startday"])->setCellValue("N".$row,$val["Endday"]);
                $objSheet->setCellValue("O".$row,$val["Testdays"])->setCellValue("P".$row,$val["Defectmode1"])->setCellValue("Q".$row,$val["Defectmode2"])->setCellValue("R".$row,$val["RCCA"])->setCellValue("S".$row,$val["Teststatus"])->setCellValue("T".$row,$val["Results"])->setCellValue("U".$row,$val["Issuestatus"]);
                $objSheet->setCellValue("V".$row,$val["Category"])->setCellValue("W".$row,$val["PIC"])->setCellValue("X".$row,$val["JIRANO"])->setCellValue("Y".$row,$val["SPR"])->setCellValue("Z".$row,$val["Temp"])->setCellValue("AA".$row,$val["Dropcycles"])->setCellValue("AB".$row,$val["Drops"])->setCellValue("AC".$row,$val["Dropside"]);
                $objSheet->setCellValue("AD".$row,$val["Hit"])->setCellValue("AE".$row,$val["Boot"])->setCellValue("AF".$row,$val["Testlab"])->setCellValue("AG".$row,$val["Mfgsite"])->setCellValue("AH".$row,$val["Testername"])->setCellValue("AI".$row,$val["NextCheckpointDate"])->setCellValue("AJ".$row,$val["IssuePublished"]);
                $objSheet->setCellValue("AK".$row,$val["ORTMFGDate"])->setCellValue("AL".$row,$val["ReportedDate"])->setCellValue("AM".$row,$val["IssueDuration"])->setCellValue("AN".$row,$val["Today"])->setCellValue("AO".$row,$val["Remarks"]);
                $row++;
                $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
        //$objWriter->save("Demo.xlsx");    //保存文件
        browser_excel($type,$filename);
        $objWriter->save("php://output");   //下载文件
    }
}

// ------------------------------------------------------------------------
function getData($db,$sql){
    $resource = mysqli_query($db, $sql);
    $res = array();
    while($row=mysqli_fetch_array($resource)){
        $res[] = $row;
    }
    return $res;
}

//获取Product名为一个数组
function getDistinctProduct($db){
    $product_name = array();
    $check_product = mysqli_query($db, "SELECT DISTINCT(Products) FROM DQA_Test_Main");
    while($row=mysqli_fetch_array($check_product)){
        array_push($product_name,$row["Products"]);
    }
    return $product_name;
}

//根据时间段获取Product名为一个数组
function getDistinctProductByPeriod($db,$start,$end){
    $product_name = array();
    $check_product = mysqli_query($db, "SELECT DISTINCT(Products) FROM DQA_Test_Main WHERE (Timedt>='$start' and Timedt<='$end')");
    while($row=mysqli_fetch_array($check_product)){
        array_push($product_name,$row["Products"]);
    }
    return $product_name;
}

//根据传入的product查询数据
function getDataByProduct($db,$product){
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Units!='N/A' ";
    $res = getData($db,$sql);
    return $res;
}

//根据传入的product,時間段查询数据
function getDataByProductAndPeriod($db,$product,$start,$end){
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND (Timedt>='$start' and Timedt<='$end') AND Units!='N/A' ";
    $res = getData($db,$sql);
    return $res;
}

// 根据传入的测试人名查询数据
function getDataByTester($db,$name){
    $sql = "SELECT * FROM DQA_Test_Main WHERE Testername='$name' Units!='N/A' ";
    $res = getData($db,$sql);
    return $res;
}

//added on 2022-02-09 for matrix auto transforming
//根据传入的product tester date查询某一次的测试记录
function getDataForMatrixTransform($db,$product,$tester,$starting){
    $sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' ";
    $res = getData($db,$sql_query);
    return $res;
}

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
?>