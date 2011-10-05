<?php
	require_once("Product.php");
	
	class ConcreteProduct2 extends Product
	{
		public function __construct()
		{
			$this->productType = "Concrete Product 2";
		}
	}
?>