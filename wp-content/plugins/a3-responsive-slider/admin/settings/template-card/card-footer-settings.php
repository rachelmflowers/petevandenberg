<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Template Card Footer Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class A3_Responsive_Slider_Template_Card_Footer_Settings extends A3_Responsive_Slider_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'card-footer';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'a3_rslider_template_card_footer_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'a3_rslider_template_card_footer_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 3;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Card Footer Settings successfully saved.', 'a3_responsive_slider' ),
				'error_message'		=> __( 'Error: Card Footer Settings can not save.', 'a3_responsive_slider' ),
				'reset_message'		=> __( 'Card Footer Settings successfully reseted.', 'a3_responsive_slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
						
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $a3_responsive_slider_admin_interface;
		
		$a3_responsive_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $a3_responsive_slider_admin_interface;
		
		$a3_responsive_slider_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $a3_responsive_slider_admin_interface;
		
		$a3_responsive_slider_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'card-footer',
			'label'				=> __( 'Card Footer', 'a3_responsive_slider' ),
			'callback_function'	=> 'a3_responsive_sider_template_card_footer_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $a3_responsive_slider_admin_interface;
		
		$output = '';
		$output .= $a3_responsive_slider_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
				
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' 		=> __( 'Card Footer Settings', 'a3_responsive_slider' ),
                'type' 		=> 'heading',
           	),			
			array(  
				'name' 		=> __( 'Card Footer Padding', 'a3_responsive_slider' ),
				'id' 		=> 'card_footer_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'card_footer_padding_top',
	 										'name' 		=> __( 'Top', 'a3_responsive_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'card_footer_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'a3_responsive_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'card_footer_padding_left',
	 										'name' 		=> __( 'Left', 'a3_responsive_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
											
									array( 
											'id' 		=> 'card_footer_padding_right',
	 										'name' 		=> __( 'Right', 'a3_responsive_slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
	 							)
			),
			array(  
				'name' 		=> __( 'Card Footer Background Colour', 'a3_responsive_slider' ),
				'desc' 		=> __( 'Default', 'a3_responsive_slider' ) . ' [default_value]',
				'id' 		=> 'card_footer_background_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			
			array(  
				'name' 		=> __( 'Card Footer Top Border Type', 'a3_responsive_slider' ),
				'id' 		=> 'card_footer_top_border_type',
				'class' 	=> 'card_footer_top_border_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'cog_border',
				'checked_value'		=> 'cog_border',
				'unchecked_value'	=> 'manual_border',
				'checked_label'		=> __( 'Cog Border', 'a3_responsive_slider' ),
				'unchecked_label' 	=> __( 'Manual Border', 'a3_responsive_slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'card_footer_top_border_manual_container',
           	),
			array(  
				'name' 		=> __( 'Card Footer Top Border', 'a3_responsive_slider' ),
				'id' 		=> 'card_footer_top_border',
				'type' 		=> 'border_styles',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Card Footer Shadow', 'a3_responsive_slider' ),
				'id' 		=> 'card_footer_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 1, 'h_shadow' => '0px' , 'v_shadow' => '-3px', 'blur' => '2px' , 'spread' => '0px', 'color' => '#DBDBDB', 'inset' => '' )
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	
	if ( $("input.card_footer_top_border_type:checked").val() == 'cog_border') {
		$(".card_footer_top_border_manual_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".card_footer_top_border_manual_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.card_footer_top_border_type', function( event, value, status ) {
		$(".card_footer_top_border_manual_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".card_footer_top_border_manual_container").slideUp();
		} else {
			$(".card_footer_top_border_manual_container").slideDown();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
}

global $a3_responsive_sider_template_card_footer_settings;
$a3_responsive_sider_template_card_footer_settings = new A3_Responsive_Slider_Template_Card_Footer_Settings();

/** 
 * a3_responsive_sider_template_card_footer_settings_form()
 * Define the callback function to show subtab content
 */
function a3_responsive_sider_template_card_footer_settings_form() {
	global $a3_responsive_sider_template_card_footer_settings;
	$a3_responsive_sider_template_card_footer_settings->settings_form();
}

?>