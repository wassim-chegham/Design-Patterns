<?php
	
	require_once('Command.php');

	class ColorCommand extends Command
	{
		protected $receiver;
		protected $thisColor;
		protected $previousColor;
		
		public function __construct($receiverParam, $action)
		{
			/**
			 * Stocker l'objet receveur et l'action qui est, dans notre cas, la
			 * la couleur qu'on souhaite lui attribuer
			 */
			$this->receiver = $receiverParam;
			$this->thisColor = $action;
		}
		
		public function Execute()
		{
			/**
			 * Stocker l'ancienne coleur afin qu'on puisse annuler l'action, puis
			 * executer la commande
			 */
			$this->previousColor = $this->receiver->getColor();
			$this->receiver->setColor($this->thisColor);
		}
		
		public function UnExecute()
		{
			/*
				Retrieve the color that we stored and set it back
				to what it was originally.
			*/
			/**
			 * Récuperer la couleur stockée et l'appliqué à l'objet (ceci annule
			 * la derniere couleur appliquée et remet l'ancienne) 
			 */
			 
			$this->receiver->setColor($this->previousColor);
		}
	}

?>