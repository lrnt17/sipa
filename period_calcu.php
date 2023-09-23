<?php
    require('connect.php');
    require('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <title>SiPa | Period Tracker</title>
    
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }

        .skiptranslate iframe  {
        visibility: hidden !important;
        }
        
        .period-day {
            background-color: #CAA4D0;
            color:#ffff;
        }

        .ovulation-day {
            background-color: #F0C2A9;
            color:#ffff;
        }

        .hide{
            display: none;
        }

        .table {
            display: inline-block;
            margin: 10px
        }

        #result {
            display: flex;
            flex-wrap: wrap;
        }
        .day{
            color: #184DA8; font-weight: lighter;
            font-size:14px;
        }

        table, th, td {
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body style="background: #F2F5FF;">
    <!-- navigation bar with logo -->
    <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
        <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
        
            <div class="col-auto"><p style="font-size: 3.5rem;"><span translate="no">Period</span></p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Calculator</p></div>
        </div>
    </div>

<div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center;">
                    Wondering, “When will I get my period?” ALWAYS know! Our easy tracking tool helps map out your cycle for months.
                </div>
                
              </div>
            </div>
    

        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 10px;
                background-color: #1F6CB5;
                border-radius: 99px;
                height: 75px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-3">
                <div class="row">
                    <div class="col-auto"><p style="font-size: 2rem;  font-weight:bolder;">Track</p></div>
                    <div class="col-auto"><p style="font-size: 2rem;" >your periods</p></div>
                </div>
            </div>
        </div>
        
    
    
    <div class="text-center"id="form-container">
        <form onsubmit="period_calcu.submit(event)" method="post" class="form-con">

            <div class="row align-items-start mt-4" style="text-align: center;">
                <div class="col">
                    <div class="container">
                        <label for="last-period" style="font-weight: bold; color:#5A5A5A;">First day of last period</label>
                    </div>
                </div>
                <div class="col">
                    <div class="container">
                        <label for="period-length" style="font-weight: bold; color:#5A5A5A;">Length of last <span translate="no"> period </span> (in days)</label>
                    </div>
                </div>
                <div class="col">
                    <div class="container">
                        <label for="cycle-length" style="font-weight: bold; color:#5A5A5A;">Length of menstrual cycle (in days)</label>
                    </div>
                </div>
            </div>
            
            <div class="row align-items-start my-4" style="text-align: center;">
                <div class="col">
                    <div class="container p-3 rounded-4 shadow-sm rounded" style="background:#ffff;">
                    <input class="py-3" type="text" id="last-period" placeholder="Select date" style="border: none; outline: none; font-size:20px; color:#5A5A5A; text-align: center;" required>
                    </div>
                </div>
                <div class="col">
                    <div class="container p-3 rounded-4 shadow-sm rounded" style="background:#ffff;">
                        <input class="py-3" type="number" id="period-length" placeholder="ex. 7" min="1" max="10" value="5" style="border: none;
                        outline: none; font-size:20px; color:#5A5A5A;" required>
                    </div>
                </div>
                <div class="col">
                    <div class="container p-3 rounded-4 shadow-sm rounded" style="background:#ffff;">
                        <input class="py-3" type="number" id="cycle-length" placeholder="ex. 28" min="21" max="35" value="28" style="border: none;
                        outline: none; font-size:20px; color:#5A5A5A;" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="" style="display: flex; justify-content: center;">
                        <style> font{ vertical-align: initial !important;}</style>
                        <button class="btn my-3 px-5 py-3 rounded-pill shadow-sm rounded" id="js-calc-period-btn" style="background: #D2E0F8;">Calculate my <span translate="no"> period</span></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 20px;
                background-color: #CAA4D0;
                border-radius: 99px;
                height: 20px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-2">
                <div class="row">
                    <div class="col-auto"><p style="color:#5A5A5A;"><span translate="no">Period days</span></p></div>
                </div>
            </div>
        </div>
        <div class="row" style="align-items: center;">
            <div class="col-auto">
                <div class="vl" style="width: 20px;
                background-color: #F0C2A9;
                border-radius: 99px;
                height: 20px;
                display: -webkit-inline-box;"></div>
            </div>
        
            <div class="col-auto mt-2">
                <div class="row">
                    <div class="col-auto"><p style="color:#5A5A5A;">Ovulation period</p></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="resultbox row">
        <div class="js-period-calcu-buttons hide">
            <div class="row mt-2" style="justify-content: flex-end;">
                <div class="col-auto">
                    <p style="margin-top:10px;">Next 3 months </p>
                </div>
                <div class="col-auto">
                    <button id="next-3-months" onclick="period_calcu.next3Months()" class="btn" style="font-size:20px; color:#1F6CB5; float:right;"><i class="fa-solid fa-circle-chevron-right"></i></button>
                </div>
            </div>
        </div>
        <div id="result" style="justify-content: space-evenly;"></div>
        
    </div>

</div>

    <script>

            // Initialize Flatpickr on the date input element
        flatpickr("#last-period", {
            dateFormat: "Y-m-d", // Set the desired date format
            defaultDate: currentDate, // Set the default date
        });

        var period_calcu = {

            numOfMonths: 2,
            addMonths: 3,
            submit: function(e){

                e.preventDefault();
                let firstDayLastPeriod = document.getElementById('last-period').value;
                let periodLength = parseInt(document.getElementById('period-length').value);
                let cycleLength = parseInt(document.getElementById('cycle-length').value);

                let form = new FormData();

                form.append('firstDayLastPeriod', firstDayLastPeriod);
                form.append('periodLength', periodLength);
                form.append('cycleLength', cycleLength);
                form.append('numOfMonths', period_calcu.numOfMonths);
                form.append('addMonths', period_calcu.addMonths);
                form.append('data_type', 'submit_periodResult');
                var ajax = new XMLHttpRequest();

                ajax.addEventListener('readystatechange',function(){

                    if(ajax.readyState == 4)
                    {
                        if(ajax.status == 200){
                            //document.getElementById('result').innerHTML = "";
                            let obj = JSON.parse(ajax.responseText);

                            if(obj.success){
                                //document.getElementById('result').innerHTML = "";
                                document.getElementById('result').innerHTML = obj.rows;
                            }
                            
                            if (period_calcu.numOfMonths == 11) {
                                document.querySelector(".js-period-calcu-buttons").classList.add('hide');
                            } else {
                                document.querySelector(".js-period-calcu-buttons").classList.remove('hide');
                            }
                            
                        }else{
                            alert("Please check your internet connection");
                        }
                    }
                });

                ajax.open('post','ajax.php', true);
                ajax.send(form);
            },

            next3Months: function(){
                period_calcu.numOfMonths = period_calcu.numOfMonths + 3;
                period_calcu.addMonths += 3;

                console.log(period_calcu.numOfMonths);
                period_calcu.submit(event);
            },
        };

        var currentDate = new Date().toISOString().slice(0, 10);
        document.getElementById('last-period').value = currentDate;


        // Function to scroll to the calendar
        function scrollToCalendar() {
            var calendarContainer = document.getElementById("result");
            calendarContainer.scrollIntoView({ behavior: "smooth" }); // This will scroll to the calendar with smooth animation
        }

        // Add an event listener to the button to go to the calendar div
        var showCalendarButton = document.getElementById("js-calc-period-btn");
        showCalendarButton.addEventListener("click", scrollToCalendar);

    </script>

<br><br><br>
<?php include('footer.php') ?>
</body>
</html>
