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
      } /*else
      if ($_POST['data_type'] == 'submit_periodResult') {

        $firstDayLastPeriod = new DateTime($_POST['firstDayLastPeriod']);
        $periodLength = (int)$_POST['periodLength'];
        $cycleLength = (int)$_POST['cycleLength'];
        $numOfMonths = (int)$_POST['numOfMonths'];
        $addMonths = (int)$_POST['addMonths'];

        $startDateTime = clone $firstDayLastPeriod;
        $endDateTime = clone $startDateTime;
        //$endDateTime->add(new DateInterval('P3M'));
        $endDateTime->add(new DateInterval("P{$addMonths}M"));
        $periodDays = [];
        $ovulationDays = [];
        $currentDate = clone $startDateTime;
        while ($currentDate <= $endDateTime) {
            $periodStart = clone $currentDate;
            $periodEnd = clone $currentDate;
            $periodEnd->add(new DateInterval("P{$periodLength}D"))->sub(new DateInterval('P1D'));
            $periodDays[] = ['start' => $periodStart->format('Y-m-d'), 'end' => $periodEnd->format('Y-m-d')];
            $ovulationStart = clone $currentDate;
            $ovulationStart->add(new DateInterval("P{$cycleLength}D"))->sub(new DateInterval('P16D'));
            $ovulationEnd = clone $ovulationStart;
            $ovulationEnd->add(new DateInterval('P4D'));
            $ovulationDays[] = ['start' => $ovulationStart->format('Y-m-d'), 'end' => $ovulationEnd->format('Y-m-d')];
            $currentDate->add(new DateInterval("P{$cycleLength}D"));
        }
        include 'calculate_period.php';
        // Assign generated calendar to rows key in info array
        $info['rows'] = build_calendar($startDateTime->format('n'),$startDateTime->format('Y'),$periodDays,$ovulationDays,$numOfMonths);
        $info['success'] = true;
      }*/
      else
      if ($_POST['data_type'] == 'add_method_details') {
    
        $advantages_input = addslashes($_POST['advantages_input']);
        $disadvantages_input = addslashes($_POST['disadvantages_input']);
        $fyi_input = addslashes($_POST['fyi_input']);
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

        /*$query = "SELECT * FROM appointments WHERE app_date = '$appointment_date' && app_timeslot = '$appointment_timeslot'";
        $rows = query($query);*/

        $info['success'] = true;
        $info['message'] = "Method details successfully added";
      }
      else
      if ($_POST['data_type'] == 'load_method_effects') {

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
        
      } else
      if ($_POST['data_type'] == 'delete_positive_effects') {

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
      } else
      if ($_POST['data_type'] == 'delete_negative_effects') {

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
      } else
      if ($_POST['data_type'] == 'delete_fyi') {

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
      } else
      if ($_POST['data_type'] == 'edit_positive_desc') {
    
        $edited_positive_input = addslashes($_POST['advantages_input']);
        $positive_effect_id = (int)($_POST['positive_effect_id']);
      
        $query = "update method_positive_effects set positive_effect_desc = '$edited_positive_input' where positive_effect_id = '$positive_effect_id' limit 1";
        query($query);
    
        $info['success'] = true;
        $info['message'] = "Positive effect was edited successfully";
      } else
      if ($_POST['data_type'] == 'edit_negative_desc') {
    
        $edited_negative_input = addslashes($_POST['disadvantages_input']);
        $negative_effect_id = (int)($_POST['negative_effect_id']);
      
        $query = "update method_negative_effects set negative_effect_desc = '$edited_negative_input' where negative_effect_id = '$negative_effect_id' limit 1";
        query($query);
    
        $info['success'] = true;
        $info['message'] = "negative effect was edited successfully";
      } else
      if ($_POST['data_type'] == 'edit_fyi_desc') {
    
        $edited_fyi_input = addslashes($_POST['fyi_input']);
        $fyi_id = (int)($_POST['fyi_id']);
      
        $query = "update method_fyi set fyi_desc = '$edited_fyi_input' where fyi_id = '$fyi_id' limit 1";
        query($query);
    
        $info['success'] = true;
        $info['message'] = "fyi was edited successfully";
      }
  }

  echo json_encode($info);
