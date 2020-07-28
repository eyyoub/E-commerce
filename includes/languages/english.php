<?php 

    function lang( $phrase ) {

    	static $lang = array(

    		// Navbar Links

    		'home_admin' 	=> 'Home',
    		'categories' 	=> 'Categories',
    		'items' 		=> 'Items',
    		'members' 		=> 'Members',
            'comments'      => 'Comments',
    		'statistics' 	=> 'Statistics',
    		'logs' 			=> 'Logs',
    		'edit_profile' 	=> 'Edit Profile',
    		'settings' 		=> 'Settings',
    		'logout' 		=> 'Logout'

    		);

    	return $lang[$phrase];

    }