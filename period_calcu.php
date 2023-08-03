<?php
    require('connect.php');
    require('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
            <div class="col-auto"><p style="font-size: 3.5rem;">Period</p></div>
            <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Calculator</p></div>
        </div>
    </div>

<div class="container">

            <div class="row height d-flex justify-content-center align-items-center">

              <div class="col-md-6">

                <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center;">
                    Wondering, “When will I get my period?” ALWAYS knows! Our easy tracking tool helps map out your cycle for months.
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
        
    
    <!--<div id="form-container">
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
    </div>-->

    <div class="text-center"id="form-container">
        <form onsubmit="period_calcu.submit(event)" method="post" class="form-con">

            <div class="row align-items-start mt-4">
                <div class="col">
                    <div class="container">
                        <label for="last-period" style="font-weight: bold; color:#5A5A5A;">First day of last period</label>
                    </div>
                </div>
                <div class="col">
                    <div class="container">
                        <label for="period-length" style="font-weight: bold; color:#5A5A5A;">Length of last period (in days)</label>
                    </div>
                </div>
                <div class="col">
                    <div class="container">
                        <label for="cycle-length" style="font-weight: bold; color:#5A5A5A;">Length of menstrual cycle (in days)</label>
                    </div>
                </div>
            </div>
            
            <div class="row align-items-start my-4">
                <div class="col">
                    <div class="container p-3 rounded-4 shadow-sm rounded" style="background:#ffff;">
                        <input class="py-3" type="date" id="last-period" style="border: none;
                        outline: none; font-size:20px; color:#5A5A5A;"required>
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
                    <div class="">
                        <button class="btn my-3 px-5 py-3 rounded-pill shadow-sm rounded" style="background: #D2E0F8;">Calculate my period</button>
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
                    <div class="col-auto"><p style="color:#5A5A5A;">Period days</p></div>
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
    </script>
</body>
</html>


