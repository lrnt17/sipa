
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
                                //template.querySelector(".js-comment-link").setAttribute('onclick',`mycomment.view_comments(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';

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
            alert(forum_id);
            return;
        }
        
        let form = new FormData(); //new form within javascript
        let comment_part = true;

        form.append('id', forum_id);
        form.append('comment_part', comment_part);
        form.append('data_type', 'delete_post');
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


};

mycomment.load_comments(); //dito lumabas yung mga forum kasi tinatawag