define(function(require) {
var elgg = require("elgg");
var $ = require("jquery");
var notificationsOffset = 0;
//general chat array
var generalChatArray = [];
//open chats
var openChats =[];
//we register an onclick event on the find friends a tag
//we get the usersview via ajax
$(document).on('click','#find-friends',function(){
 alert('hello this is js ');
	//we get our view via ajax 
	elgg.get('ajax/view/meetpeople/meetfriends',{
		data :  {
			guid : elgg.get_logged_in_user_guid(),
			type :'friends'
		},
		success : function(data){
			alert(data);	
           $('#find-friends-content').html(data);
		}
	});

});
//we register an action to send a friend request 
$(document).on('click','.add-friend',function(e){
  //we get the guid of the user to sned friend requst to
  element = e.currentTarget;
  ugid = e.currentTarget.id;
  cgid = elgg.get_logged_in_user_guid();
  //we send and ajx post request 
  elgg.action('friendRequest',{
   data :{
   		ugid :ugid,
   		cgid:cgid 
   },
   success : function(wrapper){
   	 if(wrapper.output == 'alreadyFriends' )
   	 	{
   	 		element.innerHTML = alreadyFriends;
   	 	 }else if(wrapper.output == 'requestSent'){
   	 	 		element.innerHTML = 'Request Sent';
   	 	 		element.style.background = 'green';
   	 	 }

   }

  });
});
//register and onclick event zwhen the notifications icon is clicked 
$(document).on('click','#notifications-icon',function(e){
      //we request our notifications and put in the modal
      elgg.get('ajax/view/meetpeople/getNotifications',{
      	data:{
      		offset : notificationsOffset
      	},
      	success: function(data){
      		//we insert data into our modal
      		$('#notification-content').html(data);

      	}
      });
});
//getting the chats between a users and a friend
$(document).on('click','.friend-chat',function(e){
	//we get the guid of the user
	var gid = e.currentTarget.dataset.gid;
	var count=0;
	var index =0;
	var chat_html = '<div style="width:50%;">';
	//we check our general chat array if the following guid is there
	for(var friend_chat =0;friend_chat<generalChatArray.length;friend_chat++ ){
	  console.log(generalChatArray);
		if(generalChatArray[friend_chat]['friend_gid'] == gid){
			++count;
			index = friend_chat;
			break;

		}

	}
	if(count){
		var openChatsStatus = false;
		//we check if the open chat array is empty
		if(openChats.length){
            
			//we loop through our openChats
			for(var i =0 ; i < openChats.length ; i++){
                 if( gid == openChats[i])
                 	openChatsStatus = true;
			}
			if(!openChatsStatus)
				openChats.push({ gid : gid});

		}else{
			openChats.push({ gid : gid});
		}
		//we get 15% of our array
		chat_html+='<div class="chat-heading">'+generalChatArray[index].username+'</div><div class="chat-body"><ul><ul id="chat'+ generalChatArray[index].friend_gid+'" style="width:100%;overflow:scroll;height:100%">';
		var array_length = generalChatArray[index]['chat'].length;
		var upperbound = array_length;
		  if(array_length > 6){
		  	var upperbound = Math.ceil(0.15*array_length);
		  }
		
		//we got our guid
		for(var chats=0;chats < upperbound;chats++){
			//we construct our chat box
     		chat_html+='<li><p>'+generalChatArray[index]['chat'][chats]['description']+'</p><div style="text-align:right;"><span>'+generalChatArray[index].chat[chats]['date_created']+'</span></div></li>';        
				if(chats === upperbound-1){
					chat_html+='</ul><li class="chat-msg"><textarea class="chat-send" data-gid="'+generalChatArray[generalChatArray.length-1]['chat'][chats]['friend_id']+'" data-indexe="'+(generalChatArray.length-1)+'"></textarea></li>';
				}	
		}
		//we insert our chat box in to html page
		$('#chat-div').append(chat_html+'</ul></div></div>');
	}else{
		//we get our elements from via ajax 
		elgg.action('getChat',{
			data : {
				ugid :gid
			},
			success : function(wrapper){
				openChats.push({ gid : wrapper.output.friend_gid});
				//we get the length of our chat array
					var array_length = wrapper.output['chat'].length;
					console.log(wrapper.output);
				//we check if there was no chat 
				if(wrapper.output.status ==='noChats'){
					generalChatArray.push(wrapper.output);
					console.log(wrapper.output.friend_gid);
					console.log(generalChatArray.length);
					chat_html+= '<div class="chat-heading">'+wrapper.output.username+'</div><div class="chat-body"><ul><ul style="height:100%;width:100%;overflow:auto;backgroud-color :gray;" id="chat' + wrapper.output.friend_gid+ '" ></ul><li class="chat-msg"><textarea style="width:300px;height :50px;" class="chat-send" data-gid="'+wrapper.output.friend_gid+'" data-indexe="'+(generalChatArray.length-1)+'" ></textarea></li>';
					console.log(chat_html);
				}
				else{
					generalChatArray.push(wrapper.output);
					var upperbound = array_length;
					  if(array_length > 6){
					  	var upperbound = Math.ceil(0.15*array_length);
					  }
					console.log(wrapper.output);
					chat_html+='<div class="chat-heading">'+generalChatArray[generalChatArray.length-1].username+'</div><div class="chat-body"><ul><ul id="chat'+generalChatArray[generalChatArray.length-1].friend_gid+'" >';
					

					//we got our guid
				for(var chats=0;chats < upperbound;chats++){
			//we construct our chat box
	     			chat_html+='<li><p>'+generalChatArray[index]['chat'][chats]['description']+'</p><div style="text-align:right;"><span>'+generalChatArray[generalChatArray.length-1]['chat'][chats]['date_created']+'</span></div></li>';        
					if(chats === upperbound-1){
						chat_html+='</ul><li class="chat-msg"><textarea class="chat-send" data-gid="'+generalChatArray[generalChatArray.length-1]['chat'][chats]['friend_id']+'" data-indexe="'+(generalChatArray.length-1)+'"></textarea></li>';
					}	
		}
				}
				$('#chat-div').append(chat_html+'</ul></div></div>');
			}
		});
	}
});
//listening a send chat request
$(document).on('keypress','.chat-send',function(event){

  var keycode = event.keyCode ? event.keyCode : event.which;
  if(keycode == 13){
  	
  var element = event.currentTarget;
	//we get the message from the text area 
var text = element.value;
//we get list element
var li = element.parentNode;
//send chat status
var chat_status = '';
//friends guid
var fid = element.dataset.gid;
//we add our text to before the li containing the textarea


//we create a promise

//we send chat 
sendChat(text,fid).then(function(){
	//we use a promise

//we update the general chat array
//we get the index of the current friends chat
var index = parseInt(element.dataset.indexe);
//we first set the chat status
generalChatArray[index]['status'] = 'chat';



generalChatArray[index]['chat'].unshift({'date_created' : new Date(),'description' : text});

console.log(generalChatArray);

li.previousSibling.innerHTML += '<li><p>'+text+'</p><div><span></span></div></li>';

element.value ='';

},function(){
	console.log('and error occured');
});
 


  }
//end of if
event.stopPropagation();

});
//confirming friend request elgg_register_action("friendRequest", elgg_get_plugins_path().'meetpeople/actions/friendRequest.php');
$(document).on('click','.friend-confirm',function(e){
  //we get the guid of the user to sned friend requst to
  element = e.currentTarget;
  ugid = e.currentTarget.id;
  cgid = elgg.get_logged_in_user_guid();
  //we send and ajx post request 
  elgg.action('confirmFriendRequest',{
   data :{
   		ugid :ugid,
   		cgid:cgid 
   },
   success : function(wrapper){
   	 if(wrapper.output == 'tryAgain' )
   	 	{
   	 		element.innerHTML = 'Try again';
   	 	 }else if(wrapper.output == 'nowFriends'){
   	 	 		element.innerHTML = 'now friends';
   	 	 		element.style.background = 'green';
   	 	 }

   }

  });
});
//functions to carry out every 10000ms
setInterval(function(){
  if(elgg.is_logged_in()){
	//we check the number of notifications 
	elgg.action('getNotifications',{
		data:{
			wtf:'guess'

		},
		success:function(wrapper){
			if(parseInt(wrapper.output) == 0){
               $('#notification-count').html('');
			}else{
				 $('#notification-count').html(parseInt(wrapper.output));
			}

		}
	});
	 elgg.get('ajax/view/meetpeople/friendsonline',{
      	data:{
      		wtf : 'wtf'
      	},
      	success: function(data){
      		//we insert data into our modal
      		$('#friends-online').html(data);

      	}
      });
	}

},10000);
setInterval(function(){
    //we check ii user is logged in
    if(elgg.is_logged_in()){
    //we test if our open chat array is empty
    if(openChats.length){
    	 //update chat 
    updateChat(openChats,generalChatArray).then(function(output){
    	//we get the required text chat from the different active chats 
    	var userChat  = output;

    	for( var i=0 ; i < userChat.length ; i++ ){
    		var html ='';
    		 console.log(userChat[i]['friend_gid']);
            //we get the id of the ul element containing the chats 
             var ul  = $('#chat' + userChat[i]['friend_gid']);
            
             //we loop through every chat and we update 
             for( var chat =0; chat<=userChat[i]['chat'].length-1;chat++){
             		//we construct our html element
             		html +='<li><p>'+userChat[i]['chat'][chat]['description']+'</p><div style="text-align:right;"><span>'+ userChat[i]['chat'][chat]['date_created']+'</span></div></li>';        ; 
        			
             }
             console.log(html);
             //insert the chats into the html element
    	ul.html(html);

    	}

    	
    },function(output){

    	console.log('error');
    });

    }else{
    	//do nothing
    }
}
   
},2000);




});
//functions sendChat
// @param text the content
// @param fid friend guid
//@return string success | error 
function sendChat(text,fid){
  return new Promise(function(success,failure){
     //we verify if the text is not empty
  if(text == '' || typeof(text)=='undefined' ){
  	console.log('chat text empty');
  	failure();

  }
  if(fid =='' || typeof(fid) =='undefined'){
  	console.log('gid empty or undefined');
  	failure();

  }
  //if everything is chack(fine)
  //we send an ajax send request

  elgg.action('sendChat',{
  	data :{
  		fid : fid,
  		chat_msg : text
  	},
  	success : function(wrapper){
  		console.log('send ',wrapper.output);
  		//console.log(wrapper.output);
            //we check if an error occured
            if(wrapper.output == 'success'){
            	success();
            }else if(wrapper.output == 'error'){
            	failure();
            }
  	}
  })



  });
  
 
}
//function update chat 
//@param array the array containing all the active users chat window
//@return void
function updateChat(array,generalChatArray){
    return new Promise(function(success,failure){
            array = JSON.stringify(array);
            elgg.action('updateChat',{
            	data : { activeChats : array
            	},
            	success : function(wrapper){

            			success(wrapper.output);
            	},
            	error : function(wrapper){
            		failure(wrapper.error);
            	}
            });
    });

}