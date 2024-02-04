<?php

use App\Config\DatabaseConnection;
use App\Models\Subscriber;
use App\Repositories\SubscriberRepository;

require_once __DIR__ . '/Repositories/SubscriberRepository.php';
require_once __DIR__ . '/Config/DatabaseConnection.php';
require_once __DIR__ . '/Models/Subscriber.php';

header('Content-Type: application/json');

//Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  //Check to see if the request is for /api/subscribers
  if ($_SERVER['REQUEST_URI'] === '/api/subscribers') {
    // Check if $_POST is populated
    if (!empty($_POST)) {
      $email = $_POST['email'];
      $name = $_POST['name'];
      $last_name = $_POST['last_name'];
      $status = $_POST['status'];
    } else {
        // If $_POST is not populated, try using file_get_contents
        $rawData = file_get_contents("php://input");
        parse_str($rawData, $postData);

        // Now $postData should contain the parsed data
        $email = $postData['email'];
        $name = $postData['name'];
        $last_name = $postData['last_name'];
        $status = $postData['status'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Invalid email address';
    }

    if (empty($name)) {
      $errors['name'] = 'Name is required';
    }

    if (empty($last_name)) {
      $errors['last_name'] = 'Last name is required';
    }

    if (empty($status)) {
      $errors['status'] = 'Status is required';
    }

    //if any input is invalid, return errors
    if (!empty($errors)) {
      echo json_encode(['errors' => $errors]);
      exit;
    }

    //Create DB connection
    try {
      $databaseConnection = new DatabaseConnection();
    } catch (PDOException $e) {
      die('Could not establish a DB connection: ' . $e->getMessage());
    }

    //Check if subscriber details exists
    try {
      $subscriberRepository = new SubscriberRepository($databaseConnection);
      $subscriberData = $subscriberRepository->subscriberExists($email);
    } catch (PDOException $e) {
      die('Error while checking if subscriber exists: ' . $e->getMessage());
    }

    if ($subscriberData) {
      echo json_encode([
          'message' => 'Subscriber already exists',
          'data' => $subscriberData
      ]);
      exit;
    }

    //Insert new subscriber
    try {
      $newSubscriber = new Subscriber($email, $name, $last_name, $status);
      $insertData = $subscriberRepository->insertSubscriber($newSubscriber);
    } catch (PDOException $e) {
      die('Error while inserting subscriber: ' . $e->getMessage());
    }

    echo json_encode([
      'message' => 'Subscriber added successfully',
      'data' => $insertData,
    ]);

  } else {
    echo json_encode(['message' => 'Invalid request uri...it is not currently supported']);
  }

} else {
  echo json_encode(['message' => 'This is a GET request']);
}
