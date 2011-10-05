<?php
	
	require_once('classes/AbstractProductB.php');
	require_once('classes/AbstractProductA.php');
	
	require_once('classes/ConcreteFactory1.php');
	require_once('classes/ConcreteFactory2.php');
	
	echo "<h1>Abstract Factory</h1>";
	
	$factory = new ConcreteFactory1();
	// $factory = new ConcreteFactory2();

	// Create the products.
	$productA = $factory->CreateProductA();
	$productB = $factory->CreateProductB();

	// See what types have been created.
	echo "Product A type = " . $productA->productType . "<br/>";
	echo "Product B type = " . $productB->productType . "<br/>";

?>