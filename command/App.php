	<?php

/*
	On va implementer le patron Command, où les actions sont des objets
	possedants les methodes Execute() et UnExecute().
	On va donc pouvoir stocker ces objets dans un tableau afin de maintenir 
	un indexage pour qu'on puisse annuler et rejouer les actions comme on le 
	souhaite.

	Si l'utilisateur annule un certain nombre d'actions, puis ajoute de 
	nouvelles actions, il ecrase les actions qui restaient à jouer !!

*/

include_once('classes/Command.php');
include_once('classes/MenuItem.php');
include_once('classes/ColorCommand.php');
include_once('classes/Canvas.php');

class Test 
{

	/**
	 * Le tableau qui va nous permettre de memoriser les commandes que l'ont 
	 * va pouvoir demander
	 */
	public $menu;

	/**
	 * Le tableau qui va nous permettre de memoriser les commandes qu'on a déjà
	 * demdandé. Ce tableau est caché et n'est pas accessible par l'utilisateur.
	 */
	public $history;

	/**
	 * Le tableau de l'historique accessbile à l'utilisateur. Cet historique
	 * est identique au précédant à la différence près que si l'utilisateur
	 * annule une commande, celle-ci sera retiré de cet historique.
	 */
	public $historyDisplay;

	/**
	 * Dans cet exemple le receveur est toujours le même canvas, mais en réalité
	 * ceci change en fonction de l'élément séléctionné.
	 */
	public $receiver;

	/**
	 * Cet index nous nous dira où est ce qu'on se trouve dans l'historique caché
	 * afin que l'ont puisse rejouer et annuler les actions.
	 */
	public $historyIndex;

	/**
	 * Ceci va nous permettre d'avoir une unique instance pendant toute la durée
	 * de vie de notre application (le patron Singleton)
	 */
	private static $key="c";

	public function __construct()
	{
		$this->menu = array();
		$this->history = array();
		$this->historyDisplay = array();
		$this->receiver = new Canvas();
		$this->historyIndex = -1;

		/**
		 * Ajouter un certain nombre d'éléments au menu, qui ont chacun un 
		 * ColorCommand permettant de changer la couleur du canvas
		 */
		$this->menu[1] = new MenuItem("Rouge", new ColorCommand($this->receiver, "ff0000"));
		$this->menu[] = new MenuItem("Orange", new ColorCommand($this->receiver, "ff9900"));
		$this->menu[] = new MenuItem("Jaune", new ColorCommand($this->receiver, "ffff00"));
		$this->menu[] = new MenuItem("Verts", new ColorCommand($this->receiver, "00ff00"));
		$this->menu[] = new MenuItem("Blue", new ColorCommand($this->receiver, "0000ff"));
		$this->menu[] = new MenuItem("Indigo", new ColorCommand($this->receiver, "9900ff"));
		$this->menu[] = new MenuItem("Violet", new ColorCommand($this->receiver, "ff00ff"));
		$this->menu[] = new MenuItem("Blanc", new ColorCommand($this->receiver, "ffffff"));
		$this->menu[] = new MenuItem("Gris", new ColorCommand($this->receiver, "999999"));
		$this->menu[] = new MenuItem("Noire", new ColorCommand($this->receiver, "000000"));
	}

	// Sauvegarder l'objet courant en session
	public function __destruct()
	{
		$_SESSION[self::$key] = serialize($this);
	}

	public static function instance()
	{
		/**
		 * Permet d'avoir l'instance courante de l'application
		 */
		session_start();
		if(isset($_SESSION[self::$key]) === TRUE)
		{
			
			return unserialize($_SESSION[self::$key]);
		}
		
		return new Test();

	}


	public function menuClickHandler($rowIndex)
	{
		$menuItem = $this->menu[$rowIndex];

		/**
		 * On appelle la methode Execute() et on incrémente l'historique.
		 */
		$menuItem->command->Execute();
		$this->historyIndex++;

		/**
		 * Ajouter l'élément éxecuter à l'historique caché et à celui de 
		 * l'utilisateur
		 */
		$this->history[] = $menuItem;
		$this->historyDisplay[] = $menuItem;

		/**
		 * Si l'utilisateur essaye d'ajouter des actions après avoir annuler
		 * une parties de d'autres actions, les autres actions seraient perdues.
		 * On remplace donc l'historique caché avec celui que l'utilisateur peut
		 * voir.
		 */
		if ($this->historyIndex < count( $this->history ) - 1)
		{
			// empty the history
			$this->history = array();
			for ($i = 0; $i < count( $this->historyDisplay ) ; $i++)
			{
				$this->history[] = $this->historyDisplay[$i];
			}
			$this->historyIndex = count( $this->historyDisplay) - 1;
		}
	}

