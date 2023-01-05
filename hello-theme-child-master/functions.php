<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */

@ini_set( 'post_max_size', '254M');
@ini_set( 'max_execution_time', '3000' );


function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.1'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

function chocolat_style() {
	wp_enqueue_style('chocolat-style', get_stylesheet_directory_uri() . '/chocolat.css', false);
}
add_action( 'wp_enqueue_scripts', 'chocolat_style', 20 );

function chocolat_script() {
	wp_enqueue_script( 'chocolat-script', get_stylesheet_directory_uri() . '/chocolat.js', array( 'jquery' ),'',true );
}
add_action( 'wp_enqueue_scripts', 'chocolat_script' );

function auto_redirect_after_logout(){
  wp_safe_redirect( home_url() );
  exit;
}
add_action('wp_logout','auto_redirect_after_logout');

// function redirect_to_front_page($user_login, $user) {
// 	//Send author straight to the site upon login - skip looking at the profile page
// 	if(in_array('subscriber', (array) $user->roles)) {
// 		wp_redirect(get_option('siteurl'));
// 		die();
// 	}
// }
// add_action('wp_logout', 'redirect_to_front_page', 10, 2);

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect them to the default place
            return $redirect_to;
        } else {
            return "https://holdfastsocialclub.com/welcome/";
        }
    } else {
        return $redirect_to;
    }
}
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// redirect main page search to studios - not working
// add_filter( 'get_search_form', function( $form ) {
// 	$form = str_replace( 'name="s"', 'name="fwp_studio_search"', $form );
// 	$form = preg_replace( '/action=".*"/', 'action="/socialclub/shops/"', $form );
// 	return $form;
// } );

function fix_post_id_on_preview($null, $post_id) {
    if (is_preview()) {
        return get_the_ID();
    }
    else {
        $acf_post_id = isset($post_id->ID) ? $post_id->ID : $post_id;

        if (!empty($acf_post_id)) {
            return $acf_post_id;
        }
        else {
            return $null;
        }
    }
}
add_filter( 'acf/pre_load_post_id', 'fix_post_id_on_preview', 10, 2 );

// remove "Private: " from titles
function remove_private_prefix($title) {
	$title = str_replace('Private: ', '', $title);
	return $title;
}
add_filter('the_title', 'remove_private_prefix');


// check for empty queries
add_filter( 'facetwp_query_args', function( $query_args, $class ) {
    if( !empty( $_GET["_studio_search"] ) ) {
		echo "<div id='nostudios'><p>Sorry, not tattoo studios found at this location!</p><button onclick='FWP.reset()'>See all studios</button></div>";
    }
    return $query_args;
}, 10, 2 );

// add page to admin bar: https://sumtips.com/blogging/customize-wordpress-admin-bar/
// hide admin bar for everyone except admin
function remove_admin_bar() {
	if (!current_user_can('administrator')) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar_items() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('edit');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('new-content');
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_items' );

add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type)
{
    if ($post_type === 'artists' || $post_type === 'shop') return false;
    return $current_status;
}

add_filter("admin_body_class", "my_folded_menu", 10, 1);

function my_folded_menu($classes){
	if (!current_user_can('administrator')) {
    	return $classes." folded";
	}
}

if( !current_user_can('administrator') ){
    remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    add_action( 'personal_options', 'prefix_hide_personal_options' );
}
 
function prefix_hide_personal_options() {
  ?>
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ){
            $( '#your-profile .form-table:first, #your-profile h3:first, .yoast, .user-description-wrap, .user-profile-picture, h2, .user-pinterest-wrap, .user-myspace-wrap, .user-soundcloud-wrap, .user-tumblr-wrap, .user-wikipedia-wrap' ).remove();
        } );
    </script>
  <?php
}

function wpb_remove_screen_options() { 
	if(!current_user_can('administrator')) {
		return false;
	}
	return true; 
}
add_filter('screen_options_show_screen', 'wpb_remove_screen_options');

// hide some menu items for everyone except admin
function remove_menu_items() {
	if (!current_user_can('administrator')) {
		remove_menu_page('tools.php');
		remove_menu_page('edit.php');
		remove_menu_page('index.php');
		remove_menu_page('edit.php?post_type=elementor_library');
		remove_menu_page('edit.php?post_type=shop');
		remove_menu_page('edit.php?post_type=artists');
	}
}
add_action('admin_menu', 'remove_menu_items');

