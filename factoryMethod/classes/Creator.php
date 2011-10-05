<?php
class Creator
{
	public function Creator(){}
	
	public function FactoryMethod()
	{
		return new Product();
	}
	public function AnOperation()
	{
		echo "I am an operation";
	}		
}
?>