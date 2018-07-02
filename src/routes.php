<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$configuration = array(
		'settings' => [
			'displayErrorDetails' => true,
		],
);

$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);


// GET ALL COSTUMERS
$app->get('/api/costumers', function(Request $request,Response $response){

$query = "SELECT * FROM costumers";

	try {
		//GET DB OBJECT
		$db = new db();
		//CONNECT
		$db = $db->connect();

		$stmt = $db->query($query);
		$costumers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($costumers);

	} catch (PDOException $e) {
		echo '{"error":{"text": '.$e->getMessage().'}';
	}

});




//GET SINGLE COSTUMER
$app->get('/api/costumer/{id}', function(Request $request,Response $response){

$id = $request->getAttribute('id');

$query = "SELECT * FROM costumers WHERE id = $id";

	try {
		//GET DB OBJECT
		$db = new db();
		//CONNECT
		$db = $db->connect();

		$stmt = $db->query($query);
		$costumer = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($costumer);

	} catch (PDOException $e) {
		echo '{"error":{"text": '.$e->getMessage().'}';
	}

});


//DELETE SINGLE COSTUMER
$app->delete('/api/costumer/delete/{id}', function(Request $request,Response $response){

$id = $request->getAttribute('id');
 
$query = "DELETE FROM costumers WHERE id = $id";

	try {
		//GET DB OBJECT
		$db = new db();
		//CONNECT
		$db = $db->connect();

		$stmt = $db->prepare($query);
		$stmt->execute();
		echo '{"Notice": "Costumer Deleted"}';


	} catch (PDOException $e) {
		echo '{"error":{"text": '.$e->getMessage().'}';
	}

});


//ADD SINGLE COSTUMER
$app->post('/api/costumer/add', function(Request $request,Response $response){
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$state = $request->getParam('state');


$query = "INSERT INTO costumers (first_name,last_name,phone,email,address,city,state) VALUES 
(:first_name,:last_name,:phone,:email,:address,:city,:state)";

	try {
		//GET DB OBJECT
		$db = new db();
		//CONNECT
		$db = $db->connect();

		$stmt = $db->prepare($query);
		$stmt->bindParam(':first_name',$first_name);
		$stmt->bindParam(':last_name',$last_name);
		$stmt->bindParam(':phone',$phone);
		$stmt->bindParam(':email',$email);
		$stmt->bindParam(':address',$address);
		$stmt->bindParam(':city',$city);
		$stmt->bindParam(':state',$state);
		
		$stmt->execute();

		echo '{"Notice": {"text:" "Customer Added"}';

	} catch (PDOException $e) {
		echo '{"error":{"text": '.$e->getMessage().'}';
	}

});

//UPDATE SINGLE COSTUMER

//ADD SINGLE COSTUMER
$app->put('/api/costumer/update/{id}', function(Request $request,Response $response){
	$id = $request->getAttribute('id');

	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$state = $request->getParam('state');

$query = "UPDATE costumers SET 

		first_name = :first_name,
		last_name = :last_name,
		phone = :phone,
		email = :email ,
		address = :address ,
		city = :city ,
		state = :state 
	WHERE id = $id";

	try {
		//GET DB OBJECT
		$db = new db();
		//CONNECT
		$db = $db->connect();

		$stmt = $db->prepare($query);
		$stmt->bindParam(':first_name',$first_name);
		$stmt->bindParam(':last_name',$last_name);
		$stmt->bindParam(':phone',$phone);
		$stmt->bindParam(':email',$email);
		$stmt->bindParam(':address',$address);
		$stmt->bindParam(':city',$city);
		$stmt->bindParam(':state',$state);
		
		$stmt->execute();

		echo '{"Notice": {"text:" "Customer Updated"}';

	} catch (PDOException $e) {
		echo '{"error":{"text": '.$e->getMessage().'}';
	}

});



?>