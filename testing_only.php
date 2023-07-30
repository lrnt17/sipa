<?php 
  require('connect.php'); // db to
  require('functions.php'); //dito mag proprocess yung mga functions
  $info['data_type'] = "";
  $info['success'] = false; 


  if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['data_type']))
  {
      $info['data_type'] = $_POST['data_type'];
    
      if($_POST['data_type'] == 'admin_signup') {

          $emp_num = addslashes($_POST['emp_number']);
          $fullname = addslashes($_POST['fullname']);
          $gmail = addslashes($_POST['gmail']);
          $health_facility = addslashes($_POST['health_facility']);
          $selected_value = $_POST['selected_value'];
          $pnum = (int)($_POST['pnum']);
          $address = addslashes($_POST['address']);
          $password = $_POST['password'];
          $password_retype = $_POST['con_pass'];
          $terms_conditions = $_POST['terms_conditions'];
          $privacy_policy = $_POST['privacy_policy'];
          //$date = date("Y-m-d H:i:s");

          //check if employee exist
          $query = "select * from employee where employee_number = '$emp_num'";
          $emp_row = query($query);

          if(!$emp_row) {

              $info['message'] = "Employee does not exists";

          } else {

              $query = "select * from admin where admin_empnum = '$emp_num' limit 1";
              $row = query($query);
    
              if($row) {
    
                  $info['message'] = "That employee number already have an account";
    
              } else
              if ($password !== $password_retype) {
    
                  $info['message'] = "Passwords dont match";
    
              } else {
    
                  $password = password_hash($password, PASSWORD_DEFAULT);
                  $query = "insert into admin (admin_empnum,admin_fullname,admin_email,health_facility,specialization,admin_pnum,admin_address,admin_password,terms_conditions,privacy_policy)
                    values ('$emp_num','$fullname','$gmail','$health_facility','$selected_value','$pnum','$address','$password','$terms_conditions','$privacy_policy')";
                  query($query);
    
                  $query = "select * from admin where admin_email = '$gmail' limit 1";
                  $row = query($query);
                  
                  if($row){
    
                    $row = $row[0];
                    $info['success'] = true;
                    $info['message'] = "Your profile was created successfully";
                    //authenticate($row);
                  }
              }
          }

      } else
      if ($_POST['data_type'] == 'admin_login') {
    
          $emp_number = $_POST['emp_number'];
          $password = $_POST['password'];
      
          //check if this account exists
          $query = "select * from admin where admin_empnum = '$emp_number' limit 1";
          $row = query($query);
      
          if (!$row) {

            $info['message'] = "Wrong employee number or password..";

          } else {
            
            $row = $row[0];

            if (password_verify($password, $row['admin_password'])) {
              //correct
              $info['test'] = 
              $info['success'] = true;
              authenticate($row);
              $info['message'] = "Successful login";

            } else {

              $info['message'] = "Wrong employee number or password....";

            }
      
          }
      } else
      if ($_POST['data_type'] == 'load_admins') {
      
          $query = "select * from admin";
          $rows = query($query);
          
          if($rows){
      
            foreach ($rows as $key => $row) {
      
              /*$id = $row['user_id'];
              $query = "select * from users where id = '$id' limit 1";
              $user_row = query($query);
              
              if($user_row){
                $rows[$key]['user'] = $user_row[0];
                $rows[$key]['user']['image'] = get_image($user_row[0]['image']);
              }*/
            }
            
            $info['rows'] = $rows;
          }
      
          $info['success'] = true;
      } else
      if ($_POST['data_type'] == 'delete_rows') {

          // Get IDs of rows to delete
          $ids = json_decode($_POST['ids']);

          // Delete rows from database
          foreach ($ids as $id) {
            $id = (string)$id;
            $query = "delete from admin where admin_empnum = '$id' LIMIT 1";
            query($query);
          }

          $info['success'] = true;
          $info['message'] = "Your post was deleted successfully";
      } else
      if ($_POST['data_type'] == 'edit_admin') {
    
        $fullname = addslashes($_POST['edit_fullname']);
        $gmail = addslashes($_POST['edit_gmail']);
        $health_facility = addslashes($_POST['edit_health_facility']);
        $selected_value = $_POST['selected_value'];
        $pnum = (int)($_POST['edit_pnum']);
        $address = addslashes($_POST['edit_address']);
        $id = $_POST['emp_num'];
      
        $query = "update admin set 
        admin_fullname = '$fullname', 
        admin_email = '$gmail',
        health_facility = '$health_facility', 
        specialization = '$selected_value',
        admin_pnum = '$pnum', 
        admin_address = '$address' 
        where admin_empnum = '$id' limit 1";
        query($query);
    
        $info['success'] = true;
        $info['message'] = "Your post was edited successfully";
          
    
      } else
      if ($_POST['data_type'] == 'add_appointment') {
    
        $fullname = addslashes($_POST['fullname']);
        $address = addslashes($_POST['address']);
        $email = addslashes($_POST['email']);
        $municipality = addslashes($_POST['selected_municipality']);
        $contact = (int)($_POST['contact']);
        $gender = $_POST['selected_gender'];
        $dob = $_POST['dob'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_timeslot = $_POST['appointment_timeslot'];
    
        $query = "insert into appointments (app_name,app_address,app_email,city_municipality,app_pnum,app_gender,app_bdate,app_date,app_timeslot) 
        values ('$fullname','$address','$email','$municipality','$contact','$gender','$dob','$appointment_date','$appointment_timeslot')";
        query($query);

        /*$query = "SELECT * FROM appointments WHERE app_date = '$appointment_date' && app_timeslot = '$appointment_timeslot'";
        $rows = query($query);*/

        $info['success'] = true;
        $info['message'] = "Your appointment was successfully created";
      }
  }

  echo json_encode($info);
