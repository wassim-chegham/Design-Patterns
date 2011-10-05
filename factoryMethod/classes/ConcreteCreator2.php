<?php

	require_once("Creator.php");
	require_once("ConcreteProduct2.php");

	class ConcreteCreator2 extends Creator
	{
		public function __construct()
		{
			parent::Creator();
		}

		// @override
		public function FactoryMethod()
		{
			return new ConcreteProduct2();
		}
	}
?>