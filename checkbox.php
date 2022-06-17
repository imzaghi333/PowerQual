<?php
$arr_product = array();
$arr_title = array();
$filter_title =array();
if ($_POST) 
	{ 
		if($_POST['checkbox']!="")
		{
			foreach($_POST['checkbox'] as $selected) {
				$title = explode("_",$selected,3);
				print_r($title);
				echo "checkbox ".$title[0]."<br>";
				echo "checkbox ".$title[1]."<br>";
				array_push($arr_title, $title[0]);
				array_push($arr_product, $title[1]);
				array_push($filter_title, ' Titles = '."'$title[0]'");
				//$filter_title[] = ' Titles = '."'$title[0]'";
			}
			print_r($arr_title);
			$NUM = '('. implode(' OR',$filter_title).')';
			echo $NUM;
		}
		
	}
?>