function edit_custom_post() {
	edit_post_link(__('Edit Profile'));
}
add_shortcode( 'edit_custom_post', 'edit_custom_post');

function item_list($list) {
	$item_array = explode(", ", $list);
	foreach($item_array as $item) {
		$list_itemized .= "<li class='elementor-icon-list-item anchor-list'>
			<span class='elementor-icon-list-icon'><i aria-hidden='true' class='fas fa-anchor'></i></span>
			<span class='elementor-icon-list-text'>".$item."</span>";
	}
	return $list_itemized;
}

function user_page() {
	$current_user = wp_get_current_user();
	$userID       = $current_user->ID;
	
	$args = array( 'author' => $userID, 'post_type' => 'artists' ) ;
	$authors_posts_artists = get_posts($args);

	$args2 = array( 'author' => $userID, 'post_type' => 'shop' ) ;
	$authors_posts_studios = get_posts($args2);
	
	echo "<div style='display: flex;'>";
	if($authors_posts_artists) {
		foreach ( $authors_posts_artists as $authors_post ) {
			echo "<a class='post-edit-link' style='margin-right: 15px;' href=/artists/".$authors_post->post_name.">My Artist Profile</a>";
		}
	}
	
	if($authors_posts_studios) {
		foreach ( $authors_posts_studios as $authors_post ) {
			echo "<a class='post-edit-link' href=/shop/".$authors_post->post_name.">My Studio Profile</a>";
		}
	}
	echo "</div>";
 }
 add_shortcode( 'user_page', 'user_page');

// Custom Categories - Artists
function art_style() {
	if( !post_password_required( $post )):
		echo "<h3>Art Style</h3>".item_list(get_field('art_style'));
	endif;
}
add_shortcode( 'art_style', 'art_style');


function work_experience() {
    $years_tattooing = get_field('years_tattooing');

	$work_experience = "<h3>Years Of Experience</h3><li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
			<i aria-hidden='true' class='fas fa-anchor'></i>
		</span>
		<span class='elementor-icon-list-text'>".$years_tattooing."</span>
	</li>";
	
	if( !post_password_required( $post )):
		echo $work_experience;
	endif;
}
add_shortcode( 'work_experience', 'work_experience');

function musical_taste() {
    $music_preference = get_field('music_preference');

	$musical_taste = "<h3>Musical taste</h3>";
	if( $musical_taste ==="All of the above") {
		$musical_taste .= "<p>Anything but country, metal or rap</p>";
	} else {
		$musical_taste .= "<p>".item_list($music_preference)."</p>";
		
	}
	if( !post_password_required( $post )):
		echo $musical_taste;
	endif;
}
add_shortcode( 'musical_taste', 'musical_taste');


function equipment_required() {
	if( !post_password_required( $post ) && get_field('equipment_required')):
		echo "<h3>Equipment Required</h3>".item_list(get_field('equipment_required'));
	endif;
}
add_shortcode( 'equipment_required', 'equipment_required');

function hourly_percentage_expectation() {
	if( !post_password_required( $post )):
		echo "<h3>Hourly and Percentage Expectation</h3>".item_list(get_field('hourly_and_percentage'));
	endif;
}
add_shortcode( 'hourly_percentage_expectation', 'hourly_percentage_expectation');

// Custom Categories - Shops


function post_content() {
	$content = get_the_content();
	$img = get_the_post_thumbnail_url();
	$studio_logo = '<p>';
	if(!empty($img)) {
		$studio_logo .= "<img class='studioLogo' src='".$img."'/>";
	}
	$studio_logo .= $content;
	$studio_logo .= '</p>';
	echo $studio_logo;
}
add_shortcode( 'post_content', 'post_content');


function artists_and_years() {
    $years_in_business = get_field('years_in_business');
    $number_of_current_artists = get_field('number_of_current_artists');

	if( !post_password_required( $post )):
		echo "<p>We have been in business for ".$years_in_business." years and currently are ".$number_of_current_artists." artists";
	endif;
}
add_shortcode( 'artists_and_years', 'artists_and_years');

