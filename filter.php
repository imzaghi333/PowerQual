<!doctype html>
<html lang="en">
  <head>
	  <style>
		  input.defaultcheckbox
		  {
			  width :20px;
			  height :20px;
		  }
	  </style>
  	<title>Project list</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="Filter/css/style.css">

	</head>
	<body>
	<?php
		require_once("./js/conf.php"); 
	?>		
    <form action="filter.php" method="post">
	<!--section class="ftco-section"-->
		<!--div class="container"-->
			<div class="row justify-content-center">
				<div class="col-md-7 text-center mb-5">
					<h2 class="heading-section">Project list</h2>
				</div>
			</div>
			<!--div class="row justify-content-center"-->
				<!--div class="col-lg-4 d-flex justify-content-center align-items-center"-->
				<table align="center" width="50%" cellpadding="10" border="0">
                    <tr>
                    <td>Product &nbsp;&nbsp;<span class="tablet-icon"></span></td>
                	 <td>
					<?php
						echo "<select name='ary[]' class='js-select2' multiple='multiple'>";
						$check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
						while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
							echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
						}
						echo "</select>";
					?>
					</td>
                    </td>
                    </tr>
                </table>
				<!--/div-->
			<!--/div-->
			<div class="row justify-content-center">
				<div class="col-md-7 text-center mb-5">
					<h2 class="heading-section">SKU List</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 d-flex justify-content-center align-items-center">
					<?php
						echo "<select name='aryy[]' class='js-select2' multiple='multiple'>";
						$check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
						while ($row = mysqli_fetch_array($check)) {
							echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
						}
						echo "</select>";
					?>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 text-center mb-5">
					<h2 class="heading-section">Verification Type</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 d-flex justify-content-center align-items-center">
					<?php
						echo "<select name='ary3[]' class='js-select2' multiple='multiple'>";
						$check = mysqli_query($con, "SELECT DISTINCT(VT) FROM DQA_Test_Main ORDER BY VT ASC ");
						while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
							echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
						}
						echo "</select>";
					?>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-7 text-center mb-5">
					<h2 class="heading-section">Stage</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 d-flex justify-content-center align-items-center">
					<?php
						echo "<select name='ary4[]' class='js-select2' multiple='multiple'>";
						$check = mysqli_query($con, "SELECT DISTINCT(Stages) FROM DQA_Test_Main ORDER BY Stages ASC ");
						while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
							echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
						}
						echo "</select>";
					?>
				</div>
			</div>
		<!--/div-->
		&nbsp;&nbsp;&nbsp;	<input type="submit" name="submit" value=Submit>
	<!--/section-->
	
</form>


<?php

    if ($_POST) 
	{ 
		if($_POST['ary']!="")
		{
			foreach($_POST['ary'] as $selected) {
				echo "project list ".$selected."<br>";
				$filter_Pro[] = ' Products = '."'$selected'";
			}
		}
		else
		{
			$check = mysqli_query($con, "SELECT DISTINCT(Products) FROM DQA_Test_Main ORDER BY Products ASC ");
			while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
				//echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
				$filter_Pro[] = ' Products = '."'$row[0]'";

			}
		}
      	if($_POST['aryy']!="")
	  	{
			foreach($_POST['aryy'] as $selected) {
				echo "SKU list ".$selected."<br>";
				$filter_SKU[] = ' SKUS = '."'$selected'";
			}
		}
		else
		{
			$check = mysqli_query($con, "SELECT SKUS FROM dropbox_sku");
			while ($row = mysqli_fetch_array($check)) {
				//echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
				$filter_SKU[] = ' SKUS = '."'{$row['SKUS']}'";
			}
			

		}

		if($_POST['ary3']!="")
		{
		  foreach($_POST['ary3'] as $selected) {
			  echo "VT list ".$selected."<br>";
			  $filter_VT[] = ' VT = '."'$selected'";
		  }
		}
		else
		{

				$check = mysqli_query($con, "SELECT DISTINCT(VT) FROM DQA_Test_Main ORDER BY VT ASC ");
				while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
				//echo "<option value='{$row["SKUS"]}' data-badge=''>{$row['SKUS']}</option>";
				$filter_VT[] = ' VT = '."'$row[0]'";
			}
			

		}

		if($_POST['ary4']!="")
		{
		  foreach($_POST['ary4'] as $selected) {
			  echo "Stages list ".$selected."<br>";
			  $filter_Sta[] = ' Stages = '."'$selected'";
		  }
		}
		else
		{

			$check = mysqli_query($con, "SELECT DISTINCT(Stages) FROM DQA_Test_Main ORDER BY Stages ASC ");
			while ($row = mysqli_fetch_array($check,MYSQLI_NUM)) {
				//echo "<option value=" ."'$row[0]'" . "  data-badge=''>" . $row[0] . "</option>";
				$filter_Sta[] = ' Stages = '."'$row[0]'";

			}

		}

		$cc = 0;
		$sql_tt = "SELECT DISTINCT Titles,Stages,VT,Products,SKUS,Phases,Testername,Timedt FROM DQA_Test_Main WHERE (". implode(" OR",$filter_Pro).")"." AND (".implode(" OR",$filter_SKU).")"." AND (".implode(" OR",$filter_VT).")"." AND (".implode(" OR",$filter_Sta).")";
		echo $sql_tt;
		$rr_time = mysqli_query($con,$sql_tt);
		echo "<p class='query_desc'>您查询了".$tt."的测试记录</p>";
		echo "<table border='1' rules='all' class='query_table'>";
		echo "<tr><th width='4%'>NO.</th><th>Title</th><th>Stage</th><th>VT</th><th>Product</th><th>SKU</th><th>Tester</th><th>Date</th><th>Link</th><th>Del</th><th>CheckBox</th></tr>";
		while($row=mysqli_fetch_array($rr_time,MYSQLI_BOTH)){
			$cc++;
			$product = $row['Products'];
			$tester = $row['Testername'];
			$starting = $row['Timedt'];
			$user_name = urlencode($tester);
			$product_name = urlencode($product);
			$start = urlencode($starting);
		
		?>
		<tr>
			<td><?php echo $cc; ?></td>
			<td><?php echo $row['Titles']; ?></td>
			<td><?php echo $row['Stages']; ?></td>
			<td><?php echo $row['VT']; ?></td>
			<td><?php echo $product ?></td>
			<td><?php echo $row['SKUS']; ?></td>
			<td><?php echo $tester ?></td>
			<td><?php echo substr($starting,0,10); ?></td>
			<td><a href="matrix_edit.php?user=<?php echo $user_name; ?>&product=<?php echo $product_name; ?>&starting=<?php echo $start ?>" >Matrix</a></td>
			<td align="center"><input name="del_matrix2" id="del_matrix2" type="button" class="del_matrix1" value="Del" onclick="deleteMatrix('<?php echo $tester; ?>','<?php echo $product; ?>','<?php echo $starting; ?>');" /></td>
		    <td align="center"><input type="checkbox" id="ch_box<?php echo $cc; ?>" class="defaultcheckbox"></td>
		</tr>
		<?php
					}
			echo "</table>";
		}

		?>

  <script src="Filter/js/jquery.min.js"></script>
  <script src="Filter/js/popper.js"></script>
  <script src="Filter/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <script src="Filter/js/main.js"></script>

	</body>
</html>

