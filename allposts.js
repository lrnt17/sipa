// DO NOT INCLUDE ALL OF THIS!!!

var allposts = {

    page_number: (typeof page_number == 'undefined') ? 1 : page_number,
    //start: (typeof start == 'undefined') ? 5 : start,
    //limit: (typeof limit == 'undefined') ? 5 : limit,

    submit: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-post-input").value.trim();
        let title = document.getElementById("post_title").value;
        let anonymous = document.querySelector(".js-anonymous").checked;
        console.log(anonymous);
        if(text == "" && title == ""){
            alert("Please type something");
            return;
        }

        let form = new FormData(); //new form within javascript

        form.append('post', text);
        form.append('post_title', title);
        form.append('anonymous', anonymous);
        form.append('data_type', 'add_post');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    alert(obj.message);

                    if(obj.success){
                        document.querySelector(".js-post-input").value = "";
                        document.getElementById("post_title").value = "";
                        document.querySelector(".js-anonymous").checked = false;
                        allposts.load_posts();
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
    load_posts: function(){
        
        let form = new FormData();
        //console.log(allposts.start);console.log(allposts.limit);
        form.append('page_number', allposts.page_number);
        //form.append('start', allposts.start);
        //form.append('limit', allposts.limit);
        form.append('data_type', 'load_posts');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        let post_holder = document.querySelector(".js-posts");
                        
                        post_holder.innerHTML = "";
                        let template = document.querySelector(".js-post-card");

                        //console.log(obj.rows);
                        if (typeof obj.rows == 'object') {
                        
                            for (var i = 0; i < obj.rows.length; i++) {
                                
                                template.querySelector(".js-title").innerHTML = obj.rows[i].forum_title;//si .forum_title ito naman sa db
                                template.querySelector(".js-post").innerHTML = obj.rows[i].forum_desc; //ito naman sa db
                                template.querySelector(".js-date").innerHTML = obj.rows[i].date;// si .date based  sa nasa ajax
                                template.querySelector(".js-comment-link").setAttribute('onclick',`allposts.view_comments(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-like-button").setAttribute('forum_id', obj.rows[i].forum_id);
                                template.querySelector(".js-num-likes").setAttribute('forum_id', obj.rows[i].forum_id);
                                
                                //para mag iba iba kulay nung like button
                                //red kapaga nilike na, blue kpaag hindi pa
                                allposts.userLiked(obj.rows[i].forum_id, function(userlikes) {
                                    //console.log(userlikes);
                                    let likeButton = clone.querySelector(".js-like-button");
                                    //console.log(likeButton);
                                    if (userlikes) {
                                        likeButton.classList.add('btn_selected');
                                    } else {
                                        likeButton.classList.add('btn');
                                    }
                                });

                                //template.querySelector(".js-like-button").setAttribute('onclick',`allposts.like(${obj.rows[i].forum_id})`);
                                //counting the number of likes
                                if (obj.rows[i].getlikes['count(*)'] == 0) {
                                    template.querySelector(".js-num-likes").innerHTML = "";
                                } else {
                                    template.querySelector(".js-num-likes").innerHTML = obj.rows[i].getlikes['count(*)'];
                                }
                                
                                //counting the number of comments
                                if(obj.rows[i].comment_count > 0){
									template.querySelector(".js-comment-link").innerHTML = `Comments (${obj.rows[i].comment_count})`;
								}else{
									template.querySelector(".js-comment-link").innerHTML = `Comments`;
								} 
                                //console.log(obj.rows[i].comment_count);
                                template.querySelector(".js-delete-button").setAttribute('onclick',`allposts.delete(${obj.rows[i].forum_id})`);
                                template.querySelector(".js-edit-button").setAttribute('onclick',`my_edit_post.show_me(${obj.rows[i].forum_id})`);
                                //template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.user_fname : 'User';
                                template.querySelector(".js-username").innerHTML = (obj.rows[i].user_fname) ? obj.rows[i].user_fname : 'User';
                                template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.user_id : '#';

                                if(typeof obj.rows[i].user == 'object')
                                    template.querySelector(".js-image").src = obj.rows[i].user.image;

                                let clone = template.cloneNode(true);

                                //for pressing like button
                                clone.querySelector('.js-like-button').addEventListener('click', function(event) {
                                    // Call the allposts.like function and pass a reference to the clicked button element
                                    allposts.like(event.target);
                                });

                                clone.setAttribute('id','post_'+obj.rows[i].forum_id);
                                
                                let row_data = JSON.stringify(obj.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');
                                clone.setAttribute('row',row_data);

                                let action_buttons = clone.querySelector(".js-modification-buttons");
								if(!obj.rows[i].user_owns)
									action_buttons.remove();

                                clone.classList.remove('hide');
                                
                                post_holder.appendChild(clone);
                            }
                            //allposts.start += allposts.limit;
                        }else{
                            post_holder.innerHTML = "Nothing follows";
                            //document.querySelector(".js-view-more").classList.add('hide');
                        }
                        
                    }
                    document.querySelector(".js-page-number").innerHTML = "Page " + allposts.page_number;
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    view_comments: function(id){
			
        window.location.href = "post.php?id="+id;
    },
    
    view_more: function(){
        
        //e.preventDefault();
        allposts.load_posts();
    },

    next_page: function(){ //dito iicrement si page
        allposts.page_number = allposts.page_number + 1;
        //allposts.load_posts();
        window.location.href = 'community_forum_1.php?page=' + allposts.page_number;
    },

    prev_page: function(){
        allposts.page_number = allposts.page_number - 1;

        //pag bumaba less than 1, page 1 pa rin lalabas
        if (allposts.page_number < 1) {
            allposts.page_number = 1;
        }
        window.location.href = 'community_forum_1.php?page=' + allposts.page_number;
        //allposts.load_posts();
    },

    delete: function(forum_id) {
        if (!confirm("Are you sure you want to delete this post?")) {
            //alert(forum_id);
            return;
        }
        
        let form = new FormData(); //new form within javascript
        let comment_part = false;

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
                        //allposts.load_posts();
                        window.location.reload();
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    new_topic: function(){
        
        // Get reference to the form element
        //document.querySelector('.js-start-topic').classList.remove('hide');
        var form = document.querySelector('.js-start-topic');
        //var button = document.querySelector('button');
        if (form.classList.contains('hide')) {
            form.classList.remove('hide');
        } else {
            form.classList.add('hide');
            
        }
    },

    userLiked: function(forum_id, callback) {
        
        //alert(forum_id);
        let form = new FormData();

        form.append('forum_id', forum_id);
        form.append('data_type', 'user_liked');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    if(obj.success){
                        //return true;
                        callback(true);
                    }else{
                        //return false;
                        callback(false);
                    }
                }else{
                    alert("Please check your internet connection");
                }
            }
        });

        ajax.open('post','ajax.php', true);
        ajax.send(form);
    },

    like: function(likeButton){

        let forum_id = likeButton.getAttribute('forum_id');
        
        if (likeButton.classList.contains('btn')) {
            action = 'like';
            //console.log(action);
        } else if (likeButton.classList.contains('btn_selected')) {
            action = 'unlike';
        } else {
            console.log('The button does not have either class');
        }

        let form = new FormData(); //new form within javascript

        form.append('action', action);
        form.append('forum_id', forum_id);
        form.append('data_type', 'add_like');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    console.log(obj.row.likes['count(*)']);

                    if(obj.success){
                        
                        if (action == 'like') {
                            likeButton.classList.remove('btn');
                            likeButton.classList.add('btn_selected');
                        }else{
                            likeButton.classList.remove('btn_selected');
                            likeButton.classList.add('btn');
                        }

                        //dito nangyayari yung pag add ng number matically
                        let likesCount = obj.row.likes['count(*)'];
                        let likesElement = document.querySelector(`.js-num-likes[forum_id="${forum_id}"]`);
                        if (likesCount == 0) {
                            likesElement.innerHTML = '';
                        } else {
                            likesElement.innerHTML = likesCount;
                        }
                        //document.querySelector(`.js-num-likes[forum_id="${forum_id}"]`).innerHTML = obj.row.likes['count(*)'];
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


if(typeof all_topics_page != 'undefined'){
    allposts.load_posts();
}

 //dito lumabas yung mga forum kasi tinatawag