	public function undoHandler()
	{
		/**
		 * Si l'utilisateur a cliqué sur annuler et qu'il n'est pas au début,
		 * appellons la méthode UnExecute de notre historique et retirons cette
		 * actions de l'historique de l'utilisateur (celui qu'il peut voir) 
		 */
		if ($this->historyIndex >= 0)
		{


			$this->history[$this->historyIndex]->command->UnExecute();
			unset( $this->historyDisplay[$this->historyIndex] );

			// reindex the array !!
			$this->historyDisplay = array_values($this->historyDisplay);
			$this->historyIndex--;
		}
	}

	public function redoHandler()
	{
		if ( count( $this->history ) - 1 > $this->historyIndex )
		{
			/**
			 * Si l'utilisateur a cliqué sur rejouer et qu'il n'est pas à la fin
			 * de l'historique, on ajoute l'élément depuis l'historique caché
			 * à celui de l'utilisateur (celui qu'il peut voir). On incrémente 
			 * l'index évidement.
			 */
			$this->historyIndex++;
			$this->history[$this->historyIndex]->command->Execute();
			$this->historyDisplay[] = $this->history[$this->historyIndex];
		}
	}

	////////////////////////////////////////////////////////////////////////////

	public function getCanvasColor()
	{
		return $this->receiver->getColor();
	}

	public function handleRequest()
	{
		/* scenario d'utilisation
		try {
			$this->menuClickHandler(0); // ajoute rouge
			$this->menuClickHandler(0); // ajoute rouge
			$this->menuClickHandler(0); // ajoute rouge

			$this->menuClickHandler(1); // ajoute orange
			$this->menuClickHandler(2); // ajoute jaune
			$this->menuClickHandler(3); // ajoute vert

			$this->undoHandler(); // retire vert
			$this->undoHandler(); // retire jaune
			$this->undoHandler(); // retire orange

			$this->menuClickHandler(9); // ajoute noire

			$this->undoHandler(); // retire noire

			$this->redoHandler(); // rejoue noire
			$this->redoHandler(); // ne fait rien

			$this->undoHandler(); // retire noire
			$this->undoHandler(); // retire rouge
			$this->undoHandler(); // retire rouge
			$this->undoHandler(); // retire rouge
			$this->undoHandler(); // retire rouge

			return;
		}
		catch(Exception $e)
		{
			var_dump($e);
		}
		//*/

		$menuIndex = ( isset($_GET['m']) && !empty($_GET['m']) ) ? $_GET['m'] : '';

		// handle menu requests
		if ( $menuIndex !== '' )
		{
			$this->menuClickHandler($menuIndex);
		}

		// handle events
		if ( isset($_GET['undo']) )
		{
			$this->undoHandler();
		}
		else if ( isset($_GET['redo']) )
		{
			$this->redoHandler();
		}
		
		if( isset($_GET['ajax']) )
		{ 
			$color =  $this->getCanvasColor();
			
			function array_map_cb($n){ return $n->name;}
			$h = '<li>'.implode('</li><li>', array_map('array_map_cb', array_values($this->history))).'</li>';
			$hh = '<li>'.implode('</li><li>', array_map('array_map_cb', array_values($this->historyDisplay))).'</li>';
			?>
			
			<div id="canvas" style="background:#<?php echo $color; ?>;width:100%;height:100%;border:1px solid #aaa;">
			</div>
			<div id="historyDisplay">
				Historique (public):<ul><?php echo $hh; ?></ul>
				Historique (privé):<ul><?php echo $h; ?></ul>
			</div>
			
			<?php exit();
		}
	
	}

}

// Utilisation

$c = Test::instance();
$c->handleRequest();

?>