<?php
include("connect.php"); 

if (isset($_GET['method_name'])) {
    $method_name = $_GET['method_name'];

    // Prepare the method name for the SQL query
    $methodSafe = mysqli_real_escape_string($conn, $method_name);

    // Query the database to fetch the contraceptive method information
    $query = "SELECT * FROM birth_controls WHERE LOWER(REPLACE(birth_control_name, ' ', '')) = LOWER(REPLACE('$methodSafe', ' ', ''))";
    $result = mysqli_query($conn, $query);

    // Check if the method exists in the birth_controls table
    if (mysqli_num_rows($result) > 0) {
        $method_details = mysqli_fetch_assoc($result);
        echo json_encode($method_details); // Return the method details as JSON
    } else {
        echo "Not found";
    }
}
?>