function equipment_available() {
	if( !post_password_required( $post )):
		echo "<h3>Shop Amenities</h3>".item_list(get_field('shop_amenities'));
	endif;
}
add_shortcode( 'equipment_available', 'equipment_available');

function typical_clientele() {
	if( !post_password_required( $post )):
		echo "<h3>Typical Clientele</h3>".item_list(get_field('typical_clientele'));
	endif;
}
add_shortcode( 'typical_clientele', 'typical_clientele');

function clientele_description() {

	if( !post_password_required( $post )):
		echo "<h3>Clientele description</h3>".item_list(get_field('clientele_description'));
	endif;
}
add_shortcode( 'clientele_description', 'clientele_description');

function looking_for() {
	if( !post_password_required( $post )):
		echo "<h3>We're looking for...</h3>".item_list(get_field('looking_for'));
	endif;
}
add_shortcode( 'looking_for', 'looking_for');

function workload_expectation() {
	if( !post_password_required( $post )):
		echo "<h3>Workload Expectation</h3>".item_list(get_field('workload_expectation'));
	endif;
}
add_shortcode( 'workload_expectation', 'workload_expectation');

function work_station_description() {
    $work_station_description = get_field('work_station_description');
	$img = get_field('workspace_photo');
	$img_url = wp_get_attachment_image_url($img, 'large');

	$work_station = "<h3>Work Station</h3>";
	if(!empty($img_url)) {
		$work_station .= "<img class='workspaceImg' src='".$img_url."'/>";
	}
	$work_station .= item_list(get_field('work_station_description2'));
	if( !post_password_required( $post )):
		echo $work_station;
	endif;
}
add_shortcode( 'work_station_description', 'work_station_description');


function payment_structure() {
	if( !post_password_required( $post )):
		echo "<h3>Payment Structure</h3>".item_list(get_field('payment_structure'));
	endif;
}
add_shortcode( 'payment_structure', 'payment_structure');

function shop_rate() {
	if( !post_password_required( $post )):
		echo "<h3>Shop Rate</h3>".item_list(get_field('shop_rate'));
	endif;
}
add_shortcode( 'shop_rate', 'shop_rate');

// Custom Fields - Artists
function social_links() {
	$custom_fields = get_field('studio_instagram');
	if(empty($custom_fields)) {
		$custom_fields = get_field('instagram');
	}
	$insta = str_replace("https://www.instagram.com/", "", $custom_fields);
	$insta = str_replace("https://instagram.com/", "", $insta);
	$insta = str_replace("/", "", $insta);

	if(!empty($custom_fields)) {
		$social = "<li class='elementor-icon-list-item social-custom artist-social'><a href='".$custom_fields."' target='_blank'><span class='elementor-icon-list-icon'><i aria-hidden='true' class='fab fa-instagram'></i></span><span class='elementor-icon-list-text'>".$insta."</span></a></li>";
	}

	if( !post_password_required( $post )):
		echo $social;
	endif;
}
add_shortcode(("social_links"), "social_links");

function apprenticeship_details() {
	if( !post_password_required( $post )):
		echo "<h3>Apprenticeship Details</h3><p>".get_field('apprenticeship_details')."</p>";
	endif;
}
add_shortcode(("apprenticeship_details"), "apprenticeship_details");

function current_shop() {
	if( !post_password_required( $post )):
		echo "<h3>Current Studio</h3><p>".get_field('current_shop')."</p>";
	endif;

}
add_shortcode(("current_shop"), "current_shop");

function experience_wish() {
	if( !post_password_required( $post )):
		echo "<h3>The Experience I Wish To Have</h3><p>".get_field('experience_wish')."</p>";
	endif;
}
add_shortcode(("experience_wish"), "experience_wish");

function local_accrediations() {
	if( !post_password_required( $post )):
		echo "<h3>Local Accreditations</h3><p>".get_field('local_accreditations')."</p>";
	endif;
}
add_shortcode(("local_accrediations"), "local_accrediations");

function artist_website() {
	$website = get_field('website');

	if(!empty($website)) {
		$website = str_replace("https://","", $website);
		if( !post_password_required( $post )):
			echo "<li class='elementor-icon-list-item social-custom'><a href='".get_field('website')."' target='_blank'>
					<span class='elementor-icon-list-icon'><i aria-hidden='true' class='fas fa-globe'></i></span><span class='elementor-icon-list-text'>".$website."</span></a>
				</li>";
		endif;
	}
}
add_shortcode( 'artist_website', 'artist_website');

