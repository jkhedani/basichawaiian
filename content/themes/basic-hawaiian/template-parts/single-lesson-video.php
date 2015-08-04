<?php
/**
 * @package Basic Hawaiian
 */

get_template_part('template-parts/single','lesson-header');

?>

		<h2 class="lesson-instructions">
			<?php
				if ( get_field( 'optional_instructions' ) ) :
					// Display optional instructions if they exist.
					echo get_field( 'optional_instructions' );
				else :
					echo 'Watch and learn from the video below.';
				endif;
			?>
		</h2>
	</header><!-- .entry-header -->

	<div class="lesson-content row">
		<!-- Video Player -->
		<div class="video-player-container col-sm-8">
			<?php
				// Retrieve the video url
				$videourl = get_field( 'youtube_video_url' );
				// Breakdown the url into recognizable parts
				$videourl_str = parse_str( parse_url( $videourl, PHP_URL_QUERY ), $videourl_param);
				// Extract the video id from the video url
				if ( $videourl_param['v'] ) {
					$video_id = $videourl_param['v'];
				} else {
					$video_id = ''; // Maybe find a better fallback
				}
			?>
			<iframe width="100%" height="315" src="//www.youtube.com/embed/<?php echo $video_id; ?>?showinfo=0" frameborder="0" allowfullscreen></iframe>
		</div>
		<!-- Video Metadata -->
		<div class="video-player-metadata col-sm-4">
			<?php // youtube metadata
				/**
				 * Youtube
				 *
				 * @link http://www.w3bees.com/2013/09/youtube-php-api.html
				 * @version YouTube API V2
				 * @param str youtube video url
				 * @return object || void
				 * @copyright w3bees.com
				 */
				function youtube($url) {
				  # get video id from url
				  $urlQ = parse_url( $url, PHP_URL_QUERY );
				  parse_str( $urlQ, $query );

				  # YouTube api v2 url
				  $apiURL = 'http://gdata.youtube.com/feeds/api/videos/'. $query['v'] .'?v=2&alt=jsonc';

				  # curl options
				  $options = array(
				    CURLOPT_URL  => $apiURL,
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_BINARYTRANSFER => true,
				    CURLOPT_SSL_VERIFYPEER => false,
				    CURLOPT_TIMEOUT => 5 );

				  # connect api server through cURL
				  $ch = curl_init();
				  curl_setopt_array($ch, $options);
				  # execute cURL
				  $json = curl_exec($ch) or die( curl_error($ch) );
				  # close cURL connect
				  curl_close($ch);

				  # decode json encoded data
				  if ($data = json_decode($json))
				    return (object) $data->data;
				}

				/**
				 * Truncate incoming YouTube text to prevent overflow.
				 *
				 */
				function truncate($text, $chars = 25) {
			    $text = $text." ";
			    $text = substr($text,0,$chars);
			    $text = substr($text,0,strrpos($text,' '));
			    $text = $text."...";
			    return $text;
				}
				$youtube = youtube($videourl);
				$youtube_title = $youtube->title;
				$youtube_description = truncate( $youtube->description, 200);
			?>
			<h3 class="youtube-title"><?php echo $youtube_title; ?></h3>
			<p class="youtube-description"><?php echo $youtube_description; ?></p>
			<a class="watch-youtube" href="<?php echo $videourl; ?>" target="_blank"><i class="fa fa-youtube-play"></i>View more on YouTube</a>
		</div>
	</div><!-- .entry-content -->

	<footer class="lesson-footer row">

<?php get_template_part('template-parts/single','lesson-footer'); ?>
