<?php
/**
 * Description of developerimagesMain
 *
 * @author Andrew Killen
 */
class developerimagesMain{
    /*
     * the name of the option in the options table
     */
    protected $option_name = "dev_images_destination";
    /*
     * the option is saved in here!
     */
    protected $option = "";
     /**
     * The unique instance of the plugin.
     *
     * @var instance
     */
    private static $instance;
 
    /**
     * Gets an instance of our plugin.
     *
     * @return instance
     */
    final public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    private function __construct() {      
        /*
         * If there is a CONSTANT defined in wp-config.php it will use that.
         * Otherwise it will use the saved option or setup a new one in the 
         * customizer
         */
       if(! defined('DEV_IMAGES_DESTINATION') ){
            add_action( 'customize_register', array($this, 'customize_register') );
            $this->option = get_option($this->option_name);
       } else {
            $this->option = untrailingslashit( DEV_IMAGES_DESTINATION );
       }
       
       add_action('wp_enqueue_scripts', array($this, "scripts") );      
    }
    /**
     * Add the section, settings and controller to allow users to update the settings
     * inside the customizer
     * 
     * @param object $wp_customize
     */
    public function customize_register($wp_customize){        
       $wp_customize->add_section( 'devimages', array( 
           'title'      =>__(  "Developer Images", 'devimages' ),
           'description'=>__(  "Repoint images and media to another domain when loading a page.  Ideal if you have a production db on your local machine and want to see images in the design", 'devimages' ),
       ));       
       $wp_customize->add_setting( $this->option_name, array(
		'default'           => get_bloginfo('url'),
                'sanitize_callback' => array($this, 'url_sanatizer' ),
                'transport'         => 'postMessage',	
                'type'              => 'option'
	) );       
       $wp_customize->add_control(new WP_Customize_Control( $wp_customize, 
                'devimages_url_control', 
                array(
                    'label'    => __( 'Set Destination URL', 'devimages' ),
                    'description'=>__( 'Enter the URL of the domain you want to redirect images to, i.e. https://www.thewpcrowd', 'devimages' ),
                    'section'  => 'devimages',
                    'settings' => $this->option_name,
                    'type'     => 'text',		
                    'priority' => 1,                    
                )
            ) );     
    }
    /**
     *  Make sure that the URL is a URL and get rid of any trailing slash.
     * @param string $value
     * @return string
     */
    public function url_sanatizer($value){                
	return untrailingslashit( filter_var($value, FILTER_SANITIZE_URL) );    
    }
    
    /**
     * Load the image changer script in the foot and load the settings it will
     * use to know the existing domain and new destination domain.
     */
    public function scripts(){        
        wp_enqueue_script('changer',  plugins_url( "js/script.js", __FILE__ ) , array('jquery'), null, 1 );

        $args = array(
                'domain' => untrailingslashit(get_bloginfo('url') ),
                'destination' => $this->option
                );
        wp_localize_script( 'changer', 'devimg', $args );        
    }
}
