<?php
/**
 * WP GitHub Buttons
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2015 Michael Uno; Licensed GPLv2
 * 
 */

/**
 * Creates a widget.
 * 
 * @since   0.0.1
 */
class WPGitHubButtons_Widget extends WPGitHubButtons_AdminPageFramework_Widget {
    
    /**
     * The user constructor.
     * 
     * Alternatively you may use start_{instantiated class name} method.
     */
    public function start() {}
    
    /**
     * Sets up arguments.
     * 
     * Alternatively you may use set_up_{instantiated class name} method.
     */
    public function setUp() {
        
        $_sClassName = get_class( $this );
        new WPGitHubButtons_MultiTextCustomFieldType( $_sClassName );        
        new WPGitHubButtons_RevealerCustomFieldType( $_sClassName );
        
        $this->setArguments( 
            array(
                'description'   => __( 'Displays a GitHub button.', 'wp-github-buttons' ),
            ) 
        );
    
    }    

    /**
     * Sets up the form.
     * 
     * Alternatively you may use load_{instantiated class name} method.
     */
    public function load( $oAdminWidget ) {
        
        $this->addSettingFields(
            array(
                'field_id'      => 'title',
                'type'          => 'text',
                'title'         => __( 'Widget Title', 'wp-github-buttons' ),
            ),     
            array(
                'field_id'      => 'type',
                'type'          => 'revealer',
                'select_type'   => 'select',
                'title'         => __( 'Type', 'wp-github-buttons' ),
                'label'         => array(
                    '.fork'      => __( 'Fork', 'wp-github-buttons' ),
                    '.follow'    => __( 'Follow', 'wp-github-buttons' ),
                    '.star'      => __( 'Star', 'wp-github-buttons' ),
                    '.issue'     => __( 'Issue', 'wp-github-buttons' ),
                    '.custom'    => __( 'Custom', 'wp-github-buttons' ),
                ),
                'default'       => 'fork',
            ),
            array()
        );
        
        $this->addGitHubFields();

        $this->addSettingFields(
            array(
                'field_id'      => 'data_text', // data-text  - hyphens get converted to underscores by the framework.
                'type'          => 'text',
                'title'         => __( 'Button Label', 'wp-github-buttons' ),
                'default'       => __( 'Fork', 'wp-github-buttons' ),
            ),    
            array(
   
                'field_id'      => 'data_icon', // data-icon
                'type'          => 'text',
                'title'         => 'Octicon',
                'default'       => '',
                'description'   => array(
                    'e.g. <code>octicon-gift</code>, <code>octicon-star</code>',
                    sprintf( 
                        __( 'See <a href="%1$s" target="_blank">here</a> to find more items.', 'wp-github-butotns' ),
                        'https://octicons.github.com/'
                    ),
                ),
            ),
            array(
                'field_id'      => 'data_style',  // data-style
                'type'          => 'select',
                'title'         => __( 'Size', 'wp-github-buttons' ),
                'label'         => array(
                    'mega'        => __( 'Large', 'wp-github-buttons' ),
                    'default'     => __( 'Default', 'wp-github-buttons' ),
                    // 'small'        => __( 'Small', 'wp-github-buttons' ),
                ),
                'default'       => 'default',
            ),
            array(
                'field_id'      => 'custom_attributes',
                'type'          => 'multi_text',
                'title'         => __( 'Custom Attributes', 'wp-github-buttons' ),
                'description'   => __( 'Set HTML attribute name-value pairs applied to the button element <code>div</code> tag.', 'wp-github-buttons' ),
                'label'         => array(
                    'attribute' => __( 'Attribute', 'wp-github-buttons' ),
                    'value' => __( 'Value', 'wp-github-buttons' ),
                ),
                'repeatable'    => true,
                'default'       => array(
                    'attribute' => 'rel',
                    'value'     => 'nofollow',
                ),
            )              
        );           
        
    }
        private function addGitHubFields() {
            
            $this->addSettingFields(
                array(
                    'field_id'      => 'account',
                    'type'          => 'text',
                    'title'         => __( 'GitHub Account', 'wp-github-buttons' ),
                    'description'   => sprintf( 
                        __( 'For example, <code>%1$s</code> in <code>%2$s</code>', 'wp-github-butotns' ),
                        'michaeluno',
                        'https://github.com/michaeluno/wp-github-buttons'
                    ),      
                    'class'         => array(
                        'fieldrow' => 'fork follow star issue',
                    ),                    
                    'hidden'        => true,
                ),                        
                array(
                    'field_id'      => 'repository',
                    'type'          => 'text',
                    'title'         => __( 'GitHub Repository Name', 'wp-github-buttons' ),
                    'description'   => sprintf( 
                        __( 'For example, <code>%1$s</code> in <code>%2$s</code>', 'wp-github-butotns' ),
                        'wp-github-buttons',
                        'https://github.com/michaeluno/wp-github-buttons'
                    ),
                    'class'         => array(
                        'fieldrow' => 'fork follow star issue'
                    ),                    
                    'hidden'        => true,
                ),    
                array(
                    'field_id'      => 'show_count',
                    'type'          => 'checkbox',
                    'title'         => __( 'Show Count', 'wp-github-buttons' ),
                    'label'         => __( 'Show the count indication along with the button.', 'wp-github-buttons' ),
                    'class'         => array(
                        'fieldrow' => 'fork follow star issue'
                    ),                    
                    'hidden'        => true,
                ),                 
                array(
                    'field_id'      => 'href',
                    'type'          => 'text',
                    'title'         => __( 'Custom URL', 'wp-github-buttons' ),
                    'description'   => sprintf( 
                        'e.g. <code>%1$s</code>',
                        'https://wordpress.org'
                    ),
                    'class'         => array(
                        'fieldrow' => 'custom'
                    ),                    
                    'hidden'        => true,
                ),                  
                array()
            );
        }    
   
    
    /**
     * Validates the submitted form data.
     * 
     * Alternatively you may use validation_{instantiated class name} method.
     * @return      array       The filtered submitted user input array.
     */
    public function validate( $aSubmit, $aStored, $oAdminWidget ) {
        
        // Uncomment the following line to check the submitted value.
        // AdminPageFramework_Debug::log( $aSubmit );
        
        if ( '.custom' !== $aSubmit['type'] ) {
            unset( $aSubmit['href'] );
        }
        
        return $aSubmit;
        
    }    
    
    /**
     * Print out the contents in the front-end.
     * 
     * Alternatively you may use the content_{instantiated class name} method.
     * @return      string      The content output.
     */
    public function content( $sContent, $aArguments, $aFormData ) {
        
        return $sContent
            . getWPGitHubButton( 
                array( 
                    // the plugin output function needs the 'title' key, not title_attribute
                    'title' => isset( $aFormData['title_attribute'] ) 
                        ? $aFormData['title_attribute'] 
                        : '',
                )
                + $aFormData 
                + $aArguments 
            )
            ;

    }
        
}