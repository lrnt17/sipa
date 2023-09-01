<?php
 require("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedMethod = json_decode(file_get_contents('php://input'), true)['selectedMethod'];

    // Perform a database query to fetch the effectiveness rate based on $selectedMethod
    // Assuming you have a database connection established

    // Replace 'your_query_here' with your actual query to fetch the effectiveness rate
    $query = "SELECT birth_control_effectivity_rate FROM birth_controls WHERE birth_control_name = '$selectedMethod'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);
    
    // Check if a row was returned
    if ($row = mysqli_fetch_assoc($result)) {
        $effectivenessRate = $row["birth_control_effectivity_rate"];
        echo json_encode(["effectivenessRate" => $effectivenessRate]);
    } else {
        echo json_encode(["error" => "Method not found"]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