// Custom Fields - Shops
function shop_website() {
	$website = get_field('studio_website');

	if(!empty($website)) {
		$website = str_replace("https://","", $website);
		if( !post_password_required( $post )):
			echo "<li class='elementor-icon-list-item social-custom'><a href='".get_field('website')."' target='_blank'>
					<span class='elementor-icon-list-icon'><i aria-hidden='true' class='fas fa-globe'></i></span><span class='elementor-icon-list-text'>".$website."</span></a>
				</li>";
		endif;
	}
}
add_shortcode( 'shop_website', 'shop_website');

function shop_artist_social_links() {
	$shop_artists_social = "<li class='elementor-icon-list-item social-custom artist-social-list'>";
	for($i = 1; $i <= 6; $i++) {
		$custom_fields = get_field('artist_instagram_link_'.$i);
		$insta = str_replace("https://www.instagram.com/", "", $custom_fields);
		$insta = str_replace("https://instagram.com/", "", $insta);
		$insta = str_replace("https:www.instagram.com", "", $insta);
		$insta = str_replace("/", "", $insta);
	
		if(!empty($custom_fields)) {
			$shop_artists_social .= "<a href='".$custom_fields."' target='_blank'><span class='elementor-icon-list-icon'><i aria-hidden='true' class='fab fa-instagram'></i></span><span class='elementor-icon-list-text'>".$insta."</span></a>";
		}	
	}
	$shop_artists_social .= "</li>";

	if( !post_password_required( $post )):
		echo $shop_artists_social;
	endif;
}
add_shortcode( 'shop_artist_social_links', 'shop_artist_social_links');

function address() {
	$address = "<h3>Address</h3>
		<p>".get_field('acf_street')."<br/>
		".get_field('acf_city').", ".get_field('acf_zip').", ".get_field('acf_province')."<br/>".get_field('acf_country')."</p>";

	if( !post_password_required( $post )):
		echo $address;
	endif;
}
add_shortcode( 'address', 'address');

function local_area_description() {
	if( !post_password_required( $post )):
		echo "<h3>The local area</h3><p>".get_field('local_area_description')."</p>";
	endif;
}
add_shortcode( 'local_area_description', 'local_area_description');

function shop_hours() {
	if( !post_password_required( $post )):
		echo "<h3>Studio hours</h3><p>".get_field('studio_hours')."</p>";
	endif;
}
add_shortcode( 'shop_hours', 'shop_hours');

function accommodations() {
	if( !post_password_required( $post )):
		echo "<h3>Accommodations</h3><p>".get_field('acf_accomodations')."</p>";
	endif;
}
add_shortcode( 'accommodations', 'accommodations');

function biz_health_accreditations() {
	if(!empty($custom_fields) && !post_password_required( $post )) {
		echo "<h3>Business and Health Accreditations</h3><p>".get_field('local_accreditations')."</p>";
	}
}
add_shortcode( 'biz_health_accreditations', 'biz_health_accreditations');

function reset_search() {
	if( !post_password_required( $post )):
		echo "<button class='reset-search' onclick='FWP.reset()'>Reset search</button>";
	endif;
}
add_shortcode( 'reset_search', 'reset_search');

function gallery_image($acf_img) {
	$image = get_field($acf_img);
	$img_url = wp_get_attachment_image_url($image, 'large');
	if($img_url) {
		return "<a class='chocolat-image' href='".$img_url."'><img src='".$img_url."'/></a>";
	} else {
		return false;
	}
}

// Image Gallery
function image_gallery() {
	$image_list = 
	$numImg = 0;
	$images = "";
	$galleryRows = "";
	
	for($i=1; $i<=6; $i++) {
		$img = gallery_image('gallery_image_'.$i);
		if($img) {
			$images .= gallery_image('gallery_image_'.$i);
			$numImg++;
		}
	}

	switch ($numImg) {
		case 1:
		case 2:
			$galleryRows = "one_image_row";
			break;
		case 3:
		case 4:
			$galleryRows = "two_image_rows";
			break;
			
		case 5:
		case 6:
			$galleryRows = "three_image_rows";
			break;
	}
	if( !post_password_required( $post )):
		echo "<div class='custom_img_gallery chocolat-parent ".$galleryRows."'>".$images."</div>";
	endif;
}
add_shortcode("image_gallery", "image_gallery");

