<?php
require_once("./js/conf.php");
header("Content-Type:text/html;charset=UTF-8");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");

if(isset($_POST["matrix_edit"]) && $_POST["matrix_edit"]=="matrix_edit_do" ){
    // =========== 以下内容就是New Test页面用户填写的 ========
    $stage     = $_POST["stage"];
    $vt        = $_POST["vt"];
    $pr_name   = $_POST["pr_name"];
    $sku       = $_POST["sku"];
    $year      = $_POST["year"];
    $month     = $_POST["month"];
    $phase     = $_POST["phase"];
    $testlab   = $_POST["testlab"];
    $mfgsite   = $_POST["mfgsite"];
    $tester    = $_POST["tester"];
    $timedt    = $_POST["timedt"];
    $title     = $_POST["title"];
    $pre_id    = $_POST["record_id"];    //原来的RecordID   
    
    // ---- modified on 2022-01-25
    $number       = $_POST["number"];        //测试机数量
    $arr_requests = $_POST["requests"];      //Yes,No,N/A  
    $arr_group    = $_POST["group"];         //Group A,Group B,Group B,......
    $arr_test     = $_POST["test_item"];     //Test Items,不可以重复
    //$arr_terminal = $_POST["terminal"];      //我也不清楚DQA想写什么玩意 canceled on 2022-03-11
    $arr_condition= $_POST["conditions"];    //Test condition
    $order        = $_POST["test_order"];    //A,B,C,D......Z
    $arr_start    = $_POST["starting"];      //开始日期
    $arr_end      = $_POST["ending"];        //结束日期
    $arr_status   = $_POST["status"];        //complete, ongoing.....
    $arr_fail     = $_POST["fail"];          //fail sympton
    $arr_fa       = $_POST["rcca"];          //FA
    $arr_remark   = $_POST["remarks"];       //备注，不清楚DQA想写什么玩意
    $arr_result   = $_POST["subject18"];     //default is PASS
      
    //有相同Test item结束
    if(count($arr_test)!=count(array_unique($arr_test))){
        echo "<script>window.alert('有相同的Test Item!~點擊返回');history.back();</script>";
        exit();
    }
    // ---- modified on 2022-01-25 for fail text
    $arr_fail1  = $_POST["subject1"];      //Defect Mode(Symptom)
    $arr_fail2  = $_POST["subject2"];      //Defect Mode(Symptom+Finding)
    $arr_fail3  = $_POST["subject3"];      //RCCA
    $arr_fail4  = $_POST["subject4"];      //Issuestatus
    $arr_fail5  = $_POST["subject5"];      //Category
    $arr_fail6  = $_POST["subject6"];      //PIC
    $arr_fail7  = $_POST["subject7"];      //JIRA
    $arr_fail8  = $_POST["subject8"];      //SPR
    $arr_fail9 = $_POST["subject9"];       //TEMP
    $arr_fail10 = $_POST["subject10"];     //Dropcycles
    $arr_fail11 = $_POST["subject11"];     //Drops
    $arr_fail12 = $_POST["subject12"];     //Dropside
    $arr_fail13 = $_POST["subject13"];     //Hit
    $arr_fail14 = $_POST["subject14"];     //NextCheckpointDate
    $arr_fail15 = $_POST["subject15"];     //IssuePublished
    $arr_fail16 = $_POST["subject16"];     //ORTMFGDate
    $arr_fail17 = $_POST["subject17"];     //ReportedDate
    $arr_sn     = $_POST["sn"];            //机台SN                   

    // ----------- Units需要转成二维数组 -----------
    $len_order = count($order);
    $arr_order = array();
    for($loop=0; $loop<$len_order; $loop++){
        if($order[$loop]=="请选择" || $order[$loop]==" " || $order[$loop]==""){
            $arr_order[$loop] = ' ';
        }
        else{
            array_push($arr_order,strtoupper($order[$loop])); //用户写入的test order转成大写字符
        }
    }

    //转置test order
    $arr_order_tmp1 = array_chunk($arr_order,$number);
    $len1 = count($arr_order_tmp1);
    $len2 = count($arr_order_tmp1[0]);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_order_tmp2[$j][$i] = $arr_order_tmp1[$i][$j];    //转置后安装unit1,2,3...顺序排列
        }
    }

    //转置RecordID 2022-03-31修改
    $arr_id_tmp1 = array_chunk($pre_id,$number);
    $len_id_tmp1 = count($arr_id_tmp1);
    $len_id_tmp2 = count($arr_id_tmp1[0]);
    for($i=0; $i<$len_id_tmp1; $i++){
        for($j=0; $j<$len_id_tmp2; $j++){
            $arr_id_tmp2[$j][$i] = $arr_id_tmp1[$i][$j];
        }
    }
    //echo "<pre>";
    //print_r($arr_id_tmp2);
    //echo "--------------------------<br>";
    //print_r($arr_order_tmp2);

    //转置test result
    $arr_result_tmp1 = array_chunk($arr_result,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_result_tmp2[$j][$i] = $arr_result_tmp1[$i][$j];
        }
    }
    
    //转置User填写的fail information, total 17 items currently
    //1. Subject1	$row_result2	Defectmode1(Symbol)
    $arr_fail1_tmp = array_chunk($arr_fail1,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_df1[$j][$i] = $arr_fail1_tmp[$i][$j];
        }
    }
    //2. Subject2	$row_result3	Defectmode1(Symbol+Findings)
    $arr_fail2_tmp = array_chunk($arr_fail2,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_df2[$j][$i] = $arr_fail2_tmp[$i][$j];
        }
    }
    //3. Subject3	$row_result4	RCCA
    $arr_fail3_tmp = array_chunk($arr_fail3,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_rcca[$j][$i] = $arr_fail3_tmp[$i][$j];
        }
    }
    //4. Subject4	$row_result6	Issuestatus
    $arr_fail4_tmp = array_chunk($arr_fail4,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_issue_status[$j][$i] = $arr_fail4_tmp[$i][$j];
        }
    }
    //5. Subject5	$row_result7	Category
    $arr_fail5_tmp = array_chunk($arr_fail5,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_category[$j][$i] = $arr_fail5_tmp[$i][$j];
        }
    }
    //6. Subject6	$row_result8	PIC
    $arr_fail6_tmp = array_chunk($arr_fail6,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_pic[$j][$i] = $arr_fail6_tmp[$i][$j];
        }
    }
    //7. Subject7	$row_result9	JIRANO
    $arr_fail7_tmp = array_chunk($arr_fail7,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_jira[$j][$i] = $arr_fail7_tmp[$i][$j];
        }
    }
    //8. Subject8	$row_result10	SPR
    $arr_fail8_tmp = array_chunk($arr_fail8,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_spr[$j][$i] = $arr_fail8_tmp[$i][$j];
        }
    }
    //9. Subject9	$row_result11	Temp
    $arr_fail9_tmp = array_chunk($arr_fail9,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_temp[$j][$i] = $arr_fail9_tmp[$i][$j];
        }
    }
    //10. Subject10	$row_result12	Dropcycles
    $arr_fail10_tmp = array_chunk($arr_fail10,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_drop_cycles[$j][$i] = $arr_fail10_tmp[$i][$j];
        }
    }
    //11. Subject11	$row_result13	Drops
    $arr_fail11_tmp = array_chunk($arr_fail11,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_drops[$j][$i] = $arr_fail11_tmp[$i][$j];
        }
    }
    //12. Subject12	$row_result14	Dropside
    $arr_fail12_tmp = array_chunk($arr_fail12,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_dropside[$j][$i] = $arr_fail13_tmp[$i][$j];
        }
    }
    //13. Subject13	$row_result15	Hit
    $arr_fail13_tmp = array_chunk($arr_fail13,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_hit[$j][$i] = $arr_fail13_tmp[$i][$j];
        }
    }
    //14. Subject14	$row_result16	NextCheckpointDate
    $arr_fail14_tmp = array_chunk($arr_fail14,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_NextCheckpointDate[$j][$i] = $arr_fail14_tmp[$i][$j];
        }
    }
    //15. Subject15	$row_result17	IssuePublished
    $arr_fail15_tmp = array_chunk($arr_fail15,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_IssuePublished[$j][$i] = $arr_fail15_tmp[$i][$j];
        }
    }
    //16. Subject16	$row_result18	ORTMFGDate
    $arr_fail16_tmp = array_chunk($arr_fail16,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_ort_mfg_date[$j][$i] = $arr_fail16_tmp[$i][$j];
        }
    }
    //17. Subject17	$row_result19	ReportedDate
    $arr_fail17_tmp = array_chunk($arr_fail17,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_reported_date[$j][$i] = $arr_fail17_tmp[$i][$j];
        }
    }
    
    //先根据原来的RecordID删除原来的记录,然后保存新编辑的数据
    /*
    $LEN_ORIGINAL_ID = count($pre_id);
    for($k=0; $k<$LEN_ORIGINAL_ID; $k++){
        $del_id = $pre_id[$k];
        $del_original = "DELETE FROM DQA_Test_Main WHERE RecordID='$del_id' ";
        mysqli_query($con,$del_original);
    }
    */
    sleep(1);    //延迟1秒
    //寫入編輯後的新數據
    $counter = 0;        //作为测试机编号
    $loop = count($arr_order_tmp2);
    $loop_inner = count($arr_order_tmp2[0]);
    for($i=0; $i<$loop; $i++){
        $counter++;
        for($j=0; $j<$loop_inner; $j++){
            $request = $arr_requests[$j];
            $group = $arr_group[$j];
            $test_item = $arr_test[$j];
            $test_id = $arr_id_tmp2[$i][$j];
            $condition = $arr_condition[$j];
            $unit = $arr_order_tmp2[$i][$j];       //test order
            $sn = $arr_sn[$i];
            $start = $arr_start[$j];
            $end = $arr_end[$j];
            $test_status = $arr_status[$j];
            
            $result   = $arr_result_tmp2[$i][$j];      //result
            $fail_symptom = $arr_fail[$j];
            $fa = $arr_fa[$j];
            $remark = $arr_remark[$j];

            //modified here on 2022-01-27
            $df1 = $arr_fail_df1[$i][$j];
            $df2 = $arr_fail_df2[$i][$j];
            $rcca = $arr_fail_rcca[$i][$j];
            $issue_status = $arr_fail_issue_status[$i][$j];
            $category = $arr_fail_category[$i][$j];
            $pic = $arr_fail_pic[$i][$j];
            $jira = $arr_fail_jira[$i][$j];
            $spr = $arr_fail_spr[$i][$j];
            $temp = $arr_fail_temp[$i][$j];
            $drop_cycles = $arr_fail_drop_cycles[$i][$j];
            $drops = $arr_fail_drops[$i][$j];
            $drop_side = $arr_fail_dropside[$i][$j];
            $hit = $arr_fail_hit[$i][$j];
            $check_point = $arr_fail_NextCheckpointDate[$i][$j];    //NextCheckpointDate
            $published = $arr_fail_IssuePublished[$i][$j];   //IssuePublished
            $mfg_date = $arr_fail_ort_mfg_date[$i][$j];
            $report_date = $arr_fail_reported_date[$i][$j];
            
            $sql_add = "REPLACE INTO DQA_Test_Main(RecordID,Stages,VT,Products,SKUS,Years,Months,Phases,Testlab,Mfgsite,Boot,Testername,SN,";
            $sql_add.= "Units,`Groups`,Testitems,Startday,Endday,Results,Remarks,Timedt,Unitsno,Defectmode1,Defectmode2,RCCA,Teststatus,";
            $sql_add.= "Issuestatus,Category,PIC,JIRANO,SPR,Temp,Dropcycles,Drops,Dropside,Hit,NextCheckpointDate,IssuePublished,ORTMFGDate,ReportedDate,";
            $sql_add.= "Requests,Titles,Testcondition,Failinfo,FAA) ";
            $sql_add.= "VALUES('$test_id','$stage','$vt','$pr_name','$sku','$year','$month','$phase','$testlab','$mfgsite','$boot','$tester','$sn','$unit',";
            $sql_add.= "'$group','$test_item','$start','$end','$result','$remark','$timedt','$counter','$df1','$df2','$rcca','$test_status',";
            $sql_add.= "'$issue_status','$category','$pic','$jira','$spr','$temp','$drop_cycles','$drops','$drop_side','$hit','$check_point','$published','$mfg_date','$report_date',";
            $sql_add.= "'$request','$title','$condition','$fail_symptom','$fa')";
            //echo $sql_add;
            mysqli_query($con,$sql_add);
        }
    }
    mysqli_close($con);
    $url = "index.php";
    $message = urlencode("数据保存完成 :)");
    header("location:success.php?url=$url&message=$message");
}
?>