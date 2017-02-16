<?php
// allow SVG upload
/*
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// use Font Awesome
function enqueue_load_fa() {
    wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' ); 
}
add_action( 'wp_enqueue_scripts', 'enqueue_load_fa' );
*/


// add my css
function wpb_adding_scripts() {	
	//wp_register_script('pace-js',get_stylesheet_directory_uri().'/js/pace.js');
    wp_register_style('riehm-style',get_stylesheet_directory_uri().'/scss/riehm.css');
	wp_enqueue_style(array('riehm-style'));
}

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' ); 


// custom modules
add_action( 'widgets_init', 'my_widget_init' );

function my_widget_init() {
    register_widget( 'Spoke_Tribe__Events__List_Widget' );
}

class Spoke_Tribe__Events__List_Widget extends WP_Widget {
	private static $limit = 5;
	public static $posts = array();

	public function __construct( $id_base = '', $name = '', $widget_options = array(), $control_options = array() ) {
		$widget_options = array_merge(
			array(
				'classname'   => 'spoke-tribe-events-list-widget',
				'description' => esc_html__( 'Riehm widget that displays upcoming events.', 'the-events-calendar' ),
			),
			$widget_options
		);

		$control_options = array_merge( array( 'id_base' => 'spoke-tribe-events-list-widget' ), $control_options );

		$id_base = empty( $id_base ) ? 'spoke-tribe-events-list-widget' : $id_base;
		$name    = empty( $name ) ? esc_html__( 'Riehm Events List', 'the-events-calendar' ) : $name;

		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	// The main widget output function.
	
	public function widget( $args, $instance ) {
		return $this->widget_output( $args, $instance );
	}

	// The main widget output function (called by the class's widget() function).
	
	public function widget_output( $args, $instance, $template_name = 'widgets/list-widget' ) {
		global $wp_query, $tribe_ecp, $post;

		$no_upcoming_events = true;
		
		$widgetID = $args['widget_id'];		
		$excerpt = get_field('show_excerpt', 'widget_' . $widgetID);

		$instance = wp_parse_args(
			$instance, array(
				'limit' => self::$limit,
				'title' => '',
			)
		);

		
		extract( $args, EXTR_SKIP );
		
		//print_r($args[widget_id]);
		extract( $instance, EXTR_SKIP );

		// Temporarily unset the tribe bar params so they don't apply
		$hold_tribe_bar_args = array();
		foreach ( $_REQUEST as $key => $value ) {
			if ( $value && strpos( $key, 'tribe-bar-' ) === 0 ) {
				$hold_tribe_bar_args[ $key ] = $value;
				unset( $_REQUEST[ $key ] );
			}
		}

		$title = apply_filters( 'widget_title', $title );

		self::$limit = absint( $limit );

		if ( ! function_exists( 'tribe_get_events' ) ) {
			return;
		}

		self::$posts = tribe_get_events(
			apply_filters(
				'tribe_events_list_widget_query_args', array(
					'eventDisplay'   => 'list',
					'posts_per_page' => self::$limit,
					'tribe_render_context' => 'widget',
					'featured' => empty( $instance['featured_events_only'] ) ? false : (bool) $instance['featured_events_only'],
				)
			)
		);

		// If no posts, and the don't show if no posts checked, let's bail
		if ( empty( self::$posts ) && $no_upcoming_events ) {
			return;
		}

		echo $before_widget;
		
		do_action( 'tribe_events_before_list_widget' );

		if ($excerpt){
			
		}
		
		if ( $title ){
			do_action( 'tribe_events_list_widget_before_the_title' );
			echo $before_title . $title . $after_title;
			do_action( 'tribe_events_list_widget_after_the_title' );
		}

		// Include template file
		include Tribe__Events__Templates::getTemplateHierarchy( $template_name );
		do_action( 'tribe_events_after_list_widget' );

		echo $after_widget;
		wp_reset_query();

		$jsonld_enable = isset( $jsonld_enable ) ? $jsonld_enable : true;

		
		$jsonld_enable = apply_filters( 'tribe_events_' . $this->id_base . '_jsonld_enabled', $jsonld_enable );

		$jsonld_enable = apply_filters( 'tribe_events_widget_jsonld_enabled', $jsonld_enable );

		if ( $jsonld_enable ) {
			Tribe__Events__JSON_LD__Event::instance()->markup( self::$posts );
		}

		// Reinstate the tribe bar params
		if ( ! empty( $hold_tribe_bar_args ) ) {
			foreach ( $hold_tribe_bar_args as $key => $value ) {
				$_REQUEST[ $key ] = $value;
			}
		}
	}

	// The function for saving widget updates in the admin section.
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = $this->default_instance_args( $new_instance );

		$instance['title']                = strip_tags( $new_instance['title'] );
		$instance['limit']                = $new_instance['limit'];
		$instance['no_upcoming_events']   = $new_instance['no_upcoming_events'];
		$instance['featured_events_only'] = $new_instance['featured_events_only'];

		if ( isset( $new_instance['jsonld_enable'] ) && $new_instance['jsonld_enable'] == true ) {
			$instance['jsonld_enable'] = 1;
		} else {
			$instance['jsonld_enable'] = 0;
		}

		return $instance;
	}

	//Output the admin form for the widget.
	
	public function form( $instance ) {
		$instance  = $this->default_instance_args( $instance );
		$tribe_ecp = Tribe__Events__Main::instance();
		include( $tribe_ecp->pluginPath . 'src/admin-views/widget-admin-list.php' );
	}

	//elements are generated and set to their default value.
	
	protected function default_instance_args( array $instance ) {
		return wp_parse_args( $instance, array(
			'title'                => esc_html__( 'Upcoming Events', 'the-events-calendar' ),
			'limit'                => '5',
			'no_upcoming_events'   => false,
			'featured_events_only' => false,
		) );
	}
}
	
// create my own module
function DS_Custom_Modules(){
 if(class_exists("ET_Builder_Module")){
 include("ds-custom-modules.php");
 }
}

function Prep_DS_Custom_Modules(){
 global $pagenow;

$is_admin = is_admin();
 $action_hook = $is_admin ? 'wp_loaded' : 'wp';
 $required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
 $specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
 $is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
 $is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
 $is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import']; 
 $is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
 add_action($action_hook, 'DS_Custom_Modules', 9789);
 }
}
Prep_DS_Custom_Modules();
	
?>