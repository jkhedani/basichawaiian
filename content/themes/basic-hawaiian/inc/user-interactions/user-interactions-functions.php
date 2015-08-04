<?php


function finish_lesson() {

	// Nonce check
	$nonce = $_REQUEST['nonce'];
	if (!wp_verify_nonce($nonce, 'user_interactions_scripts_nonce')) die(__('Busted.'));

	// Retrieve data
	$lessonData = json_decode(stripslashes($_REQUEST['lessonData']));

	// Practice Retrieving data
	$currentLessonData = json_decode(get_user_meta($lessonData->userID, $lessonData->postID,true));
	if ( $currentLessonData ) {
		// Increment completed
		$currentLessonData->completed = $currentLessonData->completed + 1;
	} else {
		// Finish lesson
		$currentLessonData = array(
			'correct' => 0,
			'wrong' => 0,
			'completed' => 1
		);
	}

	update_user_meta($lessonData->userID, $lessonData->postID,json_encode($currentLessonData));

	// Build the response...
	$success = true;
	$response = json_encode(array(
		'success' => $success,
	));

	// Construct and send the response
	header("content-type: application/json");
	echo $response;
	exit;

}
add_action('wp_ajax_nopriv_finish_lesson', 'finish_lesson');
add_action('wp_ajax_finish_lesson', 'finish_lesson');

do_action( 'wp_ajax_' . $_REQUEST['action'] );
do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );


?>
