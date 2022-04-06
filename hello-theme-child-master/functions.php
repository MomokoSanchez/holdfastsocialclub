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
// 	if(in_array('author', (array) $user->roles)) {
// 		wp_redirect(get_option('siteurl'));
// 		die();
// 	}
// }
// add_action('wp_logout', 'redirect_to_front_page', 10, 2);

// redirect main page search to studios - not working
// add_filter( 'get_search_form', function( $form ) {
// 	$form = str_replace( 'name="s"', 'name="fwp_studio_search"', $form );
// 	$form = preg_replace( '/action=".*"/', 'action="/socialclub/shops/"', $form );
// 	return $form;
// } );

// add_filter( 'facetwp_preload_url_vars', function( $url_vars ) {
//     if ( 'socialclub/shops/' == FWP()->helper->get_uri() ) {
// 		echo $url_vars;
//         if ( empty( $url_vars['musical_taste'] ) ) {
//             $url_vars['musical_taste'] = [ 'folk' ];
//         }
// 		echo $url_vars;
//     }
//     return $url_vars;
// } );

// check for empty queries
add_filter( 'facetwp_query_args', function( $query_args, $class ) {
    if( !empty( $_GET["_studio_search"] ) ) {
		echo "<div id='nostudios'><p>Sorry, not tattoo studios found at this location!</p><button onclick='FWP.reset()'>See all studios</button></div>";
    }
    return $query_args;
}, 10, 2 );


// hide admin bar for everyone except admin
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

function edit_custom_post() {
	edit_post_link(__('Edit my posting'));
}
add_shortcode( 'edit_custom_post', 'edit_custom_post');

