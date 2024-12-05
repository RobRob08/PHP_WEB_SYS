<?php
include 'db_connect.php';

header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the order data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Log the incoming data for debugging
    file_put_contents('php://stderr', print_r($data, true)); // This logs to error log

    // Check if all the required fields are present
    if (isset($data['first_name'], $data['last_name'], $data['email'], $data['country'], $data['street_address_1'], $data['city'], $data['state'], $data['zip'])) {

        // Prepare SQL to insert the order into the orders table
        try {
            $street_address_2 = isset($data['street_address_2']) ? $data['street_address_2'] : null;

            $stmt = $pdo->prepare('INSERT INTO orders (first_name, last_name, email, country, street_address_1, street_address_2, city, state, zip, created_at) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');

            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['country'],
                $data['street_address_1'],
                $street_address_2,
                $data['city'],
                $data['state'],
                $data['zip']
            ]);

            $orderId = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'order_id' => $orderId]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }

    } else {
        // If required fields are missing
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
