<?php

// Determine the request type
$request_method = $_SERVER['REQUEST_METHOD'];

// Determine the requested URL
$request_uri = $_SERVER['REQUEST_URI'];

header('Content-Type: application/json');

echo json_encode([
  'request_method' => $request_method,
  'request_uri' => $request_uri,
]);
