<?php  
/* 
Plugin Name: AnyTimeReply
Plugin URI: http://anytimereply.com/wordpress
Version: 2.1 
Description: AnyTimeReply is free sales chatbot platform. It helps you to reply query from your website visitors and collect leads in interactive way. You can also setup Facebook messanger chatbot with in few minutes.   

Author: Spiker Solutions
Author URI: http://spikersolutions.com/ 
*/  
define( 'WP_DEBUG', false );

add_shortcode( 'anytimereply_button', 'atr_callinti' );
add_action( 'admin_menu', 'anytimereply_settings_menu' );

add_action( 'admin_init', 'atr_mysettings' ); 

atr_callinti();

function atr_callinti()
	{
			wp_enqueue_script( 'jquery');
			
			wp_register_script( 'chatscript', plugin_dir_url( __FILE__ ) . 'js/chat.js',array('jquery'));
			wp_enqueue_script('chatscript');
			wp_register_script( 'jquerypopupscript', plugin_dir_url( __FILE__ ) . 'js/jquery.popup.js',array('jquery'));
			wp_enqueue_script('jquerypopupscript');
			wp_register_style( 'chatstyle', plugin_dir_url( __FILE__ ) .'css/chatbox.css');
			wp_enqueue_style('chatstyle');
			 
			$channelID = get_option( 'atr_txttitle' );

	echo '
			
			
					<div class="popup js__popup js__slide_top" style="text-align:center;"> 
		<a href="#" class="p_close js__p_close" title="Close"> <span></span><span></span> </a>
		<div id="atrintro233">
		<a href="http://anytimereply.com" target="_blank"><img src="' . plugin_dir_url( __FILE__ ) . 'images/logo.png" id="mariaicon886" width="200"  /></a>
		</div>';
		
					
						echo '<div class="userleads">
		<br />
		<div class="leadsinfo">There is <b>NO</b> queue. You can start chat immediate. Give us your details: </div><br />
		<form name="userleads">
		<input type="text" name="uname" placeholder="Your Name.. " required="required" class="datas" title="Type your Name here" /><br /><br />
		<input type="email" name="email" placeholder="Your Email.." class="datas" title="Type your Email here" /> <br /><br />
		<input type="button" value="Start Chat" id="startchat" onclick="startChat(' .$channelID  . ');" />
		</form>
		</div>';
					
						echo '<div class="chatboxcontent">
		
		<div class="chatboxmessage">
		<span class="chatboxmessagefrom">AnyTimeReply:  </span>
		<span class="chatboxmessagecontent">Hello, how can I help you today?</span>
		</div>
		</div>
		
		<div class="chatboxinput">
		<textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,' . $channelID . ');" placeholder="Type your message here.."></textarea>
		<div id="thinking"></div>
		</div>
		
		</div>';


		
			echo '<div class="supportbtn12344" onClick="initChat();" >
<span class="js__p_start"   ><img src="' . plugin_dir_url( __FILE__ ) . '/images/bluedot.png" height="22" id="supportsmalldot"  />&nbsp;Support</span>
</div>';

		}
	

	function atr_mysettings() {
				register_setting( 'atr_option_group', 'atr_type' );
				register_setting( 'atr_option_group', 'atr_txttitle' );
							
 	} 
	function anytimereply_settings_menu() {
		add_options_page(
			'AnyTimeReply Settings',
			'AnyTimeReply Settings',
			'manage_options',
			'anytime-reply-plugin',
			'atr_managesettings'
		);
	}
	function atr_managesettings() { 
	
				if ( !current_user_can( 'manage_options' ) )  {
						wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
					}
					$id = $_GET['id'];
					if($id){
						if(get_option( 'atr_txttitle' )!== false){
							update_option('atr_txttitle',$id);
							echo '<div class="updated notice"><p>Channel ID updated. Your service activated.</p></div>';
						}
						else
						{
							add_option('atr_txttitle',$id);
							echo '<div class="updated notice"><p>Channel ID Added. Your service activated.</p></div>';
						}
					}
					echo '<div class="wrap">';
					echo '<h1> Settings</h1><br /><h2><a href="http://anytimereply.com" target="_blank">AnyTimeReply.com</a></h2><br /><form action ="options.php" method="post">';
					settings_fields( 'atr_option_group' );
					
					echo '<strong>AnyTimeReply\'s Channel ID</strong>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<input type="text" name="atr_txttitle" value="' . 
					get_option( 'atr_txttitle' ) .  '"  />
					<br /> 
					 ';
					 if(!get_option( 'atr_txttitle' )){
						 echo '<a href="#" target="_blank"> <h3>If you do not have, Get now. Its free!</h3></a>';
						 
					 }
					
					 
					submit_button(); 
					echo '</form>';
					 if(!get_option( 'atr_txttitle' )){
					echo '
                    <div class="atrnewregistration">
                        <form action="http://anytimereply.com/savedatafromplugin.php" method="post">
                        Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" name="email" width="50" class="atrnewregistrationfield" required="required" /><br />
                        Password:&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password" width="50" class="atrnewregistrationfield" required="required" /><br />
                        Channel Name: <input type="text" name="channelname" width="50" class="atrnewregistrationfield" required="required" /><br />
                        <input type="submit" value="Get Channel ID" />
                        
                        </form>
                        <br />
                        </div>';
					 }
						?>
                        
                        <?PHP
					echo '</div><div id="atrnotification">AnyTimeReply is free service from AnyTimeReply.com. After getting channel ID you can access your collected leads, unsolved queries, add new FAQs. <a href="http://anytimereply.com/main/login/" target="_blank">Click here to access your panel</a>. You can use same email and password to login it. 
					<br />YOU MUST NEED TO SETUP FAQs AND DATAS BEFORE MAKE IT PUBLIC. YOU CAN SEND SUPPORT MESSAGE VIA http://anytimereply.com SUPPORT CHAT IF NEEDED.
					</div>';
					
					
					 if(get_option( 'atr_txttitle' )){
						 
						?>
                        
                        <?PHP
					 }
					
					echo '<br /><b>If you need any help or want to customize it contact us at support@spikersolutions.com</b>';
			
		 } 
		 

	
	
?>