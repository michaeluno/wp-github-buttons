<?php
/**
 * Loads the pluigin
 *    
 * @package      WP GitHub Buttons
 * @copyright    Copyright (c) 2015, <Michael Uno>
 * @author       Michael Uno
 * @authorurl    http://michaeluno.jp
 * @since        0.0.1
 * 
 */


/**
 * Loads the plugin.
 * 
 * @action      do      wp_github_buttons_action_after_loading_plugin
 * @since       0.0.1
 */
final class WPGitHubButtons_Bootstrap extends WPGitHubButtons_AdminPageFramework_PluginBootstrap {
    
    /**
     * Register classes to be auto-loaded.
     * 
     * @since       0.0.1
     */
    public function getClasses() {
        
        // Include the include lists. The including file reassigns the list(array) to the $_aClassFiles variable.
        $_aClassFiles   = array();
        $_bLoaded       = include( dirname( $this->sFilePath ) . '/include/class-list.php' );
        if ( ! $_bLoaded ) {
            return $_aClassFiles;
        }
        return $_aClassFiles;
                
    }

    /**
     * The plugin activation callback method.
     */    
    public function replyToPluginActivation() {

        $this->_checkRequirements();
        
    }
        /**
         * 
         * @since            0.0.1
         */
        private function _checkRequirements() {

            $_oRequirementCheck = new WPGitHubButtons_AdminPageFramework_Requirement(
                WPGitHubButtons_Registry::$aRequirements,
                WPGitHubButtons_Registry::NAME
            );
            
            if ( $_oRequirementCheck->check() ) {            
                $_oRequirementCheck->deactivatePlugin( 
                    $this->sFilePath, 
                    __( 'Deactivating the plugin', 'wp-github-buttons' ),  // additional message
                    true    // is in the activation hook. This will exit the script.
                );
            }        
             
        }    
    
        
    /**
     * Load localization files.
     * 
     * @remark      A callback for the 'init' hook.
     */
    public function setLocalization() {
        
        // This plugin does not have messages to be displayed in the front end.
        if ( ! $this->bIsAdmin ) { return; }
        
        load_plugin_textdomain( 
            WPGitHubButtons_Registry::TEXT_DOMAIN, 
            false, 
            dirname( plugin_basename( $this->sFilePath ) ) . '/' . WPGitHubButtons_Registry::TEXT_DOMAIN_PATH
        );
        
    }        
    
    /**
     * Loads the plugin specific components. 
     * 
     * @remark        All the necessary classes should have been already loaded.
     */
    public function setUp() {
            
        $this->_include();
            
        new WPGitHubButtons_Shortcode( WPGitHubButtons_Registry::$sShortcodes['main'] );
        
        new WPGitHubButtons_ResourceLoader;
        
        new WPGitHubButtons_Widget( __( 'WP GitHub Button', 'wp-github-buttons' ) );
        
    }
        /**
         * Includes additional files.
         */
        private function _include() {
            
            // Functions
            include( dirname( $this->sFilePath ) . '/include/function/functions.php' );
            
        }
    
}