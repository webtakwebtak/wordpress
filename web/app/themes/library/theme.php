<?php
namespace Library;

/**
 * Add common WordPress theme support tags
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 */
class Theme
{
    /**
     * ThemeSupportExtend constructor.
     */
    public function __construct()
    {
        //add bundje for js/css
        add_action( 'wp_enqueue_scripts', array( $this, 'theme_enqueue_scripts' ));
        
        //theme support
        add_action('init',  array( $this,'addSupport' ));
        
        //Images
        add_filter( 'intermediate_image_sizes_advanced', array( $this, 'remove_default_images' ));
        add_action( 'after_setup_theme', array( $this, 'add_image_sizes') );
        add_filter( 'image_size_names_choose', array( $this, 'choose_on_insert') );
        add_action('after_setup_theme', array( $this,'default_image_size'));
        add_filter('max_srcset_image_width', create_function('', 'return 1;'));
        add_filter( 'image_send_to_editor', array( $this,'add_custom_data_attribute'), 10, 8 );
        add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_zero'); 
        
        //remove widget
        add_action( 'wp_network_dashboard_setup', array( $this,'dweandw_remove'), 20 );
        add_action( 'wp_user_dashboard_setup',array( $this,'dweandw_remove'), 20 );
        add_action( 'wp_dashboard_setup',array( $this,'dweandw_remove'), 20 );
        
        //remove update links
        remove_action( 'load-update-core.php', array( $this,'wp_update_plugins') );
        add_filter('pre_site_transient_update_core', array( $this,'remove_core_updates'));
        add_filter('pre_site_transient_update_plugins', array( $this,'remove_core_updates'));
        add_filter('pre_site_transient_update_themes', array( $this,'remove_core_updates'));
        
        //ajax
        add_action( 'wp_ajax_my_action', array( $this, 'my_action' ));
        add_action( 'wp_ajax_nopriv_my_action', array( $this, 'my_action' ));
    }

    public function remove_core_updates(){
        global $wp_version;
        return(object) array('last_checked'=> time(),'version_checked'=> $wp_version);
    }
    
    public function dweandw_remove() {
        remove_meta_box( 'dashboard_primary', get_current_screen(), 'side' );
    }
    
    public function remove_default_images( $sizes ) {
        unset( $sizes['small']); // 150px
        unset( $sizes['medium']); // 300px
        unset( $sizes['large']); // 1024px
        unset( $sizes['medium_large']); // 768px
        return $sizes;
    }
    
    public function add_image_sizes() {
        add_image_size( 'xs', 50, '', false );
        add_image_size( 'sm', 540, '', false );
        add_image_size( 'md', 720,  '',false );
        add_image_size( 'lg', 960,  '',false);
        add_image_size( 'xl', 1140,  '',false );
    }
    
    public function choose_on_insert( $sizes ) {
        return array_merge( $sizes, array(
            'md' => __('Medium'),
            'xs' => __('Extra small'),
        ) );
    }
    
    public function default_image_size() {
        update_option('image_default_size', 'xs' );  
    }

    public function addSupport()
    {
        add_post_type_support('page', 'excerpt');
        add_theme_support('post-thumbnails');
    }
  
    function add_custom_data_attribute( $html, $id, $caption, $title, $align, $url, $size, $alt ){
        if( $id > 0 ){
            $small      = wp_get_attachment_image_src($id, 'xs'); // get media full size url
            $img_size   = wp_get_attachment_image_src($id, 'full'); // get media full size url
            $data .= sprintf( ' data-media-width="%s" ', $img_size[1] ); // get original width
            $data .= sprintf( ' data-media-height="%s" ', $img_size[2] ); // get original height
            $html = str_replace("size-full","", $html ); // replace szie-full
            $html = str_replace( $img_size[0], $small[0], $html ); // replace and add custom attributes
            $html = str_replace( "<img src", "<img{$data}src", $html ); // replace and add custom attributes
            
        }
        return $html;
    }
    
    
    public function theme_enqueue_scripts() {
        wp_enqueue_script( 'bundle', get_stylesheet_directory_uri() . '/assets/dist/js/bundle.js','', 1, false );
        wp_localize_script( 'bundle', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) ); 
    }
    
    public function my_action() {
        $whatever = intval( $_POST['whatever'] );
        $whatever += 10;
        echo $whatever;
        wp_die();
    }
}

new \Library\Theme;
