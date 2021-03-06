<?php
/**
 * Downlod current test matrx to your PC Download directory
 */
require_once("../js/conf.php");
require_once "../Classes/PHPExcel.php";
require_once "../Classes/PHPExcel/IOFactory.php";

$product = $_POST["product"];
$tester = $_POST["tester"];
$starting = $_POST["starting"];
$phase = $_POST["phase1"];
$vt = $_POST["vt1"];
$qty = $_POST["number1"];    //测试机数量,也作为循环用的机台编号
$today = date("Ymd");
$type = "Excel5";    //输出xlsx扩展名, Excel5输出xls扩展名
$filename = $product."_".$phase."_".$vt."_test_status_".$today.".xls";
//2022-03-28移除了Terminal列
$counts = $qty+4;//test order从第五列开始,A-D列内容固定,Start day开始的位置和机台数量有关
$sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' ";

//新建一个Excel对象
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Felix Qian - 錢暾")->setTitle("Document For Exporting Matrix")->setDescription("Document generated via PHPExcel1.8.2");
$objPHPExcel->setActiveSheetIndex(0);//第一张sheet
$objSheet = $objPHPExcel->getActiveSheet();
$objSheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //设置文本居中
$objSheet->getDefaultStyle()->getFont()->setName("Calibri")->setSize("11");    //设置默认字体及大小
$objSheet->setTitle($product);    //给活动sheet起名
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'allborders' => array( //设置全部边框
            'style' => PHPExcel_Style_Border::BORDER_THIN
        ),
    ),
);//边框格式

$objSheet->getColumnDimension('C')->setWidth(40);
$objSheet->getColumnDimension('D')->setWidth(30);
$objSheet->mergeCells("A1:A2")->setCellValue("A1","Requested");
$objSheet->mergeCells("B1:B2")->setCellValue("B1","Group");
$objSheet->mergeCells("C1:C2")->setCellValue("C1","Test Item");
$objSheet->mergeCells("D1:D2")->setCellValue("D1","Test conditions");

//将列的数字序号转成字母:PHPExcel_Cell::stringFromColumnIndex($i);从0开始 
//将列字母转成数字: PHPExcel_Cell::columnIndexFromString('AA');
for($i=4; $i<$counts; $i++){
    $cellName = PHPExcel_Cell::stringFromColumnIndex($i);
    $cellName1 = $cellName."1:".$cellName."2";
    $objSheet->mergeCells($cellName1)->setCellValue($cellName."1",($i-3));
}

//从start开始的列动态调整,跟测试机数量有关
$start_col = PHPExcel_Cell::stringFromColumnIndex($counts);
$end_col = PHPExcel_Cell::stringFromColumnIndex($counts+1);
$status_col = PHPExcel_Cell::stringFromColumnIndex($counts+2);
$test_res_col = PHPExcel_Cell::stringFromColumnIndex($counts+3);
$fail_col = PHPExcel_Cell::stringFromColumnIndex($counts+4);
$fa_col = PHPExcel_Cell::stringFromColumnIndex($counts+5);
$remark_col = PHPExcel_Cell::stringFromColumnIndex($counts+6);
$objSheet->getColumnDimension($start_col)->setWidth(12);
$objSheet->getColumnDimension($end_col)->setWidth(12);
$objSheet->getColumnDimension($test_res_col)->setWidth(12);
$objSheet->getColumnDimension($fail_col)->setWidth(20);
$objSheet->getColumnDimension($fa_col)->setWidth(20);
$objSheet->getColumnDimension($remark_col)->setWidth(20);

