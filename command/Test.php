<?php

require_once('App.php');

print_r($_SESSION['c']);
unset($_SESSION['c']);
var_dump($c);
exit;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Design Pattern : Command</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<script type="text/javascript" src="/site/assets/js.php?v=2"></script>
		<script type="text/javascript">
			//<![CDATA[
			$(function(){
				$('a').click(function(e){
					e.preventDefault();
					
					$('#response').load($(this).attr('href')+'&ajax&t='+new Date().getTime());
					
				});
			});
			//]]>
		</script>
	</head>
	<body>

		<div id="hBox" style="width:600px;height:600px;margin-left:50%;left:-300px;position:relative;background:#fff;padding:10px;">
			<div id="menuView" style="width:100%;">
				<p>Menu: 
				<?php

					foreach( $c->menu as $i => $menuItem )
					{
						echo '<a href="?m=' . $i . '" >' . $menuItem->name. '</a>&nbsp;&nbsp;';
					}

				?>
				</p>
				<hr />
				<p>Actions: 
					<a href="?undo">Annuler</a>&nbsp;&nbsp;
					<a href="?redo">Rétablir</a>
				</p>
			</div>
			<div id="response" style="width:100%;height:100px;">
				<div id="canvas" style="background:#<?php echo $c->getCanvasColor(); ?>;width:100%;height:100%;border:1px solid #aaa;">
				</div>
				<div id="historyDisplay">
					Historique (public):<ul>
					<?php foreach( $c->historyDisplay as $i => $menuItem ){
						echo '<li>' . $menuItem->name . '</li>';
					}?>
					</ul>
					Historique (privé):<ul>
					<?php foreach( $c->history as $i => $menuItem ){
						echo '<li>' . $menuItem->name . '</li>';
					}?>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
<?php

?>
