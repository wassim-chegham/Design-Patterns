<?php
	
	require_once('classes/Singleton.php');
	
	echo "<h1>Singleton</h1>";
	
	$mySingleton = Singleton::instance();
	$mySingleton->property = "Original.";
	
	echo "Property before = " . $mySingleton->property . "<br/>";
	
	$mySecondSingleton = Singleton::instance();
	$mySingleton->property = "Modified.";
	
	echo "Property after = " . $mySingleton->property . "<br/>";

?>