<?php
    require('connect.php');
    require('functions.php');
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

    .table {
        display: inline-block;
        margin: 10px
    }

    #result {
        display: flex;
  flex-wrap: wrap;
    }
    </style>
</head>
<body>
    <!-- navigation bar with logo -->
    <?php //include('header.php') ?>

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
            <button id="next-3-months" onclick="period_calcu.next3Months()">Next 3 Months</button>
        </div>
        <div id="result"></div>
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


