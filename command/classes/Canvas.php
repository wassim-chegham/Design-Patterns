<?php

	class Canvas
	{
		private $color;
		
		public function __construct ($color="#fff")
		{
			$this->color = $color;
		}
		
		public function getColor()
		{
			return $this->color;
		}
		
		public function setColor($color)
		{
			$this->color = $color;
		}
		
	}

?>