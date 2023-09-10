<?php
include("connect.php");
require('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the user_id and selected_method from the POST data
  $user_id = $_POST['user_id'];
  $selected_method = $_POST['selected_method'];

  // Escape the data to prevent SQL injection (use mysqli_real_escape_string or prepared statements)
  $selected_method_safe = mysqli_real_escape_string($conn, $selected_method);

  // First, delete rows from the reminder table with the same user_id
  $deleteQuery = "DELETE FROM reminder WHERE user_id = '$user_id'";

  // Execute the delete query
  if (mysqli_query($conn, $deleteQuery)) {
    // The rows in the reminder table have been deleted successfully
    // Now, update the users table with the selected contraceptive method
    $updateQuery = "UPDATE users SET birth_control_name = '$selected_method_safe', birth_control_startdate = NULL, birth_control_enddate = NULL, birth_control_usage = NULL, isMessaged = NULL WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $updateQuery);

    // Check if the update was successful
    if ($result) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error updating data in the users table.']);
    }
  } else {
    // Handle the delete query error
    echo json_encode(['success' => false, 'message' => 'Error deleting data from the reminder table.']);
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
