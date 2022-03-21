<?php 
	$events = "";
	
	function get_data($url)
	{
	  $ch = curl_init();
	  $timeout = 5;
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}	
	
	function post($cmd) {
		$url = 'http://localhost/events-main/code/back/' . $cmd;
		
		$json = get_data($url);
		$json = json_decode($json);
		
		if (!$json) {
			print_r ($json);
			exit ("Problème d'interprétation du Jsonz");
		}
		return $json;
	}
	
	
	function post2 ($cmd) {
		$url = 'http://localhost/events-main/code/back/';
		$data = array('cmd' => $cmd);

		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'GET',
				'content' => http_build_query($data)
			)
		);
		
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) { /* Handle error */ }

		//$result = json_decode($result);
		var_dump($result);
		return $result;
	}
	
	if (isset($_GET["event"])) {
		$resultAdd = post("?cmd=add&nom" . $_GET["nom"] . "&description=" . $_GET["description"] . "&datedebut=" . $_GET["datedebut"] . "&datefin" . $_GET["datefin"]);
	}
	
	$resultList = post("?cmd=list");
?>

<html>
<body>
	<!--Créer un événement-->
	<?php if (isset($resultAdd["message"])) {?>
		<p><?=$resultAdd["message"]?></p> 
	<?php } ?>
	
	<form name="event" method="get">
		<div>
			Nom: <br>
			<input type="text" name="event[nom]" required autofocus maxlength="32">
		</div>
		<div>
			Description:<br>
			<textarea name="event[description]">
				
			</textarea>
		</div>
		<div>
			Date de début: <br>
			<input type="date" name="event[datedebut]">
		<div>
		<div>
			Date de fin: <br>
			<input type="date" name="event[datefin]">
		</div>
		
		<input type="submit" value="ajouter" name="add">
	</form>
	
	<!--Lister les événements-->
	<?php
	if (isset($resultList->data)) {
		foreach ($resultList->data as $event) { ?>
			<div>
				<p><?= $event["nom"] ?></p>
				<p><?= $event["description"] ?></p>
				<p><?= $event["datedebut"] ?></p>
				<p><?= $event["datefin"] ?></p>
			</div>
	<?php 
		}
	}
	?>
</body>
</html>