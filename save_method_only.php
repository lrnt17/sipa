<?php
include("connect.php");
require('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the user_id and selected_method from the POST data
  $user_id = $_POST['user_id'];
  $selected_method = $_POST['selected_method'];

  // Escape the data to prevent SQL injection (use mysqli_real_escape_string or prepared statements)
  $selected_method_safe = mysqli_real_escape_string($conn, $selected_method);

  // Update the users table with the selected contraceptive method
  $query = "UPDATE users SET birth_control_name = '$selected_method_safe' WHERE user_id = '$user_id'";
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
