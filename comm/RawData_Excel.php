<?php
/**
 * Export Raw Data to Excel, export to .xls file
 * felix_qian@wistron.com
 */

require_once("../js/conf.php");
mysqli_query($con,"set names utf8");
header("Content-Type:text/html;charset=UTF-8");
date_default_timezone_set("PRC");

require_once "../Classes/PHPExcel.php";
require_once "../Classes/PHPExcel/IOFactory.php";

/**
 * Only select Product
 */
if(isset($_GET["product"])){
    $product = $_GET["product"];
    echo $product;
}

/**
 * Product+Stage
 */
?>