<?php
    /*
    function build_calendar1($month, $year){

        $daysOfWeek = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        //Then we'll get the first day of the month that is in the argument of this function
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        //Now getting the number of days this month contains
        $numberDays = date('t', $firstDayOfMonth);
        //Getting some information about the first day of this month
        $dateComponents = getdate($firstDayOfMonth);
        //Getting the name of this month
        $monthName = $dateComponents['month'];
        //Getting the index value 0-6 of the first day of this month
        $dayOfWeek = $dateComponents['wday'];
        //Getting the current date
        $dateToday = date('Y-m-d');
        //Now creating the HTML table
        $calendar = "<table class='table table-bordered'>";
        $calendar.="<center><h2>$monthName $year</h2>";

        $calendar.="<tr>";

        //Creating the calendars headers
        foreach($daysOfWeek as $day){
            $calendar.="<th class='header'>$day</th>";
        }

        $calendar.= "</tr><tr>";

        //The variable $dayOfWeek will make sure that there must be only 7 columns on our table
        if($dayOfWeek > 0){
            for($k=0; $k<$dayOfWeek;$k++){
                $calendar.="<td></td>";
            }
        }

        //Initiating the day counter
        $currentDay = 1;

        //Getting the month number
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {

            //If seventh column (Saturday) reached, start a new row
            if ($dayOfWeek==7) {
                $dayOfWeek=0;
                $calendar.="</tr><tr>";
            }
            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";

            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
            $isWeekend = ($dayOfWeek == 0 || $dayOfWeek == 6); // Check if it's Saturday (0) or Sunday (6)
            
            $calendar.="<td><h4>$currentDay</h4>";

            $calendar.="</td>";

            //Incrementing the counters
            $currentDay++;
            $dayOfWeek++;
        }

        //Completing the row of the last week in month, if necessary
        if($dayOfWeek != 7){
            $remainingDays = 7-$dayOfWeek;

            for ($i=0; $i<$remainingDays; $i++) { 
                $calendar.="<td></td>";
            }
        }

        $calendar.="</tr>";
        $calendar.="</table>";

        echo $calendar;
    }
    */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>Period Tracker</title>
    <!--<style>
        body {
            top:0!important;
            height: 100%;
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
            letter-spacing: 1px;
            background: #F2F5FF;
        }

        #form-container {
            display: flex;
            justify-content: center;
            margin: 0 auto;
            width:100%;
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 15px;
            color: #575757;
            text-align:center;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 5px;
        }

        button {
            margin-top: 10px;
            padding: 5px 10px;
        }

        #result {
            margin-top: 20px;
        }

        .calendar-day {
            display: inline-block;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            margin: 2px;
        }

        .period-day {
            background-color: #CAA4D0;
            color: white;
        }

        .ovulation-day {
            background-color: #F0C2A9;
            color: white;
        }
        
        table {
          border-collapse: collapse;
          margin-bottom: 20px;
        }
        
        td{
            font-size:15px;
            border: 0px solid #ddd;
            padding: 10px;
            text-align:center;
        }

        th {
            font-size:15px;
            border: 0px solid #ddd;
            padding: 10px;
            text-align:center;
            color: #184DA8;
        }

        .container-header{
            display: flex;
            justify-content: center;
            margin: 0 auto;
            width:100%;
            margin: 0;
        }

        .head{
            width: 80%;
            min-height: auto;
            background: #D2E0F8;
            border-radius: 30px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            padding: 40px 40px;
        }

        h1{
            display:inline;
        }
        
        .h1text{
            display: flex;
            justify-content: center;
        }

        .header-text{
            color: #2F2F2F;
            font-weight: 400;
            font-size: 60px;
        }

        .header-text1{
            color: #2F2F2F;
            font-weight: 600;
            font-size: 60px;
        }

        .infobox{
            display: flex;
            justify-content: center;
            margin: 0 auto;
            width:100%;
            margin: 0;
        }

        .infotext-box{
            width: 35%;
            min-height: auto;
            background: #FFFFFF;
            border-radius: 25px;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            padding: 5px 70px;
            margin-top: -2.5%;
            z-index: 1;
        }

        p{
            text-align:center;
            font-size: 15px;
            color: #575757;
        }

        .top-con{
            padding-left: 7%;
            padding-top: 3%;
            display: flex;
            width:100%;
            align-items: center;

        }

        .vl {
            width: 13px;
            background-color: #1F6CB5;
            border-radius: 99px;
            height: 65px;
        }

        .title{
            display: flex;
            justify-content: center;
        }

        .title-text{
            margin-left:20px;
            color: #2F2F2F;
            font-weight: 600;
            font-size: 32px;
        }

        .title-text1{
            color: #2F2F2F;
            font-weight: 400;
            font-size: 32px;
        }

        .btn{
            display: flex;
            justify-content: center;
            width:100%;
            margin: 0;
        }

        .log-btn{
            width: 25%;
            padding: 25px 20px;
            text-align: center;
            border: none;
            background: #D2E0F8;
            border-radius: 25px;
            font-size: 1.2rem;
            color: #2F2F2F;
            cursor: pointer;
            box-shadow: 0 0 2px rgba(0,0,0,.3);
            letter-spacing: 1.3px;
        }

        .form-con{
            display: flex;
            width: 80%;
            min-height: auto;
            background: #F2F5FF;
            border-radius: 30px;
            padding: 40px 40px 40px 0px;
        }

        .form-box{
            width: 50%;
            min-height: auto;
            padding: 0px 20px 40px 40px;
            
        }

        input{
            width: 85%;
            height: 50%;
            border: none;
            padding: 25px 35px;
            font-size: 1rem;
            border-radius: 25px;
            background: #ffff;
            outline: none;
            box-shadow: 0 0 5px rgba(0,0,0,.3);
            margin-top: 15px;
        }

        .resultbox{
            display: flex;
            justify-content: center;
            margin: 0 auto;
            width:100%;

        }
        
    </style>-->
    <style>
        .period-day {
    background-color: pink;
    }

    .ovulation-day {
        background-color: #c7e3b1;
    }

    .hide{
        display: none;
    }
    </style>
