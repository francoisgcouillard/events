<?php
//Commencé a 17h50
//Fini a 19h15

//22h20
//23h10

define("FILE", "events.json");

if (!isset($_GET["cmd"])) {
	http_response_code(400);
	die();
}
if (!in_array($_GET["cmd"], ["add", "list"])) {
	http_response_code(406);
	die();
}

function validationCreer($form) {
	
	//nom 32 char max
	if (count($form["nom"]) > 32) {
		return false;
	}
	
	return true;
}

$events = json_decode(file_get_contents(FILE), true);

header('Content-Type: application/json; charset=utf-8');

//Créer un événement
if ($_GET["cmd"] == "add") {
	//Validation des données
	if (!validationCreer($_GET["event"])){
		$response = [ 
			'success' => false, 
			'message' => 'Formulaire invalide, le nom a-t-il moins de 32 chars?',
			'data' => null
		];
	 
		print json_encode( $response );
		die();
	}
	
	//On ajoute l'événement a la liste
	$events[] = $_GET["event"];
	
	file_put_contents (FILE, json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
	
	$response = [ 
		'success' => true, 
		'message' => 'Événement ajouté',
		'data' => null
	];
	 
	print json_encode( $response );

}
//Lister les événements
else if ($_GET["cmd"] == "list") {
	
	$response = [ 
		'success' => true, 
		'message' => 'Opération réussie',
		'data' => $events
	];
	 
	print json_encode( $response );
}

?>