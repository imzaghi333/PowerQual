<?php
require_once("../js/conf.php");
header("Content-Type:text/html;charset=UTF-8");

if(isset($_POST["searchit"]) && $_POST["searchit"]=="searchdo"){
    $search_txt = $_POST["search"];
    $sql_search_it = "SELECT * FROM DQA_Test_Main WHERE SN LIKE '%$search_txt%' OR Products LIKE '%$search_txt%' OR Testitems LIKE '%$search_txt%' OR Testername LIKE '%$search_txt%' ORDER BY Timedt DESC ";
    $counter = 0;
    $search_result = mysqli_query($con, $sql_search_it);
    $cc = mysqli_num_rows($search_result);
    if($cc==0){
        echo "<p style='font-size:30px;font-weight:bold;'>No data searched</p>";
        exit();
    }
    else{
        echo "<p class='text-info'>Searched data about ".$search_txt."</p>";
        echo "<table border='1' rules='all' class='customers'>";
        echo "<tr><th width='4%'>NO.</th><th>Products</th><th>SKU</th><th>SN</th><th>Test Item</th><th width='8%'>Date</th><th>Tester</th><th>Result</th><th>RecordID</th></tr>";
        while($row=mysqli_fetch_array($search_result,MYSQLI_BOTH)){
            $counter++;
            echo "<tr>";
            echo "<td>$counter</td><td>".$row['Products']."</td><td>".$row['SKUS']."</td><td>".$row['SN']."</td><td>".$row['Testitems']."</td><td>";
            echo substr($row['Timedt'],0,10)."</td><td>".$row['Testername']."</td><td><a href='../details.php?id=$row[0]'>$row[20]</a></td><td>$row[0]</td>";
            echo "</tr>";
            
        }
        echo "</table>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="zh_cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favior.ico">
    <style type="text/css">
    @font-face {
        font-family: "ecnu.otf";
        src: url(../style/Helvetica/ecnu.otf);
    }
    body{
        margin: 0px; padding: 0px;
        font-size: 14px;
        font-family: "ecnu.otf";
        background-color: #282a35;
    }
    .customers{
        font-family:Helvetica;
        width:90%;
        border-collapse:collapse;
        margin: 0 auto;
        color: #fff;
    }
    .customers td, .customers th {
        font-size:14px;
        border:1px dotted #999;
        padding:3px 7px 2px 7px;
    }
    .customers th {
        font-size:12px;
        padding-top:5px;
        padding-bottom:4px;
        color:#fff22d;
    }
    .customers a{
        text-decoration: none; 
        color: #fff;
    }
    .customers a:hover{
        text-decoration: underline; 
        color: #cc2229;
    }
    .text-info{
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        font-family: "ecnu.otf";;
    }
    </style>
    <link rel="shortcut icon" href="images/favior.ico">
    <title><?php echo $search_txt; ?></title>
</head>
<body>

</body>
</html>