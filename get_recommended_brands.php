<?php
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected method from the AJAX request
    $selectedMethod = json_decode(file_get_contents('php://input'), true)['selectedMethod'];

    // Query the database to get the recommended brands for the selected method
    $query = "SELECT brand_name, brand_img, brand_price, brand_longevity FROM birth_control_brand_price WHERE selected_birth_control = '$selectedMethod'";
    $result = mysqli_query($conn, $query);

    $recommendedBrands = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $recommendedBrands[] = $row;
    }

    // Respond with the recommended brands data
    echo json_encode($recommendedBrands);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
