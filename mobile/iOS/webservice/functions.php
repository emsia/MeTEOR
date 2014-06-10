<?php
	function getSQL(){
		$mysqli = new mysqli("localhost", "meteor", "xpF7mBWqMtvJUpt9", "meteor");
		return $mysqli;
	}
?>