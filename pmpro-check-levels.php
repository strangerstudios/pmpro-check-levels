<?php
/*
Plugin Name: PMPro Check Levels
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-check-levels/
Description: A collection of customizations useful when allowing users to pay by check for Paid Memberships Pro levels.
Version: .2
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
/*
	Sample use case: You have a paid level (id=1) that you want to allow people to pay by check for.
	
	1. Change your Payment Settings to the "Pay by Check" gateway and make sure to set the "Instructions" with instructions for how to pay by check. Save.
	2. Change the Payment Settings back to use your gateway of choice. Behind the scenes the Pay by Check settings are still stored.
	3. Create a new level for your Pay by Check option. Set the $pmpro_check_levels array below to include the ID of this level.
	
	* Users checking out for the check level won't have access to the regular paid level. 
	* They will see instructions for how to mail a check/etc.
	* After you recieve and cash the check, you can change their level to the full member level by editing the user in the admin dashboard.
*/

/*
	Settings, Globals and Constants
	
	Uncomment these lines and change them or set these values in another plugin or your active theme's functions.php file.
*/
//global $pmpro_check_levels;
//$pmpro_check_levels = array(1);					//set this array to include the ids of levels where users should be forced to pay by check

/*
	Change gateway to "check" for the levels specified
*/
function pmprocl_init_check_gateway_for_levels()
{
	global $pmpro_check_levels;
	if(!empty($_REQUEST['level']) && !empty($pmpro_check_levels) && in_array($_REQUEST['level'], $pmpro_check_levels))
	{
		//set gateway to check and make check a valid gateway
		$_REQUEST['gateway'] = "check";
		add_filter('pmpro_valid_gateways', create_function('$gateways', '$gateways[]="check"; return $gateways;'));
		
		//set this global so we don't require billing fields
		global $pmpro_requirebilling;
		$pmpro_requirebilling = false;
		
		//don't use the pmpro-add-paypal-express on this level
		remove_action("pmpro_checkout_boxes", "pmproappe_pmpro_checkout_boxes", 20);
		remove_filter("pmpro_valid_gateways", "pmproappe_pmpro_valid_gateways");
	}
}
add_action('init', 'pmprocl_init_check_gateway_for_levels', 20);

/*
	Fix admin change email when changing members who paid by check.
	We don't want to mention "free" /etc.
*/
function pmprocl_pmpro_email_data($email_data, $email) 
{	
	// Get user info
	if(isset($email_data['user_login'])) 
	{
		$user = get_user_by( 'login', $email_data['user_login'] );
		$membership_level = pmpro_getMembershipLevelForUser($user->ID);		
	}

	// Get last order details
	$order = new MemberOrder();
	$order->getLastMemberOrder($user->ID, "cancelled");
	
	// Check to make sure there changing levels and are not cancelling
	if(isset($email_data["membership_change"]) && $order->gateway == 'check' && !empty($membership_level->ID))
		$email_data["membership_change"] = str_replace(". This membership is free", "", $email_data["membership_change"]);	
	
	return $email_data;
}
add_filter('pmpro_email_data', 'pmprocl_pmpro_email_data', 10, 2);

