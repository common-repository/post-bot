<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}	
/*aspc_clear_session();*/
if ( ! function_exists( 'aspc_get_msgs' ) ) {
	/*Ajax call for chatbox*/
	add_action( 'wp_ajax_aspc_get_msgs', 'aspc_get_msgs' );
	function aspc_get_msgs(){
		$msg = aspc_steps(0);
		$input= aspc_step_input_box(1);
		if (!empty(aspc_gSes('add_post_msg'))) {
			$msg = aspc_gSes('add_post_msg');
			$input = aspc_gSes('add_post_input');
			$step = aspc_gSes('add_post_step');
		}
		echo json_encode(array('msg'=>$msg,'input'=>$input));
		exit();
	}
}
if ( ! function_exists( 'aspc_auto_chat_response' ) ) {
	/*Front End Add Post Ajax Call*/
	add_action( 'wp_ajax_aspc_auto_chat_response', 'aspc_auto_chat_response' );
	function aspc_auto_chat_response(){
		$data = array();
		$data['conf'] = (isset($_POST['conf']) && $_POST['conf'] != '' ? intval($_POST['conf']) : '');
		$data['step'] = (isset($_POST['step']) && $_POST['step'] != '' ? intval($_POST['step']) : '');
		$data['value'] = (isset($_POST['value']) && $_POST['value'] != '' ? sanitize_text_field($_POST['value']) : '');
		$data['msg'] = ($_POST['msg'] != '' ? wp_kses_post(stripslashes($_POST['msg'])) : '');
		$sesStep = aspc_gSes('add_post_step','');
		if (isset($data['conf']) && $data['conf'] == 3) {
			aspc_clear_session();
			aspc_sSes('add_post_msg','');
			aspc_sSes('add_post_step',0);
			aspc_sSes('add_post_input','',aspc_step_input_box(1,1));
			$msg = wp_kses_post(stripslashes(aspc_steps(1,0)));
			aspc_sSes('add_post_msg','',$msg);
			echo json_encode( array('step'=>1,'msg'=>$msg, 'input'=>aspc_step_input_box(1,1)));
			exit();
		}
		if (isset($data['conf']) && $data['conf'] == 2) {
			$step = (int)$data['step'];
			$msg = wp_kses_post(stripslashes(aspc_steps(6)));
			aspc_clear_session();
			aspc_sSes('add_post_msg','');
			echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>''));
			exit();
		}
		if ($data['step'] == 0) {
				aspc_sSes('add_post_step','',0);
				aspc_sSes('add_post_array','post_title',$data['value']);
				aspc_sSes('add_post_input','',aspc_step_input_box(1,1));
				$step = 1;
				$msg = aspc_steps(1,2);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(1,1)));
			exit();
		}
		if ($data['step'] == 1) {
			if ($data['conf'] == 0 && $data['conf'] != '') {
				aspc_sSes('add_post_step','',1);
				aspc_sSes('add_post_input','',aspc_step_input_box(1,1));
				$step = (int)$data['step'];
				$msg = aspc_steps(1,0);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(1,1)));
				exit();
			}if ($data['conf'] == 1) {
				aspc_sSes('add_post_step','',1);
				aspc_sSes('add_post_input','',aspc_step_input_box(2,1));
				$step = ((int)$data['step'] + 1);
				$msg = aspc_steps(1,1);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(2,1)));
				exit();
			}else {
				aspc_sSes('add_post_step','',1);
				aspc_sSes('add_post_input','',aspc_step_input_box(1,1));
				$step = ((int)$data['step']);
				$msg = aspc_steps(1,2);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(1,1)));
				exit();
			}
		}
		if ($data['step'] == 2) {
			if ($data['step'] == 2 && (isset($data['conf']) && $data['conf'] == 1)) {
				aspc_sSes('add_post_step','',2);
				aspc_sSes('add_post_input','',aspc_step_input_box(2,2));
				$step = ((int)$data['step']+1);
				$msg = aspc_steps(2,1);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				$ID = aspc_bot_add_new_post();
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(2,2)));	
				exit();
			}elseif (isset($data['conf']) && $data['conf'] == 0 && $data['conf'] != '') {
				aspc_sSes('add_post_step','',2);
				aspc_sSes('add_post_input','',aspc_step_input_box(2,1));
				$msg = aspc_steps(2,0);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				$ID = aspc_bot_add_new_post();
				echo json_encode( array('step'=>2,'msg'=>$msg, 'input'=>aspc_step_input_box(2,1)));	
				exit();
			}else {
				aspc_sSes('add_post_step','',2);
				aspc_sSes('add_post_input','',aspc_step_input_box(2));
				aspc_sSes('add_post_array','post_content',sanitize_textarea_field($data['value']));
				$step = 3;
				$msg = aspc_steps(2,2);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(2)));
				exit();
			}
		}
		if ($data['step'] == 3) {
			if ($data['conf'] == 0) {
				$msg = aspc_steps(7);
				aspc_clear_session();
				aspc_sSes('add_post_msg','');
				echo json_encode( array('step'=>3,'msg'=>$msg, 'input'=>''));
				exit();
			}
			if ($data['step'] == 3 && $data['conf'] == 1) {
				aspc_sSes('add_post_step','',3);
				aspc_sSes('add_post_input','',aspc_step_input_box(3));
				$step = 4;
				$msg = aspc_steps(3,1);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				echo json_encode( array('step'=>$step,'msg'=>$msg, 'input'=>aspc_step_input_box(3)));
				exit();
			}
		}
		if ($data['step'] == 4) {
				aspc_sSes('add_post_step','',4);
				aspc_sSes('add_post_input','','');
				$step = 5;
				$msg = aspc_steps(5,0);
				$msg = wp_kses_post(stripslashes($data['msg'].$msg));
				aspc_sSes('add_post_msg','',$msg);
				$attech_id = aspc_bot_upload_image();
				aspc_sSes('add_post_step','',5);
				echo json_encode( array('attech_id'=>$attech_id,'step'=>$step,'msg'=>$msg, 'input'=>''));
				exit();
		}
	}
}

