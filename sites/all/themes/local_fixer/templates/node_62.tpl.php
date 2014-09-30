<?php
$cur_path = getcwd();
//echo $cur_path;
/*chdir('../../../../../');
define('SITE_URL','http://www.onebiz.com');
//define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
include_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
chdir($cur_path);*/

function custom_drupal_mail($from = 'default_from', $to, $subject, $message) {
  $my_module = 'custom';
  $my_mail_token = microtime();
  if ($from == 'default_from') {
    // Change this to your own default 'from' email address.
    $from = variable_get('system_mail', 'dump@zealousys.com');
  }
  $message = array(
    'id' => $my_module . '_' . $my_mail_token,
    'to' => $to,
    'subject' => $subject,
    'body' => array($message),
    'headers' => array(
      'From' => $from,
      'Sender' => $from,
      'Return-Path' => $from,
	  //'Content-type' => 'text/html;charset=UTF-8',
    ),
  );
  $system = drupal_mail_system($my_module, $my_mail_token);
  $message = $system->format($message);
  
  if ($system->mail($message)) {
	
   return TRUE;
  }
  else {
   
	return FALSE;
	
  }
}

if(isset($_REQUEST['script']) && $_REQUEST['script'] == 'approve' && $_REQUEST['id'] != ''){


 

 

	$getCode = db_query("select rid,code from {regcode} where is_active ='1' limit 0,1");
	$cntCode =  $getCode->rowCount();
	
	$getEmail = db_query("select email from {tbl_email_request} where id ='".$_REQUEST['id']."'");
	foreach($getEmail as $em){
	}
	if($cntCode > 0){
					foreach($getCode as $cd){
					}
						// code for insert in assigned code table 
						$id = db_insert('tbl_assigned_code') // Table name no longer needs {}
									->fields(array(
									  'code_id' => $cd->rid,
									  'code' => $cd->code,
									  'email' => $em->email,
									  'datetime' => date("Y-m-d h:i:s"),
									  
									))
						->execute();
						 
						// code for update request status 
						 $num_updated = db_update('tbl_email_request') // Table name no longer needs {}
						  ->fields(array(
							  'status' => 'approve',
						  ))
						  ->condition('id', $_REQUEST['id'],'=')
						  ->execute();
						  
						  // code for update code status 
						 $num_updated = db_update('regcode') // Table name no longer needs {}
						  ->fields(array(
							  'is_active' => '0',
						  ))
						  ->condition('rid', $cd->rid,'=')
						  ->execute();
						  



	//$to = "aspanchal86@gmail.com"; // to e-mail address
				$to = $em->email;
				/*$from = "webmaster@example.com"; // from e-mail address
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <webmaster@example.com>' . "\r\n";*/
				$subject = "Localfixer - Request for Login"; // subject of e-mail
				
				$body = "Dear User,<br/>
					Your Request is Successfully Approved by Administrator.<br/>
					Your Code For accessing the site is ".$cd->code.""; 
					
				//mail($to,$subject,$body,$headers);
				try{
					custom_drupal_mail('default_from',$to, $subject, $body);
					
					//drupal_mail('custom', 'mymail', $to, $language, $params = array('username' => 'John Potato'), $from = NULL, $send = TRUE);

					

				}catch(Exception $e){
					echo $e;
					die();
				}
			
			//custom_drupal_mail('default_from','aspanchal86@gmail.com', $subject, $body);

			  
			$_GET['msg'] = 'save';			  
			//header("Location:/email-invite-request");
	}else{
		$_GET['msg'] = 'notAvailable';
		//header("Location:/email-invite-request");
		
		
	}
}
if(isset($_REQUEST['script']) && $_REQUEST['script'] == 'reject' && $_REQUEST['id'] != ''){

	
	$getEmail = db_query("select email from {tbl_email_request} where id ='".$_REQUEST['id']."'");
	foreach($getEmail as $em){
	}
						 
						// code for update request status 
						 $num_updated = db_update('tbl_email_request') // Table name no longer needs {}
						  ->fields(array(
							  'status' => 'reject',
						  ))
						  ->condition('id', $_REQUEST['id'],'=')
						  ->execute();
					
				$to = $em->email;
				
				$subject = "Localfixer - Request for Login"; // subject of e-mail
				
				$body = "Dear User,<br/>
					Your Request is being rejected by Administrator.<br/>"; 
					
				
				try{
					custom_drupal_mail('default_from',$to, $subject, $body);
					
					//drupal_mail('custom', 'mymail', $to, $language, $params = array('username' => 'John Potato'), $from = NULL, $send = TRUE);

					

				}catch(Exception $e){
					echo $e;
					die();
				}					
				  
		header("Location:/email-invite-request");
	
}


 //$path = path_to_theme(); ?>
<style type="text/css">
.SpanApr{ background: none repeat scroll 0 0 green;
    color: white;
    padding: 3px 10px;}
.SpanRej{ background: none repeat scroll 0 0 red;
    color: white;
    padding: 3px 10px;}	
</style> 
<section id="container-top-bar" class="content-top-bar fullheight">
    <div class="container">
      <div class="row">
        <a id="main-content"></a> 
        <?php if(isset($_GET['msg']) && $_GET['msg'] != ''){ ?>
        <div class="alert alert-block alert-success">
  			<a href="#" data-dismiss="alert" class="close">×</a>
		<span><?php if($_GET['msg'] == 'save'){
			echo 'Request Successfully Approved';
		}else if($_GET['msg'] == 'reject'){
			echo 'Request Successfully Rejected';
		}?></span>
        </div>
        <?php } ?>


		<?php print $messages; ?>
       <?php 
	   $requestList= db_query("select * from {tbl_email_request}  ORDER BY id desc");
		$cntList =  $requestList->rowCount();
	    ?> 
         <div class="white-bg clearfix">
          <div class="col-sm-12">
            <div class="profile-rgt-box">
              
              <div class="latest-profile-update">
                <table id="invite_table" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Email</th>
                <th>Datetime</th>
                <th>Action</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Sr No.</th>
                <th>Email</th>
                <th>Datetime</th>
                <th>Action</th>
            </tr>
        </tfoot>
 
        <tbody>
           <?php 
		   $ind = 1;
		   foreach($requestList as $req){ ?>
            <tr>
                <td><?php echo $ind; ?></td>
                <td><?php echo $req->email ?></td>
                <td><?php echo $req->datetime ?></td>
                <td>
                <?php if($req->status == 'pending'){ ?>
                	<div class="list-button active"><a href="?script=approve&id=<?php echo $req->id; ?>" >Approve</a></div>
                    <div class="list-button active"><a href="?script=reject&id=<?php echo $req->id; ?>" >Reject</a></div>
                <?php }else{ 
							if($req->status == 'approve'){
								echo '<span class="SpanApr">Approved</span>';
							}else if($req->status == 'reject'){
								echo '<span class="SpanRej">Rejected</span>';
							}?>
                <?php } ?>
                </td>
            </tr>
           <?php 
		   $ind++;
		    } ?> 
        </tbody>
    </table>
              </div>
            </div>
          </div>
        </div>	
      </div>
    </div>
  </section>
   <link href="<?php echo path_to_theme(); ?>/css/jquery.dataTables.css" rel="stylesheet" />
  <script src="<?php echo path_to_theme(); ?>/js/jquery.dataTables.min.js"></script>  
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#invite_table').dataTable();
} );
</script>  