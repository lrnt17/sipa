
var mycomment = {

    page_number: (typeof page_number == 'undefined') ? 1 : page_number,
	post_id: (typeof post_id == 'undefined') ? 0 : post_id,
    
    submit: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-comment-input").value.trim();
        
        if(text == "" && title == ""){
            alert("Please type something");
            return;
        }

        let form = new FormData(); //new form within javascript
        
        form.append('post_id', mycomment.post_id);
        form.append('post', text);
        form.append('data_type', 'add_comment');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        document.querySelector(".js-comment-input").value = "";
                        mycomment.load_comments();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },
    //dito mapapalitan si loading...... sa taas, magiging data na sya
    load_comments: function(e){

        let form = new FormData();
        
        form.append('post_id', mycomment.post_id);
        form.append('page_number', mycomment.page_number);
        form.append('data_type', 'load_comments');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success){
                        let post_holder = document.querySelector(".js-comments-loading");
                        //console.log(post_holder);
                        post_holder.innerHTML = "";
                        let template = document.querySelector(".js-comment-card");
                        
                        if (typeof obj.rows == 'object') {
                        
                            for (var i = obj.rows.length - 1; i >= 0; i--) {
                                template.querySelector(".js-comment").innerHTML = obj.rows[i].forum_desc; //ito naman sa db
                                template.querySelector(".js-date").innerHTML = obj.rows[i].date;// si .date based  sa nasa ajax
                                template.querySelector(".js-delete-button").setAttribute('onclick',`mycomment.delete(${obj.rows[i].forum_id})`);
								template.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_comment.show_me(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-reply-link").setAttribute('onclick',`mycomment.view_replies(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';
                                
                                //counting the number of comments
                                if(obj.rows[i].reply_count > 0){
									template.querySelector(".js-reply-link").innerHTML = `Reply (${obj.rows[i].reply_count})`;
								}else{
									template.querySelector(".js-reply-link").innerHTML = `Reply`;
								}

                                if(typeof obj.rows[i].user == 'object')
                                    template.querySelector(".js-photo").src = obj.rows[i].user.user_image;

                                let clone = template.cloneNode(true);
                                clone.setAttribute('id','post_'+obj.rows[i].forum_id);
								let row_data = JSON.stringify(obj.rows[i]);
								row_data = row_data.replaceAll('"','\\"');

                                clone.setAttribute('row',row_data);
                                
                                let action_buttons = clone.querySelector(".js-action-buttons");
                                if(!obj.rows[i].user_owns){
                                    action_buttons.remove();
                                }
                                    
                                clone.classList.remove('hide');
                                
                                post_holder.appendChild(clone);
                            }

                        }else{
                            post_holder.innerHTML = "<div style='text-align:center;padding:10px'>No comments found</div>";
                        }
                    }
                    document.querySelector(".js-page-number").innerHTML = "Page " + mycomment.page_number;
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },
    //ala na to
    view_comments: function(forum_id){

        window.location.href = "post.php?id="+forum_id;
    },

    view_replies: function(forum_id){

        let form = new FormData();
        form.append('forum_id', forum_id);
        form.append('data_type', 'get_replies');
        let ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                let data = JSON.parse(ajax.responseText);
                //console.log(data);
                
                if (data.success) {
                    // Get reference to reply button element
                    let replyButtonElement = document.querySelector('#post_' + forum_id + ' .js-reply-link');
                    
                    // Get existing replies container or create a new one if it doesn't exist
                    let repliesContainer = document.querySelector('#post_' + forum_id + ' .replies-container');
                    
                    // Clear existing content in replies container
                    if (repliesContainer) {
                        repliesContainer.innerHTML = '';
                    } else {
                        repliesContainer = document.createElement('div');
                        repliesContainer.classList.add('replies-container');
                    }
                    
                    //console.log(data.rows);
                    // Check if there are any replies
                    if (typeof data.rows == 'object' && data.rows.length > 0) {
                        // Loop through replies data and create elements for each reply
                        for (let i = data.rows.length - 1; i >= 0; i--) {
                            //Outer div
                            let replyWrapper = document.createElement('div');
                            replyWrapper.classList.add('reply-wrapper');

                                //Inner divs


                                let userimageElement = document.createElement('img');
                                userimageElement.src = 'assets/images/57.png'; // Default image source
                                userimageElement.classList.add('js-userimage-reply');
                                
                                if (typeof data.rows[i].user == 'object') {
                                    userimageElement.src = data.rows[i].user.image;
                                }
                                
                                let usernameElement = document.createElement('div');
                                usernameElement.classList.add('js-username-reply');
                                usernameElement.innerHTML = (data.rows[i].user_fname) ? data.rows[i].user_fname : 'User';
                                
                                let replyElement = document.createElement('div');
                                replyElement.classList.add('reply');
                                replyElement.innerHTML = data.rows[i].forum_desc;
                            
                                // Create action buttons container
                                let actionButtonsContainer = document.createElement('div');
                                actionButtonsContainer.classList.add('js-action-buttons', 'class_51');
                                
                                    // Create edit button
                                    /*let editButton = document.createElement('div');
                                    editButton.classList.add('js-edit-button', 'class_53');
                                    editButton.style.color = 'blue';
                                    editButton.style.cursor = 'pointer';
                                    editButton.innerHTML = 'Edit';
                                    //editButton.setAttribute('onclick', `my_edit_reply.show_me(${data.rows[i].forum_id})`);

                                    // Create delete button
                                    let deleteButton = document.createElement('div');
                                    deleteButton.classList.add('js-delete-button', 'class_53');
                                    deleteButton.style.color = 'red';
                                    deleteButton.style.cursor = 'pointer';
                                    deleteButton.innerHTML = 'Delete';

                                // Append action buttons to container
                                actionButtonsContainer.appendChild(editButton);
                                actionButtonsContainer.appendChild(deleteButton);*/

                            replyWrapper.appendChild(userimageElement);
                            replyWrapper.appendChild(usernameElement);
                            replyWrapper.appendChild(replyElement);
                            replyWrapper.appendChild(actionButtonsContainer);

                            let clone = replyWrapper.cloneNode(true);
                            clone.setAttribute('id','post_'+data.rows[i].forum_id);
                            let row_data = JSON.stringify(data.rows[i]);
                            row_data = row_data.replaceAll('"','\\"');

                            clone.setAttribute('row',row_data);
                            //replyWrapper.appendChild(clone);

                            // Create edit button bago to!!!!!!!!!!!!!!!!!!!!!!!!!
                            let editButton = document.createElement('div');
                            editButton.classList.add('js-edit-button', 'class_53');
                            editButton.style.color = 'blue';
                            editButton.style.cursor = 'pointer';
                            editButton.innerHTML = 'Edit';

                            // Attach event listener to the edit button
                            editButton.addEventListener('click', mycomment.editReply);

                            // Create delete button
                            let deleteButton = document.createElement('div');
                            deleteButton.classList.add('js-delete-button', 'class_53');
                            deleteButton.style.color = 'red';
                            deleteButton.style.cursor = 'pointer';
                            deleteButton.innerHTML = 'Delete';

                            // Attach event listener to the edit button
                            deleteButton.addEventListener('click', mycomment.deleteReply);

                            // Append action buttons to container in cloned replyWrapper
                            let clonedActionButtonsContainer = clone.querySelector('.js-action-buttons');
                            clonedActionButtonsContainer.appendChild(editButton);
                            clonedActionButtonsContainer.appendChild(deleteButton);

                            let action_buttons = clone.querySelector(".js-action-buttons");
                            if(!data.rows[i].user_owns){
                                action_buttons.remove();
                            }

                            //repliesContainer.appendChild(replyWrapper);
                            repliesContainer.appendChild(clone);
                        }
                    } else {
                        // Display message if there are no replies
                        let noRepliesMessage = document.createElement('p');
                        noRepliesMessage.innerHTML = 'No replies yet';
                        repliesContainer.appendChild(noRepliesMessage);
                    }
                    
                    // Create form element for adding new reply
                    let replyForm = document.createElement('form');
                    replyForm.onsubmit = mycomment.reply;
                    replyForm.classList = 'js-replied';
                    replyForm.method = 'post';
                    replyForm.setAttribute('forum_id', forum_id);
                    
                    // Create textarea element for reply input
                    let replyInput = document.createElement('textarea');
                    replyInput.placeholder = 'Add a reply...';
                    replyInput.classList = 'js-reply-input';
                    replyInput.name = 'reply_text';
                    replyForm.appendChild(replyInput);
                    
                    // Create button element for submitting form
                    let replyButton = document.createElement('button');
                    replyButton.innerHTML = 'Reply';
                    replyForm.appendChild(replyButton);
                    
                    // Append form element to replies container
                    repliesContainer.appendChild(replyForm);
                    // Insert or replace replies container after reply button element
                    if (replyButtonElement.nextSibling) {
                        replyButtonElement.parentNode.replaceChild(repliesContainer, replyButtonElement.nextSibling);
                    } else {
                        replyButtonElement.parentNode.appendChild(repliesContainer);
                    }


                }
            }
        });
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    next_page: function(){ //dito iicrement si page
        mycomment.page_number = mycomment.page_number + 1;
        mycomment.load_comments();
        //window.location.href = 'post.php?page=' + mycomment.page_number;
    },

    prev_page: function(){
        mycomment.page_number = mycomment.page_number - 1;

        //pag bumaba less than 1, page 1 pa rin lalabas
        if (mycomment.page_number < 1) {
            mycomment.page_number = 1;
        }
        //console.log(page_number);
        //window.location.href = 'post.php?page=' + mycomment.page_number;
        mycomment.load_comments();
    },

    delete: function(forum_id) {
        if (!confirm("Are you sure you want to delete this comment?")) {
            //alert(forum_id);
            return;
        }
        
        let form = new FormData(); //new form within javascript
        //let comment_part = true;

        form.append('id', forum_id);
        //form.append('comment_part', comment_part);
        form.append('data_type', 'delete_comment');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        mycomment.load_comments();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    reply: function(e){ //dito iicrement si page
        
        e.preventDefault();
        // Get value of reply_text input field
        let replyText = e.target.elements.reply_text.value.trim();
        
        // Check if reply text is empty
        if (replyText == "") {
            alert("Please type something");
            
            return;
        }
        console.log(replyText);
        // Get forum_id from data attribute of form element
        let forumId = e.target.getAttribute('forum_id');
        console.log(forumId);
        // Create FormData object to send data to server
        let form = new FormData();
        form.append('forum_id', forumId);
        form.append('reply_text', replyText);
        form.append('data_type', 'add_reply');
        
        // Create AJAX request to send data to server
        var ajax = new XMLHttpRequest();

        /*ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let data = JSON.parse(ajax.responseText);
                    alert(data.message);
                    if (data.success) {
                        // Clear reply_text input field
                        e.target.elements.reply_text.value = "";
                        // Reload replies
                        mycomment.view_replies(forumId);
                    }
                }
                
            } else {
                alert("Please check your internet connection!!!!!!");
            }
        });*/

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let data = JSON.parse(ajax.responseText);
                    if (data.success) {
                        alert(data.message);
                        // Clear reply_text input field
                        e.target.elements.reply_text.value = "";
                        // Reload replies
                        mycomment.view_replies(forumId);
                    } else {
                        alert(data.message);
                    }
                } else {
                    alert("There was an error. Please try again.");
                }
            }
        });
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    editReply: function(e) {
        // Get the parent replyWrapper element
        let replyWrapper = e.target.closest('.reply-wrapper');
        //console.log(replyWrapper);
        // Get the existing reply content
        let replyElement = replyWrapper.querySelector('.reply');
        //console.log(replyElement);
        let replyText = replyElement.innerHTML;
        //console.log(replyText);
        // Create an input field for editing the reply
        let editInput = document.createElement('input');
        editInput.type = 'text';
        editInput.value = replyText;

        // Replace the reply content with the input field
        replyWrapper.replaceChild(editInput, replyElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.innerHTML = 'Save';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', mycomment.saveReply);

        // Append the Save button to the replyWrapper element
        replyWrapper.appendChild(saveButton);

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-edit');
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Cancel button
        cancelButton.addEventListener('click', function() {
            // Replace editInput and saveButton with original replyElement
            replyWrapper.replaceChild(replyElement, editInput);
            replyWrapper.removeChild(saveButton);
            replyWrapper.removeChild(cancelButton);
            // Show the edit and delete buttons
            replyWrapper.querySelector('.js-edit-button').classList.remove('hide');
            replyWrapper.querySelector('.js-delete-button').classList.remove('hide');
        });

        // Append the Cancel button to the replyWrapper element
        replyWrapper.appendChild(cancelButton);

        // Hide the edit and delete buttons
        replyWrapper.querySelector('.js-edit-button').classList.add('hide');
        replyWrapper.querySelector('.js-delete-button').classList.add('hide');
    },

    saveReply: function(e) {

        //e.preventDefault();
        let replyWrapper = e.target.closest('.reply-wrapper');
        console.log(replyWrapper);
        // Get the edited reply input field
        let editInput = replyWrapper.querySelector('input');
        console.log(editInput);
        // Get the edited reply content
        let editedReplyText = editInput.value;
        console.log(editedReplyText);
        // Send the updated reply content to the server using AJAX
        // You can use the fetch API or other AJAX libraries for this
        // Example using fetch API:
        let forumId = replyWrapper.id.replace('post_', '');
        console.log(forumId);

        let form = new FormData();

        form.append('id', forumId);
        form.append('post', editedReplyText);
        form.append('data_type', 'my_edit_reply');
        
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //ganto daw iconvert si JSON back to javascript
                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); //nasa ajax.php yung .message

                    if(obj.success){
                        // Update the reply element with the edited text
                        let replyElement = document.createElement('div');
                        replyElement.classList.add('reply');
                        replyElement.innerHTML = editedReplyText;
                        // Replace editInput and saveButton with replyElement
                        let saveButton = replyWrapper.querySelector('button');
                        replyWrapper.replaceChild(replyElement, editInput);
                        replyWrapper.removeChild(saveButton);

                        // Show the edit and delete buttons
                        replyWrapper.querySelector('.js-edit-button').classList.remove('hide');
                        replyWrapper.querySelector('.js-delete-button').classList.remove('hide');
                        
                        // Remove the cancel button
                        let cancelButton = replyWrapper.querySelector('.js-cancel-edit');
                        replyWrapper.removeChild(cancelButton);
                    }//nasa ajax.php yung .sucess
                        //window.location.reload();
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
        /*fetch('/update-reply', {
            method: 'POST',
            body: JSON.stringify({ replyId, editedReplyText }),
            headers: {
            'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Handle the server response
            if (data.success) {
            // Update the reply content on the page
            let replyElement = document.createElement('div');
            replyElement.classList.add('reply');
            replyElement.innerHTML = editedReplyText;

            replyWrapper.replaceChild(replyElement, editInput);

            // Remove the Save button
            event.target.remove();
            } else {
            // Handle the case where the server update failed
            console.log('Failed to update reply.');
            }
        })
        .catch(error => {
            console.log('Error:', error);
        });*/
    },

    deleteReply: function(e) {

        //e.preventDefault();
        let replyWrapper = e.target.closest('.reply-wrapper');
        console.log(replyWrapper);
        let replyButtonElement = e.target.closest('.js-comment-card');
        let comment_id = replyButtonElement.id.replace('post_', '');
        console.log(comment_id);
        // Send the updated reply content to the server using AJAX
        // You can use the fetch API or other AJAX libraries for this
        // Example using fetch API:
        let replyId = replyWrapper.id.replace('post_', '');
        console.log(replyId);

        if (!confirm("Are you sure you want to delete this reply?")) {
            //alert(forum_id);
            return;
        }

        let form = new FormData();

        form.append('id', replyId);
        form.append('data_type', 'delete_reply');
        
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //ganto daw iconvert si JSON back to javascript
                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); //nasa ajax.php yung .message

                    if(obj.success){
                        mycomment.view_replies(comment_id);
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },
};

mycomment.load_comments(); //dito lumabas yung mga forum kasi tinatawag