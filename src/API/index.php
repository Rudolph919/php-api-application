<?php

namespace App\API;

use Exception;
use PDOException;
use App\Models\Subscriber;
use App\Config\DatabaseConnection;
use App\Repositories\SubscriberRepository;

require_once __DIR__ . '/../Repositories/SubscriberRepository.php';
require_once __DIR__ . '/../Config/DatabaseConnection.php';
require_once __DIR__ . '/../Models/Subscriber.php';

//Create DB connection
try {
  $databaseConnection = new DatabaseConnection();
} catch (PDOException $e) {
  die('Could not establish a DB connection: ' . $e->getMessage());
}

$subscriberRepository = new SubscriberRepository($databaseConnection);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if ($_GET['action'] === 'getAllSubscribers') {
    try {
        $subscribers = $subscriberRepository->getAllSubscribers();
    } catch (Exception $e) {
        die('Could not get subscribers: ' . $e->getMessage());
    }
    echo json_encode($subscribers);
  } elseif ($_GET['action'] === 'getSubscriber') {
    try {
        $email = $_GET['email'];
        $subscriber = $subscriberRepository->getSubscriberDetails($email);
    } catch (Exception $e) {
        die('Could not get subscriber: ' . $e->getMessage());
    }
    echo json_encode($subscriber);
  }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $action = json_decode(file_get_contents('php://input'), true)['action'];
  $data = json_decode(file_get_contents('php://input'), true)['subscriber'];

  if ($action === 'registerSubscriber') {
    $errors = []; // Initialize errors array

    //Validate data
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Invalid email address';
    }

    $name = strip_tags(htmlspecialchars($data['name']));
    if (empty($name)) {
      $errors['name'] = 'Name is required';
    }

    $last_name = strip_tags(htmlspecialchars($data['last_name']));
    if (empty($last_name)) {
      $errors['last_name'] = 'Last name is required';
    }

    $status = strip_tags(htmlspecialchars($data['status']));
    if (empty($status)) {
      $errors['status'] = 'Status is required';
    }

    //if any input is invalid, return errors
    if (!empty($errors)) {
      echo json_encode(['errors' => $errors]);
    }

    //Check if subscriber details exists
    try {
      $subscriberData = $subscriberRepository->subscriberExists($email);
    } catch (PDOException $e) {
      die('Error while checking if subscriber exists: ' . $e->getMessage());
    }

    if ($subscriberData) {
      echo json_encode([
          'message' => 'Subscriber already exists',
          'data' => $subscriberData
      ]);
    }

    try {
      $newSubscriber = new Subscriber($email, $name, $last_name, $status);
      $insertData = $subscriberRepository->insertSubscriber($newSubscriber);
      echo json_encode([
          'message' => 'Subscriber added successfully',
          'data' => $insertData
      ]);
    } catch (PDOException $e) {
      die('Error while inserting subscriber: ' . $e->getMessage());
    }
  }
}