</head>
<body>
    <div class="container-header">
        <div class="head">
            <div class="h1text">
                <h1 class="header-text">Period &#8202;</h1>
                <h1 class= "header-text1">Calculator</h1>
            </div>
        </div>
    </div>
    <div class="infobox">
        <div class="infotext-box">
            <p>Wondering, “When will I get my period?” ALWAYS knows! Our easy tracking tool helps map out your cycle for months.</p>
        </div>
    </div>
    <div class="top-con">
        <div class="vl"></div>
        <div class="title">
            <h1 class="title-text">Track &#8202;</h1>
            <h1 class= "title-text1">your periods</h1>
        </div>
    </div>
    
    <!--<div id="form-container">
        <div class="form-con">
            <div class="form-box">
                <label for="last-period">First day of last period</label>
                <input type="date" id="last-period" required>
            </div>
            <div class="form-box">
                <label for="period-length">Length of last period (in days)</label>
                <input type="number" id="period-length" placeholder="ex. 7" min="1" max="10" value="5" required>
            </div>
            <div class="form-box">
                <label for="cycle-length">Length of menstrual cycle (in days)</label>
                <input type="number" id="cycle-length" placeholder="ex. 28" min="21" max="35" value="28" required>
            </div>
        </div>
    </div>
    <div class="btn">
        <button class="class_60 log-btn" onclick="calculatePeriod()">Calculate my period</button>
    </div>-->
    <div id="form-container">
        <form onsubmit="period_calcu.submit(event)" method="post" class="form-con">
            <div class="form-box">
                <label for="last-period">First day of last period</label>
                <input type="date" id="last-period" required>
            </div>
            <div class="form-box">
                <label for="period-length">Length of last period (in days)</label>
                <input type="number" id="period-length" placeholder="ex. 7" min="1" max="10" value="5" required>
            </div>
            <div class="form-box">
                <label for="cycle-length">Length of menstrual cycle (in days)</label>
                <input type="number" id="cycle-length" placeholder="ex. 28" min="21" max="35" value="28" required>
            </div>
            <div class="btn">
                <button class="class_60 log-btn">Calculate my period</button>
            </div>
        </form>
    </div>
    
    <div class="resultbox">
        <div class="js-period-calcu-buttons hide">
            <button id="prev-3-months">Previous 3 Months</button>
            <button id="next-3-months" onclick="period_calcu.next3Months()">Next 3 Months</button>
        </div>
        <div id="result"></div>
    </div>

    <!--<script>

      function createCalendar(firstDay, periodLength, cycleLength) {
          var currentDate = new Date(firstDay);
          var currentMonth = currentDate.getMonth();
          var currentYear = currentDate.getFullYear();
          var table = document.createElement('table');
          var thead = document.createElement('thead');
          var tbody = document.createElement('tbody');
          var tr = document.createElement('tr');
          var th = document.createElement('th');
          th.colSpan = 7;

          th.textContent = currentDate.toLocaleString('default', { month: 'long' }) + ' ' + currentYear;

          tr.appendChild(th);
          thead.appendChild(tr);

          tr = document.createElement('tr');
          var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
          for (var i = 0; i < daysOfWeek.length; i++) {
              th = document.createElement('th');
              th.textContent = daysOfWeek[i];
              tr.appendChild(th);
          }
          thead.appendChild(tr);

          tr = document.createElement('tr');
          for (var i = 0; i < currentDate.getDay(); i++) {
              var td = document.createElement('td');
              tr.appendChild(td);
          }

          for (var i = 0; i < 90; i++) {

              if (currentDate.getMonth() !== currentMonth) {
                  tbody.appendChild(tr);
                  table.appendChild(thead);
                  table.appendChild(tbody);
                  currentMonth = currentDate.getMonth();
                  currentYear = currentDate.getFullYear();
                  thead = document.createElement('thead');
                  tbody = document.createElement('tbody');
                  tr = document.createElement('tr');
                  th = document.createElement('th');
                  th.colSpan = 7;

                  th.textContent = currentDate.toLocaleString('default', { month: 'long' }) + ' ' + currentYear;

                  tr.appendChild(th);
                  thead.appendChild(tr);

                  tr = document.createElement('tr');

                  for (var j = 0; j < daysOfWeek.length; j++) {
                      th = document.createElement('th');
                      th.textContent = daysOfWeek[j];
                      tr.appendChild(th);
                  }
                  thead.appendChild(tr);

                  tr = document.createElement('tr');

                  for (var j = 0; j < currentDate.getDay(); j++) {
                      td = document.createElement('td');
                      tr.appendChild(td);
                  }
              }

              td = document.createElement('td');

              if (i % cycleLength < periodLength) {
                  td.classList.add('period-day');
              } else if (i % cycleLength === cycleLength - 14) {
                  td.classList.add('ovulation-day');
              }

              td.textContent = currentDate.getDate();
              tr.appendChild(td);

              if (currentDate.getDay() === 6) {
                  tbody.appendChild(tr);
                  tr = document.createElement('tr');
              }

              currentDate.setDate(currentDate.getDate() + 1);
          }

          tbody.appendChild(tr);
          table.appendChild(thead);
          table.appendChild(tbody);

          return table;
      }

        function calculatePeriod() {
            var firstDay = document.getElementById('last-period').value;
            var periodLength = parseInt(document.getElementById('period-length').value);
            var cycleLength = parseInt(document.getElementById('cycle-length').value);

            var result = document.getElementById('result');
            result.innerHTML = '';

            var calendar = createCalendar(firstDay, periodLength, cycleLength);
            result.appendChild(calendar);
        }
    </script>-->
    <script>
        function calculatePeriod() {
            // Get user inputs
            const firstDayLastPeriod = document.getElementById('last-period').value;
            const periodLength = parseInt(document.getElementById('period-length').value);
            const cycleLength = parseInt(document.getElementById('cycle-length').value);

            // Make an AJAX request to the PHP script to calculate the period and ovulation days
            const xhr = new XMLHttpRequest();
            const url = `calculate_period.php?first_day_last_period=${firstDayLastPeriod}&period_length=${periodLength}&cycle_length=${cycleLength}`;
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Display the result on the calendar
                const result = xhr.responseText;
                document.getElementById('result').innerHTML = result;
            }
            };
            xhr.send();
        }

        var period_calcu = {

            submit: function(e){

                e.preventDefault();
                let firstDayLastPeriod = document.getElementById('last-period').value;
                let periodLength = parseInt(document.getElementById('period-length').value);
                let cycleLength = parseInt(document.getElementById('cycle-length').value);

                let form = new FormData();

                form.append('firstDayLastPeriod', firstDayLastPeriod);
                form.append('periodLength', periodLength);
                form.append('cycleLength', cycleLength);
                form.append('data_type', 'submit_periodResult');
                var ajax = new XMLHttpRequest();

                ajax.addEventListener('readystatechange',function(){

                    if(ajax.readyState == 4)
                    {
                        if(ajax.status == 200){

                            let obj = JSON.parse(ajax.responseText);
                            document.getElementById('result').innerHTML = obj.rows;
                            document.querySelector(".js-period-calcu-buttons").classList.remove('hide');
                        }else{
                            alert("Please check your internet connection");
                        }
                    }
                });

                ajax.open('post','testing_only.php', true);
                ajax.send(form);
            },

            /*next3Months: function() {
                // Add 3 months to the end date
                let calendarEndDate = new Date(document.getElementById('calendar-end-date').value);
                calendarEndDate.setMonth(calendarEndDate.getMonth() + 3);

                // Update the value of the calendar-end-date input
                document.getElementById('calendar-end-date').value = calendarEndDate.toISOString().slice(0, 10);

                // Send an AJAX request to rebuild the calendar with the new end date
                this.submit(new Event('submit'));
            }*/
        };

        var currentDate = new Date().toISOString().slice(0, 10);
        document.getElementById('last-period').value = currentDate;
    </script>
</body>
</html>
