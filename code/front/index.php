<?php 
	$events = "";
	
	function post ($cmd) {
		$url = '../back/';
		$data = array('cmd' => $cmd);

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */ }
		
		var_dump($result);
		return $result;
	}
	
	if (isset($_POST)) {
		$resultAdd = post("add");
	}
	
	$resultList = post("list");
?>

<html>
<body>
	<!--Créer un événement-->
	<?php if (isset($resultAdd["message"])) {?>
		<p><?=$resultAdd["message"]?></p> 
	<?php } ?>
	
	<form name="event" method="post">
		<input type="text" name="nom" required>
		<textarea name="description">
			
		</textarea>
		<input type="date" name="datedebut">
		<input type="date" name="datefin">
		
		<input type="submit" value="ajouter">
	</form>
	
	<!--Lister les événements-->
	<?php foreach ($resultList["data"] as $event) { ?>
		<div>
			<p><?= $event["nom"] ?></p>
			<p><?= $event["description"] ?></p>
			<p><?= $event["datedebut"] ?></p>
			<p><?= $event["datefin"] ?></p>
		</div>
	<?php } ?>
</body>
</html>