/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
add_action( 'wp', 'custom_maybe_activate_user', 9 );
function custom_maybe_activate_user() {

	$template_path    = STYLESHEETPATH . '/gfur-activate-template/activate.php';
	$is_activate_page = isset( $_GET['page'] ) && $_GET['page'] === 'gf_activation';
	$is_activate_page = $is_activate_page || isset( $_GET['gfur_activation'] ); // WP 5.5 Compatibility

	if ( ! file_exists( $template_path ) || ! $is_activate_page ) {
		return;
	}

	require_once( $template_path );

	exit();
}


function exclude_some_custom_fields( $protected, $meta_key ) {
	if ((get_post_type() =='artists') || (get_post_type() =='shop') ) {
	  if ( in_array( $meta_key, array( 'rank_math_analytic_object_id', 'rank_math_internal_links_processed', 'rank_math_seo_score' ) ) ) {
		return true;
	  }
  
	}
	return $protected;
  }
  add_filter( 'is_protected_meta', 'exclude_some_custom_fields', 10, 2 );

  
	function exclude_custom_fields_from_artists( $protected, $meta_key ) {
		if (get_post_type() =='artists') {
			if ( in_array( $meta_key, array( 'Work station photo', 'Social Media 1', 'Artist Social Media', 'Accomodations', 'Business and Health Accreditations', 'Local area description', 'Shop artist instagram 1', 'Shop artist instagram 2', 'Shop artist instagram 3', 'Shop artist instagram 4', 'Shop artist instagram 5', 'Shop artist instagram 6', 'Shop hours', 'Shop website', 'Workspace image' ) ) ) {
			return true;
		}
		}
		return $protected;
	}
  	add_filter( 'is_protected_meta', 'exclude_custom_fields_from_artists', 10, 2 );
	
	function exclude_custom_fields_from_studios( $protected, $meta_key ) {
		if (get_post_type() =='shop') {
			if ( in_array( $meta_key, array( 'Social Media 1', 'Artist Social Media', 'Current Shop', 'Apprenticeship details', 'Experience wish', 'Local Accreditations' ) ) ) {
			return true;
		}
		}
		return $protected;
	}
	add_filter( 'is_protected_meta', 'exclude_custom_fields_from_studios', 10, 2 );

  	add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments' );
	function show_current_user_attachments( $query ) {
		$user_id = get_current_user_id(); // get current user ID
		if ( $user_id && !current_user_can('manage_options')) {  // if we have a current user ID (they're logged in) and the current user is not an administrator
			$query['author'] = $user_id; // add author filter, ensures only the current users images are displayed
		}
		return $query;
	}

	function getGeoCode($address){
        // geocoding api url
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address";
        // send api request
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $data['lat'] = $json->results[0]->geometry->location->lat;
        $data['lng'] = $json->results[0]->geometry->location->lng;
        return $data;
	}
	function after_submission($entry, $form) {

	}

	add_action( 'gform_after_submission_5', 'after_submission', 10, 2 );

	/**
	 * Update the query to use specific post statuses.
	 *
	 * @since 1.0.0
	 * @param \WP_Query $query The WordPress query instance.
	 */
	function my_query_by_post_status( $query ) {
		$query->set( 'post_status', [ 'published', 'protected' , 'private' ] );
	}
	add_action( 'elementor/query/private_posts', 'my_query_by_post_status' );

	function hide_home_button() {
		if (!current_user_can('administrator')) {
			echo '<style>
				.edit-post-fullscreen-mode-close, #categorydiv, a.page-title-action {
					display: none !important;
				} 
				#wpadminbar {
					height: 45px;
				}
				#wpadminbar .ab-item {
					font-size: 20px;
				}
				.wp-admin #wpadminbar #wp-admin-bar-site-name>.ab-item:before {
					width: 30px;
				}
			</style>';
		}
	}
	add_action('admin_head', 'hide_home_button');
?>