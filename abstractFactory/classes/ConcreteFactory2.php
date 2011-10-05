<?php
	require_once('AbstractFactory.php');
	require_once('ProductA2.php');
	require_once('ProductB2.php');
	
	class ConcreteFactory2 extends AbstractFactory
	{
		public function __construct()
		{
			parent::AbstractFactory();
		}

		// @override 
		public function CreateProductA()
		{
			return new ProductA2();
		}

		// @override 
		public function CreateProductB()
		{
			return new ProductB2();
		}
	}

?>