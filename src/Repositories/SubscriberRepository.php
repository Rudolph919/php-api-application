<?php

namespace App\Repositories;

use PDO;
use App\Models\Subscriber;
use App\Config\DatabaseConnection;

class SubscriberRepository
{

  private $conn;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->conn = $databaseConnection->createConnection();
    }

    public function subscriberExists($email)
    {
      $query = "SELECT COUNT(*) FROM subscribers WHERE email = :email";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':email', $email);
      $stmt->execute();

      if ($stmt->fetchColumn() === 0) {
        return false;
      } else {
        return $this->getSubscriberDetails($email);
      }
    }

    public function insertSubscriber(Subscriber $subscriber)
    {
      $query = "INSERT INTO subscribers (email, name, last_name, status) VALUES (:email, :name, :last_name, :status)";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':email', $subscriber->email);
      $stmt->bindParam(':name', $subscriber->name);
      $stmt->bindParam(':last_name', $subscriber->lastName);
      $stmt->bindParam(':status', $subscriber->status);
      $stmt->execute();

      return $this->getSubscriberDetails($subscriber->email);

    }

    public function getSubscriberDetails($email)
    {
        $query = "SELECT * FROM subscribers WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