if ( ! function_exists( 'aspc_bot_add_new_post' ) ) {
	/*Add Post Call*/
	function aspc_bot_add_new_post(){
		$author = wp_get_current_user();
		$my_post = array(
		  'post_title'    => aspc_gSes('add_post_array','post_title'),
		  'post_content'  => aspc_gSes('add_post_array','post_content'),
		  'post_status'   =>'publish',
		  'post_author'   => $author->ID
		);
		$ID = wp_insert_post( $my_post , true);
		aspc_sSes('add_post_array','add_post_ID',$ID);
		return $ID;
	}
}
if ( ! function_exists( 'aspc_step_input_box' ) ) {
	/*Get Input based on steps*/
	function aspc_step_input_box($step,$num=0){
		if ($step == 1 || $step == '') {
			return '<input type="text" class="add_title" name="title" data-step="'.$num.'" placeholder="Enter Post Title">';
		}elseif ($step == 2 && $num !=2) {
			return '<textarea name="post_content" data-step="2" class="add_inputs" placeholder="Add Post Content"></textarea>';
		}elseif ($step == 2 && $num==2) {
			return '<textarea name="post_content" data-step="3" class="add_inputs" placeholder="Add Post Content"></textarea>';
		}elseif ($step == 3) {
			return '<input type="file" id="Botfile" name="file">';
		} else {
			return '';
		}
	}
}
if ( ! function_exists( 'aspc_steps' ) ) {
	/*Auto Post Steps*/
	function aspc_steps($step,$conf=2,$iconf=2){
		if ($step != '' || $step == 0) {
			if ($step == 0) {
				if (empty(aspc_gSes('welcome'))) {
					$msg = '<p class="pl-left smsg"><span>Hello '.aspc_get_user_name().', Welcome to our bot based WordPress Post system.</span></p>';
					$msg.= '<p class="pl-left"><span>Please provide your post title.</span></p>';
				}else {
					$msg.= '<p class="pl-left"><span>Please provide your post title.</span></p>';
				}
			}elseif ($step == 1 && $conf == 2) {
				$msg = '<p class="pl-left rsure"><span>Are you sure you want to use this title?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="1">YES</span><span data-key="0">NO</span></p>';
			}elseif ($step == 1 && $conf == 1) {
				$msg = '<p class="pl-left smsg"><span>Great! You\'re post title is set successfully. </span></p>';
				$msg .= '<p class="pl-left"><span>Please provide post description.</span></p>';
			}elseif ($step == 1 && $conf == 0) {
				$msg = '<p class="pl-left"><span>Please provide your post title.</span></p>';
			}elseif ($step == 2 && $conf == 2) {
				$msg = '<p class="pl-left rsure"><span>Are you sure you want use this description?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="1">YES</span><span data-key="0">NO</span></p>';
			}elseif ($step == 2 && $conf == 1) {
				$msg = '<p class="pl-left smsg"><span>Great! You\'re post description is set successfully.  </span></p>';
				$msg .= '<p class="pl-left smsg"><span>Fantastic! You\'re post is created successfully and published.</span></p>';
				$msg .= '<p class="pl-left rsure"><span>Do you want to upload post picture?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="1">YES</span><span data-key="0">NO</span></p>';
			}elseif ($step == 2 && $conf == 0) {
				$msg = '<p class="pl-left"><span>Please provide post description.</span></p>';
			}elseif ($step == 3 && $conf == '') {
				$msg = '<p class="pl-left rsure"><span>Do you want to upload post picture?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="1">YES</span><span data-key="0">NO</span></p>';
			}elseif ($step == 3 && $conf == 1) {
				$msg = '<p class="pl-left"><span>Please upload you\'re post picture.</span></p>';
			}elseif ($step == 4 && $conf == 0) {
				$msg = '<p class="pl-left"><span>Please upload you\'re post picture.</span></p>';
			}elseif ($step == 5) {
				$msg = '<p class="pl-left smsg"><span>Great! You\'re post picture is uploaded successfully.</span></p>';
				$msg .= '<p class="pl-left rsure"><span>Do you want to create more Post?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="3">YES</span><span data-key="2">NO</span></p>';
			}elseif ($step == 3 && $conf == 1 && $iconf == 0) {
				$msg = '<p class="pl-left"><span>Please upload you\'re post picture.</span></p>';
			}elseif ($step == 6) {
				$msg = '<p class="pl-left smsg"><span>Congratulations!! '.aspc_get_user_name().', Thank you very much for using POST BOT plugin to create your posts.</span></p>';
			}elseif ($step == 7) {
				$msg .= '<p class="pl-left rsure"><span>Do you want to create more Post?</span></p>';
				$msg .= '<p class="pl-left clsbtns"><span data-key="3">YES</span><span data-key="2">NO</span></p>';
			}
			return $msg;
		}
	}
}
if ( ! function_exists( 'aspc_bot_upload_image' ) ) {
	function aspc_bot_upload_image(){		
		$post_id = aspc_gSes('add_post_array','add_post_ID');
	   	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	    require_once( ABSPATH . 'wp-admin/includes/media.php' );
	    $attachment_id = media_handle_upload( 'file', $post_id );
	    $Set = set_post_thumbnail( $post_id, $attachment_id );
	    return $attachment_id;
	}
}
if ( ! function_exists( 'aspc_gSes' ) ) {
	/* Get Session values by key and child keys
	* Session use while only call ajax while adding data into session
	*/
	function aspc_gSes($key,$innerKey='') {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if ($innerKey != '') {
			return @$_SESSION[$key][$innerKey];	
		}else {
			return @$_SESSION[$key];
		}
	}
}
if ( ! function_exists( 'aspc_sSes' ) ) {
	/* Set Session values by key and child keys
	* Session use while only call ajax while adding data into session
	*/
	function aspc_sSes($key,$innerKey='',$value='') {
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if ($innerKey != '') {
			$_SESSION[$key][$innerKey] = $value;
		}else {
			$_SESSION[$key] = $value;
		}
		return true;
	}
}
if ( ! function_exists( 'aspc_get_user_name' ) ) {
	/* Get current user name if not found then set username as name.
	*/
	function aspc_get_user_name(){
		$current_user = wp_get_current_user();
		$username = (!empty($current_user->user_firstname) ?  $current_user->user_firstname : sanitize_user($current_user->user_login));
		return $username;
	}
}
if ( ! function_exists( 'aspc_add_chat_footer_code' ) ) {
	/* Display chatbox in footer based on roles
	*/
	function aspc_add_chat_footer_code(){
		$roles = get_option( 'as_post_roles');
		if (empty($roles)) {
			$roles = array();
		}	
		 $user = wp_get_current_user();
		 $UserRole = @$user->roles[0];
		 	
		 if ( in_array($UserRole,$roles) ) {
	 		require_once ASPC_PLUGIN_PATH.'includes/front.php'; 	
		 }
	}
	add_action( 'wp_footer','aspc_add_chat_footer_code');
}
if ( ! function_exists( 'aspc_chat_box_options' ) ) {
	function aspc_chat_box_options() {
	    add_menu_page(
	        __( 'Post Bot', 'textdomain' ),
	        'Post Bot',
	        'manage_options',
	        'aspc_add_post',
	        'aspc_chat_option_callback',
	        'dashicons-format-status',
	        99
	    );
	}
	add_action( 'admin_menu', 'aspc_chat_box_options' );
}
if ( ! function_exists( 'aspc_chat_option_callback' ) ) {
	/* Display option is admin menu
	*/
	function aspc_chat_option_callback(){
		$roles = get_option( 'as_post_roles');
		if (!empty($roles)) {
			$roles = $roles;
		}else {
			$roles = array();
		}
		require_once ASPC_PLUGIN_PATH.'includes/admin.php';
	}
}
if (isset($_POST["as_post_popup_admin"])) {
	$roles = (!empty($_POST["post_publish_roles"]) ?  $_POST["post_publish_roles"] : array());
	foreach ($roles as $key => $value) {
		$roles[$key] = sanitize_text_field($value);
	}
	update_option( 'as_post_roles', $roles);
}
function aspc_clear_session(){
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if (!empty($_SESSION)) {
		unset($_SESSION['add_post_msg']);
		unset($_SESSION['msg']);	
		unset($_SESSION['add_post_step']);	
		unset($_SESSION['add_post_array']);	
		unset($_SESSION['add_post_ID']);
	}
}