// Custom Categories - Artists
function art_style() {
    $categories = get_the_category();

	echo "<h3>Art Style</h3>";
	foreach($categories as $category) {
		if($category->parent == 32){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'art_style', 'art_style');

function work_experience() {
    $categories = get_the_category();

	echo "<h3>Years Of Experience</h3>";
	foreach($categories as $category) {
		if($category->parent == 45){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'work_experience', 'work_experience');

function musical_taste() {
    $categories = get_the_category();

	echo "<h3>Musical taste</h3><p>";
	foreach($categories as $category) {
		if($category->parent == 14){
			echo $category->name.", ";
		}
	}
	echo "</p>";
}
add_shortcode( 'musical_taste', 'musical_taste');

function equipment_required() {
    $categories = get_the_category();

	echo "<h3>Equipment Required</h3>";
	foreach($categories as $category) {
		if($category->parent == 53){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'equipment_required', 'equipment_required');


function hourly_percentage_expectation() {
    $categories = get_the_category();

	echo "<h3>Hourly and Percentage Expectation</h3>";
	foreach($categories as $category) {
		if($category->parent == 105){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'hourly_percentage_expectation', 'hourly_percentage_expectation');

// Custom Categories - Shops
function artists_and_years() {
    $categories = get_the_category();
	$num_artists = "";
	$num_years = "";

	foreach($categories as $category) {
		if($category->parent == 62){
			$num_artists = $category->name;
		} else if ($category->parent == 45){
			$num_years = $category->name;
		}
	}

	echo "<p>We have been in business for ".$num_years." years and currently are ".$num_artists." artists";
}
add_shortcode( 'artists_and_years', 'artists_and_years');

function equipment_available() {
    $categories = get_the_category();

	echo "<h3>Equipment</h3>";
	foreach($categories as $category) {
		if($category->parent == 53){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'equipment_available', 'equipment_available');

function typical_clientele() {
    $categories = get_the_category();

	echo "<h3>Typical Clientele</h3>";
	foreach($categories as $category) {
		if($category->parent == 66){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'typical_clientele', 'typical_clientele');

function clientele_description() {
    $categories = get_the_category();

	echo "<h3>Clientele description</h3>";
	foreach($categories as $category) {
		if($category->parent == 72){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'clientele_description', 'clientele_description');

function looking_for() {
    $categories = get_the_category();

	echo "<h3>We're looking for...</h3>";
	foreach($categories as $category) {
		if($category->parent == 78){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'looking_for', 'looking_for');

function workload_expectation() {
    $categories = get_the_category();

	echo "<h3>Workload Expectation</h3>";
	foreach($categories as $category) {
		if($category->parent == 82){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'workload_expectation', 'workload_expectation');

function work_station_description() {
    $categories = get_the_category();

	echo "<h3>Work Station</h3>";
	foreach($categories as $category) {
		if($category->parent == 86){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'work_station_description', 'work_station_description');


function payment_structure() {
    $categories = get_the_category();

	echo "<h3>Payment Structure</h3>";
	foreach($categories as $category) {
		if($category->parent == 94){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'payment_structure', 'payment_structure');

function shop_rate() {
    $categories = get_the_category();

	echo "<h3>Shop Rate</h3>";
	foreach($categories as $category) {
		if($category->parent == 100){
			echo "<li class='elementor-icon-list-item anchor-list'><span class='elementor-icon-list-icon'>
					<i aria-hidden='true' class='fas fa-anchor'></i>
				</span>
				<span class='elementor-icon-list-text'>".$category->name."</span>
			</li>";
		}
	}
}
add_shortcode( 'shop_rate', 'shop_rate');

// Custom Fields - Artists

function social_links() {
	$custom_fields = get_post_meta(get_the_id(),"Social Media 1", true);
	$insta = str_replace("https://www.instagram.com/", "", $custom_fields);
	$insta = str_replace("https://instagram.com/", "", $insta);
	$insta = str_replace("/", "", $insta);
	if(!empty($custom_fields)) {
		echo "<li class='elementor-icon-list-item social-custom'><a href='".$custom_fields." 'target='_blank'><span class='elementor-icon-list-icon'><i aria-hidden='true' class='fab fa-instagram'></i></span><span class='elementor-icon-list-text'>".$insta."</span></a></li>";
	}
}
add_shortcode(("social_links"), "social_links");

function apprenticeship_details() {
		echo "<h3>Apprenticeship Details</h3>";
		$custom_fields = get_post_meta(get_the_id(),"Apprenticeship details", true);
		echo "<p>".$custom_fields."</p>";

}
add_shortcode(("apprenticeship_details"), "apprenticeship_details");

function current_shop() {
	echo "<h3>Current Shop</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Current Shop", true);
	echo "<p>".$custom_fields."</p>";

}
add_shortcode(("current_shop"), "current_shop");

function experience_wish() {
	echo "<h3>The Experience I Wish To Have</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Experience wish", true);
	echo "<p>".$custom_fields."</p>";

}
add_shortcode(("experience_wish"), "experience_wish");

function local_accrediations() {
	echo "<h3>Local Accreditations</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Local Accreditations", true);
	echo "<p>".$custom_fields."</p>";

}
add_shortcode(("local_accrediations"), "local_accrediations");

// Custom Fields - Shops
function shop_website() {
	$custom_fields = get_post_meta(get_the_id(),"Shop website", true);
	if(!empty($custom_fields)) {
		$website = str_replace("https://","", $custom_fields);
		$website = str_replace("http://","", $website);
		echo "<li class='elementor-icon-list-item social-custom'><a href='".$custom_fields."' target='_blank'><span class='elementor-icon-list-icon'><i aria-hidden='true' class='fas fa-globe'></i></span><span class='elementor-icon-list-text'>".$website."</span></a></li>";
	}
}
add_shortcode( 'shop_website', 'shop_website');

function shop_artist_social_links() {
	echo "<li class='elementor-icon-list-item social-custom artist-social-list'>";
	for($i = 1; $i <= 6; $i++) {
		$custom_fields = get_post_meta(get_the_id(),"Shop artist instagram "."$i", true);
		$insta_link = "https://instagram.com/".$custom_fields."/";
		$insta = str_replace("@", "", $custom_fields);
		$insta = str_replace(" ", "", $insta);
	
		if(!empty($custom_fields)) {
			echo "<a href='".$insta_link."' target='_blank'><span class='elementor-icon-list-icon'><i aria-hidden='true' class='fab fa-instagram'></i></span><span class='elementor-icon-list-text'>".$insta."</span></a>";
		}	
	}
	echo "</li>";
}
add_shortcode( 'shop_artist_social_links', 'shop_artist_social_links');

function address() {
	echo "<h3>Address</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Address", true);
	$street = get_post_meta(get_the_id(),"Street", true);
	$city = get_post_meta(get_the_id(),"City", true);
	$postal = get_post_meta(get_the_id(),"Postal Code", true);
	$province = get_post_meta(get_the_id(),"Province", true);
	echo "<p>".$street."<br/>";
	echo $city.", ".$postal.", ".$province."<br/>Canada</p>";
}
add_shortcode( 'address', 'address');

function local_area_description() {
	echo "<h3>The local area</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Local area description", true);
	echo "<p>".$custom_fields."</p>";
}
add_shortcode( 'local_area_description', 'local_area_description');

function shop_hours() {
	$custom_fields = get_post_meta(get_the_id(),"Shop hours", true);
	echo "<h3>Shop hours</h3>";
	echo "<p>".$custom_fields."</p>";
}
add_shortcode( 'shop_hours', 'shop_hours');

function accommodations() {
	echo "<h3>Accommodations</h3>";
	$custom_fields = get_post_meta(get_the_id(),"Accomodations", true);
	echo "<p>".$custom_fields."</p>";
}
add_shortcode( 'accommodations', 'accommodations');

function reset_search() {
	echo "<button class='reset-search' onclick='FWP.reset()'>Reset search</button>";
}
add_shortcode( 'reset_search', 'reset_search');

// Image Gallery
function image_gallery() {
	$numImg = 0;
	$images = "";
	$galleryRows = "";
	
	for($i=1; $i<=6; $i++) {
		$img = get_post_meta(get_the_id(),"Image file ".$i, true);
		if(!empty($img)) {
			$images .= "<a class='chocolat-image' href='".$img."'><img src='".$img."'/></a>";
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
	echo "<div class='custom_img_gallery chocolat-parent ".$galleryRows."'>".$images."</div>";
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
?>