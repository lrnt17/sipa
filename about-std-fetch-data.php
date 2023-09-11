<?php
require("connect.php");

$query = "SELECT std_img, std_name, std_symptom, std_cause, std_treatment, std_treatment_cost FROM std";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

header("Content-Type: application/json");
echo json_encode($data);
?>
