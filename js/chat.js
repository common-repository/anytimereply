var chId=0;
var username="You";

var windowFocus = true;
var chatHeartbeatCount = 0;
var maxChatHeartbeat = 10000;
var minChatHeartbeat = 3000;
var chatHeartbeatTime = minChatHeartbeat;
var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var emails='';
var chatHeartbeatCount = 0;
var maxChatHeartbeat = 10000;
var minChatHeartbeat = 3000;
var chatHeartbeatTime = minChatHeartbeat;
setTimeout('chatStatus();',chatHeartbeatTime);
$j=jQuery.noConflict();

function initChat(){
	
	
$j(".js__p_start").simplePopup();	
}
function startChat(chId){
	username = document.userleads.uname.value;
	emails = document.userleads.email.value;
	$j.post("http://anytimereply.com/chat.php?action=sendleads&id=" + chId + "&username=" + username + "&emails=" +emails, {} , function(data){

	$j('.userleads').css('display','none');
	
	$j('.chatboxcontent').css('display','block');
	$j('.chatboxinput').css('display','block');
	});
}
function checkChatBoxInputKey(event,chatboxtextarea,chId) {
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		
		message = $j(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$j(chatboxtextarea).val('');
		$j(chatboxtextarea).focus();
		$j(chatboxtextarea).css('height','44px');
		if (message != '') {
			$j.post("http://anytimereply.com/chat.php?action=sendchat&id=" + chId + "&name=" + emails, {to: "AnyTimeReply", message: message} , function(data){
				message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
				$j(".chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+username+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
				
				document.getElementById("thinking").innerHTML="Replying..";
				
				$j(".chatboxcontent").scrollTop($j(".chatboxcontent")[0].scrollHeight);
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$j(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$j(chatboxtextarea).css('overflow','auto');
	}
	 
}


function chatStatus(){

	var itemsfound = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = x+' replied...';
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				$j('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
				
			}
		}
	}
	
	$j.ajax({
	  url: "http://anytimereply.com/chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {

		$j.each(data.items, function(i,item){
			if (item)	{ 

				chatboxtitle = item.f;

				
				
				if (item.s == 1) {
					item.f = username;
				}

				if (item.s == 2) {
					$j(".chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					newMessages[chatboxtitle] = true;
					newMessagesWin[chatboxtitle] = true;
					$j(".chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.f+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
					$j("#thinking").empty();
				}

				$j(".chatboxcontent").scrollTop($j(".chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		
		setTimeout('chatStatus();',chatHeartbeatTime);
	}});
}