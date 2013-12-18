<?php
require_once(ABSPATH . WPINC . '/rss.php');
global $ssc_options;
$options = $ssc_options;
add_action( 'init', 'ssc_init_meta_boxes', 9999 );
add_action( 'init', 'ssc_modify_roles' );
//add_action( 'init', 'ssc_register_menus' );
add_action( 'init', 'ssc_scripts_method', 0 );
add_action( 'init', 'ssc_custom_post_type' );
add_action( 'init', 'ssc_register_menus' );
add_action( 'init', 'ssc_register_sidebars' );
add_action( 'init', 'ssc_taxonomy_init', 0 );
//add_action( 'admin_init', 'ssc_admin_settings_api_init' );
add_action( 'admin_head', 'ssc_admin_logo' );
add_action( 'login_head', 'ssc_login_head' );
add_action( 'wp_dashboard_setup', 'ssc_dashboard_widgets' );
add_action( 'wp_user_dashboard_setup', 'ssc_user_dashboard' );
add_action( 'admin_head', 'admin_css' );
add_action( 'wp_dashboard_setup', 'ssc_add_dashboard_widgets' );
add_filter( 'admin_footer_text', 'ssc_admin_footer' );
add_filter( 'cmb_meta_boxes', 'ssc_meta_boxes' );
add_filter( 'the_content', 'do_shortcode', 11 );
add_filter( 'widget_text', 'do_shortcode' );
/**/
/*
 * Permissions
 */
function ssc_modify_roles(){
	global $ssc_options;
	$options = $ssc_options;
	if ( array_key_exists('permissions', $options ) ) {
  	foreach ($options['permissions'] as $role => $value ) {
	  	$cur_role = get_role( $role );
		  foreach ( $value as $action => $caps ) {
			  if ( $action == 'add' ) {
				  foreach ($caps as $cap) {
					  $cur_role->add_cap( $cap );
				  }
			  }
			  if ( $action == 'remove' ) {
				  foreach ($caps as $cap ) {
					  $cur_role->remove_cap( $cap );
	  			}
		  	}
		  }
	  }
	}
}
function ssc_init_meta_boxes(){
	if( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( get_stylesheet_directory() . '/lib/metabox/init.php' );
	}
}
/**/
function ssc_meta_boxes( $meta_boxes ) {
	global $ssc_options;
	$options = $ssc_options;
	$prefix = '_ssc_';
	if ( array_key_exists( 'metaboxes', $options ) ) {
  	foreach ($options['metaboxes'] as $metabox) {
	  	$meta_boxes[] = array(
		  	'id' => $metabox['id'],
			  'title' => $metabox['title'],
			  'pages' => $metabox['pages'],
			  'context' => $metabox['context'],
			  'priority' => $metabox['priority'],
			  'show_names' => $metabox['show_names'],
			  'fields' => $metabox['fields'],
			);
    }
	}
	/**/
	return $meta_boxes;
}

function ssc_register_sidebars() {
	global $ssc_options;
	$options = $ssc_options;
	if ( array_key_exists('sidebars', $options ) ) {
  	foreach ($options['sidebars'] as $sidebar) {
	  	register_sidebar( array(
        'name' => __( $sidebar['title'], $sidebar['machine_name'] ),
        'id' => $sidebar['id'],
        'description' => __( $sidebar['description'] ),
        'before_widget' => '<article id="%1$s" class="widget %2$s">',
        'after_widget' => '</article>',
        'before_title' => '<h2 class="'.$sidebar['machine_name'].'">',
        'after_title'   => '</h2>',
		    )
	    );
	  }
	}
}	
/**/
//Featured Pictures for Posts
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

function ssc_scripts_method() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'flexslider', get_stylesheet_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'datetime', get_stylesheet_directory_uri() . '/js/jonthornton-jquery-timepicker-83399f0/jquery.timepicker.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), false, true );
	//wp_enqueue_script('modernizr', get_stylesheet_directory_uri() . '/js/modernizr.js', array());
}	
/**/
/*
 * Footer Text
 */
function ssc_admin_footer () {
	global $ssc_options;
	$options = $ssc_options;
	echo $options['admin']['footer']['text'];
}
/**/
/*
 * Custom Post Types
 */
function ssc_custom_post_type() {
	global $ssc_options;
	$options = $ssc_options;
	if ( array_key_exists('post_types', $options ) ) {
  	foreach ( $options['post_types'] as $post_type ) {
	  	$args = array(
		  	'labels' => array(
			  	'name' => __( $post_type['labels']['name'] ),
				  'singular_name' => __( $post_type['labels']['singular_name'] ),
				  ),
  			'public' => $post_type['public'],
	  		'has_archive' => $post_type['has_archive'],
		  	);
  		if ( is_array( $post_type['taxonomies'] ) ) {
	  		$args['taxonomies'] = $post_type['taxonomies'];
  	  }
  	  /**/
  	  if ( is_array( $post_type['description'] ) ) {
			  $args['description'] = $post_type['description'];
    	}
    	/**/
  	 	if ( is_array( $post_type['supports'] ) ) {
  	  	$args['supports'] = $post_type['supports'];
  	  }
  	  if ( is_array( $post_type['map_meta_cap'] ) ) {
  	  	$args['map_meta_cap'] = $post_type['map_meta_cap'];
  	  }
  	  if ( is_array( $post_type['capability_type'] ) ) {
  	  	$args['capability_type'] = $post_type['capability_type'];
  	  }
  	  if ( is_array( $post_type['capabilities'] ) ) {
  	  	$args['capabilities'] = $post_type['capabilities'];
  	  }
	  register_post_type( $post_type['machine_name'], $args	);
	  }
	}
}
/*
 * registers menus
 */
