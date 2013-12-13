<?php
/*
 * Marker file, returns all of the markers from all of the domains
 */
//ob_clean();
//flush();
//readfile( './marker.txt' );
define( 'WP_USE_THEMES', false );
//require( '../../../../wp-blog-header.php' );
require( '../wp-blog-header.php' );
if ( array_key_exists( 'sites', $_REQUEST ) ) {
	$requested_site = $_REQUEST['sites'];
	if ( $requested_site != 'all' ) {
		$site_list = array( 0 => array( 'blog_id' => $requested_site ) );
		$file = '/marker/marker-' . $requested_site . '.txt';
	}
	else {
		$site_list = get_blog_list( 0, 'all' );
		$file = '/marker/marker.txt';
	}
}
else {
  $site_list = get_blog_list( 0, 'all' );
  $file = '/marker/marker.txt';
}
foreach( $site_list as $site ){
	$site_options[$site['blog_id']]['phone'] = get_blog_option( $site['blog_id'], 'ssc_admin_location_settings_phone' );
	$site_options[$site['blog_id']]['street'] = get_blog_option( $site['blog_id'], 'ssc_admin_location_settings_street' );
	$site_options[$site['blog_id']]['city'] = get_blog_option( $site['blog_id'], 'ssc_admin_location_settings_city' );
	$site_options[$site['blog_id']]['state'] = get_blog_option( $site['blog_id'], 'ssc_admin_location_settings_state' );
	$site_options[$site['blog_id']]['zip'] = get_blog_option( $site['blog_id'], 'ssc_admin_location_settings_zip' );
}
$data = "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
foreach ($site_options as $blog_id) {
	$address = 'street=' . str_replace( ' ', '+', $blog_id['street'] ) . '&state=' . str_replace(' ', '+', $blog_id['state'] ) . '&postalcode=' . urlencode( $blog_id['zip'] );
	$query = '&country=us&format=json&countrycodes=us&polygon=0&addressdetails=0&' . $address;
	//$output = file_get_contents( 'http://nominatim.openstreetmap.org/search?street=5557+gibson+drive&state=GA&postalcode=30102&country=us&format=json&polygon=0&addressdetails=0' );
	//$loc = file_get_contents( 'http://nominatim.openstreetmap.org/search?' . $query );

	$output = json_decode( file_get_contents( 'http://nominatim.openstreetmap.org/search?' . $query ) );
	if ( $output[0]->lat){
  	$data .= $output[0]->lat;
	  $data .= "\t";
  	$data .= $output[0]->lon;
	  $data .= "\t";
	  $data .= $blog_id['city'] ;
	  $data .= "\t";
	  $data .= '<div class="map-location"><address>'.$blog_id['street'] . '<br>'.$blog_id['state'] .' ' . $blog_id['zip'] .'</address><a href="tel:'.$blog_id['phone'].'">'.$blog_id['phone'].'</a></div>';//<img src="http://www.scottsawyerconsulting.com/sites/all/themes/sscblck/logo.png"></div>';
	  $data .= "\t";
	  $data .= 'http://www.scottsawyerconsulting.com/sites/all/themes/sscblck/logo.png';
	  $data .= "\t";
	  $data .= '30,30';
	  $data .= "\t";
	  $data .= '0,-15';
	  $data .= "\n";
  }
}
$path = realpath(dirname(__FILE__));
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]; //.$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"]; //.$_SERVER["REQUEST_URI"];
 }

$file_handle = fopen( $_SERVER['DOCUMENT_ROOT'] . $file, 'w' ); //$path.'/'.$file, 'w' );
fwrite( $file_handle, $data );
fclose( $file_handle );
header( "location:" . $pageURL . $file );
exit;
?>