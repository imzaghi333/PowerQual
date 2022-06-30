<?php
/* ******************************************
                   _ooOoo_
                  o8888888o
                  88" . "88
                  (| -_- |)
                  O\  =  /O
               ____/`---'\____
             .'  \\|     |//  `.
            /  \\|||  :  |||//  \
           /  _||||| -:- |||||-  \
           |   | \\\  -  /// |   |
           | \_|  ''\---/''  |   |
           \  .-\__  `-`  ___/-. /
         ___`. .'  /--.--\  `. . __
      ."" '<  `.___\_<|>_/___.'  >'"".
     | | :  `- \`.;`\ _ /`;.`/ - ` : | |
     \  \ `-.   \_ __\ /__ _/   .-` /  /
======`-.____`-.___\_____/___.-`____.-'======
                   `=---='
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
           佛祖保佑        永无BUG
****************************************** */

require_once "../js/conf.php";
require_once "./functions.php";
require_once "../Classes/PHPExcel.php";
require_once "../Classes/PHPExcel/IOFactory.php";

$today = date("Y/n/j");   //日期显示2022/3/3 2022/10/1格式
mysqli_query($con, "UPDATE DQA_Test_Main SET Today='$today'");//更新DQA_Test_Main数据表为导出数据当天日期
mysqli_query($con, "UPDATE fail_infomation SET Today='$today'");//更新fail_infomation数据表为导出数据当天日期

$current_date = date("Ymd");    //作为Excel文件名的一部分
$type = "Excel5";    //输出xlsx扩展名, Excel5输出xls扩展名
$filename = "QTP Raw Data record format_V4_".$current_date.".xls";//导出的文件名

/**
 * Duration
 * if result=='pass':
 *     Duration='NA'
 * elif issue_status=='Closed':
 *     Duration=NextCheckPointDate-ReportedDate
 * else:
 *     Duration=Today-ReportedDate
*/
mysqli_query($con, "UPDATE DQA_Test_Main SET Testdays=DATEDIFF(Endday,Startday) WHERE Startday!='' AND Endday!='' ");    //计算测试完成的时间
mysqli_query($con, "UPDATE fail_infomation SET IssueDuration=DATEDIFF(NextCheckpointDate,ReportedDate) WHERE Issuestatus='Closed' AND NextCheckpointDate!='' AND ReportedDate!='' ");
mysqli_query($con, "UPDATE fail_infomation SET IssueDuration=DATEDIFF(Today,ReportedDate) WHERE Issuestatus!='Closed' AND Issuestatus!='' AND ReportedDate!='' ");

