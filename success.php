<?php
date_default_timezone_set("PRC");
header("Content-Type:text/html;charset=UTF-8");
$message=urldecode($_GET["message"]);
$url=trim($_GET["url"]);
if(substr($url,0,15)=="matrix_edit.php"){
    //$username = urlencode($_GET["user"]);
	$product = urlencode($_GET["product"]);
	$starting = urlencode($_GET["starting"]);
	$url1 = $url."&product=".$product."&starting=".$starting;
}
else{
	$url1 = $url;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>操作成功</title>
	<style type="text/css">
	    @font-face {
			font-family: Helvetica;
			src: url(.style/Helvetica/Helvetica);
		}
		body {margin:0; padding:0; background: url(images/J20.jpg); background-size: cover; font-family:Helvetica;}
		.box{width:550px; margin:100px auto; padding:20px;line-height:180%;color: #f0f0f0;}
		.box h1{margin-bottom:10px; color: #cb364a;text-align: center; font-family: Helvetica;}
		.box p{font-size: 16px;}
		#time{color:#cb364a; font-size: 18px; font-weight: bold;}
		a.a1:link,a.a1:visited{color:#0099FF;text-decoration:none;}
		a.a1:hover{color:#cb364a; text-decoration:underline;}
	</style>
</head>

<body>
<div class="box">
	<h1>提示：<?php echo $message;?></h1>
	<p>系统将在 <span id="time">3</span> 秒钟后自动跳转，如果不想等待，请点击 <a class="a1" href="<?php echo $url1?>">这里</a> 返回。</p>
</div>
</body>
</html>

<script type="text/javascript">
function playSec(num){
	time.innerHTML=num;
	if(--num >0)
	{
		setTimeout("playSec("+num+")",1000);
	}else
	{
		location.href="<?php echo $url1?>";
	}
}
playSec(3);
</script>