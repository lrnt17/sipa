var todays_appointment_list = {

    edit_id: '',
    facility_id: (typeof partner_facility_id == 'undefined') ? 0 : partner_facility_id,
    location: (typeof city_municipality == 'undefined') ? null : city_municipality,
    health_facility: (typeof health_facility == 'undefined') ? null : health_facility,
    current_page: (typeof current_page == 'undefined') ? 1 : current_page,
    last_page: (typeof last_page == 'undefined') ? 0 : last_page,
    month: (typeof month == 'undefined') ? getMonth() : month,
    year: (typeof year == 'undefined') ? getFullYear(): year,
    appointmentDate: null,
    appointmentTimeslot: null,
    selectedDate: null,
    selectedTimeslot: null,
    showEntryNum: 10,
    column: 'app_id',
    order: 'desc',
    searchQuery: null,
    new_appointment: true,
    load_appointments: null,

    load_todays_appointments: function(e){

        let city_municipality = todays_appointment_list.location;
        let health_facility = todays_appointment_list.health_facility;
        let show_entry = todays_appointment_list.showEntryNum;
        let column = todays_appointment_list.column;
        let order = todays_appointment_list.order;
        let searchQuery = todays_appointment_list.searchQuery;
        //let current_date = todays_appointment_list.current_date;
        console.log(searchQuery);//return;
        let form = new FormData();

        form.append('city_municipality', city_municipality);
        form.append('health_facility', health_facility);
        form.append('show_entry', show_entry);
        form.append('column', column);
        form.append('order', order);
        form.append('page', this.current_page);
        form.append('search_query', searchQuery);
        form.append('data_type', 'load_todays_appointments');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let data = JSON.parse(ajax.responseText);

                    let table = document.querySelector("#appointment_table tbody");
                    let template = document.querySelector("#appointments-template");
                    table.innerHTML = "";

                    console.log(data);

                    // Calculate starting and ending indices
                    let startIndex = (data.current_page - 1) * data.rows_per_page + 1;
                    let endIndex = Math.min(data.current_page * data.rows_per_page, data.total_rows);

                    // Display range of entries
                    let rangeElement = document.querySelector(".js-entry-range");
                    let constant_total_rows = data.constant_total_rows ? " (filtered from " + data.constant_total_rows + " total entries)" : "";
                    //rangeElement.textContent = "Showing " + startIndex + " to " + endIndex + " of " + data.total_rows + " entries" + constant_total_rows;
                    if (isNaN(startIndex) && isNaN(endIndex) && data.total_rows === undefined) {
                        rangeElement.textContent = "No data entries to be found";
                    } else {
                        rangeElement.textContent = "Showing " + startIndex + " to " + endIndex + " of " + data.total_rows + " entries" + constant_total_rows;
                    }
                    
                    console.log(startIndex, endIndex, data.total_rows);
                    
                    if(data.success){

                        // Generate table rows
                        for (let i = 0; i < data.rows.length; i++) {
                            let row = document.importNode(template.content, true);
                            row.querySelector(".js-select-appointment").setAttribute('app_id', data.rows[i].app_id);
                            row.querySelector(".js-appointment-id").textContent = data.rows[i].app_id;
                            row.querySelector(".js-userfname").textContent = data.rows[i].app_fname;
                            row.querySelector(".js-userlname").textContent = data.rows[i].app_lname;
                            
                            row.querySelector(".js-appointment-date").textContent = data.rows[i].app_date;
                            row.querySelector(".js-appointment-timeslot").textContent = data.rows[i].app_timeslot;
                            row.querySelector(".js-appointment-status").textContent = data.rows[i].status;
                            row.querySelector(".js-appointment-details-btn").setAttribute('onclick',`todays_appointment_list.view_appointment('${data.rows[i].app_id}')`);
                            row.querySelector(".js-appointment-edit-btn").setAttribute('onclick',`todays_appointment_list.edit_appointment('${data.rows[i].app_id}')`);
                            
                            
                            //copying the content of postCard
                            let clone = row.cloneNode(true);

                            // Get root element of cloned template
                            let rootElement = clone.querySelector(':first-child');
                            rootElement.setAttribute('id','appointment_'+data.rows[i].app_id);
                            let row_data = JSON.stringify(data.rows[i]);
                            row_data = row_data.replaceAll('"','\\"');
                            rootElement.setAttribute('row',row_data);

                            table.appendChild(clone);
                        }

                    } else {
                        
                        let row = document.createElement("tr");
                        let cell = document.createElement("td");
                        cell.colSpan = 7;
                        cell.classList.add('pt-5','pb-3');
                        cell.textContent = "No match found";
                        cell.style.fontWeight="600";
                        row.appendChild(cell);
                        table.appendChild(row);
                    }

                    // Update pagination controls here
                    todays_appointment_list.last_page = data.last_page;
                    let current_page_select = document.querySelector("#current-page");
                    current_page_select.innerHTML = "";

                    for (let i = 1; i <= todays_appointment_list.last_page; i++) {
                        let option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        if (i == todays_appointment_list.current_page) {
                            option.selected = true;
                        }
                        current_page_select.appendChild(option);
                    }
                }
            }
        });

        ajax.open('post','ajax-admin.php', true);
        ajax.send(form);
    },

    search_appointments: function(query) {

        todays_appointment_list.searchQuery = query;
        todays_appointment_list.current_page = 1;
        todays_appointment_list.load_todays_appointments();
    },

    add_appointment: function(){
        todays_appointment_list.load_appointments = false;
        document.querySelector(".js-create-new-appointment").classList.remove('hide');
        todays_appointment_list.selectedDate = null;
        todays_appointment_list.selectedTimeslot = null;
        todays_appointment_list.load_barangays();
        todays_appointment_list.loadCalendarNewAppointment(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout-new');
        todays_appointment_list.loadTimeslotsNewAppointment();
    },

    create_new_appointment: function(e){

        e.preventDefault();

        let inputs = document.querySelectorAll('.create-new-appointment');

        let appointment_date = todays_appointment_list.selectedDate;
        let appointment_timeslot = todays_appointment_list.selectedTimeslot;
        let select_barangay = document.getElementById("new_barangay");
        let selected_barangay = select_barangay.options[select_barangay.selectedIndex].value;

        console.log(appointment_date, appointment_timeslot, selected_barangay);

        if (appointment_date != null && appointment_timeslot != null) {

            todays_appointment_list.validate_new_appointment_data().then(isValid => {
                if (isValid) {
                    // Continue with your form submission
                    let form = new FormData();
            
                    for (var i = inputs.length - 1; i >= 0; i--) {
                        form.append(inputs[i].name, inputs[i].value);
                        console.log(inputs[i].name, inputs[i].value);
                    }

                    form.append('selected_barangay', selected_barangay);
                    form.append('appointment_date', appointment_date);
                    form.append('appointment_timeslot', appointment_timeslot);
                    form.append('data_type', 'add_appointment');
                    //return;
                    //console.log(todays_appointment_list.edit_id,appointment_date,appointment_timeslot);return;
                    var ajax = new XMLHttpRequest();

                    ajax.addEventListener('readystatechange',function(){

                        if(ajax.readyState == 4)
                        {
                            if(ajax.status == 200){

                                console.log(ajax.responseText);
                                let obj = JSON.parse(ajax.responseText);
                                alert(obj.message);

                                if(obj.success){
                                    let table = document.querySelector("#appointment_table tbody");
                                    table.innerHTML = "";
                                    
                                    todays_appointment_list.clear_new_appointment_inputs();
                                    todays_appointment_list.load_todays_appointments();
                                    todays_appointment_list.hide()
                                }
                            }else{
                                alert("Please check your internet connection");
                            }
                        }
                    });

                    ajax.open('post','../ajax.php', true);
                    ajax.send(form);

                } else {
                    console.log('Invalid data');
                }
            });
        } else {
            alert('Please select an appointment date and a timeslot');
            return;
        }
    },

    view_appointment: function(id){

        document.querySelector(".js-view-appointment").classList.remove('hide');
        //manage_admins.edit_id = id;

        let data = document.querySelector("#appointment_"+id).getAttribute("row");
        data = data.replaceAll('\\"','"');
        data = JSON.parse(data);
        console.log(data);
        if(typeof data == 'object') {

            document.querySelector(".js-view-appointment-schedule").innerHTML = data.app_date;
            document.querySelector(".js-view-timeslot").innerHTML = data.app_timeslot;
            document.querySelector(".js-view-patient-name").innerHTML = data.app_fname + ' ' + data.app_lname;
            document.querySelector(".js-view-gender").innerHTML = data.app_gender;

            let date = new Date(data.app_bdate);
            let formattedDate = date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.querySelector(".js-view-dob").innerHTML = formattedDate;
            document.querySelector(".js-view-pnum").innerHTML = data.app_pnum;
            document.querySelector(".js-view-gmail").innerHTML = data.app_email;
            document.querySelector(".js-view-address").innerHTML = data.app_address;
            document.querySelector(".js-view-barangay").innerHTML = data.barangay;
            document.querySelector(".js-view-status").innerHTML = data.status;
            document.querySelector(".js-view-privacy-policy").innerHTML = data.appointment_data_privacy;

        } else {
            alert("Invalid data");
        }
    },

    edit_appointment: function(id){
        
        todays_appointment_list.load_appointments = true;
        document.querySelector(".js-edit-appointment").classList.remove('hide');
        todays_appointment_list.edit_id = id;

        let data = document.querySelector("#appointment_"+id).getAttribute("row");
        data = data.replaceAll('\\"','"');
        data = JSON.parse(data);
        //console.log(data);return;
        if(typeof data == 'object') {

            document.querySelector(".js-edit-fname").value = data.app_fname;
            document.querySelector(".js-edit-lname").value = data.app_lname;
            document.querySelector(".js-edit-gmail").value = data.app_email;
            document.querySelector(".js-edit-pnum").value = data.app_pnum;
            document.querySelector(".js-edit-gender").value = data.app_gender;
            document.querySelector(".js-edit-dob").value = data.app_bdate;
            document.querySelector(".js-edit-address").value = data.app_address;
            document.querySelector(".js-edit-city-municipality").value = data.city_municipality;
            document.querySelector(".js-edit-health-facility").value = data.health_facility;
            document.querySelector(".js-edit-barangay").value = data.barangay;
            document.querySelector(".js-edit-status").value = data.status;
            todays_appointment_list.selectedDate = data.app_date;
            todays_appointment_list.appointmentDate = data.app_date;
            todays_appointment_list.selectedTimeslot = data.app_timeslot;
            todays_appointment_list.appointmentTimeslot = data.app_timeslot;
            console.log(todays_appointment_list.selectedDate, todays_appointment_list.selectedTimeslot);

            todays_appointment_list.loadCalendar(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout');
            todays_appointment_list.loadTimeslots();
            //todays_appointment_list.selectTimeslot(todays_appointment_list.selectedTimeslot);

        } else {
            alert("Invalid data");
        }
    },

    save_updated_appointment: function(e){

        e.preventDefault();

        let inputs = document.querySelectorAll('.edit-appointment');

        let appointment_date = todays_appointment_list.selectedDate;
        let appointment_timeslot = todays_appointment_list.selectedTimeslot;

        let form = new FormData();

        for (var i = inputs.length - 1; i >= 0; i--) {
            form.append(inputs[i].name, inputs[i].value);
            console.log(inputs[i].name, inputs[i].value);
        }

        form.append('app_id', todays_appointment_list.edit_id);
        form.append('appointment_date', appointment_date);
        form.append('appointment_timeslot', appointment_timeslot);
        form.append('data_type', 'edited_appointment');

        //console.log(todays_appointment_list.edit_id,appointment_date,appointment_timeslot);return;
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){

                        let table = document.querySelector("#appointment_table tbody");
                        table.innerHTML = "";
                        
                        todays_appointment_list.load_todays_appointments();
                        todays_appointment_list.hide();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax-admin.php', true);
        ajax.send(form);
    },

    delete_appointment: function(){

        let selectedRows = document.querySelectorAll("#appointment_table .js-select-appointment:checked");
        if (selectedRows.length == 0) {
            alert("Please select at least one row to delete");
            return;
        }

        let ids = [];
        selectedRows.forEach(function(row) {
            let id = row.getAttribute("app_id");
            ids.push(id);
        });

        //console.log(JSON.stringify(ids));return;

        let form = new FormData();
        form.append('ids', JSON.stringify(ids));
        form.append('data_type', 'delete_appointment');

        let ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if (obj.success) {

                        let table = document.querySelector("#appointment_table tbody");
                        table.innerHTML = "";
                        
                        todays_appointment_list.load_todays_appointments();
                        todays_appointment_list.hide();
                    }
                } else {
                    alert("Please check your internet connection");
                }
            }
        });
        ajax.open('post', 'ajax-admin.php', true);
        ajax.send(form);
    },

    sortTable: function(column, order) {

        console.log(column, order);
        todays_appointment_list.column = column;
        todays_appointment_list.order = order;
        todays_appointment_list.load_todays_appointments();
    },

    loadCalendar: function (month, year, location, health_facility, new_appointment, parentSelector) {
        
        //todays_appointment_list.load_appointments = true;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.querySelector(".calendar-layout").innerHTML = xhttp.responseText;

                // check if a date has been selected
                if (todays_appointment_list.selectedDate !== null) {
                    // find the td element with the selected date
                    //const tds = document.querySelectorAll('.new-dates');
                    const parent = document.querySelector(parentSelector);
                    const tds = parent.querySelectorAll('.new-dates');
                    for (let i = 0; i < tds.length; i++) {
                        if (tds[i].getAttribute('onclick').includes(todays_appointment_list.selectedDate)) {
                            tds[i].classList.add('selected');
                            break;
                        }
                    }
                }

            }
        };
        xhttp.open("GET", "calendar-admin.php?month=" + month + "&year=" + year + "&location=" + location + "&health_facility=" + health_facility + "&new_appointment=" + new_appointment, true);
        xhttp.send();
    },

    loadCalendarNewAppointment: function (month, year, location, health_facility, new_appointment, parentSelector) {
        
        //todays_appointment_list.load_appointments = false;
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.querySelector(".calendar-layout-new").innerHTML = xhttp.responseText;

                // check if a date has been selected
                if (todays_appointment_list.selectedDate !== null) {
                    // find the td element with the selected date
                    //const tds = document.querySelectorAll('.new-dates');
                    const parent = document.querySelector(parentSelector);
                    const tds = parent.querySelectorAll('.new-dates');
                    for (let i = 0; i < tds.length; i++) {
                        if (tds[i].getAttribute('onclick').includes(todays_appointment_list.selectedDate)) {
                            tds[i].classList.add('selected');
                            break;
                        }
                    }
                }

            }
        };
        xhttp.open("GET", "calendar-admin.php?month=" + month + "&year=" + year + "&location=" + location + "&health_facility=" + health_facility + "&new_appointment=" + new_appointment, true);
        xhttp.send();
    },

    loadTimeslots: function () {

        // Remove the 'selected-timeslot' class from all timeslots
        let selectedTimeslots = document.querySelectorAll('.selected-timeslot');
        for (let i = 0; i < selectedTimeslots.length; i++) {
            selectedTimeslots[i].classList.remove('selected-timeslot');
        }

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
                    div_timeslot.style.minWidth="210px";
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
                    } else {
                        // add an onclick event to the timeslot to allow it to be selected
                        /*div_timeslot.onclick = function () {
                            todays_appointment_list.selectTimeslot(timeslot_value);
                        };*/
                        (function (timeslot) {
                            // add an onclick event to the timeslot to allow it to be selected
                            div_timeslot.onclick = function () {
                                console.log('test');
                                todays_appointment_list.selectTimeslot(timeslot);
                            };
                        })(timeslots[i].time);
                    }
                    console.log(todays_appointment_list.selectedDate);
                    // Add the 'selected-timeslot' class if this timeslot matches todays_appointment_list.selectedTimeslot
                    if (timeslots[i].time === todays_appointment_list.appointmentTimeslot && timeslots[i].date === todays_appointment_list.appointmentDate) {
                        div_timeslot.classList.add('selected-timeslot');
                    }

                    // append the span elements to the div_timeslot element
                    div_timeslot.appendChild(span_time);
                    div_timeslot.appendChild(lineBreak); 
                    div_timeslot.appendChild(span_slots);
                    timeslotsContainer.appendChild(div_timeslot);
                }

            }
        };
        xhttp.open("GET", "calendar-admin.php?timeslots=1&date=" + todays_appointment_list.selectedDate + "&location=" + todays_appointment_list.location + "&health_facility=" + todays_appointment_list.health_facility, true);
        xhttp.send();
    },

    loadTimeslotsNewAppointment: function () {

        // Remove the 'selected-timeslot' class from all timeslots
        let selectedTimeslots = document.querySelectorAll('.selected-timeslot');
        for (let i = 0; i < selectedTimeslots.length; i++) {
            selectedTimeslots[i].classList.remove('selected-timeslot');
        }

        // load the timeslots via AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                // parse the response as JSON
                var timeslots = JSON.parse(xhttp.responseText);
                // display the timeslots in the modal
                var timeslotsContainer = document.querySelector('.timeslots-new');
                timeslotsContainer.innerHTML = '';

                for (var i = 0; i < timeslots.length; i++) {
                    var div_timeslot = document.createElement('div');
                    div_timeslot.style.minWidth="210px";
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
                    } else {
                        // add an onclick event to the timeslot to allow it to be selected
                        /*div_timeslot.onclick = function () {
                            todays_appointment_list.selectTimeslot(timeslot_value);
                        };*/
                        (function (timeslot) {
                            // add an onclick event to the timeslot to allow it to be selected
                            div_timeslot.onclick = function () {
                                console.log('test');
                                todays_appointment_list.selectTimeslot(timeslot);
                            };
                        })(timeslots[i].time);
                    }
                    console.log(todays_appointment_list.selectedDate);
                    // Add the 'selected-timeslot' class if this timeslot matches todays_appointment_list.selectedTimeslot
                    /*if (timeslots[i].time === todays_appointment_list.appointmentTimeslot && timeslots[i].date === todays_appointment_list.appointmentDate) {
                        div_timeslot.classList.add('selected-timeslot');
                    }*/

                    // append the span elements to the div_timeslot element
                    div_timeslot.appendChild(span_time);
                    div_timeslot.appendChild(lineBreak); 
                    div_timeslot.appendChild(span_slots);
                    timeslotsContainer.appendChild(div_timeslot);
                }

            }
        };
        xhttp.open("GET", "calendar-admin.php?timeslots=1&date=" + todays_appointment_list.selectedDate + "&location=" + todays_appointment_list.location + "&health_facility=" + todays_appointment_list.health_facility, true);
        xhttp.send();
    },

    load_barangays: function(){
            
        let partner_facility_id = todays_appointment_list.facility_id;
        //console.log(partner_facility_id);
        let form = new FormData();

        form.append('partner_facility_id', partner_facility_id);
        form.append('data_type', 'load_user_barangay');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){
                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        
                        let selectElement = document.getElementById("new_barangay");
                        selectElement.innerHTML = "";

                        let blankOption = document.createElement("option");
                        blankOption.value = "";
                        blankOption.text = "Select a Barangay";
                        blankOption.disabled = true;
                        blankOption.selected = true;
                        selectElement.appendChild(blankOption);

                        obj.rows.forEach(function(user_barangay) {
                            user_barangay.barangay.forEach(function(barangay) {
                                let option = document.createElement("option");
                                option.value = barangay.barangay_name;
                                option.text = barangay.barangay_name;
                                option.setAttribute("user_barangay-name", barangay.barangay_name);

                                // Set selected value
                                /*if (option.value === "<?=$row['user_barangay']?>") {
                                    option.selected = true;
                                }*/

                                selectElement.appendChild(option);
                            });
                        });

                    }
                }
            }
        });

        ajax.open('post','../ajax.php', true);
        ajax.send(form);
    },

    showPreviousMonth: function () {
        
        if (todays_appointment_list.month === 1) {
            todays_appointment_list.month = 12;
            todays_appointment_list.year--;
        } else {
            todays_appointment_list.month--;
        }
        todays_appointment_list.loadCalendar(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout');
    },

    showThisMonth: function () {
        let dateNew = new Date();
        todays_appointment_list.month = dateNew.getMonth() + 1; // JavaScript months are 0-based
        todays_appointment_list.year = dateNew.getFullYear();
        todays_appointment_list.loadCalendar(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout');
    },

    showNextMonth: function () {
        
        if (todays_appointment_list.month === 12) {
            todays_appointment_list.month = 1;
            todays_appointment_list.year++;
        } else {
            todays_appointment_list.month++;
        }
        todays_appointment_list.loadCalendar(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout');
    },

    showPreviousMonthNewAppointment: function () {
        
        if (todays_appointment_list.month === 1) {
            todays_appointment_list.month = 12;
            todays_appointment_list.year--;
        } else {
            todays_appointment_list.month--;
        }
        todays_appointment_list.loadCalendarNewAppointment(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout-new');
    },

    showNextMonthNewAppointment: function () {
        
        if (todays_appointment_list.month === 12) {
            todays_appointment_list.month = 1;
            todays_appointment_list.year++;
        } else {
            todays_appointment_list.month++;
        }
        todays_appointment_list.loadCalendarNewAppointment(todays_appointment_list.month, todays_appointment_list.year, todays_appointment_list.location, todays_appointment_list.health_facility, todays_appointment_list.new_appointment, '.calendar-layout-new');
    },

    selectDate: function (date){

        // remove the 'selected' class from any previously selected dates
        let selectedDates = document.querySelectorAll('.selected');
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
        
        todays_appointment_list.selectedDate = date;
        //document.querySelector('.js-selected-date').innerHTML = todays_appointment_list.selectedDate;
        console.log(todays_appointment_list.selectedDate);
        //todays_appointment_list.loadTimeslots();
        if (todays_appointment_list.load_appointments) {
            todays_appointment_list.loadTimeslots();
        } else {
            document.querySelector(".timeslots-new").classList.remove('hide');
            todays_appointment_list.loadTimeslotsNewAppointment();
        }
    },

    selectTimeslot: function (timeslot) {
        console.log(timeslot);
        // remove the 'selected' class from any previously selected timeslots
        let selectedTimeslots = document.querySelectorAll('.selected-timeslot');
        for (let i = 0; i < selectedTimeslots.length; i++) {
            selectedTimeslots[i].classList.remove('selected-timeslot');
        }
        // add the 'selected' class to the clicked timeslot
        event.target.classList.add('selected-timeslot');
        // store the selected timeslot
        todays_appointment_list.selectedTimeslot = timeslot;
    },

    go_to_page: function(page) {

        this.current_page = page;
        this.load_todays_appointments();
    },

    previous_page: function() {

        if (this.current_page > 1) {
            this.current_page--;
            this.load_todays_appointments();
        }
    },

    next_page: function() {

        if (this.current_page < this.last_page) {
            this.current_page++;
            this.load_todays_appointments();
        }
    },

    go_to_last_page: function() {
        
        this.current_page = this.last_page;
        this.load_todays_appointments();
    },

    hide: function(){
        //document.querySelector(".js-add-admin").classList.add('hide');
        document.querySelector(".js-edit-appointment").classList.add('hide');
        document.querySelector(".js-view-appointment").classList.add('hide');
        document.querySelector(".js-create-new-appointment").classList.add('hide');

        document.querySelector(".timeslots-new").classList.add('hide');
        todays_appointment_list.clear_new_appointment_inputs();
    },

    clear_new_appointment_inputs: function(){
                                            
        let fields = document.querySelectorAll('.appointment-form input, .appointment-form select');
        for (let field of fields) {
            if (field.classList.contains('js-gender')) {
                // If the field is a select element with the class 'gender', set the selected index to 0
                field.selectedIndex = 0;
            } else {
                // For all other input fields, clear the value
                field.value = '';
            }
        }
    },

    select_all_appointments: function(source){
        let checkboxes = document.getElementsByName('all_appointments[]');
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    },

    num_rows_displayed: function(num_value){

        //console.log(num_value);
        todays_appointment_list.showEntryNum = num_value;
        todays_appointment_list.current_page = 1;
        todays_appointment_list.load_todays_appointments();
    },

    validate_new_appointment_data: function() {
        return new Promise((resolve, reject) => {
            let fields = document.querySelectorAll('.appointment-form input');
            //console.log(fields);
            for (let field of fields) {
                //console.log(field); // Log the current field
                if (field.classList.contains('js-dob')) {
                    //console.log(field.value);
                    const selectedDate = new Date(field.value);
                    const today = new Date();
                    const age = today.getFullYear() - selectedDate.getFullYear();
                    if (age < 18) {
                        alert('You should be at least 18 years old to make an appointment.');
                        resolve(false); // Resolve the promise with 'false'
                        return; // Stop execution of the function
                    }
                }
    
                if (field.classList.contains('js-pnum')) {
                    let form = new FormData();
                    form.append('contact_number', field.value);
                    form.append('data_type', 'check_contact_number');
                    var ajax = new XMLHttpRequest();
    
                    ajax.addEventListener('readystatechange',function(){
                        if(ajax.readyState == 4) {
                            if(ajax.status == 200){
                                let obj = JSON.parse(ajax.responseText);
                                if(obj.success){
                                    alert(obj.message);
                                    resolve(false); // Resolve the promise with 'false'
                                } else {
                                    resolve(true); // Resolve the promise with 'true'
                                }
                            } else {
                                alert("Please check your internet connection");
                                resolve(false); // Resolve the promise with 'false'
                            }
                        }
                    });
    
                    ajax.open('post','../ajax.php', true);
                    ajax.send(form);
    
                    return; // Return here to prevent the function from immediately resolving the promise
                }
            }
            resolve(true); // If no AJAX request was made, resolve the promise with 'true'
        });
    },
};

if (typeof todays_appointments_list != 'undefined') {
    todays_appointment_list.load_todays_appointments();
}