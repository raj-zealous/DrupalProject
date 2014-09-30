<?php
$cur_path = getcwd();
//echo $cur_path;
chdir('../../../../../');
define('DRUPAL_ROOT', getcwd());
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
include_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
chdir($cur_path);






if(isset($_POST['invite_email']) && $_POST['invite_email'] != ''){
	$chkEmail = db_query("select * from {tbl_email_request} where email ='".$_POST['invite_email']."' ");
$cntMail =  $chkEmail->rowCount();
	if($cntMail > 0){
		echo 'You are already requested for the same';
	}else{
		$id = db_insert('tbl_email_request') // Table name no longer needs {}
					->fields(array(
					  'email' => $_POST['invite_email'],
					  'datetime' => date("Y-m-d h:i:s"),
					  'status' => 'pending'
					))
		->execute();
		echo 'Your Successfully Submited, You will Shortly Recieved Email By Administrator';
	}
}else{
	echo 'Please Enter Email Address';
}


?>

