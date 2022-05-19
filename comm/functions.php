<?php
require_once("../js/conf.php");

/*
嘿嘿嘿
      \                    / \  //\
       \    |\___/|      /   \//  \\
            /0  0  \__  /    //  | \ \
           /     /  \/_/    //   |  \  \
           @_^_@'/   \/_   //    |   \   \
           //_^_/     \/_ //     |    \    \
        ( //) |        \///      |     \     \
      ( / /) _|_ /   )  //       |      \     _\
    ( // /) '/,_ _ _/  ( ; -.    |    _ _\.-~        .-~~~^-.
  (( / / )) ,-{        _      `-.|.-~-.           .~         `.
 (( // / ))  '/\      /                 ~-. _ .-~      .-~^-.  \
 (( /// ))      `.   {            }                   /      \  \
  (( / ))     .----~-.\        \-'                 .~         \  `. \^-.
             ///.----..>        \             _ -~             `.  ^-`  ^-_
               ///-._ _ _ _ _ _ _}^ - - - - ~                     ~-- ,.-~
                                                                  /.-~

*/

/**
 * 根据传入的SQL语句查询MySQL结果集
 */
function getData($db,$sql){
    $resource = mysqli_query($db, $sql);//get a resource type data
    $res = array();
    while($row=mysqli_fetch_assoc($resource)){
        $res[] = $row;//二维数组
    }
    return $res;
}

/**
 * 获取DQA_Test_Main中所有测试项,即Raw All -C
 */
function getRawAllComm($db){
    $raw_all = "SELECT * FROM DQA_Test_Main WHERE Units!='' ";
    $res = getData($db,$raw_all);
    return $res;
}

/**
 * 
 */
function getRawAllCommByPeriod($db,$start,$end){
    $raw_all = "SELECT * FROM DQA_Test_Main WHERE Units!='' AND (Timedt>='$start' and Timedt<='$end') ";
    $res = getData($db,$raw_all);
    return $res;
}

/**
 * 获取Product名为一个数组
 */
function getDistinctProduct($db){
    $product_name = array();
    $check_product = mysqli_query($db, "SELECT DISTINCT Products FROM DQA_Test_Main");
    while($row=mysqli_fetch_assoc($check_product)){
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
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Units!='' ";
    $res = getData($db,$sql);
    return $res;
}

/**
 * 根据传入的product,時間段查询数据
 */
function getDataByProductAndPeriod($db,$product,$start,$end){
    $sql = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND (Timedt>='$start' and Timedt<='$end') AND Units!='' ";
    $res = getData($db,$sql);
    return $res;
}

/**
 * 根据传入的测试人名查询数据
 */
function getDataByTester($db,$name){
    $sql = "SELECT * FROM DQA_Test_Main WHERE Testername='$name' Units!='' ";
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
 * added on 2022-02-09 for matrix auto transforming
 * 根据传入的product tester date查询某一次的测试记录
 */
function getDataForMatrixTransform($db,$product,$tester,$starting){
    $sql_query = "SELECT * FROM DQA_Test_Main WHERE Products='$product' AND Testername='$tester' AND Timedt LIKE '$starting%' ";
    $res = getData($db,$sql_query);
    return $res;
}
?>