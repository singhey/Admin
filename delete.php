<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/connection.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/admin/assets/required/functions.php');
	$tableName = $_GET['tableName'];
	$identifier = $_GET['id'];
	$identifierValue = $_GET['value'];
	$sql="DELETE FROM $tableName WHERE $identifier = '$identifierValue'";
	$result = _query($sql);

	if($result){
		
		header('Location:http:/admin/sql.php?table='.$tableName.'&pos=0');
	}
?>