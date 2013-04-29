<?php
/*
Plugin Name: Nivo Slider Widget
Plugin URI: http://#
Description: A Nivo Slider Widget plugin.
Version: 1.0
Author: the Batman(Nedelin Yordanov) real
Author URI: #
*/	

	
	
	class NivoSliderWidget extends WP_Widget{
		
		public function __construct(){
			parent::__construct(
				'nivosliderwidget',
				'Nivo Slider Widget',
				array( 'description' => __( 'Create a custom Nivo slideshow with this widget!', 'text_domain' ), )
			);
		
		}
		
		public function widget($args, $instance){
			extract($args);
			$imgurl = apply_filters( 'widget_imgurl', $instance['imgurl'] );
			
			
			$urls = explode(", ", $imgurl);
			echo $before_widget;
			
			$imgs_array = new ArrayObject();
			
			foreach($urls as $url)
				$imgs_array->append( new NivoSliderObj($url, "A title"));
			
			echo "<div id='slider' class='nivoSlider'>";
			
			foreach($imgs_array as $img)
				echo "<img src='$img->src' alt='' title=' ' /> ";
			
			echo "</div>";
			
			echo $after_widget;
		}
		
		public function form($instance){
			
			
			if ( isset( $instance[ 'imgurl' ] ) ) {
				$imgurl = $instance[ 'imgurl' ];
			} 
			else $imgurl = "";
		
			echo '<input id="widget_upload_image_button"  value="Open Image Gallery" type="button" class="button"/>';
			?>
			</br>
			<label for="<?php echo $this->get_field_id( 'imgurl' ); ?>" > <?php _e( 'Images:' ); ?></label> 
			
			<textarea class="widefat" data-name="nivoSlider-widget" rows="20" cols="20" id="<?php echo $this->get_field_id( 'imgurl' ); ?>" name="<?php echo $this->get_field_name( 'imgurl' ); ?>"  type="text"> <?php echo $imgurl; ?></textarea>
			
			<?php
		}
	
		public function update($new_instance, $old_instance){
			$instance = array();
			
			$instance['imgurl'] = strip_tags( $new_instance['imgurl']);
			return $instance;
		}
	
	}

	
	class NivoSliderObj{
	
		var $title;
		var $src;
		
		function __construct($src, $title=""){
			$this->title = $title;
			$this->src = $src;
		}
	}
	
// REGISTER STYLE AND SCRIPTS

	function register_frontend_styles_scripts(){
		wp_register_style("nivo_default_css", WP_PLUGIN_URL."/nivo-slider-widget/slider_css/default.css");
		wp_register_style("nivo_css", WP_PLUGIN_URL."/nivo-slider-widget/slider_css/nivo-slider.css");
		wp_enqueue_style("nivo_default_css");
		wp_enqueue_style("nivo_css");
		
		wp_register_script("nivo_js", WP_PLUGIN_URL."/nivo-slider-widget/slider_js/jquery.nivo.slider.js", array('jquery'));
		wp_register_script("brad_js", WP_PLUGIN_URL."/nivo-slider-widget/slider_js/brad.js", array('jquery'));
		wp_enqueue_script("nivo_js");
		wp_enqueue_script("brad_js");
	}

	add_action('wp_enqueue_scripts', register_frontend_styles_scripts());
	
	function wptuts_options_enqueue_scripts() {  
			
		wp_register_script( 'wptuts-upload', get_template_directory_uri() .'/wptuts-options/js/wptuts-upload.js', array('jquery','media-upload','thickbox') );  
  
		wp_enqueue_script('thickbox');  
		wp_enqueue_style('thickbox');  

		wp_enqueue_script('media-upload');  
		wp_register_script('sss-media-uploader-script', WP_PLUGIN_URL . '/nivo-slider-widget/slider_js/bradly.js', array('jquery', 'media-upload', 'thickbox'));
		
		wp_enqueue_script('sss-media-uploader-script');
   
	}  
	add_action('admin_enqueue_scripts', 'wptuts_options_enqueue_scripts'); 
	
	
	
// REGISTER CUSTOM WIDGETS	
	function NivoSliderWidgetRegister(){
     register_widget( 'NivoSliderWidget' );
	}

	add_action( 'widgets_init', 'NivoSliderWidgetRegister');
	
	
	register_sidebar(array(
		'name' => __('Page Slider'),
		'id' => 'landing_slide',
		'before_widget' => '<div class="slider-wrapper theme-default">',
		'after_widget' => '</div>'
	));
	
?>