function ssc_register_menus() {
		global $ssc_options;
	$options = $ssc_options;
	if ( array_key_exists( 'menus', $options ) ) {
  	foreach ($options['menus'] as $menus) {
	  	register_nav_menus(
		  	array(
			  	$menus['machine_name'] => __( $menus['title'] ),
				  )
			  );
	  }
	}
}
/**/
function ssc_taxonomy_init() {
	global $ssc_options;
	$options = $ssc_options;
	if ( array_key_exists( 'taxonomies', $options ) ) {
  	foreach ( $options['taxonomies'] as $tax ) {
      register_taxonomy (
      	//'menu_category',
    	  $tax['machine_name'],
    	  //'menu_item',
			  $tax['post_types'],
			  /**/
			  $tax['args']
			  /**/
        );
    }
	}
}
/**/
function ssc_login_head() {
		global $ssc_options;
	$options = $ssc_options;
	echo '
	<style>
		body.login, #login {
	  	background: #dedfdc;
	  }
	  body.login #login {
	  	padding-top:0px;
	  }
	  body.login #login h1 a {
		  background: url("'. get_stylesheet_directory_uri() .'/'.$options['logo']['image'].'") no-repeat scroll center top transparent;
		  height: '.$options['logo']['height'].';
		  width: '.$options['logo']['width'].';
	}
	</style>
	';
}

function ssc_admin_logo() {
	global $ssc_options;
	$options = $ssc_options;
	echo '<style type="text/css">
	  #wp-admin-bar-wp-logo>.ab-item .ab-icon { 
	    background-image: url('.get_stylesheet_directory_uri() .'/images/admin/' . $options['logo_admin']['image'] .') !important;
	    background-position: 0 0;
	   }
	  #header-logo { background-image: url('.get_stylesheet_directory_uri() .'/images/admin/' . $options['logo_admin']['image'] .') !important; }
	</style>';

}
/**/
/**
 * Dashboard Widget Functions
 */
/**
 * Gets all widget options, or only options for a specified widget if a widget id is provided.
 *
 * @param string $widget_id Optional. If provided, will only get options for that widget.
 * @return array An associative array
 */


function ssc_dashboard_widgets() {
	global $wp_meta_boxes;
	// Today widget
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	// Last comments
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	// Incoming links
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	// Plugins
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	// 
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	//
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
  unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
  unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

}

