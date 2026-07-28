<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate the API request
$request = \Illuminate\Http\Request::create('/admin/bookings/available-rooms?check_in=2026-07-25&check_out=2026-07-26', 'GET');

// Get the controller
$controller = new \App\Http\Controllers\BookingController();

// Call the method
$response = $controller->getAvailableRooms($request);

echo "API Response for available rooms:\n";
echo json_encode($response->toArray(), JSON_PRETTY_PRINT);
