<?php

include("connect.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['method_name'])) {
        $selectedMethod = mysqli_real_escape_string($conn, $_GET['method_name']);

        // Query the database to fetch the 'how_to_use' information for the selected method
        $query = "SELECT birth_control_how_to_use FROM birth_controls WHERE birth_control_name = '$selectedMethod'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $howToUse = $row['birth_control_how_to_use'];
            echo $howToUse; // Return the 'how_to_use' information as the response
        } else {
            echo "How to use information not found for the selected method.";
        }
    } else {
        echo "Method name parameter is missing in the request.";
    }
} else {
    echo "Invalid request method.";
}
?>
