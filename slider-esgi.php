<?php
/*
Plugin Name: Slider ESGI
Plugin Uri: monplugin.me.com
Author: Adama - Florian - Nicolas
Author URI: alice.me.com
Text Domain: monpluginlg 
Description: mon premier plugin sur Wordpress
Version: 1.0.0
*/

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists('WSD') ){

    class WSD {
    	
    	/** @var string The plugin version number */
    	var $version = '1.0.0';
    	

    	
    	public function __construct() {
                // constants
                define( 'WSD_PATH',$path );
                
                // vars
                
                $this->basename = plugin_basename( __FILE__ );
                $this->path = plugin_dir_path( __FILE__ );
                $this->url = plugin_dir_url( __FILE__ );
                $this->slug = dirname($basename);
                $this->lib = $this->url.'lib/';
                
                
    	}
    	
    	
    		
    	public function initialize() {
                
                // hooks
                register_activation_hook( __FILE__, array( $this, 'install' ) );
                
                
                // File Include
                require_once (WSD_PATH . 'class/admin-slider.php');
                require_once (WSD_PATH . 'class/wsd-shortcode.php');

                
                // Action hooks
                add_action( 'admin_menu', array( $this, 'add_options_page' ) );
                add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style' ));
                add_action('init',	array($this, 'register_post_types'));
                add_action('admin_head', array('adminSlider','wsd_add_mce_button'));
                add_action('admin_footer', array('adminSlider', 'add_html_in_footer'), 11);
                
                add_action( 'wp_ajax_slider_form_submit', array('adminSlider','slider_form_submit' ));
                add_action( 'wp_ajax_slider_delete', array('adminSlider','slider_delete' ));
                add_action( 'wp_ajax_slider_preview', array('adminSlider','slider_preview' ));
                
                
                // Fliter hooks
                add_filter( 'plugin_action_links', array( $this, 'add_setting_link' ), 10, 2 );
                
                //shortcode
                add_shortcode( 'slideshow', array('wspShortcode','slideshow_fun') );

                
            }
            
            
            public function install(){
                
            }
            
            public function add_options_page(){
                
                add_menu_page('Slider Setting', 'Swiper Slider', 'manage_options','slide-short-code-list',array( 'adminSlider', 'displayShortcodeList'),'dashicons-slides');
                add_submenu_page( 'slide-short-code-list', 'Ajouter Slider', 'Ajouter Slider','manage_options', 'add-slider',array('adminslider','addSlider'));
               
            }
            
            
            /**
            * Enqueue scripts and styles
            */
            public function load_custom_wp_admin_style($hook){
                
                // include les fichiers JS et CSS
                

                $page_list = array('toplevel_page_slide-short-code-list','swiper-slider_page_add-slider','admin_page_edit-slider');
                
                if(in_array($hook, $page_list)){
                    // JS
                    wp_register_script('wsd_jquery', $this->lib.'js/jquery.min.js');
                    wp_enqueue_script('wsd_jquery');
                    
                    wp_register_script('wsd_bootstrap', $this->lib.'js/bootstrap.min.js');
                    wp_enqueue_script('wsd_bootstrap');
                    wp_register_script('wsd_datatables', $this->lib.'js/datatables.min.js');
                    wp_enqueue_script('wsd_datatables');
                    
                    wp_register_script('wsd_media_js', $this->lib.'js/main.js');
                    wp_enqueue_script('wsd_media_js');
                    
                    wp_enqueue_media();


                    // CSS
                    
                    
                    wp_register_style('wsd_bootstrap', $this->lib.'css/bootstrap.min.css');
                    wp_enqueue_style('wsd_bootstrap');
                    
                    wp_register_style('wsd_datatable', $this->lib.'css/datatables.min.css');
                    wp_enqueue_style('wsd_datatable');
                    
                    wp_register_style('wsd_fontawesome', '//use.fontawesome.com/releases/v5.8.1/css/all.css');
                    wp_enqueue_style('wsd_fontawesome');
                }
                
            }
            
            
    	
    	public function register_post_types() {
                
                // register post type 'wsd-slider'
                register_post_type('wsd-slider', array(
                        'labels'			=> array(
                            'name'					=> __( 'Slider ESGI', 'slider-esgi' ),
                            'singular_name'			=> __( 'Slider esgi', 'slider-esgi' ),
                            'add_new'				=> __( 'Ajouter' , 'slider-esgi' ),
                            'add_new_item'			=> __( 'Ajouter nouveau Slider' , 'slider-esgi' ),
                            'edit_item'				=> __( 'Edit Slider' , 'slider-esgi' ),
                            'new_item'				=> __( 'Nouveau Slider' , 'slider-esgi' ),
                            'view_item'				=> __( 'Voir Slider', 'slider-esgi' ),
                            'search_items'			=> __( 'Rechercher Slider', 'slider-esgi' ),
                            'not_found'				=> __( 'Pas de slider trouvé', 'slider-esgi' ),
                            'not_found_in_trash'	=> __( 'No Slider found in Trash', 'slider-esgi' ), 
                        ),
                        'public'			=> false,
                        'show_ui'			=> false,
                        '_builtin'			=> false,
                        'capability_type'	=> 'post',
                        'hierarchical'		=> false,
                        'rewrite'			=> false,
                        'query_var'			=> false,
                        'supports' 			=> array('title'),
                        'show_in_menu'		=> false,
                ));
    		
    		
    		
    	}
            
          
            public function add_setting_link($links, $file){
                if ( $file == plugin_basename(dirname(__FILE__) . '/slider-esgi.php') ) {
                    $setting = '<a href="admin.php?page=slide-short-code-list" >' . __('Réglages','slider-esgi') . '</a>';
                    $about = '<a href="#"  target="_blank">' . __('A propos','slider-esgi') . '</a>';
                    array_unshift($links, $setting,$about);
                }
                return $links;
            }
    }

    $wsd = new WSD();
    $wsd->initialize();
}