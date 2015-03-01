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
        'type'              => '.fork',
        'account'           => 'michaeluno',
        'repository'        => 'wp-github-buttons',
        'show_count'        => false,
        'custom_attributes' => array(),
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
     * Stores a utility object.
     * 
     * @since       0.0.6
     */
    public $oUtil;
    
    /**
     * Sets up hooks and properties.
     */
    public function __construct( $asArguments ) {
        
        $this->oUtil      = new WPGitHubButtons_AdminPageFramework_WPUtility;
        $this->aArguments  = $this->_getFormattedArguments( 
            $this->oUtil->getAsArray( $asArguments )
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
         * @return      array
         */
        private function _getFormattedAttributes( array $aArguments ) {
            
            $_aAttributeNames = $this->_convertHyphensToUnderscores( 
                array_keys( $this->aAttributes )
            ) + array_keys( $this->aAttributes );
            
            $_aAttributes = array();
            foreach( $aArguments as $_sKey => $_mArgument ) {
                if ( ! in_array( $_sKey, $_aAttributeNames, true ) ) {
                    continue;
                }
                $_aAttributes[ $this->_convertUnderscoresToHyphens( $_sKey ) ] = $_mArgument;
            }

            $_aResult = $this->oUtil->uniteArrays(
                $aArguments,
                $this->_getCountAPIEndpointsByType( 
                    $aArguments['type'],
                    $aArguments['account'],
                    $aArguments['repository'],
                    $aArguments['show_count']
                ),
                $_aAttributes + $this->aAttributes 
            );

            // If custom octicon is set, use that
            $_aResult['data-icon'] = $this->oUtil->getElement(
                $_aAttributes,
                'data-icon',
                $_aResult['data-icon']
            );

            $_aResult = $this->_formatCustomAttributes( $aArguments['custom_attributes'] )
                + $_aResult;
            return $_aResult;
                       
        }
            /**
             * Formats custom attributes.
             * 
             * @since       0.0.6
             * @param       array       $aCustomAttributes
             * The passed array structure looks like this.
             * <code>
             * array(
             *      0 => array(
             *          'attribute' => 'rel',
             *          'value'     => 'nofollow',
             *      ),
             *      1 => array(
             *          'attributes' => 'data-...',
             *          'value'     => '...',
             *      ),
             * )
             * </code>
             * @return      array
             * The formatted structure looks like this.
             * <code>
             * array(
             *  'rel' => 'nofollow',
             *  'data-...' => '...',
             * )
             * </code>
             */
            private function _formatCustomAttributes( array $aCustomAttributes ) {
                $_aAttributes = array();
                foreach( $aCustomAttributes as $aKeyValue ) {
                    if ( ! strlen( $aKeyValue[ 'attribute' ] ) ) {
                        continue;
                    }
                    $_aAttributes[ $aKeyValue[ 'attribute' ] ] = $aKeyValue['value'];                    
                }
                return $_aAttributes;                
            }
            /**
             * Stores attributes of GitHub API end points.
             * @since       0.0.6
             */
            private $_aEndpoints = array(
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
                    'data-count-href'   => '/%account%/%repository%/stargazers',
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
            /**
             * 
             * @return      array       The attribute array containing GitHub API endpoint attributes.
             * @since       0.0.5
             */
            private function _getCountAPIEndpointsByType( $sType, $sAccount, $sRepository, $bShowCount ) {

                if ( ! isset( $this->_aEndpoints[ $sType ] ) ) {
                    return array();
                }
                
                $_aAttributes = str_replace(
                    array( '%account%', '%repository%' ),   // search
                    array( $sAccount, $sRepository ),   // replace
                    $this->_aEndpoints[ $sType ]  // subject
                );
                if ( ! $bShowCount ) {
                    unset( $_aAttributes[ 'data-count-api' ] );
                } 
                return $_aAttributes;
               
            }
        
    
    /**
     * Returns the HTML output.
     * @return      string
     */
    public function get() {
        
        $_aAttributes = array( 
            'class' => 'wp-github-button-container' 
        );
        return "<div " . $this->oUtil->generateAttributes( $_aAttributes ) . ">"
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
            
            $aAttributes['class']   = $this->oUtil->generateClassAttribute(
                $aAttributes['class'],
                'github-button'
            );
            return "<a " . $this->oUtil->generateAttributes( $aAttributes ) . '>'
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