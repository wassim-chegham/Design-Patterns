<?php 
class AbstractFactory 
{
	
	public function AbstractFactory(){}
	
	public function createProductA()
	{
		return new AbstractProductA();
	}
	
	public function createProductB()
	{
		return new AbstractProductB();
	}
	
}
?>