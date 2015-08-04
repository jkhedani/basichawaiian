<?php

function finish_lesson() {

	// Nonce check
	$nonce = $_REQUEST['nonce'];
	if (!wp_verify_nonce($nonce, 'user_interactions_scripts_nonce')) die(__('Busted.'));

	// Incoming data
	$lessonData = json_decode(stripslashes($_REQUEST['lessonData']));
	$lessonOutcome = $lessonData->outcome;
	$lessonResults = $lessonData->results;

	/**
	 * Previously Taken
	 */
	$currentLessonData = json_decode(get_user_meta($lessonData->userID, $lessonData->postID,true));
	if ( $currentLessonData ) {
		// PASS!
		if ( $lessonOutcome === 'success' ) {
			$currentLessonData->completed = $currentLessonData->completed + 1; // Increment completed
		// FAIL!
		} else {
			$currentLessonData->failed = $currentLessonData->failed + 1; // Increment failed
		}

		// We can check if we are saving a test lesson by
		// seeing if the results are empty or not. Results
		// with any data is considered a test lesson
		if ( !empty($currentLessonData->results)) {
			$currentLessonResults = $currentLessonData->results;
			// combine array value here.
			foreach( $lessonResults as $id => $result ) {
				$currentLessonResults->$id->X = $currentLessonResults->$id->X + $result->X;
				$currentLessonResults->$id->O = $currentLessonResults->$id->O + $result->O;
			}
		}

	/**
	 * First Time
	 */
	} else {
		// PASS!
		if ( $lessonOutcome === 'success' ) {
			$currentLessonData = array(
				'completed' => 1,
				'failed' => 0,
				'results' => $lessonResults,
			);
		// FAIL!
		} else {
			$currentLessonData = array(
				'completed' => 0,
				'failed' => 1,
				'results' => $lessonResults,
			);
		}
	}

	// Update data with new values
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
