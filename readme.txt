=== Paid Memberships Pro - Check Levels Add On ===
Contributors: strangerstudios
Tags: paid memberships pro, pmpro, check, cheque
Requires at least: 3.4
Tested up to: 4.1.1
Stable tag: .2

A collection of customizations useful when allowing users to pay by check for Paid Memberships Pro levels.

== Description ==

Sample use case: You have a paid level (id=1) that you want to allow people to pay by check for.
	
1. Change your Payment Settings to the "Pay by Check" gateway and make sure to set the "Instructions" with instructions for how to pay by check. Save.
2. Change the Payment Settings back to use your gateway of choice. Behind the scenes the Pay by Check settings are still stored.
3. Create a new level for your Pay by Check option. Set the $pmpro_check_levels array below to include the ID of this level.

* Users checking out for the check level won't have access to the regular paid level. 
* They will see instructions for how to mail a check/etc.
* After you recieve and cash the check, you can change their level to the full member level by editing the user in the admin dashboard.

== Installation ==

= Download, Install and Activate! =
1. Upload `pmpro-check-levels` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure to set any constants or globals at the top of the plugin.

== Frequently Asked Questions ==

= I found a bug in the plugin. =

Please post it in the issues section of GitHub and we'll fix it as soon as we can. Thanks for helping. https://github.com/strangerstudios/pmpro-check-levels/issues

= I need help installing, configuring, or customizing the plugin. =

Please visit our premium support site at http://www.paidmembershipspro.com for more documentation and our support forums.

== Changelog == 
= .3 =
* Standardizing plugin names and descriptions.

= .2 =
* The global $pmpro_check_levels var must be set in another plugin now or uncommented out at the top of the plugin.
* Removing filters from the pmpro-add-paypal-express plugin so billing fields don't show up on the checkout page for a check level. (Thanks, boldfish)

= .1 =
* Initial version.
