<?php

	require_once("Creator.php");
	require_once("ConcreteProduct1.php");

	class ConcreteCreator1 extends Creator
	{
		public function __construct()
		{
			parent::Creator();
		}

		// @override
		public function FactoryMethod()
		{
			return new ConcreteProduct1();
		}
	}
?>