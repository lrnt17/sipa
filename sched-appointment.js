var sched_appointment = {

    currentPage: (typeof currentPage == 'undefined') ? 1 : currentPage,
    totalPages: (typeof totalPages == 'undefined') ? 3 : totalPages,
    month: (typeof month == 'undefined') ? getMonth() : month,
    year: (typeof year == 'undefined') ? getFullYear(): year,
    selectedDate: null,
    selectedTimeslot: null,
    location: null,
    health_facility: null,
    barangay: null,

    submit_appointment: function(e){
        
        e.preventDefault();

        // check if a timeslot has been selected
        if (!sched_appointment.validatePage3()) {
            alert('Please select a timeslot.');
            return;
        }

        let inputs = e.currentTarget.querySelectorAll('.modal-content input');
        let select_municipality = document.getElementById("municipality");
        let selected_municipality = select_municipality.options[select_municipality.selectedIndex].value;
        let select_barangay = document.getElementById("barangay");
        let selected_barangay = select_barangay.options[select_barangay.selectedIndex].value;
        let select_health_facility = document.getElementById("health_facility");
        let selected_health_facility = select_health_facility.options[select_health_facility.selectedIndex].value;
        let select_gender = document.getElementById("gender");
        let selected_gender = select_gender.options[select_gender.selectedIndex].value;
        let appointment_date = sched_appointment.selectedDate;
        let appointment_timeslot = sched_appointment.selectedTimeslot;
        
        let form = new FormData();

        for (var i = inputs.length - 1; i >= 0; i--) {
            form.append(inputs[i].name, inputs[i].value);
            console.log(inputs[i].name, inputs[i].value);
        }
        //return;
        form.append('selected_municipality', selected_municipality);
        form.append('selected_barangay', selected_barangay);
        form.append('selected_health_facility', selected_health_facility);
        form.append('selected_gender', selected_gender);
        form.append('appointment_date', appointment_date);
        form.append('appointment_timeslot', appointment_timeslot);
        form.append('data_type', 'add_appointment');
        //console.log(selected_municipality, selected_gender, appointment_date, appointment_timeslot);
        //return;
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        sched_appointment.hide()
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
        
    },

    show: function(){
        document.querySelector(".js-sched-appointment-modal").classList.remove('hide');
        document.querySelector(".js-sched-appointment-modal").classList.add('block');
        sched_appointment.showThisMonth();
    },

    hide: function(){

        // hide the modal
        document.querySelector(".js-sched-appointment-modal").classList.add('hide');
        // clear all the input fields
        const inputs = document.querySelectorAll('input');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }

        let select_municipality = document.getElementById("municipality");
        select_municipality.selectedIndex = 0;

        let select_barangay = document.getElementById("barangay");
        select_barangay.selectedIndex = 0;
        document.querySelector(".js-select-barangay").classList.add('hide');

        let select_health_facility = document.getElementById("health_facility");
        select_health_facility.selectedIndex = 0;
        document.querySelector(".js-select-health-facility").classList.add('hide');

        let select_gender = document.getElementById("gender");
        select_gender.selectedIndex = 0;

        let data_privacy = document.getElementById('appointment_data_privacy');
        data_privacy.checked = false;

        // remove the selected date
        sched_appointment.selectedDate = null;
        const selectedDates = document.querySelectorAll('.selected');
        for (let i = 0; i < selectedDates.length; i++) {
            selectedDates[i].classList.remove('selected');
        }

        sched_appointment.selectedTimeslot = null;
        const selectedTimeslots = document.querySelectorAll('.selected-timeslot');
        for (let i = 0; i < selectedTimeslots.length; i++) {
            selectedTimeslots[i].classList.remove('selected-timeslot');
        }
        
        // show page 1
        sched_appointment.currentPage = 1;
        sched_appointment.showPage(sched_appointment.currentPage);
    },

    validatePage1: async function(){
        
        let fields = document.querySelectorAll('#page-1 select, #page-1 input');

        for (let field of fields) {
            if (!field.value.trim()) {
                alert('Please fill up all the fields');
                return false;
            }
            
            if (field.id === 'contact') {
                if (!/^\d+$/.test(field.value)) {
                    alert('Contact number should only contain numbers');
                    return false;
                }
                if (field.value.trim().length < 10) {
                    alert('Contact number should be 10 digits');
                    return false;
                }

                
                
                // Send AJAX request to check if contact number already exists
                let form = new FormData();
                form.append('contact_number', field.value);
                form.append('data_type', 'check_contact_number');

                let response = await new Promise((resolve, reject) => {
                    var ajax = new XMLHttpRequest();

                    ajax.addEventListener('readystatechange', function() {
                        if(ajax.readyState == 4) {
                            if(ajax.status == 200){
                                let obj = JSON.parse(ajax.responseText);

                                if(obj.success){
                                    alert(obj.message);
                                    reject();
                                } else {
                                    resolve();
                                }
                            } else {
                                alert("Please check your internet connection");
                                reject();
                            }
                        }
                    });

                    ajax.open('post','ajax.php', true);
                    ajax.send(form);
                }).catch(() => { return false; });

                if(response === false) return false;
            }

            if (field.id === 'dob') {
                // Check if the user is 18 years old or older
                const selectedDate = new Date(field.value);
                const today = new Date();
                const age = today.getFullYear() - selectedDate.getFullYear();
                
                if (age < 18) {
                    alert('You should be at least 18 years old to make an appointment.');
                    return false;
                }
            }

            if (field.id === 'email') {
                // Regular expression for email validation
                let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(field.value)) {
                    alert('Please enter a valid email address.');
                    return false; // Stop execution of the function
                }
            }
        }

        sched_appointment.get_selected_barangay();
        sched_appointment.get_selected_health_facility();
        console.log(sched_appointment.health_facility);
        sched_appointment.loadCalendar(sched_appointment.month, sched_appointment.year, sched_appointment.location, sched_appointment.health_facility);
        return true;

    },

    validatePage2: function(){
        // get all the input fields on page 1
        let inputDate = document.querySelector('.selected');
        
        if (inputDate) {
            return true;
        }

        alert('Please select a date');
        return false;
    },

    validatePage3: function(){
        // check if a timeslot has been selected
        return sched_appointment.selectedTimeslot !== null;
    },

    showPage: function (pageNumber) {
        const pages = document.getElementsByClassName("page");
        for (let i = 0; i < pages.length; i++) {
            pages[i].style.display = "none";
        }

        const pageToShow = document.getElementById(`page-${pageNumber}`);
        pageToShow.style.display = "block";
    },

    nextPage: async function () {

        // check if the user is allowed to move to the next page
        /*if (sched_appointment.currentPage === 1 && !sched_appointment.validatePage1()) {
            return;
        }*/

        if (sched_appointment.currentPage === 1 && !(await sched_appointment.validatePage1())) {
            return;
        }

        if (sched_appointment.currentPage === 2 && !sched_appointment.validatePage2()) {
            return;
        }

        // Move to the next page
        sched_appointment.currentPage++;
        if (sched_appointment.currentPage > sched_appointment.totalPages) {
            sched_appointment.currentPage = sched_appointment.totalPages; // Ensure we don't go beyond the last page
        }
        sched_appointment.showPage(sched_appointment.currentPage);
    },

    prevPage: function () {
        // Save form data from the current page here if needed

        // Move to the previous page
        sched_appointment.currentPage--;
        if (sched_appointment.currentPage < 1) {
            sched_appointment.currentPage = 1; // Ensure we don't go beyond the first page
        }
        sched_appointment.showPage(sched_appointment.currentPage);

        // Show/hide the Submit button on the last page
        /*if (this.currentPage === this.totalPages) {
            document.getElementById("submit-btn").style.display = "block";
        } else {
            document.getElementById("submit-btn").style.display = "none";
        }*/

        // Add logic to disable/enable Next and Prev buttons as needed
        if (sched_appointment.currentPage === 1) {
            //document.getElementById("prev-btn").disabled = true; // Disable Prev button on the first page
        }
    },

    loadCalendar: function (month, year, location, health_facility) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.querySelector(".calendar-layout").innerHTML = xhttp.responseText;

                // check if a date has been selected
                if (sched_appointment.selectedDate !== null) {
                    // find the td element with the selected date
                    const tds = document.querySelectorAll('.new-dates');
                    for (let i = 0; i < tds.length; i++) {
                        if (tds[i].getAttribute('onclick').includes(sched_appointment.selectedDate)) {
                            tds[i].classList.add('selected');
                            break;
                        }
                    }
                }

            }
        };
        xhttp.open("GET", "calendar.php?month=" + month + "&year=" + year + "&location=" + location + "&health_facility=" + health_facility, true);
        xhttp.send();
    },

    loadTimeslots: function () {
        // load the timeslots via AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                // parse the response as JSON
                var timeslots = JSON.parse(xhttp.responseText);
                // display the timeslots in the modal
                var timeslotsContainer = document.querySelector('.timeslots');
                timeslotsContainer.innerHTML = '';

                for (var i = 0; i < timeslots.length; i++) {
                    var div_timeslot = document.createElement('div');
                    div_timeslot.style.minWidth="300px";
                    div_timeslot.style.marginBlockStart="10px";
                    div_timeslot.style.marginInlineStart="20px";
                    //div_timeslot.textContent = timeslots[i].time;

                    // create a span element to display the time of the timeslot
                    var span_time = document.createElement('span');
                    span_time.classList.add("span_time");
                    span_time.textContent = timeslots[i].time;
                    timeslot_value = timeslots[i].time;
                    
                    // create a span element to display the number of available slots for the timeslot
                    var span_slots = document.createElement('span');
                    span_slots.classList.add("span_slots");
                    span_slots.textContent = ' (' + timeslots[i].availableSlots + ' slots available)';
                    
                    // create a line break element
                    var lineBreak = document.createElement('br');

                    div_timeslot.className = 'btn btn-success';

                    // check if the timeslot is booked
                    if (timeslots[i].booked) {
                        // add a class to the timeslot to indicate that it is booked
                        div_timeslot.classList.add('booked');
                        // add an onclick event to the timeslot to display an alert
                        div_timeslot.onclick = function () {
                            alert('This slot is already full.');
                        };
                    } else if (timeslots[i].isPast) {
                        console.log(timeslots[i].isPast);
                        // add a class to the timeslot to indicate that it is booked
                        div_timeslot.classList.add('timeslot_passed');
                        // add an onclick event to the timeslot to display an alert
                        div_timeslot.onclick = function () {
                            alert('This slot has already passed.');
                        };
                    } else {
                        // add an onclick event to the timeslot to allow it to be selected
                        /*div_timeslot.onclick = function () {
                            sched_appointment.selectTimeslot(timeslot_value);
                        };*/
                        (function (timeslot) {
                            // add an onclick event to the timeslot to allow it to be selected
                            div_timeslot.onclick = function () {
                                sched_appointment.selectTimeslot(timeslot);
                            };
                        })(timeslots[i].time);
                    }
                    // append the span elements to the div_timeslot element
                    div_timeslot.appendChild(span_time);
                    div_timeslot.appendChild(lineBreak); 
                    div_timeslot.appendChild(span_slots);
                    timeslotsContainer.appendChild(div_timeslot);
                }

            }
        };
        xhttp.open("GET", "calendar.php?timeslots=1&date=" + sched_appointment.selectedDate + "&location=" + sched_appointment.location + "&health_facility=" + sched_appointment.health_facility, true);
        xhttp.send();
    },

    showPreviousMonth: function () {
        
        if (sched_appointment.month === 1) {
            sched_appointment.month = 12;
            sched_appointment.year--;
        } else {
            sched_appointment.month--;
        }
        sched_appointment.loadCalendar(sched_appointment.month, sched_appointment.year, sched_appointment.location, sched_appointment.health_facility);
    },

    showThisMonth: function () {
        let dateNew = new Date();
        sched_appointment.month = dateNew.getMonth() + 1; // JavaScript months are 0-based
        sched_appointment.year = dateNew.getFullYear();
        sched_appointment.loadCalendar(sched_appointment.month, sched_appointment.year, sched_appointment.location, sched_appointment.health_facility);
    },

    showNextMonth: function () {
        
        if (sched_appointment.month === 12) {
            sched_appointment.month = 1;
            sched_appointment.year++;
        } else {
            sched_appointment.month++;
        }
        sched_appointment.loadCalendar(sched_appointment.month, sched_appointment.year, sched_appointment.location, sched_appointment.health_facility);
    },

    selectDate: function (date){

        // remove the 'selected' class from any previously selected dates
        const selectedDates = document.querySelectorAll('.selected');
        for (let i = 0; i < selectedDates.length; i++) {
            selectedDates[i].classList.remove('selected');
        }
        // find the closest td element to the clicked element
        let td = event.target;
        while (td.tagName !== 'TD') {
            td = td.parentElement;
        }
        // add the 'selected' class to the td element
        td.classList.add('selected');
        
        sched_appointment.selectedDate = date;
        document.querySelector('.js-selected-date').innerHTML = sched_appointment.selectedDate;
        console.log(sched_appointment.selectedDate);
        sched_appointment.loadTimeslots();
    },

    selectTimeslot: function (timeslot) {
        console.log(timeslot);
        // remove the 'selected' class from any previously selected timeslots
        const selectedTimeslots = document.querySelectorAll('.selected-timeslot');
        for (let i = 0; i < selectedTimeslots.length; i++) {
            selectedTimeslots[i].classList.remove('selected-timeslot');
        }
        // add the 'selected' class to the clicked timeslot
        event.target.classList.add('selected-timeslot');
        // store the selected timeslot
        sched_appointment.selectedTimeslot = timeslot;
    },

    load_city_municipality_list: function(){

        let form = new FormData();

        form.append('data_type', 'load_city_municipalities');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        
                        let selectElement = document.getElementById("municipality");
                        selectElement.innerHTML = "";

                        let blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "Select a City/Municipality";
                        blankOption.disabled = true;
                        blankOption.selected = true;
                        selectElement.appendChild(blankOption);

                        obj.rows.forEach(function(location) {
                            if (location.city_municipality !== "SiPa") {
                                let option = document.createElement("option");
                                //option.value = location.partner_facility_id;
                                option.value = location.city_municipality;
                                option.text = location.city_municipality;
                                option.setAttribute("city-municipality-name", location.city_municipality);
                                option.setAttribute("translate", "no");
                                selectElement.appendChild(option);
                            }
                        });
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    load_barangay_list: function(){

        let city_municipality = sched_appointment.location;

        let form = new FormData();

        form.append('city_municipality', city_municipality);
        form.append('data_type', 'load_barangay_list');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){
                    
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        
                        let selectElement = document.getElementById("barangay");
                        selectElement.innerHTML = "";

                        let blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "Select a Barangay";
                        blankOption.disabled = true;
                        blankOption.selected = true;
                        selectElement.appendChild(blankOption);

                        obj.rows.forEach(function(barangay_healthcare_provider) {
                            let option = document.createElement("option");
                            //option.value = barangay_healthcare_provider.partner_facility_id;
                            option.value = barangay_healthcare_provider.barangay_name;
                            option.text = barangay_healthcare_provider.barangay_name;
                            option.setAttribute("barangay-health-facility-name", barangay_healthcare_provider.barangay_name);
                            selectElement.appendChild(option);
                        });
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    load_health_facility_list: function(){

        let city_municipality = sched_appointment.location;

        let form = new FormData();

        form.append('city_municipality', city_municipality);
        form.append('data_type', 'load_health_facilities');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){
                    
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        
                        let selectElement = document.getElementById("health_facility");
                        selectElement.innerHTML = "";

                        let blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "Select a Health Facility";
                        blankOption.disabled = true;
                        blankOption.selected = true;
                        selectElement.appendChild(blankOption);

                        obj.rows.forEach(function(healthcare_provider) {
                            let option = document.createElement("option");
                            //option.value = healthcare_provider.partner_facility_id;
                            option.value = healthcare_provider.health_facility_name;
                            option.text = healthcare_provider.health_facility_name;
                            option.setAttribute("health-facility-name", healthcare_provider.health_facility_name);
                            selectElement.appendChild(option);
                        });
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    get_selected_city_municipality: function () {
        
        let select_city_municipality = document.getElementById("municipality");
        let select_health_facility = document.getElementById("health_facility");

        // Add an event listener to the select element
        select_city_municipality.addEventListener("change", function () {

            if (this.value !== '') {
                //select_health_facility.disabled = false;
                document.querySelector(".js-select-health-facility").classList.remove('hide');
                document.querySelector(".js-select-barangay").classList.remove('hide');
            } else {
                //select_health_facility.disabled = true;
            }
            // Get the selected option's value
            let selected_city_municipality = select_city_municipality.value;
            sched_appointment.location = selected_city_municipality;
            console.log(sched_appointment.location);
            sched_appointment.load_barangay_list();
            sched_appointment.load_health_facility_list();
        });
    },

    get_selected_barangay: function () {
        
        let selected_barangay = document.getElementById("barangay").value;
        sched_appointment.barangay = selected_barangay;
    },

    get_selected_health_facility: function () {
        
        let selected_health_facility = document.getElementById("health_facility").value;
        sched_appointment.health_facility = selected_health_facility;
    },

};

if (typeof appointment != 'undefined') {
    sched_appointment.load_city_municipality_list();
    sched_appointment.get_selected_city_municipality();
    //sched_appointment.loadCalendar(sched_appointment.month, sched_appointment.year);
}