<?php
/**
 * The Single Document template
 */
the_post();
if ( $post->meta->type === 'uploaded' ) {
	$filepath = $post->meta->file['link'];
	$filename = $post->meta->file['filename'];
	$filemime = $post->meta->file['mime_type'];
	$filesize = $post->meta->file['filesize'];

	header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	header("Cache-Control: public");
	header("Content-Type: " . $filemime );
	header("Content-Transfer-Encoding: Binary");
	header("Content-Length:" . $filesize );
	header("Content-Disposition: attachment; filename=" . $filename);
	readfile( $filepath );
	return;
} else {
	if ( ! empty( $post->meta->file ) ) {
		wp_redirect( $post->meta->file, 301 );
		exit;
	}
}

// If you've made it down here, you're in dangerous territory
global $wp_query;
$wp_query->set_404();
status_header(404);
$template = get_404_template();

include_once $template;
exit;