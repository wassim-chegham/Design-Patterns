<?php
class Singleton
{
	private static $_instance;
	
	public $property;
	
	public function __construct()
	{
		if ( isset(self::$_instance) )
		{
			throw new Error("Singleton can only be accessed through Singleton::instance()");
		}
		
	}
	
	public static function instance()
	{
		if ( !isset(self::$_instance) )
		{
			self::$_instance = new Singleton();
		}
		
		return self::$_instance;
		
	}
}
?>