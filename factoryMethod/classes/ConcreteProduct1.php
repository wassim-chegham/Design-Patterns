<?php
	require_once('Product.php');
	
	class ConcreteProduct1 extends Product
	{
		public function __construct()
		{
			$this->productType = "Concrete Product 1";
		}
	}
?>