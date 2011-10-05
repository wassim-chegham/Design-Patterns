<?php

	abstract class Command
	{
		protected $receiverParam;
		protected $action;
		public function __construct($receiverParam, $action)
		{
			$this->receiver = $receiverParam;
			$this->thisColor = $action;
		}
		abstract public function Execute();
		abstract public function UnExecute();
	}

?>