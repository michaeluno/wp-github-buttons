<?php
/**
 * WP GitHub Buttons
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Prints the output of the button.
 * @since       0.0.1
 * @return      void
 */
function printWPGitHubButton( $asArguments ) {
    
    echo getWPGitHubButton( $asArguments );
    
}
 
/**
 * Returns the button HTML output string.
 * @since       0.0.1
 * @return      string      The output string.
 */
function getWPGitHubButton( $asArguments ) {
    
    $_oWPGitHubButton = new WPGitHubButtons_Output( $asArguments );
    return $_oWPGitHubButton->get();
    
}