var single_video = {

    video_id: (typeof video_id == 'undefined') ? 0 : video_id,

    add_comment: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-comment-input").value.trim();
        let anonymous = document.querySelector(".js-anonymous-comment").checked;

        if(text == ""){
            alert("Please type something");
            return;
        }

        let form = new FormData(); //new form within javascript
        
        form.append('video_id', single_video.video_id);
        form.append('comment', text);
        form.append('anonymous', anonymous);
        form.append('data_type', 'add_video_comment');
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
                        document.querySelector(".js-anonymous-comment").checked = false;
                        single_video.load_comments();

                        /*let video_id_int = parseInt(single_video.video_id);
                        let video_id_string = video_id_int.toString();
                        allposts.updatePostData(video_id_string, null);*/
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    load_comments: function(){

        let form = new FormData();
        
        form.append('video_id', single_video.video_id);
        form.append('data_type', 'load_video_comments');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success){
                        let comment_holder = document.querySelector(".js-comments-loading");
                        //console.log(comment_holder);
                        comment_holder.innerHTML = "";
                        let template = document.querySelector(".js-comment-card");
                        
                        if (typeof obj.rows == 'object') {
                        
                            for (var i = obj.rows.length - 1; i >= 0; i--) {
                                template.querySelector(".js-comment").innerHTML = obj.rows[i].video_desc;
                                template.querySelector(".js-delete-button").setAttribute('onclick',`single_video.delete_comment(${obj.rows[i].video_id})`);
                                template.querySelector(".js-edit-button").setAttribute('onclick',`single_video.edit_comment_video(${obj.rows[i].video_id})`);
                                template.querySelector(".js-reply-link").setAttribute('onclick',`single_video.view_replies(${obj.rows[i].video_id})`);
                                //template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                template.querySelector(".js-username").innerHTML = obj.rows[i].user_fname;
                                //template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';
                                template.querySelector(".js-like-button").setAttribute('video_id', obj.rows[i].video_id);
                                template.querySelector(".js-num-likes").setAttribute('video_id', obj.rows[i].video_id);
                                
                                //counting the number of comments
                                if(obj.rows[i].reply_count > 0){
                                    if (obj.rows[i].reply_count == 1) {
                                        template.querySelector(".js-reply-link").innerHTML = `${obj.rows[i].reply_count} Reply`;
                                    }else{
                                        template.querySelector(".js-reply-link").innerHTML = `${obj.rows[i].reply_count} Replies`;
                                    }
								}else{
									template.querySelector(".js-reply-link").innerHTML = `Reply`;
								}

                                //counting the number of likes
                                if (obj.rows[i].getlikes['count(*)'] == 0) {
                                    template.querySelector(".js-num-likes").innerHTML = "";
                                } else {
                                    template.querySelector(".js-num-likes").innerHTML = obj.rows[i].getlikes['count(*)'];
                                }
                                template.querySelector(".js-photo").src = obj.rows[i].user_img;
                                /*if(typeof obj.rows[i].user == 'object')
                                    template.querySelector(".js-photo").src = obj.rows[i].user.user_image;*/

                                let clone = template.cloneNode(true);
                                clone.setAttribute('id','video_'+obj.rows[i].video_id);
								let row_data = JSON.stringify(obj.rows[i]);
								row_data = row_data.replaceAll('"','\\"');

                                clone.setAttribute('row',row_data);

                                let likeButton = clone.querySelector(".js-like-button");
                                //console.log(likeButton);
                                like_rating_video.userLiked(obj.rows[i].video_id, (function(likeButton) {
                                    return function(userlikes) {
                                        //console.log(userlikes);
                                        if (userlikes) {
                                            likeButton.classList.add('btn_selected');
                                        } else {
                                            likeButton.classList.add('btn');
                                        }
                                    };
                                })(likeButton));

                                //for pressing like button
                                clone.querySelector('.js-like-button').addEventListener('click', function(event) {
                                    // Call the allposts.like function and pass a reference to the clicked button element
                                    like_rating_video.like(event.target, false);
                                });

                                let timestampElement = clone.querySelector('.js-date');
                                time.updateTimestamps(timestampElement, obj.rows[i].date);

                                let action_buttons = clone.querySelector(".js-action-buttons");
                                if(!obj.rows[i].user_owns){
                                    action_buttons.remove();
                                }

                                clone.classList.remove('hide');
                                
                                comment_holder.appendChild(clone);
                            }

                        }else{
                            comment_holder.innerHTML = "<div style='text-align:center;padding:10px; color:gray;'>No comments found</div>";
                        }
                    }
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    edit_comment_video: function(video_id) {
        // Find the post element using the video_id
        let commentWrapper = document.querySelector(`#video_${video_id}`);
        
        // Get the title and content elements of the post
        let commentElement = commentWrapper.querySelector('.js-comment');

        // Get the current text of the title and content elements
        let commentText = commentElement.textContent;
        
        // Create new input elements for the title and content
        let editTextarea = document.createElement('textarea');
        editTextarea.classList.add('js-comment-input');
        editTextarea.value = commentText;

        // Replace the reply content with the input field
        commentElement.parentNode.replaceChild(editTextarea, commentElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('js-save-button');
        saveButton.innerHTML = 'Save';

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-button');
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', function() {
            // Get the edited title and content from the input fields
            let editedContent = editTextarea.value;

            // Call a function to save the edited title and content
            single_video.save_comment(video_id, editedContent);
        });

        // Attach event listener to the Cancel button
        cancelButton.addEventListener('click', function() {
            // Create new elements to replace the input fields with
            let newContentElement = document.createElement('div');
            newContentElement.classList.add('js-comment');
            newContentElement.textContent = commentText;

            // Replace editTextarea and saveButton with original replyElement
            editTextarea.parentNode.replaceChild(newContentElement, editTextarea);
            commentWrapper.removeChild(saveButton);
            commentWrapper.removeChild(cancelButton);
            
            // Show the edit and delete buttons
            commentWrapper.querySelector('.js-date').classList.remove('hide');
            commentWrapper.querySelector('.js-reply-section').classList.remove('hide');
            commentWrapper.querySelector('.js-like-section').classList.remove('hide');
            commentWrapper.querySelector('.js-action-buttons').classList.remove('hide');
        });

        // Append the Save button to the replyWrapper element
        commentWrapper.appendChild(saveButton);
        // Append the Cancel button to the replyWrapper element
        commentWrapper.appendChild(cancelButton);

        // Hide the edit and delete buttons
        commentWrapper.querySelector('.js-date').classList.add('hide');
        commentWrapper.querySelector('.js-reply-section').classList.add('hide');
        commentWrapper.querySelector('.js-like-section').classList.add('hide');
        commentWrapper.querySelector('.js-action-buttons').classList.add('hide');
    },

    save_comment: function(video_id, editedContent) {

        // Create a FormData object to send the data to the server
        let form = new FormData();
        form.append('video_id', video_id);
        form.append('edited_comment', editedContent);
        form.append('data_type', 'my_edit_comment_video');
        
        // Create a new XMLHttpRequest object
        var ajax = new XMLHttpRequest();

        // Add an event listener to handle the server response
        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); //nasa ajax.php yung .message

                    if(obj.success){
                        // Find the post element using the video_id
                        let postElement = document.querySelector(`#video_${video_id}`);

                        // Update the date element with the updated date
                        let dateElement = postElement.querySelector('.js-date');
                        //dateElement.textContent = obj.updated_date;
                        time.updateTimestamps(dateElement, obj.updated_date);

                        // Create new elements to replace the input fields with
                        let newContentElement = document.createElement('div');
                        newContentElement.classList.add('js-comment');
                        newContentElement.textContent = editedContent;
                        
                        // Replace the input fields with the new elements
                        let contentInput = postElement.querySelector('.js-comment-input');
                        contentInput.parentNode.replaceChild(newContentElement, contentInput);

                        // Remove the save and cancel buttons
                        let saveButton = postElement.querySelector('.js-save-button');
                        let cancelButton = postElement.querySelector('.js-cancel-button');
                        postElement.removeChild(saveButton);
                        postElement.removeChild(cancelButton);

                        // Show the other elements
                        postElement.querySelector('.js-date').classList.remove('hide');
                        postElement.querySelector('.js-reply-section').classList.remove('hide');
                        postElement.querySelector('.js-like-section').classList.remove('hide');
                        postElement.querySelector('.js-action-buttons').classList.remove('hide');
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    delete_comment: function(video_id) {
        if (!confirm("Are you sure you want to delete this comment?")) {
            return;
        }
        
        let form = new FormData();

        form.append('video_id', video_id);
        form.append('data_type', 'delete_comment_video');

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        single_video.load_comments();

                        /*let video_id_int = parseInt(single_video.video_id);
                        let video_id_string = video_id_int.toString();
                        allposts.updatePostData(video_id_string, null);*/
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    view_replies: function(video_id){

        let form = new FormData();
        form.append('video_id', video_id);
        form.append('data_type', 'get_replies_video');
        let ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                let data = JSON.parse(ajax.responseText);
                
                if (data.success) {
                    // Get reference to reply button element
                    let replyButtonElement = document.querySelector('#video_' + video_id + ' .js-reply-link');
                    
                    // Get existing replies container or create a new one if it doesn't exist
                    let repliesContainer = document.querySelector('#video_' + video_id + ' .replies-container');
                    
                    // Clear existing content in replies container
                    if (repliesContainer) {
                        repliesContainer.innerHTML = '';
                    } else {
                        repliesContainer = document.createElement('div');
                        repliesContainer.classList.add('replies-container');
                    }

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
                                userimageElement.src = data.rows[i].user_img;
                                
                                let usernameElement = document.createElement('div');
                                usernameElement.classList.add('js-username-reply');
                                //usernameElement.innerHTML = (data.rows[i].user_fname) ? data.rows[i].user_fname : 'User';
                                usernameElement.innerHTML = data.rows[i].user_fname;
                                
                                let dateTimeElement = document.createElement('div');
                                dateTimeElement.classList.add('js-date');
                                //dateTimeElement.innerHTML = data.rows[i].date;

                                let replyElement = document.createElement('div');
                                replyElement.classList.add('reply');
                                replyElement.innerHTML = data.rows[i].video_desc;

                                let likeButtonElement = document.createElement('button');
                                likeButtonElement.classList.add('js-like-button');
                                likeButtonElement.setAttribute('video_id', data.rows[i].video_id);
                                likeButtonElement.style.cursor = 'pointer';
                                likeButtonElement.innerHTML = 'Like';

                                let numlikeElement = document.createElement('span');
                                numlikeElement.classList.add('js-num-likes');
                                numlikeElement.setAttribute('video_id', data.rows[i].video_id);
                                
                                //counting the number of likes
                                if (data.rows[i].getlikes['count(*)'] == 0) {
                                    numlikeElement.innerHTML = "";
                                } else {
                                    numlikeElement.innerHTML = data.rows[i].getlikes['count(*)'];
                                }

                                // Create action buttons container
                                let actionButtonsContainer = document.createElement('div');
                                actionButtonsContainer.classList.add('js-action-buttons', 'class_51');

                            replyWrapper.appendChild(userimageElement);
                            replyWrapper.appendChild(usernameElement);
                            replyWrapper.appendChild(dateTimeElement);
                            replyWrapper.appendChild(replyElement);
                            replyWrapper.appendChild(likeButtonElement);
                            replyWrapper.appendChild(numlikeElement);
                            replyWrapper.appendChild(actionButtonsContainer);

                            let clone = replyWrapper.cloneNode(true);
                            clone.setAttribute('id','video_'+data.rows[i].video_id);
                            let row_data = JSON.stringify(data.rows[i]);
                            row_data = row_data.replaceAll('"','\\"');

                            clone.setAttribute('row',row_data);
                            //replyWrapper.appendChild(clone);
                            
                            // Update the timestamp dynamically
                            let timestampElement = clone.querySelector('.js-date');
                            time.updateTimestamps(timestampElement, data.rows[i].date);

                            let likeButton = clone.querySelector('.js-like-button');
                            // Apply like functionality to the like button
                            like_rating_video.userLiked(data.rows[i].video_id, (function(likeButton) {
                                return function(userLikes) {
                                if (userLikes) {
                                    likeButton.classList.add('btn_selected');
                                } else {
                                    likeButton.classList.add('btn');
                                }
                                };
                            })(likeButton));

                            // Add click event listener to the like button
                            likeButton.addEventListener('click', function(event) {
                                like_rating_video.like(event.target, false);
                            });

                            // Create edit button bago to!!!!!!!!!!!!!!!!!!!!!!!!!
                            let editButton = document.createElement('div');
                            editButton.classList.add('js-edit-button', 'class_53');
                            editButton.style.color = 'blue';
                            editButton.style.cursor = 'pointer';
                            editButton.innerHTML = 'Edit';

                            // Attach event listener to the edit button
                            editButton.addEventListener('click', single_video.edit_reply);

                            // Create delete button
                            let deleteButton = document.createElement('div');
                            deleteButton.classList.add('js-delete-button', 'class_53');
                            deleteButton.style.color = 'red';
                            deleteButton.style.cursor = 'pointer';
                            deleteButton.innerHTML = 'Delete';

                            // Attach event listener to the edit button
                            deleteButton.addEventListener('click', single_video.delete_reply);

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
                    replyForm.onsubmit = single_video.add_reply;
                    replyForm.classList = 'js-replied';
                    replyForm.method = 'post';
                    replyForm.setAttribute('video_id', video_id);
                    
                    // Create textarea element for reply input
                    let replyInput = document.createElement('textarea');
                    replyInput.placeholder = 'Add a reply...';
                    replyInput.classList = 'js-reply-input';
                    replyInput.name = 'reply_text';
                    replyForm.appendChild(replyInput);
                    
                    let breakTag1 = document.createElement('br');
                    replyForm.appendChild(breakTag1);
                    
                    // Create div element for anonymous checkbox
                    let anonymousDiv = document.createElement('div');

                        // Create label element for anonymous checkbox
                        let anonymousLabel = document.createElement('label');
                        anonymousLabel.setAttribute('for', 'anonymous');
                        anonymousLabel.textContent = 'Post anonymously:';
                        anonymousDiv.appendChild(anonymousLabel);

                        // Create input element for anonymous checkbox
                        let anonymousInput = document.createElement('input');
                        anonymousInput.setAttribute('type', 'checkbox');
                        anonymousInput.setAttribute('id', 'anonymous');
                        anonymousInput.setAttribute('name', 'anonymous_reply');
                        anonymousInput.classList.add('js-anonymous-reply');
                        anonymousDiv.appendChild(anonymousInput);

                    // Append div element to form
                    replyForm.appendChild(anonymousDiv);
                    
                    let breakTag2 = document.createElement('br');
                    replyForm.appendChild(breakTag2);

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

    add_reply: function(e){ //dito iicrement si page
        
        e.preventDefault();
        // Get value of reply_text input field
        let replyText = e.target.elements.reply_text.value.trim();
        let anonymous = e.target.elements.anonymous_reply.checked;
        
        // Check if reply text is empty
        if (replyText == "") {
            alert("Please type something");
            return;
        }
        
        // Get video_id from data attribute of form element
        let video_id = e.target.getAttribute('video_id');
        
        // Create FormData object to send data to server
        let form = new FormData();
        form.append('video_id', video_id);
        form.append('reply_text', replyText);
        form.append('anonymous', anonymous);
        form.append('data_type', 'add_reply_video');
        
        // Create AJAX request to send data to server
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let data = JSON.parse(ajax.responseText);
                    if (data.success) {
                        alert(data.message);
                        // Clear reply_text input field
                        e.target.elements.reply_text.value = "";
                        e.target.elements.anonymous_reply.checked = false;
                        // Reload replies
                        single_video.view_replies(video_id);
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

    edit_reply: function(e) {
        
        // Get the parent replyWrapper element
        let replyWrapper = e.target.closest('.reply-wrapper');

        // Get the existing reply content
        let replyElement = replyWrapper.querySelector('.reply');
        
        let replyText = replyElement.innerHTML;

        // Create an input field for editing the reply
        let editInput = document.createElement('input');
        editInput.type = 'text';
        editInput.value = replyText;

        // Replace the reply content with the input field
        replyWrapper.replaceChild(editInput, replyElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('js-save-edit');
        saveButton.innerHTML = 'Save';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', single_video.save_edited_reply);

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

    save_edited_reply: function(e) {

        let replyWrapper = e.target.closest('.reply-wrapper');
        
        // Get the edited reply input field
        let editInput = replyWrapper.querySelector('input');
        
        // Get the edited reply content
        let editedReplyText = editInput.value;
        let video_id = replyWrapper.id.replace('video_', '');

        let form = new FormData();

        form.append('video_id', video_id);
        form.append('edited_reply_text', editedReplyText);
        form.append('data_type', 'my_edit_reply_video');
        
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); 

                    if(obj.success){
                        // Update the reply element with the edited text
                        let replyElement = document.createElement('div');
                        replyElement.classList.add('reply');
                        replyElement.innerHTML = editedReplyText;

                        let dateElement = replyWrapper.querySelector('.js-date');
                        time.updateTimestamps(dateElement, obj.updated_date);

                        // Replace editInput and saveButton with replyElement
                        let saveButton = replyWrapper.querySelector('.js-save-edit');
                        replyWrapper.replaceChild(replyElement, editInput);
                        replyWrapper.removeChild(saveButton);

                        // Show the edit and delete buttons
                        replyWrapper.querySelector('.js-edit-button').classList.remove('hide');
                        replyWrapper.querySelector('.js-delete-button').classList.remove('hide');
                        
                        // Remove the cancel button
                        let cancelButton = replyWrapper.querySelector('.js-cancel-edit');
                        replyWrapper.removeChild(cancelButton);
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    delete_reply: function(e) {

        let replyWrapper = e.target.closest('.reply-wrapper');
        
        let replyButtonElement = e.target.closest('.js-comment-card');
        let comment_id = replyButtonElement.id.replace('video_', '');

        let video_id = replyWrapper.id.replace('video_', '');

        if (!confirm("Are you sure you want to delete this reply?")) {
            return;
        }

        let form = new FormData();

        form.append('video_id', video_id);
        form.append('data_type', 'delete_reply_video');
        
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        single_video.view_replies(comment_id);
                    }
                        
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    blank: function(){

        
    },

    increment_views: function() {
        
        let form = new FormData();
        form.append('video_id', single_video.video_id);
        form.append('data_type', 'increment_views');
        var ajax = new XMLHttpRequest();
    
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                let obj = JSON.parse(ajax.responseText);
                if (obj.success) {
                    // The view count was successfully incremented
                }
            }
        });
    
        ajax.open('post', 'ajax.php', true);
        ajax.send(form);
    },

    check_rating_single_video: function() {
        // Get the like button and number of likes elements
        let likeButton = document.querySelector('.single-video.js-like-button');
        //console.log(likeButton);
        // Get the video_id from the like button element
        let video_id = likeButton.getAttribute('video_id');

        // Check if the user has already liked the post
        like_rating_video.userLiked(video_id, function(userlikes) {
            if (userlikes) {
                likeButton.classList.add('btn_selected');
            } else {
                likeButton.classList.add('btn');
            }
        });

        // Add an event listener to the like button
        likeButton.addEventListener('click', function(event) {
            // Call the allposts.like function and pass a reference to the clicked button element
            like_rating_video.like(event.target, true);
        });
    },
};

single_video.load_comments();