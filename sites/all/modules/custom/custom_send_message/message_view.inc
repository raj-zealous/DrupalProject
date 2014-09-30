<?php

if (isset($_POST['reply']) && $_POST['reply'] != '') {
    // pa($_POST);
    global $user;
    $current_url = 'http://' . $_SERVER['HTTP_HOST'] . '' . request_uri();
    $node = new stdClass();
    $node->type = 'message';
    $node->body['und'][0]['value'] = $_POST['reply_message'];
    $node->field_message_status['und'][0]['value'] = 0;
    $node->field_message_read['und'][0]['value'] = 1;
    $node->field_message_id['und'][0]['value'] = arg(3);
    $node->field_message_type['und'][0]['value'] = 'message';
    $node->field_friend_id['und'][0]['value'] = $user->mail;
    $node->uid = $user->uid;
    //pa($node);
    node_save($node);
    drupal_set_message(t('Message has been sent successfully'));
    drupal_goto($current_url);
}

$reply_nodes = db_query("SELECT entity_id FROM field_data_field_message_id  
                WHERE field_message_id_value = '" . arg(3) . "' ")->fetchAll();

if (!empty($reply_nodes)) {
    foreach ($reply_nodes as $k => $v) {
        $node_details = node_load($v->entity_id);
        $get_replied_msg[] = $node_details;
    }
}

$main_profile_ = profile2_load_by_user($message_info->uid, "main");
$interest_profile_ = profile2_load_by_user($message_info->uid, "your_interest");
$user_detail_info = user_load($message_info->uid);
$user_image_ = file_create_url($user_detail_info->picture->uri);

if (isset($message_info->field_msg_attache['und'][0]['uri']) && $message_info->field_msg_attache['und'][0]['uri'] != '') {
    $download_file = file_create_url($message_info->field_msg_attache['und'][0]['uri']);
}



$sender_name_ = $main_profile_->field_name['und'][0]['value'];
$html .= '<div class="full-mesg-section">   	
                        	<div class="row clearfix">
                            	<div class="col-sm-6 col-sm-offset-6">
                                	<div class="search-data">
                                        <form id = "search_form" method = "post">
                                    	<input type="text" placeholder="Search" name = "search" value = "' . @$_POST['search'] . '">
                                        <button type="submit"><img src="' . $path . '/images/search-icon3.png" alt=""></button>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="conversation-box" id="custom-scroll-1">
                            	<div id="content-section">
                                	<div class="conversation-start-date">Conversation started July 24th, 2011</div>
                                    <div class="conversation">
                                    	<div class="main-conversation clearfix">
                                        	<div class="user-image"><a href="#"><img src="' . $user_image_ . '" alt=""></a></div>
                                            
                                            <div class="message-content new-mesg-content">
                                            	<div class="user-message clearfix">
                                            	<div class="username clearfix">
                                                	<a href="#">' . $sender_name_ . '</a>
                                                    
                                                    <div class="date">' . date('l h:ia', $message_info->created) . '</div>
                                                </div>
                                                <div class="mesg-textdata">' . parseString($message_info->body['und'][0]['value']) . '</div>';
if ($download_file != '') {    
    if (arg(4) == 'download') {
        $ext = explode(".", $message_info->field_msg_attache['und'][0]['filename']);       
        $end = end($ext);
        outputFile($download_file, $message_info->field_msg_attache['und'][0]['filename'], $end);
    }
    global $base_url;
    $current_url = $base_url . '/' . current_path();
    $html .= '</br><div class="mesg-textdata"><b> <a href = "' . $current_url . '/download' . '" > Download file </a></b></div>';
}
$html .= '</div>
                                            </div>
                                        </div>';
if (!empty($get_replied_msg)) {
    foreach ($get_replied_msg as $k => $v) {
        $replied_main_profile = profile2_load_by_user($v->uid, "main");
        $replied_user_detail_info_ = user_load($v->uid);
        $replied_user_image_ = "";
        if (isset($replied_user_detail_info_->picture->uri)) {
            $replied_user_image_ = file_create_url($replied_user_detail_info_->picture->uri);
        }
        $replied_sender_name = $replied_main_profile->field_name['und'][0]['value'];
        $html .= '<div class="main-conversation clearfix">
                                            <div class="user-image"><a href="#"><img src="' . $replied_user_image_ . '" alt=""></a></div>
                                             <div class="message-content new-mesg-content">
                                                <div class="user-message reply clearfix">
                                            	<div class="username clearfix">
                                                	<a href="#">' . $replied_sender_name . ' (logged in user)</a>
                                                    <div class="date">' . date('l h:ia', $v->created) . '</div>
                                                </div>
                                                <div class="mesg-textdata">' . $v->body['und'][0]['value'] . '</div>	
                                                </div>
                                            </div>
                                        </div>';
    }
}

$html .= '</div>
                                </div>
                            </div>
                                        <form id = "search_form" method = "post">

                            <div class="conversation-reply" >
                                     	<textarea rows="" name = "reply_message" cols=""></textarea>
                                     </div>
                                     <div class="continue text-right" >
                                     <button type="submit" style="width:20%;margin:10px;float:right;" value="Reply" placeholder=" Write a message" name="reply" id="edit-submit" class="btn-orange btn btn-primary form-submit">Reply</button></div>
                                     
</form>';