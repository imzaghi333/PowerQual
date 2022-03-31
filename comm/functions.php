<?php
require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
date_default_timezone_set("PRC");
header("Content-Type:text/html;charset=utf-8");

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
?>