/**
 * 导出数据：1.选取了时间段,导出某段时间内数据 2.未选时间段导出数据库中所有数据
*/
if(isset($_POST["to_excel"]) && $_POST["to_excel"]=="to_excel_do"){
    $start = $_POST["from"];//开始日期
    $end = $_POST["to"];//结束日期

    /**
     * 选取了时间段导出数据
    */
    if($start && $end){
        //$sql_data = "SELECT * FROM DQA_Test_Main WHERE Timedt>='$start' and Timedt<='$end'";
        $arr_product = getDistinctProductByPeriod($con,$start,$end);
        array_unshift($arr_product,"Raw All -C");//插入到数组第一个位置即$arr_product[0]
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
            //$data = getDataByProductAndPeriod($con,$arr_product[$loop],$start,$end);
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array( //设置全部边框
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
        
                ),
            );    //边框格式
            
            //第一行, 即标题行
            $objSheet->getStyle('A1:AH1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");
            $objSheet->getStyle('AI1:AN1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("548235");
            $objSheet->getStyle('AO1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");
            $objSheet->getStyle('A1:AO1')->getFont()->getColor()->setRGB("ffffff");
            $objSheet->freezePane('A2');//冻结首行

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

            if($loop==0){
                $data_all_period = getRawAllCommByPeriod($con,$start,$end);
                $row=2;
                foreach($data_all_period as $key=>$val){
                    switch ($val[18]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }
                    switch ($val[36]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }

                    $mm = "";
                    if(substr($val[6],0,1)==0){
                        $mm = removeZeroPrefix($val[6]);
                    }
                    else{
                        $mm = $val[6];
                    }
                    //设置test status $val[16]
                    $test_status = "";
                    if($val[16]=="" || $val[16]=="Not start"){
                        $test_status = "Not start";
                    }
                    if($val[16]=="Complete"){
                        $test_status = "Complete";
                    }
                    if($val[16]=="In progress"){
                        $test_status = "In progress";
                    }

                    //非Pass的结果单独处理 $val[17]
                    $rr = "";
                    if($val[17]=="Pass" || $val[17]=="TBD"){
                        $rr = $val[17];
                    }
                    else{
                        $rr = $val[48];
                    }

                    //非Pass的TEMP单独处理
                    $temp = $val[18];
                    if($val[18]=="-"){
                        $temp = "";
                    }
                    if($val[48]){
                        $temp = $val[36];
                    }
                    /*
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val["Products"])->setCellValue("D".$row,$val["SKUS"])->setCellValue("E".$row,$val["Years"])->setCellValue("F".$row,$val["Months"])->setCellValue("G".$row,$val["Phases"]);
                    $objSheet->setCellValue("H".$row,$val["SN"])->setCellValue("I".$row,$val["Unitsno"])->setCellValue("J".$row,$val["Groups"])->setCellValue("K".$row,$val["Testitems"])->setCellValue("L".$row,$val["Testcondition"])->setCellValue("M".$row,$val["Startday"])->setCellValue("N".$row,$val["Endday"]);
                    $objSheet->setCellValue("O".$row,$val["Testdays"])->setCellValue("P".$row,$val["Defectmode1"])->setCellValue("Q".$row,$val["Defectmode2"])->setCellValue("R".$row,$val["RCCA"])->setCellValue("S".$row,$val["Teststatus"])->setCellValue("T".$row,$val["Results"])->setCellValue("U".$row,$val["Issuestatus"]);
                    $objSheet->setCellValue("V".$row,$val["Category"])->setCellValue("W".$row,$val["PIC"])->setCellValue("X".$row,$val["JIRANO"])->setCellValue("Y".$row,$val["SPR"])->setCellValue("Z".$row,$val["Temp"])->setCellValue("AA".$row,$val["Dropcycles"])->setCellValue("AB".$row,$val["Drops"])->setCellValue("AC".$row,$val["Dropside"]);
                    $objSheet->setCellValue("AD".$row,$val["Hit"])->setCellValue("AE".$row,$val["Boot"])->setCellValue("AF".$row,$val["Testlab"])->setCellValue("AG".$row,$val["Mfgsite"])->setCellValue("AH".$row,$val["Testername"])->setCellValue("AI".$row,$val["NextCheckpointDate"])->setCellValue("AJ".$row,$val["IssuePublished"]);
                    $objSheet->setCellValue("AK".$row,$val["ORTMFGDate"])->setCellValue("AL".$row,$val["ReportedDate"])->setCellValue("AM".$row,$val["IssueDuration"])->setCellValue("AN".$row,$val["Today"])->setCellValue("AO".$row,$val["Remarks"]);
                    */
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val[3])->setCellValue("D".$row,$val[4])->setCellValue("E".$row,$val[5])->setCellValue("F".$row,$mm)->setCellValue("G".$row,$val[7]);
                    $objSheet->setCellValue("H".$row,$val[8])->setCellValue("I".$row,$val[26])->setCellValue("J".$row,$val[10])->setCellValue("K".$row,$val[11])->setCellValue("L".$row,$val[12])->setCellValue("M".$row,changeDatesFormatBlack($val[13]))->setCellValue("N".$row,changeDatesFormatBlack($val[14]));
                    $objSheet->setCellValue("O".$row,$val[15])->setCellValue("P".$row,$val[28])->setCellValue("Q".$row,$val[29])->setCellValue("R".$row,$val[30])->setCellValue("S".$row,$test_status)->setCellValue("T".$row,$rr)->setCellValue("U".$row,$val[31]);
                    $objSheet->setCellValue("V".$row,$val[32])->setCellValue("W".$row,$val[33])->setCellValue("X".$row,$val[34])->setCellValue("Y".$row,$val[35])->setCellValue("Z".$row,$temp)->setCellValue("AA".$row,$val[37])->setCellValue("AB".$row,$val[38])->setCellValue("AC".$row,$val[39]);
                    $objSheet->setCellValue("AD".$row,$val[40])->setCellValue("AE".$row,$val[19])->setCellValue("AF".$row,$val[20])->setCellValue("AG".$row,$val[21])->setCellValue("AH".$row,$val[22])->setCellValue("AI".$row,changeDatesFormatGreen($val[41]))->setCellValue("AJ".$row,$val[42]);
                    $objSheet->setCellValue("AK".$row,changeDatesFormatGreen($val[49]))->setCellValue("AL".$row,changeDatesFormatGreen($val[44]))->setCellValue("AM".$row,$val[45])->setCellValue("AN".$row,$val[23])->setCellValue("AO".$row,$val[24]);
                    $row++;
                    $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);
                }
            }
            else{
                $data_period = getDataByProductAndPeriod($con,$arr_product[$loop],$start,$end);
                $row=2;
                foreach($data_period as $key=>$val){
                    switch ($val[18]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }
                    switch ($val[36]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }

                    $mm = "";
                    if(substr($val[6],0,1)==0){
                        $mm = removeZeroPrefix($val[6]);
                    }
                    else{
                        $mm = $val[6];
                    }
                    //设置test status $val[16]
                    $test_status = "";
                    if($val[16]=="" || $val[16]=="Not start"){
                        $test_status = "Not start";
                    }
                    if($val[16]=="Complete"){
                        $test_status = "Complete";
                    }
                    if($val[16]=="In progress"){
                        $test_status = "In progress";
                    }

                    //非Pass的结果单独处理 $val[17]
                    $rr = "";
                    if($val[17]=="Pass" || $val[17]=="TBD"){
                        $rr = $val[17];
                    }
                    else{
                        $rr = $val[48];
                    }

                    //非Pass的TEMP单独处理
                    $temp = $val[18];
                    if($val[18]=="-"){
                        $temp = "";
                    }
                    if($val[48]){
                        $temp = $val[36];
                    }
                    /*
                    $objSheet->setCellValue("A".$row,$val["Stages"])->setCellValue("B".$row,$val["VT"])->setCellValue("C".$row,$val["Products"])->setCellValue("D".$row,$val["SKUS"])->setCellValue("E".$row,$val["Years"])->setCellValue("F".$row,$val["Months"])->setCellValue("G".$row,$val["Phases"]);
                    $objSheet->setCellValue("H".$row,$val["SN"])->setCellValue("I".$row,$val["Unitsno"])->setCellValue("J".$row,$val["Groups"])->setCellValue("K".$row,$val["Testitems"])->setCellValue("L".$row,$val["Testcondition"])->setCellValue("M".$row,$val["Startday"])->setCellValue("N".$row,$val["Endday"]);
                    $objSheet->setCellValue("O".$row,$val["Testdays"])->setCellValue("P".$row,$val["Defectmode1"])->setCellValue("Q".$row,$val["Defectmode2"])->setCellValue("R".$row,$val["RCCA"])->setCellValue("S".$row,$val["Teststatus"])->setCellValue("T".$row,$val["Results"])->setCellValue("U".$row,$val["Issuestatus"]);
                    $objSheet->setCellValue("V".$row,$val["Category"])->setCellValue("W".$row,$val["PIC"])->setCellValue("X".$row,$val["JIRANO"])->setCellValue("Y".$row,$val["SPR"])->setCellValue("Z".$row,$val["Temp"])->setCellValue("AA".$row,$val["Dropcycles"])->setCellValue("AB".$row,$val["Drops"])->setCellValue("AC".$row,$val["Dropside"]);
                    $objSheet->setCellValue("AD".$row,$val["Hit"])->setCellValue("AE".$row,$val["Boot"])->setCellValue("AF".$row,$val["Testlab"])->setCellValue("AG".$row,$val["Mfgsite"])->setCellValue("AH".$row,$val["Testername"])->setCellValue("AI".$row,$val["NextCheckpointDate"])->setCellValue("AJ".$row,$val["IssuePublished"]);
                    $objSheet->setCellValue("AK".$row,$val["ORTMFGDate"])->setCellValue("AL".$row,$val["ReportedDate"])->setCellValue("AM".$row,$val["IssueDuration"])->setCellValue("AN".$row,$val["Today"])->setCellValue("AO".$row,$val["Remarks"]);
                    */
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val[3])->setCellValue("D".$row,$val[4])->setCellValue("E".$row,$val[5])->setCellValue("F".$row,$mm)->setCellValue("G".$row,$val[7]);
                    $objSheet->setCellValue("H".$row,$val[8])->setCellValue("I".$row,$val[26])->setCellValue("J".$row,$val[10])->setCellValue("K".$row,$val[11])->setCellValue("L".$row,$val[12])->setCellValue("M".$row,changeDatesFormatBlack($val[13]))->setCellValue("N".$row,changeDatesFormatBlack($val[14]));
                    $objSheet->setCellValue("O".$row,$val[15])->setCellValue("P".$row,$val[28])->setCellValue("Q".$row,$val[29])->setCellValue("R".$row,$val[30])->setCellValue("S".$row,$test_status)->setCellValue("T".$row,$rr)->setCellValue("U".$row,$val[31]);
                    $objSheet->setCellValue("V".$row,$val[32])->setCellValue("W".$row,$val[33])->setCellValue("X".$row,$val[34])->setCellValue("Y".$row,$val[35])->setCellValue("Z".$row,$temp)->setCellValue("AA".$row,$val[37])->setCellValue("AB".$row,$val[38])->setCellValue("AC".$row,$val[39]);
                    $objSheet->setCellValue("AD".$row,$val[40])->setCellValue("AE".$row,$val[19])->setCellValue("AF".$row,$val[20])->setCellValue("AG".$row,$val[21])->setCellValue("AH".$row,$val[22])->setCellValue("AI".$row,changeDatesFormatGreen($val[41]))->setCellValue("AJ".$row,$val[42]);
                    $objSheet->setCellValue("AK".$row,changeDatesFormatGreen($val[49]))->setCellValue("AL".$row,changeDatesFormatGreen($val[44]))->setCellValue("AM".$row,$val[45])->setCellValue("AN".$row,$val[23])->setCellValue("AO".$row,$val[24]);
                    $row++;
                    $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);
                }
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
        //$objWriter->save("Demo.xlsx");    //保存文件到服务器当前目录
        browser_excel($type,$filename);
        $objWriter->save("php://output");   //下载到本地目录
    }//按时间段导出数据结束

    /* 导出全部数据,即默认导出方式

                    .::::.
                  .::::::::.
                 :::::::::::  We'll going to Yosemitte National Park
             ..:::::::::::'
           '::::::::::::'
             .::::::::::
        '::::::::::::::..
             ..::::::::::::.
           ``::::::::::::::::
            ::::``:::::::::'        .:::.
           ::::'   ':::::'       .::::::::.
         .::::'      ::::     .:::::::'::::.
        .:::'       :::::  .:::::::::' ':::::.
       .::'        :::::.:::::::::'      ':::::.
      .::'         ::::::::::::::'         ``::::.
   ...:::           ::::::::::::'              ``::.
 ```` ':.          ':::::::::'                  ::::..
                    '.:::::'                    ':'````..

    **************************************************************************

    */
    else{
        $arr_product = getDistinctProduct($con);
        array_unshift($arr_product,"Raw All -C");
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
            //$data = getDataByProduct($con,$arr_product[$loop]);
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'allborders' => array( //设置全部边框
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
        
                ),
            );    //边框格式
            
            //第一行背景色,第一行字体颜色
            $objSheet->getStyle('A1:AH1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");
            $objSheet->getStyle('AI1:AN1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("548235");
            $objSheet->getStyle('AO1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("000020");
            $objSheet->getStyle('A1:AO1')->getFont()->getColor()->setRGB("ffffff");
            $objSheet->freezePane('A2');//冻结首行
            //第一行内容, 即标题行内容,第一行内容固定
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
            // 第一行标题部分结束
            
            /**
             * 第一张sheet是所有的Data,Raw All -C
            */
            if($loop==0){
                $data_raw_all = getRawAllComm($con);
                $row=2;//从第二行开始写入内容
                foreach($data_raw_all as $key=>$val){
                    //Temperature的设定
                    switch ($val[18]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }
                    switch ($val[36]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }

                    //F列月份去掉前缀0
                    $mm = "";
                    if(substr($val[6],0,1)==0){
                        $mm = removeZeroPrefix($val[6]);
                    }
                    else{
                        $mm = $val[6];
                    }

                    //设置test status $val[16]
                    $test_status = "";
                    if($val[16]=="" || $val[16]=="Not start"){
                        $test_status = "Not start";
                    }
                    if($val[16]=="Complete"){
                        $test_status = "Complete";
                    }
                    if($val[16]=="In progress"){
                        $test_status = "In progress";
                    }

                    //非Pass的结果单独处理 $val[17]
                    $rr = "";
                    if($val[17]=="Pass" || $val[17]=="TBD"){
                        $rr = $val[17];
                    }
                    else{
                        $rr = $val[48];
                    }

                    //非Pass的TEMP单独处理
                    $temp = $val[18];
                    if($val[18]=="-"){
                        $temp = "";
                    }
                    if($val[48]){
                        $temp = $val[36];
                    }
                    /*
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val[3])->setCellValue("D".$row,$val[4])->setCellValue("E".$row,$val[5])->setCellValue("F".$row,$val[6])->setCellValue("G".$row,$val[7]);
                    $objSheet->setCellValue("H".$row,$val[8])->setCellValue("I".$row,$val[26])->setCellValue("J".$row,$val[10])->setCellValue("K".$row,$val[11])->setCellValue("L".$row,$val[12])->setCellValue("M".$row,$val[13])->setCellValue("N".$row,$val[14]);
                    $objSheet->setCellValue("O".$row,$val[15])->setCellValue("P".$row,$val[28])->setCellValue("Q".$row,$val[29])->setCellValue("R".$row,$val[30])->setCellValue("S".$row,$val[16])->setCellValue("T".$row,$val[17])->setCellValue("U".$row,$val[31]);
                    $objSheet->setCellValue("V".$row,$val[32])->setCellValue("W".$row,$val[33])->setCellValue("X".$row,$val[34])->setCellValue("Y".$row,$val[35])->setCellValue("Z".$row,$val[18])->setCellValue("AA".$row,$val[37])->setCellValue("AB".$row,$val[38])->setCellValue("AC".$row,$val[39]);
                    $objSheet->setCellValue("AD".$row,$val[40])->setCellValue("AE".$row,$val[19])->setCellValue("AF".$row,$val[20])->setCellValue("AG".$row,$val[21])->setCellValue("AH".$row,$val[22])->setCellValue("AI".$row,$val[41])->setCellValue("AJ".$row,$val[42]);
                    $objSheet->setCellValue("AK".$row,$val[43])->setCellValue("AL".$row,$val[44])->setCellValue("AM".$row,$val[45])->setCellValue("AN".$row,$val[23])->setCellValue("AO".$row,$val[24]);
                    */
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val[3])->setCellValue("D".$row,$val[4])->setCellValue("E".$row,$val[5])->setCellValue("F".$row,$mm)->setCellValue("G".$row,$val[7]);
                    $objSheet->setCellValue("H".$row,$val[8])->setCellValue("I".$row,$val[26])->setCellValue("J".$row,$val[10])->setCellValue("K".$row,$val[11])->setCellValue("L".$row,$val[12])->setCellValue("M".$row,changeDatesFormatBlack($val[13]))->setCellValue("N".$row,changeDatesFormatBlack($val[14]));
                    $objSheet->setCellValue("O".$row,$val[15])->setCellValue("P".$row,$val[28])->setCellValue("Q".$row,$val[29])->setCellValue("R".$row,$val[30])->setCellValue("S".$row,$test_status)->setCellValue("T".$row,$rr)->setCellValue("U".$row,$val[31]);
                    $objSheet->setCellValue("V".$row,$val[32])->setCellValue("W".$row,$val[33])->setCellValue("X".$row,$val[34])->setCellValue("Y".$row,$val[35])->setCellValue("Z".$row,$temp)->setCellValue("AA".$row,$val[37])->setCellValue("AB".$row,$val[38])->setCellValue("AC".$row,$val[39]);
                    $objSheet->setCellValue("AD".$row,$val[40])->setCellValue("AE".$row,$val[19])->setCellValue("AF".$row,$val[20])->setCellValue("AG".$row,$val[21])->setCellValue("AH".$row,$val[22])->setCellValue("AI".$row,changeDatesFormatGreen($val[41]))->setCellValue("AJ".$row,$val[42]);
                    $objSheet->setCellValue("AK".$row,changeDatesFormatGreen($val[49]))->setCellValue("AL".$row,changeDatesFormatGreen($val[44]))->setCellValue("AM".$row,$val[45])->setCellValue("AN".$row,$val[23])->setCellValue("AO".$row,$val[24]);
                    $row++;
                    $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);//加上边框
                }
            }//第一张sheet Raw All-C结束
            
            /**
             * 按不同的product分车给多个sheet
            */
            else{
                $data = getDataByProduct($con,$arr_product[$loop]);
                $row=2;
                foreach($data as $key=>$val){
                    //Temperature的设定
                    switch ($val[18]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }
                    switch ($val[36]) {
                        case '-':
                            $objSheet->setCellValue("Z".$row,"");
                            break;
                        case 'Cold':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("1565c0");
                            break;
                        case 'Hot':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("cc2229");
                            break;
                        case 'Room':
                            $objSheet->getStyle("Z".$row)->getFont()->getColor()->setRGB("0aa344");
                        
                        default:
                            # code...
                            break;
                    }

                    $mm = "";
                    if(substr($val[6],0,1)==0){
                        $mm = removeZeroPrefix($val[6]);
                    }
                    else{
                        $mm = $val[6];
                    }
                    //设置test status $val[16]
                    $test_status = "";
                    if($val[16]=="" || $val[16]=="Not start"){
                        $test_status = "Not start";
                    }
                    if($val[16]=="Complete"){
                        $test_status = "Complete";
                    }
                    if($val[16]=="In progress"){
                        $test_status = "In progress";
                    }

                    //非Pass的结果单独处理 $val[17]
                    $rr = "";
                    if($val[17]=="Pass" || $val[17]=="TBD"){
                        $rr = $val[17];
                    }
                    else{
                        $rr = $val[48];
                    }

                    //非Pass的TEMP单独处理
                    $temp = $val[18];
                    if($val[18]=="-"){
                        $temp = "";
                    }
                    if($val[48]){
                        $temp = $val[36];
                    }
                    /*
                    $objSheet->setCellValue("A".$row,$val["Stages"])->setCellValue("B".$row,$val["VT"])->setCellValue("C".$row,$val["Products"])->setCellValue("D".$row,$val["SKUS"])->setCellValue("E".$row,$val["Years"])->setCellValue("F".$row,$val["Months"])->setCellValue("G".$row,$val["Phases"]);
                    $objSheet->setCellValue("H".$row,$val["SN"])->setCellValue("I".$row,$val["Unitsno"])->setCellValue("J".$row,$val["Groups"])->setCellValue("K".$row,$val["Testitems"])->setCellValue("L".$row,$val["Testcondition"])->setCellValue("M".$row,$val["Startday"])->setCellValue("N".$row,$val["Endday"]);
                    $objSheet->setCellValue("O".$row,$val["Testdays"])->setCellValue("P".$row,$val["Defectmode1"])->setCellValue("Q".$row,$val["Defectmode2"])->setCellValue("R".$row,$val["RCCA"])->setCellValue("S".$row,$val["Teststatus"])->setCellValue("T".$row,$val["Results"])->setCellValue("U".$row,$val["Issuestatus"]);
                    $objSheet->setCellValue("V".$row,$val["Category"])->setCellValue("W".$row,$val["PIC"])->setCellValue("X".$row,$val["JIRANO"])->setCellValue("Y".$row,$val["SPR"])->setCellValue("Z".$row,$val["Temp"])->setCellValue("AA".$row,$val["Dropcycles"])->setCellValue("AB".$row,$val["Drops"])->setCellValue("AC".$row,$val["Dropside"]);
                    $objSheet->setCellValue("AD".$row,$val["Hit"])->setCellValue("AE".$row,$val["Boot"])->setCellValue("AF".$row,$val["Testlab"])->setCellValue("AG".$row,$val["Mfgsite"])->setCellValue("AH".$row,$val["Testername"])->setCellValue("AI".$row,$val["NextCheckpointDate"])->setCellValue("AJ".$row,$val["IssuePublished"]);
                    $objSheet->setCellValue("AK".$row,$val["ORTMFGDate"])->setCellValue("AL".$row,$val["ReportedDate"])->setCellValue("AM".$row,$val["IssueDuration"])->setCellValue("AN".$row,$val["Today"])->setCellValue("AO".$row,$val["Remarks"]);
                    */
                    $objSheet->setCellValue("A".$row,$val[1])->setCellValue("B".$row,$val[2])->setCellValue("C".$row,$val[3])->setCellValue("D".$row,$val[4])->setCellValue("E".$row,$val[5])->setCellValue("F".$row,$mm)->setCellValue("G".$row,$val[7]);
                    $objSheet->setCellValue("H".$row,$val[8])->setCellValue("I".$row,$val[26])->setCellValue("J".$row,$val[10])->setCellValue("K".$row,$val[11])->setCellValue("L".$row,$val[12])->setCellValue("M".$row,changeDatesFormatBlack($val[13]))->setCellValue("N".$row,changeDatesFormatBlack($val[14]));
                    $objSheet->setCellValue("O".$row,$val[15])->setCellValue("P".$row,$val[28])->setCellValue("Q".$row,$val[29])->setCellValue("R".$row,$val[30])->setCellValue("S".$row,$test_status)->setCellValue("T".$row,$rr)->setCellValue("U".$row,$val[31]);
                    $objSheet->setCellValue("V".$row,$val[32])->setCellValue("W".$row,$val[33])->setCellValue("X".$row,$val[34])->setCellValue("Y".$row,$val[35])->setCellValue("Z".$row,$temp)->setCellValue("AA".$row,$val[37])->setCellValue("AB".$row,$val[38])->setCellValue("AC".$row,$val[39]);
                    $objSheet->setCellValue("AD".$row,$val[40])->setCellValue("AE".$row,$val[19])->setCellValue("AF".$row,$val[20])->setCellValue("AG".$row,$val[21])->setCellValue("AH".$row,$val[22])->setCellValue("AI".$row,changeDatesFormatGreen($val[41]))->setCellValue("AJ".$row,$val[42]);
                    $objSheet->setCellValue("AK".$row,changeDatesFormatGreen($val[49]))->setCellValue("AL".$row,changeDatesFormatGreen($val[44]))->setCellValue("AM".$row,$val[45])->setCellValue("AN".$row,$val[23])->setCellValue("AO".$row,$val[24]);
                    $row++;
                    $objSheet->getStyle('A2:AO'.($row-1))->applyFromArray($styleThinBlackBorderOutline);//加上边框
                }
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel5");
        browser_excel($type,$filename);
        $objWriter->save("php://output");   //下载文件
    }
    //导出全部数据结束
}
?>