// ----------- 标题栏 -----------
$objSheet->mergeCells($start_col."1:".$end_col."1")->setCellValue($start_col."1","Test Schedule")->getStyle($start_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->setCellValue($start_col."2","Start")->getStyle($start_col."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->setCellValue($end_col."2","Finish")->getStyle($end_col."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->mergeCells($status_col."1:".$status_col."2")->setCellValue($status_col."1","Status")->getStyle($status_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->mergeCells($test_res_col."1:".$test_res_col."2")->setCellValue($test_res_col."1","Test Result")->getStyle($test_res_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->mergeCells($fail_col."1:".$fail_col."2")->setCellValue($fail_col."1","Fail Symptom")->getStyle($fail_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->mergeCells($fa_col."1:".$fa_col."2")->setCellValue($fa_col."1","RCCA")->getStyle($fa_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->mergeCells($remark_col."1:".$remark_col."2")->setCellValue($remark_col."1","Remark")->getStyle($remark_col."1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ffff99");
$objSheet->getStyle("A1:".$remark_col."2")->getFont()->setBold(true);
$objSheet->getStyle("A1:".$remark_col."2")->applyFromArray($styleThinBlackBorderOutline);//标题栏设置边框

$groups = array();
$test_items = array();
$sql_tc = "SELECT DISTINCT Testitems FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting'";
$tc = mysqli_query($con,$sql_tc);
while($tc_row = mysqli_fetch_array($tc,MYSQLI_BOTH)[0]){
    array_push($test_items,$tc_row);
}//获取某次测试的test item

$tc_num = count($test_items);    //表格行数
for($j=0; $j<$tc_num; $j++){
    $tc_txt = $test_items[$j];
    $sql_one_gp = "SELECT DISTINCT `Groups` FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Testitems='$tc_txt' ";
    $gp_info = mysqli_query($con,$sql_one_gp);
    $gp_one = mysqli_fetch_array($gp_info,MYSQLI_BOTH)[0];
    array_push($groups,$gp_one);
}//获取某次测试的Group

$total_rows = $tc_num+3;    //从第三行开始写写入测试记录, 1,2行是标题栏
for($row_no=3; $row_no<$total_rows; $row_no++){
    $tc_txt = $test_items[$row_no-3];
    $gp_txt = $groups[$row_no-3];
    //echo $tc_txt."<br>";
    $sql_one_row = "SELECT DISTINCT `Groups`,Testitems,Testcondition,RCCA,Teststatus,Startday,Endday,Requests,Failinfo,Remarks,FAA ";
    $sql_one_row .="FROM DQA_Test_Main WHERE Testitems='$tc_txt' AND Testername='$tester' AND Products='$product' AND Timedt='$starting' ";
    $row_one_check = mysqli_query($con,$sql_one_row);
    $row = mysqli_fetch_array($row_one_check,MYSQLI_BOTH);

    //获取一行的测试结果
    $sql_each_result = "SELECT Results from DQA_Test_Main WHERE Testitems='$tc_txt' AND Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Units!='' ";
    $results_array = array();

    //A-D列为固定内容Requests,Groups,Testitems,Testcondition
    $objSheet->setCellValue("A".$row_no,$row["Requests"])->getStyle("A".$row_no)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("ccffcc");
    $objSheet->setCellValue("B".$row_no,$row["Groups"])->setCellValue("C".$row_no,$row["Testitems"])->setCellValue("D".$row_no,$row["Testcondition"]);
    $objSheet->getStyle("C".$row_no.":"."D".$row_no)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);    //设置C,D,E三列文本左对齐
    
    //Test order A,B,C......
    for($ii=0; $ii<$qty; $ii++){
        $no = $ii+1;    //Unit NO.(1,2,3,.....n)
        $check = mysqli_query($con,"SELECT Units,RecordID,Unitsno,Temp FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt='$starting' AND Unitsno='$no' And `Groups`='$gp_txt' And Testitems='$tc_txt' ");
        while($info=mysqli_fetch_array($check,MYSQLI_BOTH)){
            $cell_no = PHPExcel_Cell::stringFromColumnIndex($ii+4);    //从第五列开始
            $temp = $info[3];    //Cold，Hot or Room

            //Cold就設置order為藍色,Room就設置order為綠色,Hot就設置order為紅色
            switch ($temp) {
                case 'Cold':
                    $objSheet->getStyle($cell_no.$row_no)->getFont()->getColor()->setRGB("1565c0");
                    break;
                case 'Room':
                    $objSheet->getStyle($cell_no.$row_no)->getFont()->getColor()->setRGB("0aa344");
                    break;
                case 'Hot':
                    $objSheet->getStyle($cell_no.$row_no)->getFont()->getColor()->setRGB("cc2229");
                    break;
                
                default:
                    break;
            }
            //Test order写入Excel
            $objSheet->setCellValue($cell_no.$row_no,$info[0]);
        }
    }//end for
    $objSheet->setCellValue($start_col.$row_no,$row["Startday"])->setCellValue($end_col.$row_no,$row["Endday"]);//start and finish
    //status
    //$sql_status = "SELECT DISTINCT Teststatus from DQA_Test_Main WHERE Testitems='$tc_txt' AND Products='$product' AND Testername='$tester' AND Timedt='$starting' ";
    //$res_status = mysqli_query($con,$sql_status);
    //$status = mysqli_fetch_array($res_status,MYSQLI_NUM)[0];
    //$objSheet->setCellValue($status_col.$row_no,$status);
    $one_row_result = mysqli_query($con, $sql_each_result);
    while($info = mysqli_fetch_array($one_row_result,MYSQLI_BOTH)){
        array_push($results_array,$info[0]);
    }
    $len_results = count($results_array);
    $status = "";
    $num = 0;
    for($bb=0; $bb<$len_results; $bb++){
        if($results_array[$bb]=="TBD"){
            $num++;
            if($num == $len_results){
                $status = "Not start";
            }
            else if($num>0 && $num<$len_results){
                $status = "In progress";
            }
        }
    }
    if(!in_array("TBD",$results_array)){
        $status = "Complete";
    }
    $objSheet->setCellValue($status_col.$row_no,$status);

    /**
     * 20220511 TBD>EC fail> fail> Known fail(open)> Known fail(closed) MD不早说,老子又得改还几个文件
     */
    /*
    $one_row_result = "";
    for($k=0; $k<$len_result_one_row;$k++){
        if($result_one_row[$k]=="Pass"){
            $one_row_result = "Pass";
        }
    }
    if(in_array("Fail",$result_one_row)){
        $one_row_result = "Fail";
    }
    elseif(in_array("Known Fail (Open)",$result_one_row)){
        $one_row_result = "Known Fail (Open)";
    }
    elseif(in_array("Known Fail (Close)",$result_one_row)){
        $one_row_result = "Known Fail (Close)";
    }
    elseif(in_array("EC Fail",$result_one_row)){
        $one_row_result = "EC Fail";
    }*/
    $row_result = "TBD";
    $num1 = 0;
    for($k=0; $k<$len_results;$k++){
        //echo $result_one_row[$k];                   
        if($results_array[$k]=="Pass"){
            $num1++;
            if($num1 == $len_results){
                $row_result = "Pass";
            }
        }
        else if(in_array("TBD",$results_array)){
            $row_result = "TBD";
        }
        else if(in_array("EC Fail",$results_array)){
            $row_result = "EC Fail";
        }
        else if(in_array("Fail",$results_array)){
            $row_result = "Fail";
        }
        else if(in_array("Known Fail (Open)",$results_array)){
            $row_result = "Known Fail (Open)";
        }
        else if(in_array("Known Fail (Close)",$results_array)){
            $row_result = "Known Fail (Close)";
        }
    }
    $objSheet->setCellValue($test_res_col.$row_no,$row_result);

    //Fail symptom,FA,Remark
    $objSheet->setCellValue($fail_col.$row_no,$row["Failinfo"])->setCellValue($fa_col.$row_no,$row["FAA"])->setCellValue($remark_col.$row_no,$row["Remarks"]);
}
$objSheet->getStyle("A3:".$remark_col.($total_rows-1))->applyFromArray($styleThinBlackBorderOutline);//数据部门添加边框

/**
 * 下载文件到电脑下载目录
 */
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
browser_excel($type,$filename);
$objWriter->save("php://output");   //下载文件

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