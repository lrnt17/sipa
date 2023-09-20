
var mycomment = {

    page_number: (typeof page_number == 'undefined') ? 1 : page_number,
    userId: (typeof userId == 'undefined') ? null : userId,
	post_id: (typeof post_id == 'undefined') ? 0 : post_id,
    
    submit: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-comment-input").value.trim();
        let anonymous = document.querySelector(".js-anonymous-comment").checked;

        if(text == "" && title == ""){
            alert("Please type something");
            return;
        }

        let form = new FormData(); //new form within javascript
        
        form.append('post_id', mycomment.post_id);
        form.append('post', text);
        form.append('anonymous', anonymous);
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
                        document.querySelector(".js-anonymous-comment").checked = false;
                        mycomment.load_comments();

                        let forum_id_int = parseInt(mycomment.post_id);
                        let forum_id_string = forum_id_int.toString();
                        allposts.updatePostData(forum_id_string, null);
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
    load_comments: function(){

        let form = new FormData();
        
        form.append('post_id', mycomment.post_id);
        //form.append('page_number', mycomment.page_number);
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
                                //template.querySelector(".js-date").innerHTML = obj.rows[i].date;// si .date based  sa nasa ajax
                                template.querySelector(".js-delete-button").setAttribute('onclick',`mycomment.delete(${obj.rows[i].forum_id})`);
								//template.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_comment.show_me(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-edit-button").setAttribute('onclick',`mycomment.editComment(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-reply-link").setAttribute('onclick',`mycomment.view_replies(${obj.rows[i].forum_id})`);
                                //template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                template.querySelector(".js-username").innerHTML = obj.rows[i].user_fname;
                                //template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';
                                template.querySelector(".js-like-button").setAttribute('forum_id', obj.rows[i].forum_id);
                                template.querySelector(".js-num-likes").setAttribute('forum_id', obj.rows[i].forum_id);
                                
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
                                clone.setAttribute('id','post_'+obj.rows[i].forum_id);
								let row_data = JSON.stringify(obj.rows[i]);
								row_data = row_data.replaceAll('"','\\"');

                                clone.setAttribute('row',row_data);

                                let likeButton = clone.querySelector(".js-like-button");
                                //console.log(likeButton);
                                like_rating.userLiked(obj.rows[i].forum_id, (function(likeButton) {
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
                                    like_rating.like(event.target, false);
                                });

                                let timestampElement = clone.querySelector('.js-date');
                                time.updateTimestamps(timestampElement, obj.rows[i].date);

                                let action_buttons = clone.querySelector(".js-action-buttons");
                                if(!obj.rows[i].user_owns){
                                    action_buttons.remove();
                                }

                                clone.classList.remove('hide');
                                
                                post_holder.appendChild(clone);
                            }

                        }else{
                            post_holder.innerHTML = "<div style='text-align:center;padding:10px; color:gray;'>No comments found</div>";
                        }
                    }
                    //document.querySelector(".js-page-number").innerHTML = "Page " + mycomment.page_number;
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },
    //ala na to
    /*view_comments: function(forum_id){

        window.location.href = "post.php?id="+forum_id;
    },*/
    
    editComment: function(forum_id) {
        // Find the post element using the forum_id
        let commentWrapper = document.querySelector(`#post_${forum_id}`);
        
        // Get the title and content elements of the post
        let commentElement = commentWrapper.querySelector('.js-comment');

        // Get the current text of the title and content elements
        let commentText = commentElement.textContent;
        
        // Create new input elements for the title and content
        let editTextarea = document.createElement('textarea');
        editTextarea.classList.add('js-comment-input');
        editTextarea.value = commentText;
        editTextarea.classList.add('form-control');
        editTextarea.style.resize = 'none';
        editTextarea.rows = 2; // Set the number of rows to 5


        // Replace the reply content with the input field
        commentElement.parentNode.replaceChild(editTextarea, commentElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('js-save-button', 'btn' , 'px-3', 'mr-3');
        saveButton.innerHTML = 'Save';

        saveButton.style.backgroundColor = '#F2C1A7';

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-button', 'btn', 'btn-outline-danger', 'm-3');
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', function() {
            // Get the edited title and content from the input fields
            let editedContent = editTextarea.value;

            // Call a function to save the edited title and content
            mycomment.saveComment(forum_id, editedContent);
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

    saveComment: function(forum_id, editedContent) {

        // Create a FormData object to send the data to the server
        let form = new FormData();
        form.append('forum_id', forum_id);
        form.append('content', editedContent);
        form.append('data_type', 'my_edit_comment');
        
        // Create a new XMLHttpRequest object
        var ajax = new XMLHttpRequest();

        // Add an event listener to handle the server response
        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //ganto daw iconvert si JSON back to javascript
                    console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message); //nasa ajax.php yung .message

                    if(obj.success){
                        // Find the post element using the forum_id
                        let postElement = document.querySelector(`#post_${forum_id}`);
                        console.log(postElement);

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

                        let forum_id_int = parseInt(mycomment.post_id);
                        let forum_id_string = forum_id_int.toString();
                        allposts.updatePostData(forum_id_string, null);
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
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
                    
                    //console.log(data.rows.length);
                    // Check if there are any replies
                    if (typeof data.rows == 'object' && data.rows.length > 0) {
                        // Loop through replies data and create elements for each reply
                        for (let i = data.rows.length - 1; i >= 0; i--) {
                            //Outer div ROW (pic, reply, edit)
                            let replyWrapper = document.createElement('div');
                            replyWrapper.classList.add('reply-wrapper', 'row', 'pt-4');
                            replyWrapper.style.background='';

                                //Inner divs (madami ako in-add na div, para madesign)

                                //<!--COL profile pic-->
                                let col1 = document.createElement('div');
                                col1.classList.add('col-auto');

                                //<!--COL name, comment, time, like -->
                                let col2 = document.createElement('div');
                                col2.classList.add('col');
                                
                                //<!--div for name, comment-->
                                let divname_com = document.createElement('div');
                                divname_com.classList.add('p-3', 'rounded-4');
                                divname_com.style.background='#f2f2f2';

                                //<!--row for like, time-->
                                let divlike_time = document.createElement('div');
                                divlike_time.classList.add('row', 'mt-3');

                                //<!--col like, like span-->
                                let divlike_time_col1 = document.createElement('div');
                                divlike_time_col1.classList.add('col-auto');

                                //<!--col time-->
                                let divlike_time_col2 = document.createElement('div');
                                divlike_time_col2.classList.add('col-auto');

                                //<!--COL edit,del-->
                                let col3 = document.createElement('div');
                                col3.classList.add('js-action-button','col-1');
                                
                                //<!--3 dot btn-->
                                let aTagbtn = document.createElement('a');
                                aTagbtn.classList.add('btn');
                                aTagbtn.setAttribute("data-toggle", "dropdown");
                                aTagbtn.innerHTML = '<i class="fa-solid fa-ellipsis fs-4"></i>';

                                //<!--edit,del container-->
                                let col3_container = document.createElement('div');
                                col3_container.classList.add('container');

                                //<!--edit,del dropdown ( NANDITO NAKALAGAY YUNG EDIT AND DELETE BUTTON )-->
                                let btn_dropdown = document.createElement('ul');
                                btn_dropdown.classList.add('dropdown-menu');



                                let userimageElement = document.createElement('img');
                                userimageElement.src = 'assets/images/57.png'; // Default image source
                                userimageElement.classList.add('js-userimage-reply','m-2');
                                userimageElement.src = data.rows[i].user_img;

                                /*if (typeof data.rows[i].user == 'object') {
                                    userimageElement.src = data.rows[i].user.image;
                                }*/
                                
                                let usernameElement = document.createElement('div');
                                usernameElement.classList.add('js-username-reply');
                                //usernameElement.innerHTML = (data.rows[i].user_fname) ? data.rows[i].user_fname : 'User';
                                usernameElement.innerHTML = data.rows[i].user_fname;
                                usernameElement.style.color='blue';
                                usernameElement.style.display='inline';
                                
                                let dateTimeElement = document.createElement('div');
                                dateTimeElement.classList.add('js-date', 'mx-5');
                                //dateTimeElement.innerHTML = data.rows[i].date;
                                dateTimeElement.style.display='inline';
                                dateTimeElement.style.fontSize='14px';
                                dateTimeElement.style.color='gray';

                                let replyElement = document.createElement('div');
                                replyElement.classList.add('reply');
                                replyElement.style.background='';
                                replyElement.innerHTML = data.rows[i].forum_desc;

                                let likeButtonElement = document.createElement('button');
                                likeButtonElement.classList.add('js-like-button');
                                likeButtonElement.setAttribute('forum_id', data.rows[i].forum_id);
                                likeButtonElement.style.cursor = 'pointer';
                                likeButtonElement.innerHTML = '<i class="fa-solid fa-heart" style="pointer-events: none;"></i>';

                                let numlikeElement = document.createElement('span');
                                numlikeElement.classList.add('js-num-likes');
                                numlikeElement.setAttribute('forum_id', data.rows[i].forum_id);
                                
                                //counting the number of likes
                                if (data.rows[i].getlikes['count(*)'] == 0) {
                                    numlikeElement.innerHTML = "";
                                } else {
                                    numlikeElement.innerHTML = data.rows[i].getlikes['count(*)'];
                                }

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
                            
                            //<!--profile pic-->
                            col1.appendChild(userimageElement);
                            replyWrapper.appendChild(col1); //col1

                            //<!--name, comment-->
                            divname_com.appendChild(usernameElement);
                            divname_com.appendChild(replyElement);
                            col2.appendChild(divname_com); // div
                            replyWrapper.appendChild(col2); //col2

                            //<!--like, like span-->
                            divlike_time_col1.appendChild(likeButtonElement);
                            divlike_time_col1.appendChild(numlikeElement);
                            divlike_time.appendChild(divlike_time_col1); // col
                            col2.appendChild(divlike_time); //row
                            replyWrapper.appendChild(col2); //col2

                            //<!--time-->
                            divlike_time_col2.appendChild(dateTimeElement);
                            divlike_time.appendChild(divlike_time_col2); // col
                            col2.appendChild(divlike_time); //row
                            replyWrapper.appendChild(col2); //col2

                            //<!--edit, del-->
                            col3.appendChild(aTagbtn); // 3dot button
                            btn_dropdown.appendChild(actionButtonsContainer); // EDIT, DELETE button
                            col3_container.appendChild(btn_dropdown); //container div
                            col3.appendChild(col3_container); //col3
                            replyWrapper.appendChild(col3); //col3

                            let clone = replyWrapper.cloneNode(true);
                            clone.setAttribute('id','post_'+data.rows[i].forum_id);
                            let row_data = JSON.stringify(data.rows[i]);
                            row_data = row_data.replaceAll('"','\\"');

                            clone.setAttribute('row',row_data);
                            //replyWrapper.appendChild(clone);
                            
                            // Update the timestamp dynamically
                            let timestampElement = clone.querySelector('.js-date');
                            time.updateTimestamps(timestampElement, data.rows[i].date);

                            let likeButton = clone.querySelector('.js-like-button');
                            // Apply like functionality to the like button
                            like_rating.userLiked(data.rows[i].forum_id, (function(likeButton) {
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
                                like_rating.like(event.target, false);
                            });

                            // Create edit button bago to!!!!!!!!!!!!!!!!!!!!!!!!!
                            let editButton = document.createElement('div');
                            editButton.classList.add('js-edit-button', 'class_53', 'dropdown-item');
                            editButton.style.color = 'blue';
                            editButton.style.cursor = 'pointer';
                            editButton.innerHTML = 'Edit';

                            // Attach event listener to the edit button
                            editButton.addEventListener('click', mycomment.editReply);

                            // Create delete button
                            let deleteButton = document.createElement('div');
                            deleteButton.classList.add('js-delete-button', 'class_53', 'dropdown-item');
                            deleteButton.style.color = 'red';
                            deleteButton.style.cursor = 'pointer';
                            deleteButton.innerHTML = 'Delete';

                            // Attach event listener to the edit button
                            deleteButton.addEventListener('click', mycomment.deleteReply);

                            // Append action buttons to container in cloned replyWrapper
                            let clonedActionButtonsContainer = clone.querySelector('.js-action-buttons');
                            clonedActionButtonsContainer.appendChild(editButton);
                            clonedActionButtonsContainer.appendChild(deleteButton);

                            let action_buttons = clone.querySelector(".js-action-button");
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
                        noRepliesMessage.classList.add('p-4');
                        noRepliesMessage.style.textAlign='center';
                        noRepliesMessage.style.color='gray';
                    }
                    
                    if (mycomment.userId) {
                        console.log('w/ user');
                    
                        // Create form element for adding new reply
                        let replyForm = document.createElement('form');
                        replyForm.onsubmit = mycomment.reply;
                        replyForm.classList = 'js-replied';
                        replyForm.method = 'post';
                        replyForm.setAttribute('forum_id', forum_id);
                        replyForm.classList.add('p-2', 'rounded-4','my-3');
                        replyForm.style.background ='#ebebeb';
                        
                        let textArea = document.createElement('div');
                        textArea.classList.add("d-grid");
                        // Create textarea element for reply input
                        let replyInput = document.createElement('textarea');
                        replyInput.placeholder = 'Add a reply...';
                        replyInput.classList = 'js-reply-input';
                        replyInput.name = 'reply_text';
                        replyForm.appendChild(replyInput);
                        replyInput.classList.add('form-control', 'p-3');
                        replyInput.style.resize = 'none';
                        replyInput.rows = 2; 
                        replyInput.style.background ='transparent';
                        replyInput.style.border ='none';

                        textArea.appendChild(replyInput);
                        replyForm.appendChild(textArea);
                        
                        let hr1 = document.createElement('hr');
                        replyForm.appendChild(hr1);

                        // Create div element for anonymous checkbox
                        let anonymousDivRow = document.createElement('div');
                        anonymousDivRow.classList.add("row", "mx-1", "my-2");
                        
                        // Create div element for anonymous checkbox
                        let anonymousDiv = document.createElement('div');
                        anonymousDiv.classList.add("col-auto", "me-auto");

                            // Create p element for anonymous checkbox
                            let anonymousP = document.createElement('p');
                            anonymousP.setAttribute('for', 'anonymous');
                            anonymousP.textContent = 'Anonymous:';
                            anonymousP.style.color = '#5582da';
                            anonymousP.style.display = 'inline';
                            anonymousDiv.appendChild(anonymousP);

                            // Create input element for anonymous checkbox
                            let anonymousInput = document.createElement('input');
                            anonymousInput.setAttribute('type', 'checkbox');
                            anonymousInput.setAttribute('id', 'anonymous');
                            anonymousInput.setAttribute('name', 'anonymous_reply');
                            anonymousInput.classList.add('js-anonymous-reply');
                            anonymousDiv.appendChild(anonymousInput);

                            // Create p element for anonymous checkbox
                            let anonymousLabel = document.createElement('label');
                            anonymousLabel.setAttribute('for', 'anonymous');
                            anonymousLabel.textContent = 'Post anonymously:';
                            anonymousLabel.style.color = '#5582da';
                            anonymousDiv.appendChild(anonymousLabel);


                        // Append div element to form
                        anonymousDivRow.appendChild(anonymousDiv);
                        
                        // Create div element for anonymous reply btn
                        let anonymousDiv2 = document.createElement('div');
                        anonymousDiv2.classList.add("col-auto");

                            // Create button element for submitting form
                            let replyButton = document.createElement('button');
                            replyButton.innerHTML = '<i class="fa-solid fa-reply" style="pointer-events: none;"> </i>';
                            replyButton.classList.add('btn');
                            anonymousDiv2.appendChild(replyButton);
                        
                        // Append div element to form
                        anonymousDivRow.appendChild(anonymousDiv2);
                        
                        // Append form element to replies container
                        repliesContainer.appendChild(replyForm);
                        

                        // Append div element to form
                        replyForm.appendChild(anonymousDivRow);
                    } else {
                        console.log('no user');

                        // Create the outer div
                        let outerDiv = document.createElement('div');
                        outerDiv.setAttribute('class', 'class_13');

                        // Create the inner div
                        let innerDiv = document.createElement('div');
                        innerDiv.setAttribute('class', 'class_15');
                        innerDiv.classList.add('mt-4','mb-3');
                        innerDiv.setAttribute('style', 'cursor:pointer;text-align: center;');
                        innerDiv.setAttribute('onclick', 'user.login()');

                        // Create the i element
                        let iElement = document.createElement('i');
                        iElement.setAttribute('class', 'fa-solid fa-circle-exclamation');
                        innerDiv.appendChild(iElement);

                        // Add text node to inner div
                        let textNode = document.createTextNode(" You're not signed in. ");
                        innerDiv.appendChild(textNode);

                        // Create the p element
                        let pElement = document.createElement('p');
                        pElement.setAttribute('style', 'color: blue;');
                        pElement.textContent = 'Click here to sign in and reply';
                        innerDiv.appendChild(pElement);

                        // Append inner div to outer div
                        outerDiv.appendChild(innerDiv);

                        repliesContainer.appendChild(outerDiv);
                    }

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

    /*next_page: function(){ //dito iicrement si page
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
    },*/

    reply: function(e){ //dito iicrement si page
        
        e.preventDefault();
        // Get value of reply_text input field
        let replyText = e.target.elements.reply_text.value.trim();
        let anonymous = e.target.elements.anonymous_reply.checked;
        
        // Check if reply text is empty
        if (replyText == "") {
            alert("Please type something");
            return;
        }
        
        // Get forum_id from data attribute of form element
        let forumId = e.target.getAttribute('forum_id');
        
        // Create FormData object to send data to server
        let form = new FormData();
        form.append('forum_id', forumId);
        form.append('reply_text', replyText);
        form.append('anonymous', anonymous);
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
                        e.target.elements.anonymous_reply.checked = false;
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
        //alert();
        // Get the parent replyWrapper element
        let replyWrapper = e.target.closest('.reply-wrapper');
        //console.log(replyWrapper);
        // Get the existing reply content
        // Get the existing reply content from col2, divname_com
        let col2 = replyWrapper.querySelector('.col');
        let divname_com = col2.querySelector('.p-3');
        let replyElement = replyWrapper.querySelector('.reply');
        //console.log(replyElement);
        let replyText = replyElement.innerHTML;
        //console.log(replyText);
        // Create an input field for editing the reply
        let editInput = document.createElement('input');
        editInput.type = 'text';
        editInput.value = replyText;
        editInput.classList.add('form-control');
        editInput.style.resize = 'none';
        editInput.rows = 2; // Set the number of rows to 5

        // Replace the reply content with the input field
        divname_com.replaceChild(editInput, replyElement);

        // Add a Save button for submitting the edited reply
        let saveButton = document.createElement('button');
        saveButton.classList.add('btn' , 'px-3', 'mr-3');
        saveButton.innerHTML = 'Save';

        saveButton.style.backgroundColor = '#F2C1A7';

        // Attach event listener to the Save button
        saveButton.addEventListener('click', mycomment.saveReply);

        // Append the Save button to the replyWrapper element
        divname_com.appendChild(saveButton);

        // Add a Cancel button for canceling the edit
        let cancelButton = document.createElement('button');
        cancelButton.classList.add('js-cancel-edit', 'btn', 'btn-outline-danger', 'm-3');
        cancelButton.innerHTML = 'Cancel';

        // Attach event listener to the Cancel button
        cancelButton.addEventListener('click', function() {
            // Replace editInput and saveButton with original replyElement
            divname_com.replaceChild(replyElement, editInput);
            divname_com.removeChild(saveButton);
            divname_com.removeChild(cancelButton);
            // Show the edit and delete buttons
            divname_com.querySelector('.js-edit-button').classList.remove('hide');
            divname_com.querySelector('.js-delete-button').classList.remove('hide');
        });

        // Append the Cancel button to the replyWrapper element
        divname_com.appendChild(cancelButton);

        // Hide the edit and delete buttons
        replyWrapper.querySelector('.js-edit-button').classList.add('hide');
        replyWrapper.querySelector('.js-delete-button').classList.add('hide');
    },

    saveReply: function(e) {

        //e.preventDefault();
        let replyWrapper = e.target.closest('.reply-wrapper');
        console.log(replyWrapper);
        // Get the edited reply input field
        let col2 = replyWrapper.querySelector('.col');
        let divname_com = col2.querySelector('.p-3');
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

                        // Select the date element
                        let dateElement = replyWrapper.querySelector('.js-date');
                        // Update the date element with the updated date
                        time.updateTimestamps(dateElement, obj.updated_date);

                        // Replace editInput and saveButton with replyElement
                        let saveButton = replyWrapper.querySelector('button');
                        divname_com.replaceChild(replyElement, editInput);
                        divname_com.removeChild(saveButton);

                        // Show the edit and delete buttons
                        replyWrapper.querySelector('.js-edit-button').classList.remove('hide');
                        replyWrapper.querySelector('.js-delete-button').classList.remove('hide');
                        
                        // Remove the cancel button
                        let cancelButton = replyWrapper.querySelector('.js-cancel-edit');
                        divname_com.removeChild(cancelButton);
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

    singlePost: function() {
        // Get the like button and number of likes elements
        let likeButton = document.querySelector('.single-post.js-like-button');
        console.log(likeButton);
        // Get the forum_id from the like button element
        let forum_id = likeButton.getAttribute('forum_id');

        // Check if the user has already liked the post
        like_rating.userLiked(forum_id, function(userlikes) {
            if (userlikes) {
                likeButton.classList.add('btn_selected');
            } else {
                likeButton.classList.add('btn');
            }
        });

        // Add an event listener to the like button
        likeButton.addEventListener('click', function(event) {
            // Call the allposts.like function and pass a reference to the clicked button element
            like_rating.like(event.target, true);
        });
    },
};

mycomment.load_comments(); //dito lumabas yung mga forum kasi tinatawag