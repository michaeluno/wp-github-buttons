<?php
/**
 * WP GitHub Buttons
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Load admin styles.
 * 
 * @since   0.0.1
 */
class WPGitHubButtons_ResourceLoader {
    
    /**
     * Sets up hooks.
     */
    public function __construct() {
               
        // Not using the 'wp_enqueue_script' hook as it inserts additional attributes which causes the script not run properly.
        add_action( 'wp_footer', array( $this, '_replyToAddScript' ) );
        
    }
    
    static public $_bAddedScriptToFooter;
    
    /**
     * 
     * @callback        action      wp_footer
     */
    public function _replyToAddScript() {
        
        if ( isset( self::$_bAddedScriptToFooter ) ) {
            return;
        }
        self::$_bAddedScriptToFooter = true;
        
        echo "<script async defer id='github-bjs' src='" . WPGitHubButtons_Registry::getPluginURL( 'asset/github-buttons/buttons.js' ) . "'>"
            . "</script>";
        
    }    


        
}