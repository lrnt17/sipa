var appointment_list = {

    edit_id: '',
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

    load_appointments: function(e){

        let city_municipality = appointment_list.location;
        let health_facility = appointment_list.health_facility;
        let show_entry = appointment_list.showEntryNum;
        let column = appointment_list.column;
        let order = appointment_list.order;
        let searchQuery = appointment_list.searchQuery;
        //let current_date = appointment_list.current_date;
        console.log(searchQuery);//return;
        let form = new FormData();

        form.append('city_municipality', city_municipality);
        form.append('health_facility', health_facility);
        form.append('show_entry', show_entry);
        form.append('column', column);
        form.append('order', order);
        form.append('page', this.current_page);
        form.append('search_query', searchQuery);
        form.append('data_type', 'load_appointments');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    console.log(ajax.responseText);
                    let data = JSON.parse(ajax.responseText);

                    let table = document.querySelector("#appointment_table tbody");
                    let template = document.querySelector("#appointments-template");

                    if(data.success){
                        // Get table and template elements
                        //let table = document.querySelector("#appointment_table tbody");
                        //let template = document.querySelector("#appointments-template");

                        // Clear existing rows
                        table.innerHTML = "";

                        // Calculate starting and ending indices
                        let startIndex = (data.current_page - 1) * data.rows_per_page + 1;
                        let endIndex = Math.min(data.current_page * data.rows_per_page, data.total_rows);

                        // Display range of entries
                        let rangeElement = document.querySelector(".js-entry-range");
                        let constant_total_rows = data.constant_total_rows ? " (filtered from " + data.constant_total_rows + " total entries)" : "";
                        rangeElement.textContent = "Showing " + startIndex + " to " + endIndex + " of " + data.total_rows + " entries" + constant_total_rows;

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
                            row.querySelector(".js-appointment-details-btn").setAttribute('onclick',`appointment_list.view_appointment('${data.rows[i].app_id}')`);
                            row.querySelector(".js-appointment-edit-btn").setAttribute('onclick',`appointment_list.edit_appointment('${data.rows[i].app_id}')`);
                            
                            
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
                        
                        // Update pagination controls here
                        appointment_list.last_page = data.last_page;
                        let current_page_select = document.querySelector("#current-page");
                        current_page_select.innerHTML = "";

                        for (let i = 1; i <= appointment_list.last_page; i++) {
                            let option = document.createElement("option");
                            option.value = i;
                            option.textContent = i;
                            if (i == appointment_list.current_page) {
                                option.selected = true;
                            }
                            current_page_select.appendChild(option);
                        }

                    } else {
                        
                        let row = document.createElement("tr");
                        let cell = document.createElement("td");
                        cell.colSpan = 7;
                        cell.textContent = "No match found";
                        row.appendChild(cell);
                        table.appendChild(row);
                    }
                }
            }
        });

        ajax.open('post','ajax-admin.php', true);
        ajax.send(form);
    },

    search_appointments: function(query) {

        appointment_list.searchQuery = query;
        appointment_list.load_appointments();
        /*let table = document.querySelector("#appointment_table tbody");
        let template = document.querySelector("#appointments-template");

        let city_municipality = appointment_list.location;
        let health_facility = appointment_list.health_facility;

        let form = new FormData();

        form.append('city_municipality', city_municipality);
        form.append('health_facility', health_facility);
        form.append('data_type', 'search_appointments');
        form.append('query', query);

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let data = JSON.parse(ajax.responseText);

                    // Clear existing rows
                    table.innerHTML = "";

                    if (data.success) {
                        
                        for (let i = 0; i < data.rows.length; i++) {
                            // Update row data here
                            let row = document.importNode(template.content, true);
                            row.querySelector(".js-select-appointment").setAttribute('user_id', data.rows[i].app_id);
                            row.querySelector(".js-appointment-id").textContent = data.rows[i].app_id;
                            row.querySelector(".js-userfname").textContent = data.rows[i].app_fname;
                            row.querySelector(".js-userlname").textContent = data.rows[i].app_lname;
                            
                            row.querySelector(".js-appointment-date").textContent = data.rows[i].app_date;
                            row.querySelector(".js-appointment-timeslot").textContent = data.rows[i].app_timeslot;
                            row.querySelector(".js-appointment-status").textContent = data.rows[i].status;
                            row.querySelector(".js-appointment-details-btn").setAttribute('onclick',`appointment_list.view_appointment('${data.rows[i].app_id}')`);
                            row.querySelector(".js-appointment-edit-btn").setAttribute('onclick',`appointment_list.edit_appointment('${data.rows[i].app_id}')`);
                            
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
                        cell.textContent = "No match found";
                        row.appendChild(cell);
                        table.appendChild(row);
                    }
                }
            }
        });

        ajax.open('post', 'ajax-admin.php', true);
        ajax.send(form);*/
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

        document.querySelector(".js-edit-appointment").classList.remove('hide');
        appointment_list.edit_id = id;

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
            document.querySelector(".js-edit-barangay").value = data.barangay;
            document.querySelector(".js-edit-status").value = data.status;
            appointment_list.selectedDate = data.app_date;
            appointment_list.appointmentDate = data.app_date;
            appointment_list.selectedTimeslot = data.app_timeslot;
            appointment_list.appointmentTimeslot = data.app_timeslot;
            console.log(appointment_list.selectedDate, appointment_list.selectedTimeslot);

            appointment_list.loadCalendar(appointment_list.month, appointment_list.year, appointment_list.location, appointment_list.health_facility);
            appointment_list.loadTimeslots();
            //appointment_list.selectTimeslot(appointment_list.selectedTimeslot);

        } else {
            alert("Invalid data");
        }
    },

    save_updated_appointment: function(e){

        e.preventDefault();

        let inputs = document.querySelectorAll('.edit-appointment');

        let appointment_date = appointment_list.selectedDate;
        let appointment_timeslot = appointment_list.selectedTimeslot;

        let form = new FormData();

        for (var i = inputs.length - 1; i >= 0; i--) {
            form.append(inputs[i].name, inputs[i].value);
            console.log(inputs[i].name, inputs[i].value);
        }

        form.append('app_id', appointment_list.edit_id);
        form.append('appointment_date', appointment_date);
        form.append('appointment_timeslot', appointment_timeslot);
        form.append('data_type', 'edited_appointment');

        //console.log(appointment_list.edit_id,appointment_date,appointment_timeslot);return;
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
                        
                        appointment_list.load_appointments();
                        appointment_list.hide();
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
                        
                        appointment_list.load_appointments();
                        appointment_list.hide();
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
        appointment_list.column = column;
        appointment_list.order = order;
        appointment_list.load_appointments();
    },

    loadCalendar: function (month, year, location, health_facility) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.querySelector(".calendar-layout").innerHTML = xhttp.responseText;

                // check if a date has been selected
                if (appointment_list.selectedDate !== null) {
                    // find the td element with the selected date
                    const tds = document.querySelectorAll('.new-dates');
                    for (let i = 0; i < tds.length; i++) {
                        if (tds[i].getAttribute('onclick').includes(appointment_list.selectedDate)) {
                            tds[i].classList.add('selected');
                            break;
                        }
                    }
                }

            }
        };
        xhttp.open("GET", "calendar-admin.php?month=" + month + "&year=" + year + "&location=" + location + "&health_facility=" + health_facility, true);
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
                            appointment_list.selectTimeslot(timeslot_value);
                        };*/
                        (function (timeslot) {
                            // add an onclick event to the timeslot to allow it to be selected
                            div_timeslot.onclick = function () {
                                console.log('test');
                                appointment_list.selectTimeslot(timeslot);
                            };
                        })(timeslots[i].time);
                    }
                    console.log(appointment_list.selectedDate);
                    // Add the 'selected-timeslot' class if this timeslot matches appointment_list.selectedTimeslot
                    if (timeslots[i].time === appointment_list.appointmentTimeslot && timeslots[i].date === appointment_list.appointmentDate) {
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
        xhttp.open("GET", "calendar-admin.php?timeslots=1&date=" + appointment_list.selectedDate + "&location=" + appointment_list.location + "&health_facility=" + appointment_list.health_facility, true);
        xhttp.send();
    },

    showPreviousMonth: function () {
        
        if (appointment_list.month === 1) {
            appointment_list.month = 12;
            appointment_list.year--;
        } else {
            appointment_list.month--;
        }
        appointment_list.loadCalendar(appointment_list.month, appointment_list.year, appointment_list.location, appointment_list.health_facility);
    },

    showThisMonth: function () {
        let dateNew = new Date();
        appointment_list.month = dateNew.getMonth() + 1; // JavaScript months are 0-based
        appointment_list.year = dateNew.getFullYear();
        appointment_list.loadCalendar(appointment_list.month, appointment_list.year, appointment_list.location, appointment_list.health_facility);
    },

    showNextMonth: function () {
        
        if (appointment_list.month === 12) {
            appointment_list.month = 1;
            appointment_list.year++;
        } else {
            appointment_list.month++;
        }
        appointment_list.loadCalendar(appointment_list.month, appointment_list.year, appointment_list.location, appointment_list.health_facility);
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
        
        appointment_list.selectedDate = date;
        //document.querySelector('.js-selected-date').innerHTML = appointment_list.selectedDate;
        console.log(appointment_list.selectedDate);
        appointment_list.loadTimeslots();
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
        appointment_list.selectedTimeslot = timeslot;
    },

    go_to_page: function(page) {

        this.current_page = page;
        this.load_appointments();
    },

    previous_page: function() {

        if (this.current_page > 1) {
            this.current_page--;
            this.load_appointments();
        }
    },

    next_page: function() {

        if (this.current_page < this.last_page) {
            this.current_page++;
            this.load_appointments();
        }
    },

    go_to_last_page: function() {
        
        this.current_page = this.last_page;
        this.load_appointments();
    },

    hide: function(){
        //document.querySelector(".js-add-admin").classList.add('hide');
        document.querySelector(".js-edit-appointment").classList.add('hide');
        document.querySelector(".js-view-appointment").classList.add('hide');
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
        appointment_list.showEntryNum = num_value;
        appointment_list.load_appointments();
    },
};

if (typeof appointment_admin_list != 'undefined') {
    appointment_list.load_appointments();
}