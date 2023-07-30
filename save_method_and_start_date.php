<?php
 include("connect.php");
 require('functions.php');


 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user_id, selected_method, and selected_date from the POST data
    $user_id = $_SESSION['USER']['user_id'];
    $selected_method = $_POST['selected_method'];
    $selected_date = $_POST['selected_date'];

    // Escape the data to prevent SQL injection (use mysqli_real_escape_string or prepared statements)
    $selected_method_safe = mysqli_real_escape_string($conn, $selected_method);
    $selected_date_safe = mysqli_real_escape_string($conn, $selected_date);

    
    // Convert the received UTC date back to the server's time zone
    // You can set the desired time zone for your application using date_default_timezone_set()
    // For example, if your server is in the "Asia/Manila" time zone, use the following:
        date_default_timezone_set('Asia/Manila');
        $selected_date_local = date('Y-m-d', strtotime($selected_date_safe));
    
    // Update the users table with the selected contraceptive method and start date
    $query = "UPDATE users SET birth_control_name = '$selected_method_safe', birth_control_startdate = '$selected_date_local' WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    // Check if the update was successful
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating data in the database.']);
    }

    // Close the database connection
    mysqli_close($conn);
}
  ?>

