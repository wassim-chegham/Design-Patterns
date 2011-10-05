<?php
	require_once("classes/ConcreteCreator1.php");
	require_once("classes/ConcreteCreator2.php");
	
	echo "<h1>factory Method</h1>";
	
	// $aCreator = new ConcreteCreator1();
	$aCreator = new ConcreteCreator2();
	
	$Product = $aCreator->FactoryMethod();
	
	// See if we have got the Concrete Product instead of the Abstract one.
	echo $aProduct->productType;
?>