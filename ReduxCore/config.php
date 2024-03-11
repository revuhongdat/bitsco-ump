<?php

    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Iboss_Theme_Options' ) ) {

        class Iboss_Theme_Options {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'           => 'tp_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'       => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'    => $theme->get( '' ),
                    // Version that appears at the top of your panel
                    'menu_type'          => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'     => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'         => __( 'Theme Options', 'redux-framework-demo' ),
                    'page_title'         => __( 'Theme Options', 'redux-framework-demo' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'     => 'AIzaSyAs0iVWrG4E_1bG244-z4HRKJSkg7JVrVQ',
                    // Must be defined to add google fonts to the typography module

                    'async_typography'   => false,
                    // Use a asynchronous font on the front end or font string
                    'admin_bar'          => true,
                    // Show the panel pages on the admin bar
                    'global_variable'    => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'           => false,
                    // Show the time the page took to load, etc
                    'customizer'         => true,
                    // Enable basic customizer support

                    // OPTIONAL -> Give you extra features
                    'page_priority'      => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'        => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'   => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'          => '',
                    // Specify a custom URL to an icon
                    'last_tab'           => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'          => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'          => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'      => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'       => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'       => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export' => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'     => 60 * MINUTE_IN_SECONDS,
                    'output'             => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'         => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'           => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'        => false,
                    // REMOVE

                    // HINTS
                    'hints'              => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );


             

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
                }

            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
            }
            public function setSections() {


                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => __( 'Header', 'iboss' ),
                    'desc'   => __( 'All of setings for header on this theme.', 'iboss' ),
                    'icon'   => '',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        array(
                            'id'        => 'sitename',
                            'type'      => 'textarea',
                            'title'     => __('Information your company', 'iboss'),
                            'subtitle'  => __('Information or hotline', 'iboss')
                        ),    

                        array(
                            'id'       => 'logo-on',
                            'type'     => 'switch',
                            'title'    => __( 'Enable Image Logo', 'iboss' ),
                            'compiler' => 'bool',
                            // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'     => __( 'Do you want to enable image logo?', 'iboss' ),
                            'on'        => __('Enabled', 'iboss'),
                            'off'       => __('Disabled', 'iboss')
                        ),
                        array(
                            'id'    => 'logo-image',
                            'type'  => 'media',
                            'title' => __('Logo Image', 'iboss'),
                            'desc'  => __('Image that you want to use as logo.', 'iboss')
                        ),

                    )
              );

                $this->sections[] = array(
                    'title'  => __( 'Social', 'iboss' ),
                    'desc'   => __( 'List of Social Networking.', 'iboss' ),
                    'icon'   => '',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        array(
                            'id'        => 'facebook',
                            'type'      => 'text',
                            'title'     => __('Link social network Facebook ', 'iboss'),
                            'subtitle'  => __('', 'iboss')
                        ),        
                        array(
                            'id'       => 'google',
                            'type'     => 'text',
                            'title'    => __( 'Link social network Google ++ ', 'iboss' ),
                            'subtitle' => __( '', 'iboss' ),
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'youtube',
                            'type'     => 'text',
                            'title'    => __( 'Link social network Youtube', 'iboss' ),
                            'subtitle' => __( '', 'iboss' ),
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'twitter',
                            'type'     => 'text',
                            'title'    => __( 'Link social network twitter', 'iboss' ),
                            'subtitle' => __( '', 'iboss' ),
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'rss',
                            'type'     => 'text',
                            'title'    => __( 'Link rss feed', 'iboss' ),
                            'subtitle' => __( '', 'iboss' ),
                            'default'  => ''
                        ),                                                
                    )
                );
                $this->sections[] = array(
                    'title'  => __( 'Footer', 'iboss' ),
                    'desc'   => __( 'All of setings for Footer on this theme.', 'iboss' ),
                    'icon'   => '',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
                        array(
                            'id'        => 'copyright',
                            'type'      => 'textarea',
                            'title'     => __('Your Company', 'iboss'),
                            'subtitle'  => __('Copyright by', 'iboss')
                        ),        

                        array(
                            'id'       => 'address',
                            'type'     => 'textarea',
                            'title'    => __( 'Contact', 'iboss' ),
                            'subtitle' => __( 'Input address, email, telephone ...', 'iboss' ),
                            'default'  => ''
                        ),
                        array(
                            'id'       => 'design',
                            'type'     => 'textarea',
                            'title'    => __( 'Design', 'iboss' ),
                            'subtitle' => __( 'Input design by...', 'iboss' ),
                            'default'  => ''
                        ),
                    )
                );
            }
        }

        global $reduxConfig;
        $reduxConfig = new Iboss_Theme_Options();
    }
