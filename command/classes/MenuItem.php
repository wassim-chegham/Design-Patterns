<?php

	class MenuItem
	{
		public $name;
		public $command;
		public function __construct($nameParam, $commandParam)
		{
			$this->name = $nameParam;
			$this->command = $commandParam;
		}
	}

?>