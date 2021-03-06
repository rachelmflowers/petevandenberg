<?php
class A3_Responsive_Slider_Mobile_Display
{	
	public static function mobile_dispay_slider( $slide_items = array(), $is_used_mobile_skin = false , $slider_settings = array() ) {
		
		//require_once A3_RESPONSIVE_SLIDER_DIR . '/includes/mobile_detect.php';
		$device_detect = new Mobile_Detect();
			
		$slider_template = 'template-mobile';
		$templateid = 'template_mobile';
			
		// Return empty if it does not have any slides
		if ( ! is_array( $slide_items ) || count( $slide_items ) < 1 ) return '';
		
		extract( $slider_settings );
		
		$caption_fx_out = 'fadeOut';
		$caption_fx_in = 'fadeIn';
		
		$unique_id = rand( 100, 1000 );
				
		$overlay_class = '#cycle-template-mobile-overlay-' . $unique_id;
		
		$slider_transition_data 		= A3_Responsive_Slider_Functions::get_slider_transition( $slider_transition_effect, $slider_settings );
		$fx 							= 'scrollHorz';
		$timeout 						= $slider_transition_data['timeout'];
		$speed 							= $slider_transition_data['speed'];
		
		if ( $support_youtube_videos == 1 ) {
			$timeout 						= $yt_slider_timeout*1000;
			$speed 							= $yt_slider_speed*1000;
			$delay 							= 0;
		}
						
		ob_start();
	?>
    <div class="a3-slider-card-container-mobile a3-slider-card-container-basic-mobile-skin ">
    
    <div id="a3-rslider-container-<?php echo $unique_id; ?>" class="a3-rslider-container a3-rslider-<?php echo $slider_template; ?>" slider-id="<?php echo $unique_id; ?>" is-responsive="1" is-tall-dynamic="0" >
    	<div style="height:150px" id="a3-cycle-slideshow-<?php echo $unique_id; ?>" class="cycle-slideshow a3-cycle-slideshow"
        	data-cycle-fx="<?php echo $fx; ?>"
            data-cycle-paused=true
            data-cycle-auto-height=container
            
            data-cycle-center-horz=true
            
            data-cycle-swipe=true
            
            data-cycle-caption="> .cycle-caption-container .cycle-caption"
            data-cycle-caption-template="{{slideNum}} / {{slideCount}}"
            data-cycle-caption-plugin="caption2"
            
            data-cycle-loader=true
        >

        	<div class="cycle-caption-container">
            	<div class="cycle-caption-inside">
            		<div class="cycle-caption-overlay"></div>
                	<div class="cycle-caption"></div>
                </div>
            </div>
            
		<?php foreach ( $slide_items as $item ) { ?>
        <?php
				if ( $item->is_video == 1 ) continue;
				if ( trim( $item->img_url ) == '' ) continue;
				
				$img_title = '';
				if ( trim( $item->img_title ) != '' ) {
					if ( trim( $item->img_link ) != '' ) {
						if ( stristr( $item->img_link, 'http' ) === FALSE && stristr( $item->img_link, 'https' ) === FALSE )
							$item->img_link = 'http://' . $item->img_link;
						$img_title = '<div class="cycle-title"><a href="'. trim( $item->img_link ) .'">'. trim( stripslashes( $item->img_title ) ) .'</a></div>';
					} else {
						$img_title = '<div class="cycle-title">'.trim( stripslashes( $item->img_title ) ).'</div>';	
					}
				}
				
				$img_description = '';
				if ( trim( $item->img_description ) != '' ) {
					$img_description = '<div class="cycle-description">' . A3_Responsive_Slider_Functions::limit_words( stripslashes( $item->img_description ), $caption_lenght, '...' ) . '</div>';
				}
		?>
                <img src="<?php echo esc_attr( $item->img_url ); ?>" title="" alt="" style="position:absolute; visibility:hidden; top:0; left:0;" />
            
        <?php } ?>
        </div>
    	<div class="a3-slider-bg"></div>
    </div>
    
    </div>
    
    <?php
		$slider_output = ob_get_clean();
		
		return $slider_output;
		
	}
		
}
?>