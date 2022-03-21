<?
//Commencé a 17h50
//Fini a 19h15

define("FILE", "events.json");

if (!isset($_POST["cmd"])) {
	http_response_code(400);
	die();
}
if (!in_array($_POST["cmd"], ["add", "list"])) {
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
if ($_POST["cmd"] == "add") {
	$event = $_POST["event"];
	
	//Validation des données
	if (!validationCreer($_POST["event"])){
		$response = [ 
			'success' => false, 
			'message' => 'Formulaire invalide, le nom a-t-il moins de 32 chars?' 
		];
	 
		print json_encode( $response );
		die();
	}
	
	//On ajoute l'événement a la liste
	$events[] = $event;
	
	file_put_contents (FILE, $events);
	
	$response = [ 
		'success' => true, 
		'message' => 'Événement ajouté' 
	];
	 
	print json_encode( $response );

}
//Lister les événements
else if ($_GET["cmd"] == "list") {
	
	$response = [ 
		'success' => true, 
		'message' => 'Opération réussie',
		'data' = $events
	];
	 
	print json_encode( $response );
}

?>