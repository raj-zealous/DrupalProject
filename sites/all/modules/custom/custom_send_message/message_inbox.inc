<?php

$html = '
<section id="message-page-content" class="">
<div class="message-top-box">
	<div class="container">
    	<div class="row clearfix">
        	<div class="col-sm-12">
            	<div class="settings">';
//pa(arg());
if (arg(1) != 'add') {
    $html .= '<div class="dropdown">
                                        <button class="setting-btn" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                          <img src="' . $path . '/images/settings-icon.png" alt="" >
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="' . $base_url . '/send_message_to_friend/view/archive/' . arg(3) . '">ARCHIVE</a></li>
                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="' . $base_url . '/send_message_to_friend/view/delete/' . arg(3) . '">DELETE</a></li>
                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="' . $base_url . '/send_message_to_friend/view/spam/' . arg(3) . '">Spam</a></li>
                                        </ul>
                                      </div>';
}
$html .= '</div>
            </div>
        </div>
    </div>
<div class="container">
	<div class="row clearfix">
          <div class="col-sm-12" >
          		
          		<div class="message-contentbox clearfix">
                	 <div class="message-leftbox">
                 		<div class="message-title">My messages</div>
                        
                        <div class="massages-links clearfix">
                        	<div class="message-left-link">
                            	<ul>
                                	<li class = "' . $inbox_class . '"><a href="' . $base_url . '/send_message_to_friend/add">Inbox&nbsp;<span class="counter">(' . $unread_msg_inbox . ')</span></a></li>
                                    <li class = "' . $archive_class . '"><a href="' . $base_url . '/send_message_to_friend/add/archive">' . $archive_msg_inbox . '</a></li>
                                    <li class =  "' . $spam_class . '"><a href="' . $base_url . '/send_message_to_friend/add/spam">' . $spam_msg_inbox . '</a></li>
                                </ul>
                            </div>
                            
                            <div class="message-right-link">
                            	<ul>
                               		 <li><a href="' . $base_url . '/send_message_to_friend/add">+ New Message</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        
                        <div class="mesg-list">
                        	<ul>';
if (!empty($get_all_msg)) {
    foreach ($get_all_msg as $k => $v) {

        $main_profile = profile2_load_by_user($v->uid, "main");
        $user_detail_info = user_load($v->uid);
        
        $user_image = "";
        if (isset($user_detail_info->picture->uri) && $user_detail_info->picture->uri != '') {
            $user_image = file_create_url($user_detail_info->picture->uri);
        }
        $sender_name = $main_profile->field_name['und'][0]['value'];

        //pa($main_profile);
        //pa($sender_name);
        if (strlen($v->body['und'][0]['value']) >= 40) {
            $message = substr($v->body['und'][0]['value'], 0, 40) . ' ...';
        } else {
            $message = $v->body['und'][0]['value'];
        }
        if ($v->field_message_status['und'][0]['value'] == 0) {
            $class = 'unread active';
        } else {
            $class = '';
        }
        $message_day = format_date($v->created, "custom", "l");
        //pa($message_date);
        //$user_image = "";
        $html .= '<li>
                                	<a href="' . $base_url . '/send_message_to_friend/view/message/' . $v->nid . '" class = "' . $class . '">
                                    	<div class="mesg clearfix">
                                        	<div class="user-image">
                                            	<img width ="45" height = "45" src="' . $user_image . '" alt="">
                                            </div>
                                            
                                            <div class="mesg-data">
                                            	<span class="day">' . $message_day . '</span>
                                                <span class="user-name">' . $sender_name . '</span>
                                                <span class="mesg-text">' . $message . '</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>';
    }
}
$html .= '</ul>
                        </div>                        
                	 </div>
               		 <div class="message-rightbox clearfix">';