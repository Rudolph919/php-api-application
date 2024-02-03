<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Subscriber;

class SubscriberRepository
{

  private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function subscriberExists($email)
    {
        $query = "SELECT * FROM subscribers WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function insertSubscriber(Subscriber $subscriber)
    {
        $query = "INSERT INTO subscribers (email, name, last_name, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssss', $subscriber->email, $subscriber->name, $subscriber->lastName, $subscriber->status);
        $stmt->execute();

        return $stmt->id;
    }
}
