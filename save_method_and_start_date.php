<?php
 include("connect.php");
 require('functions.php');


 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user_id, selected_method, and selected_date from the POST data
    $user_id = $_SESSION['USER']['user_id'];
    $selected_method = $_POST['selected_method'];
    $selected_date = $_POST['selected_date'];
    $birth_control_usage = $_POST['birth_control_usage'];

    // Escape the data to prevent SQL injection (use mysqli_real_escape_string or prepared statements)
    $selected_method_safe = mysqli_real_escape_string($conn, $selected_method);
    $selected_date_safe = mysqli_real_escape_string($conn, $selected_date);
    $birth_control_usage_safe = mysqli_real_escape_string($conn, $birth_control_usage);

    
    // Convert the received UTC date back to the server's time zone
        date_default_timezone_set('Asia/Manila');
        $selected_date_local = date('Y-m-d', strtotime($selected_date_safe));
    
    // Update the users table with the selected contraceptive method and start date
    $query = "UPDATE users SET birth_control_name = '$selected_method_safe', birth_control_startdate = '$selected_date_local', birth_control_usage = '$birth_control_usage_safe', isMessaged = NULL WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    // Check if the update was successful
    if ($result) {

        $deleteQuery = "DELETE FROM reminder WHERE user_id = '$user_id'";
        $result2 = mysqli_query($conn, $deleteQuery);
        
        // Calculate and insert reminder dates based on the selected method, start date, and usage
        if (calculateAndInsertReminderDates($selected_method_safe, $selected_date_local, $birth_control_usage_safe, $user_id, $conn)) {
            // Call the sendInstantSMS function here
            sendInstantSMS($conn, $user_id);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error calculating or inserting reminder dates.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating data in the database.']);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
