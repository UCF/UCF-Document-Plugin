<?php
/**
 * The Single Document template
 */

use UCFDocument\Admin\Config;

the_post();
if ( $post->meta->type === 'uploaded' ) {
	if ( isset( $post->meta->file['link'] ) ) {
		$force_download = Config::get_option_or_default( 'force_download' );

		// Set the content disposition based on if we're
		// forcing downloads or not
		$content_disposition = $force_download ? 'attachment' : 'inline';

		$filepath = get_attached_file( $post->meta->file['id'] );
		$filename = $post->meta->file['filename'];
		$filemime = $post->meta->file['mime_type'];
		$filesize = $post->meta->file['filesize'];

		header( $_SERVER["SERVER_PROTOCOL"] . " 200 OK" );
		header( "Expires: 0");
		header( "Cache-Control: no-cache, no-store, must-revalidate");
		header( "Cache-Control: pre-check=0, post-check=0, max-age=0", false);
		header( "Pragma: no-cache");
		header( "Cache-Control: public");
		header( "Content-Type: " . $filemime );
		header( "Content-Transfer-Encoding: Binary");
		header( "Content-Length:" . $filesize );
		header( "Content-Disposition: $content_disposition; filename=\"$filename\"" );
		readfile( $filepath );
		return;
	}
} else if ( ! empty( $post->meta->file ) ) {
	header( "Expires: 0" );
	header( "Cache-Control: no-cache, no-store, must-revalidate" );
	header( "Cache-Control: pre-check=0, post-check=0, max-age=0", false ) ;
	header( "Pragma: no-cache" );
	wp_redirect( $post->meta->file, 301 );
	exit;
}

// If you've made it down here, you're in dangerous territory
global $wp_query;
$wp_query->set_404();
status_header( 404 );
$template = get_404_template();

include_once $template;
exit;
