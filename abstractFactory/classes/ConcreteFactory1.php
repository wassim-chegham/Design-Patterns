<?php
	require_once('AbstractFactory.php');
	require_once('ProductA1.php');
	require_once('ProductB1.php');

	class ConcreteFactory1 extends AbstractFactory
	{
		public function __construct()
		{
			parent::AbstractFactory();
		}
		
		// @override 
		public function CreateProductA()
		{
			return new ProductA1();
		}
		
		// @override 
		public function CreateProductB()
		{
			return new ProductB1();
		}
	}

?>