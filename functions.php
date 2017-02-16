<?php
/**
 *
 * @author Mario Eichler | http://eichlersolutions.de
 * @package CaVita Bremen 2.0
 */

if (!isset($content_width)) $content_width = 770;

/**
 * upbootwp_setup function.
 *
 * @access public
 * @return void
 */
function upbootwp_setup() {

	require 'inc/general/class-Upbootwp_Walker_Nav_Menu.php';

	load_theme_textdomain('upbootwp', get_template_directory().'/languages');

	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'Bootstrap WP Primary' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'upbootwp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	)));


}

add_action( 'after_setup_theme', 'upbootwp_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function upbootwp_widgets_init() {
	register_sidebar(array(
		'name'          => __('Sidebar','upbootwp'),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action( 'widgets_init', 'upbootwp_widgets_init' );

function upbootwp_scripts() {
	wp_enqueue_script('bootstrap.js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js', array(), '3.0.3', true);
	wp_enqueue_script( 'upbootwp-jQuery', get_template_directory_uri().'/js/jquery.js',array(),'2.1.3',true);
	// wp_enqueue_script( 'upbootwp-basefile', get_template_directory_uri().'/js/bootstrap.min.js',array(),'1.1',true);
}
add_action( 'wp_enqueue_scripts', 'upbootwp_scripts' );


// Load css styles
function loadStyles() {
	wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css', array(), '3.0.3');

	wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), '4.4.0');

	wp_enqueue_style('googleFonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,600,300|Droid+Serif:400,400italic', false);

	wp_enqueue_style( 'style', get_template_directory_uri().'/style.min.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'loadStyles');


// Add gallery image size to images
add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
  add_image_size('gallery-images', 360, 240, true);
}


/**
 * upbootwp_less function.
 * Load less for development or even on the running website. If you want to use less just enable this function
 * @access public
 * @return void
 */
function upbootwp_less() {
//	printf('<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,600,300|Droid+Serif:400,400italic" rel="stylesheet" type="text/css">');
//	printf('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">');
//	printf('<link rel="stylesheet" type="text/less" href="%s" />', get_template_directory_uri().'/less/bootstrap.less?ver=1.1'); // raus machen :)
//	printf('<script type="text/javascript">var less=less||{};less.env="development";</script>'); // Entfernen, wenn fertig mit Entwicklung
//	printf('<script type="text/javascript" src="%s"></script>', get_template_directory_uri().'/js/less.js?ver=1.6.1');
	printf('<script src="https://maps.googleapis.com/maps/api/js"></script>');
}
// Enable this when you want to work with less
add_action('wp_head', 'upbootwp_less');



/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory().'/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory().'/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory().'/inc/jetpack.php';


/**
 * upbootwp_breadcrumbs function.
 * Edit the standart breadcrumbs to fit the bootstrap style without producing more css
 * @access public
 * @return void
 */
function upbootwp_breadcrumbs() {

	$delimiter = '&raquo;';
	$home = 'Home';
	$before = '<li class="active">';
	$after = '</li>';

	if (!is_home() && !is_front_page() || is_paged()) {

		echo '<ol class="breadcrumb">';

		global $post;
		$homeLink = get_bloginfo('url');
		echo '<li><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . '</li> ';

		if (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo $before . single_cat_title('', false) . $after;

		} elseif (is_day()) {
			echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
			echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;

		} elseif (is_month()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;

		} elseif (is_year()) {
			echo $before . get_the_time('Y') . $after;

		} elseif (is_single() && !is_attachment()) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $before . get_the_title() . $after;
			}

		} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;

		} elseif ( is_search() ) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;

		} elseif ( is_tag() ) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;

		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo ': ' . __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</ol>';

	}
}






/*
* Creating a function to create our Custom Post Type
*/

function custom_post_type_leistungen() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Leistungen', 'Post Type General Name', 'upbootwp' ),
		'singular_name'       => _x( 'Leistung', 'Post Type Singular Name', 'upbootwp' ),
		'menu_name'           => __( 'Leistungen', 'upbootwp' ),
		'all_items'           => __( 'Alle Leistungen', 'upbootwp' ),
		'view_item'           => __( 'Leistung anschauen', 'upbootwp' ),
		'add_new_item'        => __( 'Neue Leistung', 'upbootwp' ),
		'add_new'             => __( 'Neue Leistung hinzufuegen', 'upbootwp' ),
		'edit_item'           => __( 'Editiere Leistung', 'upbootwp' ),
		'update_item'         => __( 'Aktualisiere Leistung', 'upbootwp' ),
		'search_items'        => __( 'Suche Leistung', 'upbootwp' ),
		'not_found'           => __( 'Not Found', 'upbootwp' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'upbootwp' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __( 'leistungen', 'upbootwp' ),
		'description'         => __( 'Alle Leistungen der Praxis', 'upbootwp' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',

		'taxonomies'					=> array( 'category' ),
	);

	// Registering your Custom Post Type
	register_post_type( 'leistungen', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_type_leistungen', 0 );



/*
* Creating a function to create our Custom Post Type
*/

function custom_post_type_kurse() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Kurse', 'Post Type General Name', 'upbootwp' ),
		'singular_name'       => _x( 'Kurs', 'Post Type Singular Name', 'upbootwp' ),
		'menu_name'           => __( 'Kurse', 'upbootwp' ),
		'all_items'           => __( 'Alle Kurse', 'upbootwp' ),
		'view_item'           => __( 'Kurs anschauen', 'upbootwp' ),
		'add_new_item'        => __( 'Neuer Kurs', 'upbootwp' ),
		'add_new'             => __( 'Neuen Kurs hinzufuegen', 'upbootwp' ),
		'edit_item'           => __( 'Editiere Kurs', 'upbootwp' ),
		'update_item'         => __( 'Aktualisiere Kurs', 'upbootwp' ),
		'search_items'        => __( 'Suche Kurs', 'upbootwp' ),
		'not_found'           => __( 'Not Found', 'upbootwp' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'upbootwp' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __( 'kurse', 'upbootwp' ),
		'description'         => __( 'Alle Kurse der Praxis', 'upbootwp' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',

		'taxonomies'					=> array( 'category' ),
	);

	// Registering your Custom Post Type
	register_post_type( 'kurse', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_type_kurse', 0 );












