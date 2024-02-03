<?php

namespace App\Models;
class Subscriber
{
  public $email;
  public $name;
  public $lastName;
  public $status;

  public function __construct(string $email, string $name, string $lastName, string $status)
  {
    $this->email = $email;
    $this->name = $name;
    $this->lastName = $lastName;
    $this->status = $status;
  }

  //Getters and setters for each property
  //TODO: See if the getters and setters are required
}