function ssc_user_dashboard() {
	remove_meta_box( 'dashboard_primary', 'dashboard-user', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard-user', 'normal' );
}
/*
// Add a widget in WordPress Dashboard
 */
function ssc_dashboard_widget_function() {
	// Entering the text between the quotes
	$namespace = 'ssc_admin_dashboard_widget';
	$current_user = wp_get_current_user();
	
	if ( strlen( $current_user->display_name > 0 ) ) {
		$name = $current_user->display_name;
	}
	elseif ( strlen( $current_user->user_firstname > 0 ) ) {
		$name = $current_user->user_firstname;
		if ( strlen( $current_user->user_lastname > 0 ) ) {
			$name = $name . ' ' . $current_user->user_lastname;
		}
	}
	else { 
	  $name = $current_user->user_login; 
	}
	/**/
	$form = '';
	
	$form = '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
	$form .= wp_nonce_field( 'support_request' );
	$form .= '<input type="hidden" name="' . $namespace .'-form" value="' . $namespace .'">';
	$form .= '<input type="hidden" name="admin_email" value="' .get_blog_option( 1, 'admin_email' ) . '">';
	$form .= '<p><label for="' . $namespace . '-name">' . __( 'Name', 'text_domain' ) . ': </label>';
	$form .= '<input type="text" name="' . $namespace . '-name" id="' . $namespace . '-name" value="' . $name . '" class="widefat"></p>';
	$form .= '<p><label for="' . $namespace . '-phone">' . __( 'Phone', 'text_domain' ) . ': </label>';
	$form .=    '<input type="text" name="' . $namespace . '-phone" id="' . $namespace . '-phone" class="widefat"></p>';
	$form .=    '<p><label for="' . $namespace . '-email">' . __( 'Email', 'text_domain' ) . ': </label>';
	$form .=    '<input type="text" name="' . $namespace . '-email" id="' . $namespace . '-email" value="' . $current_user->user_email . '" class="widefat"></p>';
	$form .=    '<p><label for="' . $namespace . '-subject">' . __( 'Support Issue', 'text_domain' ) . ': </label>';
	$form .=    '<input type="text" name="' . $namespace . '-subject" id="' . $namespace . '-subject" class="widefat"></p>';
	$form .=    '<p><label for="' . $namespace . '-message">' . __( 'Issue Details', 'text_domain' ) . ': </label>';
	$form .=    '<textarea name="' . $namespace . '-message" id="' . $namespace . '-message" class="widefat"></textarea></p>';
	$form .=    '<input type="submit" value="' . __( 'Submit Support Request', 'text_domain' ) . '" class="button button-primary">';
	$form .=    '</form>';
	    /**/    
	echo '<div class="' . $namespace . '"><ul><li>';
  if ( array_key_exists( $namespace.'-form', $_POST ) && $_POST[$namespace . '-form'] == $namespace ) {
    if ( check_admin_referer( 'support_request' ) ) {
    	$to = get_blog_option( 1, 'admin_email' );
    	$subject = "Support request: ". strip_tags( $subject );
    	$message = "You have received the following support request: \n";
    	$message .= "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ \n";
    	$message .= "User: ". strip_tags( $_POST[$namespace.'-name'] ) . "\n";
    	$message .= "Email: " . strip_tags( $_POST[$namespace . '-email'] ) . "\n";
    	$message .= "Phone: " . strip_tags( $_POST[$namespace . '-phone'] ) . "\n";
    	$message .= strip_tags( $message );
    	$headers = "From: " . strip_tags( $_POST[$namespace . '-name'] ) . "\r\n\\";

    	if ( wp_mail( $to, $subject, $message ) ) {
    		$output = '<p>The following support request was sent:</p>';
    		$output .= str_replace( "\n", '<br>', $message ); 
    		echo $output;
    	}
    }
  }
  else {
  	echo $form;
  }
	echo '';  
	echo '</li></ul></div>';
}


function ssc_dashboard_widget_brand_news() {
	$feed = array( 
		'url' => 'http://demos.scottsawyerconsulting.com/feed/',
		'title' => 'Updates from the Corner Deli',
		'items' => 5,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1
		);
	echo '<div class="ssc_admin_dashboard_widget">';
	echo wp_widget_rss_output( $feed );
	echo '</div>';
}
/* 
 * Debug Hooks
 */
function ssc_dashboard_widget_debug() {
	list_hooked_functions();
}


function prefix_dashboard_widget() {
    # get saved data
    if( !$widget_options = get_option( 'my_dashboard_widget_options' ) )
        $widget_options = array( );

    # default output
    $output = sprintf(
        '<h2 style="text-align:right">%s</h2>',
        __( 'Please, configure the widget ☝' )
    );
    
    # check if saved data contains content
    $saved_feature_post = isset( $widget_options['feature_post'] ) 
        ? $widget_options['feature_post'] : false;

    # custom content saved by control callback, modify output
    if( $saved_feature_post ) {
        $post = get_post( $saved_feature_post );
        if( $post ) {
            $content = do_shortcode( html_entity_decode( $post->post_content ) );
            $output = "<h2>{$post->post_title}</h2><p>{$content}</p>";
            $output .= '<div class="ssc_admin_dashboard_widget">';

	$output .= '</div>';

        }
    }
    echo "<div class='feature_post_class_wrap'>
        <label style='background:#ccc;'>$output</label>
    </div>
    ";
}

function prefix_dashboard_widget_handle() {
    # get saved data
    if( !$widget_options = get_option( 'my_dashboard_widget_options' ) )
        $widget_options = array( );
    # process update
    if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['my_dashboard_widget_options'] ) ) {
        # minor validation
        $widget_options['feature_post'] = absint( $_POST['my_dashboard_widget_options']['feature_post'] );
        # save update
        update_option( 'my_dashboard_widget_options', $widget_options );
    }
    # set defaults  
    if( !isset( $widget_options['feature_post'] ) )
        $widget_options['feature_post'] = '';
    echo "<p><strong>Available Pages</strong></p>
    <div class='feature_post_class_wrap'>
        <label>Title</label>";
    wp_dropdown_pages( array(
        'post_type'        => 'page',
        'selected'         => $widget_options['feature_post'],
        'name'             => 'my_dashboard_widget_options[feature_post]',
        'id'               => 'feature_post',
        'show_option_none' => '- Select -'
    ) );
    echo "</div>";
}
function ssc_add_dashboard_widgets() {
	wp_add_dashboard_widget( 'ssc_dashboard_widget_site_info', 'Manage Your Site', 'ssc_dashboard_widget_function' );
	    wp_add_dashboard_widget(
        'my_dashboard_widget', 
        'Featured Dashboard Page', 
        'prefix_dashboard_widget', 
        'prefix_dashboard_widget_handle'
    );
	wp_add_dashboard_widget( 'ssc_dashboard_widget_brand_news', 'Brand News', 'ssc_dashboard_widget_brand_news' );
	wp_add_dashboard_widget( 'ssc_dashboard_widget_debug', 'Available Hooks', 'ssc_dashboard_widget_debug');
}

// Custom WordPress Admin Color Scheme
function admin_css() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/admin.css" type="text/css" media="all" />';
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/js/jonthornton-jquery-timepicker-83399f0/jquery.timepicker.css" type="text/css" media="all" />';
}

function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}
?>