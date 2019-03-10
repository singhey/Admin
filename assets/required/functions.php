<?php

	function _query($sql){
		global $con;
		$result = mysqli_query($con, $sql);
		if(!$result){
			echo "<b>Error</br>".mysqli_error($con)."</br> SQL: ".$sql;
		}
		return $result;
	}

?>