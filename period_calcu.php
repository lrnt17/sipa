<!DOCTYPE html>
<html>
<head>
    <title>Period Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        h1 {
            text-align: center;
        }

        #form-container {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            width: 300px;
        }

        label {
            display: block;
            margin-top: 10px;
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
            background-color: purple;
            color: white;
        }

        .ovulation-day {
            background-color: orange;
            color: white;
        }
        
        table {
          border-collapse: collapse;
          margin-bottom: 20px;
        }
        
        td, th {
          border: 1px solid #ddd;
          padding: 8px;
          text-align:center
        }
        
    </style>
</head>
<body>
    <h1>Period Tracker</h1>
    <div id="form-container">
        <label for="last-period">First day of last period:</label>
        <input type="date" id="last-period" required>
        <br>
        <label for="period-length">Length of last period (in days):</label>
        <input type="number" id="period-length" required>
        <br>
        <label for="cycle-length">Length of menstrual cycle (in days):</label>
        <input type="number" id="cycle-length" required>
        <br>
        <button onclick="calculatePeriod()">Submit</button>
    </div>
    <div id="result"></div>

    <script>

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
    </script>
</body>
</html>