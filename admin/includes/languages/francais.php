<?php 

    function lang( $phrase ) {

    	static $lang = array(

    		// les liens du Navbar

    		'home_admin' 	=> 'Acceuil',
    		'categories' 	=> 'Sections',
    		'items' 		=> 'Articles',
    		'members' 		=> 'Membres',
            'comments'      => 'Comments',
    		'statistics'	=> 'Statistiques',
    		'logs' 			=> 'Journaux',
    		'edit_profile'	=> 'Editer Profile',
    		'settings' 		=> 'Settings',
    		'logout' 		=> 'se Deconnecter',
    		
        
    		);

    	return $lang[$phrase];

    }