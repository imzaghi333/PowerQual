<?php
/*
 ____________________________
 < 毛主席教导我们枪杆子出政权 >
  ----------------------------
         \   ^__^
          \  (oo)\_______
             (__)\       )\/\
                 ||----w |
                 ||     ||
*/

require_once "./js/conf.php";

/**
 * 编辑的时候去掉月份前缀0
*/
function removeZeroPrefix($month){
    if(substr($month,0,1)==0 && strlen($month)>0){
        return substr($month,1,1);
    }
    else if(strlen($month)==0){
        return "";
    }
    else{
        return $month;
    }
}

if(isset($_POST["matrix_edit"]) && $_POST["matrix_edit"]=="matrix_edit_do" ){
    // =========== 以下内容就是New Test页面用户填写的 ========
    $stage     = $_POST["stage"];
    $vt        = $_POST["vt"];
    $pr_name   = $_POST["pr_name"];
    $sku       = $_POST["sku"];
    $year      = $_POST["year"];
    $month     = removeZeroPrefix($_POST["month"]);//改成在这里就去掉月份的前缀0
    $phase     = $_POST["phase"];
    $testlab   = $_POST["testlab"];
    $mfgsite   = $_POST["mfgsite"];
    $tester    = $_POST["tester"];
    $timedt    = $_POST["timedt"];
    $title     = $_POST["title"];
    $pre_id    = $_POST["record_id"];    //原来的RecordID   
    $number       = $_POST["number"];        //测试机数量
    // ====================================================

    $arr_requests = $_POST["requests"];      //Yes,No,N/A  
    $arr_group    = $_POST["group"];         //Group A,Group B,Group B,......
    $arr_test     = $_POST["test_item"];     //Test Items,不可以重复
    $arr_condition= $_POST["conditions"];    //Test condition
    $order        = $_POST["test_order"];    //A,B,C,D......Z
    $arr_start    = $_POST["starting"];      //开始日期
    $arr_end      = $_POST["ending"];        //结束日期
    $arr_status   = $_POST["status"];        //complete, ongoing.....
    $arr_fail     = $_POST["fail"];          //fail sympton
    $arr_fa       = $_POST["rcca"];          //FA
    $arr_remark   = $_POST["remarks"];       //备注，不清楚DQA想写什么玩意
    $arr_result   = $_POST["subject18"];     //default is PASS
    $arr_fail9 = $_POST["subject9"];       //TEMP 
    //urlencode,给浏览器使用
    $get_test_name = urlencode($tester);
    $get_product_name = urlencode($pr_name);
    $get_start_day = urlencode($timedt);
    //有相同Test item结束
    if(count($arr_test)!=count(array_unique($arr_test))){
        echo "<script>window.alert('有相同的Test Item!~點擊返回');history.back();</script>";
        exit();
    }        
    /**
     * ----------- 需要转成二维数组的内容 -----------
    */
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
    //转置test result
    $arr_result_tmp1 = array_chunk($arr_result,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_result_tmp2[$j][$i] = $arr_result_tmp1[$i][$j];
        }
    }
    //9. 转置 Subject9 Temp
    $arr_fail9_tmp = array_chunk($arr_fail9,$number);
    for($i=0; $i<$len1; $i++){
        for($j=0; $j<$len2; $j++){
            $arr_fail_temp[$j][$i] = $arr_fail9_tmp[$i][$j];
        }
    }
    
    //先根据原来的RecordID删除原来的记录,然后保存新编辑的数据
    /*
    $LEN_ORIGINAL_ID = count($pre_id);
    for($k=0; $k<$LEN_ORIGINAL_ID; $k++){
        $del_id = $pre_id[$k];
        $del_original = "DELETE FROM DQA_Test_Main WHERE RecordID='$del_id' ";
        mysqli_query($con,$del_original);
    }*/

    /**
     * 二重循环把数据写入数据库,用循环比用数组效率高
    */
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
            //$condition = $arr_condition[$j];
            $condition = preg_replace("/\'/","\'",$arr_condition[$j]);//单引号转义\'
            $unit = $arr_order_tmp2[$i][$j];       //test order
            $start = $arr_start[$j];
            $end = $arr_end[$j];
            $test_status = $arr_status[$j];//test status
            $result   = $arr_result_tmp2[$i][$j];      //result
            $fail_symptom = $arr_fail[$j];
            $fa = $arr_fa[$j];
            $remark = $arr_remark[$j];
            $temp = $arr_fail_temp[$i][$j];
            
            //SQL语句 O(∩_∩)O
            $sql_add = "REPLACE INTO DQA_Test_Main(RecordID,Stages,VT,Products,SKUS,Years,Months,Phases,Testlab,Mfgsite,Testername,";
            $sql_add.= "Units,`Groups`,Testitems,Startday,Endday,Results,Remarks,Timedt,Unitsno,Teststatus,";
            $sql_add.= "Temp,Requests,Titles,Testcondition,Failinfo,FAA) ";
            $sql_add.= "VALUES('$test_id','$stage','$vt','$pr_name','$sku','$year','$month','$phase','$testlab','$mfgsite','$tester','$unit',";
            $sql_add.= "'$group','$test_item','$start','$end','$result','$remark','$timedt','$counter','$test_status',";
            $sql_add.= "'$temp','$request','$title','$condition','$fail_symptom','$fa')";
            //echo "Unit#".$counter.". ".$sql_add."<br>";
            mysqli_query($con,$sql_add);
        }
    }
    mysqli_close($con);
    $url = "matrix_edit.php?user={$get_test_name}&product={$get_product_name}&starting={$get_start_day}";
    $message = urlencode("数据保存完成 :)");
    //header("location:success.php?url=$url&message=$message");
    echo "<script>window.location.href='success.php?url=$url&message=$message'</script>";
}
else{
    echo "您没有选择Test Matrix";
}
?>