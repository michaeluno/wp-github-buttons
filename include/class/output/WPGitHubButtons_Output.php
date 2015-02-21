<?php
/**
 * WP GitHub Buttons
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Handles rendering the HTML output.
 * 
 * @since   0.0.1
 */
class WPGitHubButtons_Output {
    
    /**
     * Stores the default arguments. 
     */
    public $aArguments = array(
        'type'          => '.fork',
        'account'       => 'michaeluno',
        'repository'    => 'wp-github-buttons',
        'show_count'    => true,
    );
    
    /**
     * The 'a' tag attributes 
     * 
     * @remark      `null` elements will be dropped while the empty ('') elements will remain in the tag.
     * @since       0.0.5
     */
    public $aAttributes = array(
        'class'             => '',
        'href'              => null,
        'data-icon'         => 'octicon-mark-github',   // see https://octicons.github.com/// 'data-icon'         => 'octicon-gift',   // see https://octicons.github.com/
        'data-count-href'   => null, // e.g. "/michaeluno/followers",
        'data-count-api'    => null, // e.g. "/users/michaeluno#followers",
        'data-style'        => 'default',   // default or mega
        'data-text'         => 'Fork',
    );
    
    /**
     * Sets up hooks and properties.
     */
    public function __construct( $asArguments ) {
        
        $this->aArguments = $this->_getFormattedArguments( 
            is_array( $asArguments ) 
                ? $asArguments 
                : array( $asArguments )
        );
        
        $this->aAttributes = $this->_getFormattedAttributes(
            $this->aArguments
        );
        
    }
        /**
         * Formats an argument array.
         * @return      array       The formatted argument array.
         */
        private function _getFormattedArguments( array $aArguments ) {
            
            return $aArguments + $this->aArguments;
            
        }
        /**
         * Formats an attribute array.
         */
        private function _getFormattedAttributes( array $aArguments ) {
            
            $_aAttributeNames = $this->_convertHyphensToUnderscores( 
                array_keys( $this->aAttributes ) 
            );
            
            $_aAttributes = array();
            foreach( $aArguments as $_sKey => $_mArgument ) {
                if ( ! in_array( $_sKey, $_aAttributeNames ) ) {
                    continue;
                }
                $_aAttributes[ $this->_convertUnderscoresToHyphens( $_sKey ) ] = $_mArgument;
            }

            $_aReulst = 
                $this->_getCountAPIEndpointsByType( 
                    $aArguments['type'],
                    $aArguments['account'],
                    $aArguments['repository'],
                    $aArguments['show_count']
                )
                + $_aAttributes
                + $this->aAttributes 
                ;

            // If custom octicon is set, use that
            $_aReulst['data-icon'] = $_aAttributes['data-icon'] 
                ? $_aAttributes['data-icon'] 
                : $_aReulst['data-icon'];
            
            return $_aReulst;
            
        }
            /**
             * 
             * @return      array       The attribute array containing GitHub API endpoint attributes.
             * @since       0.0.5
             */
            private function _getCountAPIEndpointsByType( $sType, $sAccount, $sRepository, $bShowCount ) {
                $_aEndpoints = array(
                    '.fork'     => array(
                        'data-count-href'   => '/%account%/%repository%/network',
                        'data-count-api'    => '/repos/%account%/%repository%#forks_count',
                        'href'              => 'https://github.com/%account%/%repository%/fork',
                        'data-icon'         => 'octicon-git-branch',
                    ),                    
                    '.follow'    => array(
                        'data-count-href'   => '%account%/followers',
                        'data-count-api'    => 'users/%account%#followers',
                        'href'              => 'https://github.com/%account%',
                    ),
                    '.star'      => array(
                        'data-count-href'   => '%account%/%repository%stargazers',
                        'data-count-api'    => '/repos/%account%/%repository%#stargazers_count',
                        'href'              => 'https://github.com/%account%/%repository%',
                        'data-icon'         => 'octicon-star',
                    ),
                    '.issue'     => array(
                        'data-count-href'   => null,
                        'data-count-api'    => '/repos/%account%/%repository%#open_issues_count',
                        'href'              => 'https://github.com/%account%/%repository%/issues',
                        'data-icon'         => 'octicon-issue-opened',
                    ),
                    '.custom'    => array(
                        'data-count-href'   => null,
                        'data-count-api'    => null,                        
                    ),
                );

                if ( isset( $_aEndpoints[ $sType ] ) ) {
                    $_aAttributes = str_replace(
                        array( '%account%', '%repository%' ),   // search
                        array( $sAccount, $sRepository ),   // replace
                        $_aEndpoints[ $sType ]  // subject
                    );
                    if ( ! $bShowCount ) {
                        unset( $_aAttributes[ 'data-count-api' ] );
                    }
               
                    return $_aAttributes;
                }
                return array();
               
            }
        
    
    /**
     * Returns the HTML output.
     * @return      string
     */
    public function get() {
        return "<div class='wp-github-button-container'>"
                    . $this->_getButtonElement( 
                        $this->aAttributes,
                        $this->aArguments 
                    )
            . "</div>"  // wp-github-button-container
        ;
    }
        /**
         * Returns the 'a' tag output.
         * 
         * @return      string      The output of the 'a' tag of the button.
         */
        private function _getButtonElement( array $aAttributes, array $aArguments ) {
            
            $_oUtil                 = new WPGitHubButtons_AdminPageFramework_WPUtility;
            $aAttributes['class']   = $_oUtil->generateClassAttribute(
                $aAttributes['class'],
                'github-button'
            );
            return "<a " . $_oUtil->generateAttributes( $aAttributes ) . '>'
                    . $aAttributes['data-text']
                . "</a>"
                ;
        }
      
    
    /**
     * Converts underscores to hyphens.
     * 
     * Used to format attributes.
     * 
     * @return      string
     * @since       0.0.5
     */
    private function _convertUnderscoresToHyphens( $asSubject ) {
        return str_replace( '_', '-', $asSubject );
    }
    /**
     * Converts hyphens to underscores.
     * 
     * Used to format attributes.
     * 
     * @return      string
     * @since       0.0.5
     */    
    private function _convertHyphensToUnderscores( $asSubject ) {
        return str_replace( '-', '_', $asSubject );        
    }
}