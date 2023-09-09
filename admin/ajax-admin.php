<?php
    error_reporting(E_ERROR | E_PARSE);
    require('../connect.php');
    require('../functions.php');
    $info['data_type'] = "";
    $info['success'] = false;
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'C:\xampp\htdocs\PHPMailer\PHPMailer\src\Exception.php';
    require 'C:\xampp\htdocs\PHPMailer\PHPMailer\src\PHPMailer.php';
    require 'C:\xampp\htdocs\PHPMailer\PHPMailer\src\SMTP.php';

    $mail = new PHPMailer(true);

    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['data_type']))
    {
        $info['data_type'] = $_POST['data_type'];
      
        if ($_POST['data_type'] == 'load_admins') 
        {
            $query = "select * from users where user_role = 'admin'";
            $rows = query($query);
            
            if($rows){
                foreach ($rows as $key => $row) {

                    $rows[$key]['user_image'] = get_admin_image($row['user_image']);
                }
                $info['rows'] = $rows;
                $info['success'] = true;
            }
        }else
        if ($_POST['data_type'] == 'admin_registration') 
        {
            $fname = addslashes($_POST['fname']);
            $lname = addslashes($_POST['lname']);
            $gmail = addslashes($_POST['gmail']);
            $health_facility = $_POST['selected_health_facility'];
            $specialization = $_POST['selected_specialization'];
            $city_municipality = $_POST['selected_city_municipality'];
            $gender = $_POST['selected_gender'];
            $role = 'admin';
            $pnum = (int)($_POST['pnum']);
            $dob = $_POST['dob'];

            // Generate a random password
            $password = bin2hex(random_bytes(8));
            
            // Generate a username based on the first name and last name
            $username = strtolower($fname . '.' . $lname);

            // Check if the generated username already exists in the database
            $query = "select * from users where user_name = '$username'";
            $row = query($query);

            // If the generated username already exists, append a number to it
            $i = 1;
            while ($row) {
                $username = strtolower($fname . '.' . $lname . '.' . $i);
                $query = "select * from users where user_name = '$username'";
                $row = query($query);
                $i++;
            }

            $query = "select * from users where user_email = '$gmail'";
            $row = query($query);

            if ($row) {

                $info['message'] = "Email account is already in used";
            } else {

                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'iskapo081702@gmail.com';                     //SMTP username
                    $mail->Password   = 'fvpbwmnfubvsratl';                               //SMTP password
                    $mail->SMTPSecure = 'ssl';
                    //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('iskapo081702@gmail.com', 'SiPa Siguradong Pagpipilian');
                    $mail->addAddress($gmail, 'none');     //Add a recipient
                
                    //Content
                    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Registration';
                    $mail->Body    = 'Welcome to SiPa Siguradong Pagpipilian. Your account has been created with the following details:<br><br>Username: <b>' . htmlspecialchars($username) . '</b><br>Password: <b>' . htmlspecialchars($password) . '</b>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    //$info['message'] = 'Message has been sent';
            
                    // connect with database
                    //$conn = mysqli_connect('localhost','root','','hotel', 3307);

                    // insert in users table
                    //$sql = "INSERT INTO email_verification(gmail, verification_code, verified_at) VALUES ('" . $gmail . "', '" . $verification_code . "', NULL)";
                    //query($sql);
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO users(user_role, user_fname, user_lname, user_dob, user_sex, user_email, user_pnum, health_facility_name, specialization, city_municipality, user_name, user_password) 
                    VALUES ('" . $role . "', '" . $fname . "', '" . $lname . "', '" . $dob . "', '" . $gender . "', '" . $gmail . "', '" . $pnum . "', '" . $health_facility . "', '" . $specialization . "', '" . $city_municipality . "', '" . $username . "', '" . $password . "')";
                    query($query);
                    //header("Location: sign_up_completed.php?email=" . $gmail);

                    //$info['success'] = true;
                    
                    //exit();
                } catch (Exception $e) {
                    //$info['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $info['message'] = 'Message has been sent';
                $info['success'] = true;
            }
        }else
        if ($_POST['data_type'] == 'edit_admin')
        {
            
            $image = $_FILES['edit_image'];

            if ($image['name']) {
                $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            
                if (!in_array($image['type'], $allowed)) {
                    $info['message'] = "Image type not supported";
                } else {
                    $folder = "../uploads/";
            
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }
            
                    $targetPath = $folder . $image['name'];
                    move_uploaded_file($image['tmp_name'], $targetPath);
            
                    $imageFilename = $targetPath;
                }
            } else {
                $imageFilename = '';
            }

            $fname = addslashes($_POST['edit_fname']);
            $lname = addslashes($_POST['edit_lname']);
            $dob = $_POST['edit_dob'];
            $gender = $_POST['selected_gender'];
            $gmail = addslashes($_POST['edit_gmail']);
            $city_municipality = $_POST['selected_city_municipality'];
            $health_facility = $_POST['selected_health_facility'];
            $specialization = $_POST['selected_specialization'];
            $pnum = (int)($_POST['edit_pnum']);
            $user_id = $_POST['user_id'];
        
            $query = "update users set 
            user_fname = '$fname',
            user_lname = '$lname',
            user_dob = '$dob',
            user_sex = '$gender',
            user_image = '$imageFilename', 
            user_email = '$gmail',
            user_pnum = '$pnum',
            health_facility_name = '$health_facility', 
            specialization = '$specialization',
            city_municipality = '$city_municipality' 
            where user_id = '$user_id' limit 1";
            query($query);
        
            $info['success'] = true;
            $info['message'] = "Admin details was edited successfully";
        }else
        if ($_POST['data_type'] == 'delete_admin')
        {
            $ids = json_decode($_POST['ids']);

            foreach ($ids as $id) {
                $id = (string)$id;
                $query = "delete from users where user_id = '$id' LIMIT 1";
                query($query);
            }

            $info['success'] = true;
            $info['message'] = "Adminstrator/s deleted successfully";
        }else
        if($_POST['data_type'] == 'load_contraceptive_list')
        {
            $user_id = $_SESSION['USER']['user_id'] ?? 0;
            $query = "select * from birth_controls";
            $rows = query($query);
            $info['rows'] = $rows;
            $info['success'] = true;
    
        }else
        if ($_POST['data_type'] == 'load_contraceptive_data')
        {
  
            $selectedOption = (int)$_POST['selectedOption'];

            $query = "select * from method_positive_effects where birth_control_id = '$selectedOption'";
            $positive_rows = query($query);

            if ($positive_rows) {
                $info['positive_rows'] = $positive_rows;
                $info['positive_rows_success'] = true;
            }

            $query = "select * from method_negative_effects where birth_control_id = '$selectedOption'";
            $negative_rows = query($query);

            if ($negative_rows) {
                $info['negative_rows'] = $negative_rows;
                $info['negative_rows_success'] = true;
            }

            $query = "select * from method_fyi where birth_control_id = '$selectedOption'";
            $fyi_rows = query($query);

            if ($fyi_rows) {
                $info['fyi_rows'] = $fyi_rows;
                $info['fyi_rows_success'] = true;
            }
          
        }else
        if ($_POST['data_type'] == 'add_new_contraceptive_details')
        {
      
            $advantages_input = addslashes($_POST['add_new_advantages']);
            $disadvantages_input = addslashes($_POST['add_new_disadvantages']);
            $fyi_input = addslashes($_POST['add_new_fyi']);
            $selected_method = $_POST['selected_method_id'];
        
            if (!empty($advantages_input)) {
                $query = "insert into method_positive_effects (birth_control_id,positive_effect_desc) values ('$selected_method','$advantages_input')";
                query($query);
            }

            if (!empty($disadvantages_input)) {
                $query = "insert into method_negative_effects (birth_control_id,negative_effect_desc) values ('$selected_method','$disadvantages_input')";
                query($query);
            }

            if (!empty($fyi_input)) {
                $query = "insert into method_fyi (birth_control_id,fyi_desc) values ('$selected_method','$fyi_input')";
                query($query);
            }

            $info['success'] = true;
            $info['message'] = "Method details successfully added";
        }else
        if ($_POST['data_type'] == 'edit_positive_effect_desc')
        {
      
          $edited_positive_input = addslashes($_POST['advantages_input']);
          $positive_effect_id = (int)($_POST['positive_effect_id']);
        
          $query = "update method_positive_effects set positive_effect_desc = '$edited_positive_input' where positive_effect_id = '$positive_effect_id' limit 1";
          query($query);
      
          $info['success'] = true;
          $info['message'] = "Positive effect was edited successfully";
        }else
        if ($_POST['data_type'] == 'edit_negative_effect_desc') 
        {
      
          $edited_negative_input = addslashes($_POST['disadvantages_input']);
          $negative_effect_id = (int)($_POST['negative_effect_id']);
        
          $query = "update method_negative_effects set negative_effect_desc = '$edited_negative_input' where negative_effect_id = '$negative_effect_id' limit 1";
          query($query);
      
          $info['success'] = true;
          $info['message'] = "negative effect was edited successfully";
        }else
        if ($_POST['data_type'] == 'edit_fyi_desc') 
        {
      
          $edited_fyi_input = addslashes($_POST['fyi_input']);
          $fyi_id = (int)($_POST['fyi_id']);
        
          $query = "update method_fyi set fyi_desc = '$edited_fyi_input' where fyi_id = '$fyi_id' limit 1";
          query($query);
      
          $info['success'] = true;
          $info['message'] = "fyi was edited successfully";
        }else
        if ($_POST['data_type'] == 'delete_positive_effects')
        {
  
            // Get IDs of rows to delete
            $ids = json_decode($_POST['positive_effect_ids']);
  
            // Delete rows from database
            foreach ($ids as $id) {
              $id = (int)$id;
              $query = "delete from method_positive_effects where positive_effect_id = '$id' LIMIT 1";
              query($query);
            }
  
            $info['success'] = true;
            $info['message'] = "Your positive effect/s was deleted successfully";
        }else
        if ($_POST['data_type'] == 'delete_negative_effects')
        {
  
            // Get IDs of rows to delete
            $ids = json_decode($_POST['negative_effect_ids']);
  
            // Delete rows from database
            foreach ($ids as $id) {
              $id = (int)$id;
              $query = "delete from method_negative_effects where negative_effect_id = '$id' LIMIT 1";
              query($query);
            }
  
            $info['success'] = true;
            $info['message'] = "Your negative effect/s was deleted successfully";
        }else
        if ($_POST['data_type'] == 'delete_fyi_infos')
        {
  
            // Get IDs of rows to delete
            $ids = json_decode($_POST['fyi_ids']);
  
            // Delete rows from database
            foreach ($ids as $id) {
              $id = (int)$id;
              $query = "delete from method_fyi where fyi_id = '$id' LIMIT 1";
              query($query);
            }
  
            $info['success'] = true;
            $info['message'] = "Your did you know info/s was deleted successfully";
        }else
        if ($_POST['data_type'] == 'add_new_column')
        {
            $column_name = addslashes($_POST['column_name']);
  
            $query = "ALTER TABLE birth_controls_chart ADD COLUMN $column_name TINYINT(1) NOT NULL DEFAULT 0";
            $row = alter_table_query($query);
            
            if ($row) {
                $info['success'] = true;
                $info['message'] = "Column ". $column_name ." is successfully created";
            } else {
                $info['message'] = "Column ". $column_name ." failed to create";
            }
        }else
        if ($_POST['data_type'] == 'load_contraceptive_chart')
        {
            $query = "SELECT * FROM birth_controls_chart";
            $rows = query($query);
            
            $info = array();
            $info['columns'] = array();
            $info['rows'] = array();

            if ($rows) {

                foreach ($rows as $row) {
                    $info['rows'][] = $row;
                }

                $info['columns'] = array_keys($info['rows'][0]);
                $info['success'] = true;
                // Exclude columns
                $columns_to_exclude = ['birth_control_chart_id', 'birth_control_icon'];
                foreach ($columns_to_exclude as $column_to_exclude) {
                    if (($key = array_search($column_to_exclude, $info['columns'])) !== false) {
                        unset($info['columns'][$key]);
                    }
                }
            }
        }else
        if ($_POST['data_type'] == 'load_data_edit_chart')
        {
            $id = $_POST['birth_control_chart_id'];

            $query = "SELECT * FROM birth_controls_chart WHERE birth_control_chart_id = '$id' LIMIT 1";
            $rows = query($query);

            if ($rows) {

                $info['chart_row_data'] = $rows;
                $info['success'] = true;
                
            }
        }else
        if ($_POST['data_type'] == 'update_chart_row')
        {
            $id = $_POST['birth_control_chart_id'];
            $query = "UPDATE birth_controls_chart SET ";
            $values = [];
            foreach ($_POST as $key => $value) {
                if ($key != 'birth_control_chart_id' && $key != 'data_type') {
                    $values[] = "$key='$value'";
                }
            }
            $query .= implode(", ", $values);
            //$query .= implode($values, ", ");
            $query .= " WHERE birth_control_chart_id = '$id'";
            query($query);

            //if ($check) {
                $info['success'] = true;
                $info['message'] = "edited successfully";
            //}
        }else
        if ($_POST['data_type'] == 'load_appointments') 
        {
            $city_municipality = $_POST['city_municipality'];
            $health_facility = $_POST['health_facility'];
            $page = $_POST['page'];
            //$rows_per_page = 10;
            $rows_per_page = 2;
            $offset = ($page - 1) * $rows_per_page;

            $query = "SELECT COUNT(*) FROM appointments WHERE city_municipality = '$city_municipality' AND health_facility = '$health_facility'";
            $result = query($query);
            $total_rows = $result[0]['COUNT(*)'];
            $last_page = ceil($total_rows / $rows_per_page);
            
            $query = "SELECT * FROM appointments WHERE city_municipality = '$city_municipality' AND health_facility = '$health_facility' ORDER BY app_id LIMIT $rows_per_page OFFSET $offset";
            $rows = query($query);
            
            if($rows){
                /*foreach ($rows as $key => $row) {

                    $rows[$key]['user_image'] = get_admin_image($row['user_image']);
                }*/
                $info['rows'] = $rows;
                $info['last_page'] = $last_page;
                $info['success'] = true;
            }
        }else
        if ($_POST['data_type'] == 'search_appointments') 
        {
            $city_municipality = $_POST['city_municipality'];
            $health_facility = $_POST['health_facility'];
            $query = $_POST['query'];
            //$sql = "SELECT * FROM appointments WHERE city_municipality = '$city_municipality' AND app_name LIKE '%$query%' ORDER BY app_id";
            $sql = "SELECT * FROM appointments WHERE (app_fname LIKE '%$query%' OR app_lname LIKE '%$query%') AND city_municipality = '$city_municipality' AND health_facility = '$health_facility' ORDER BY app_id";
            $rows = query($sql);
            if ($rows) {
                $info['rows'] = $rows;
                $info['success'] = true;
            }
        }
    }
  
    echo json_encode($info);
?>