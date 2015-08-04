jQuery(document).ready(function($) {

  /**
   * Query Parameter
   */
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  /**
   * Global: Load First card in lesson
   */
  $('.card').first().addClass('active');

  /**
   * Global: Audio
   */
  $('.audio-toggle').on('click',function() {
    var audio_player_id = '#' + $(this).attr('data-audio-id') + '-audio';
    if ( $(this).hasClass('off') ) {
      $(this).removeClass('off').addClass('on'); // Change class
      $(this).find('i').removeClass('fa-volume-off').addClass('fa-volume-up'); // Change icon
      $(audio_player_id)[0].play(); // play!
    } else if ( $(this).hasClass('on') ) {
      $(this).removeClass('on').addClass('off'); // Change class
      $(this).find('i').removeClass('fa-volume-up').addClass('fa-volume-off');
      $(audio_player_id)[0].pause(); // pause!
    }
  });

  /**
   * Global: Advance Lesson
   */
  $('#advance-lesson').on('click',function() {
    var current_card = $('.card.active');
    var next_card = current_card.next();
    var last_card = $('.card').last();

    var current_counter = $('.lei-counter.active');
    var next_counter = current_counter.next();

    // Keep advancing until the last slide
    if ( ! last_card.hasClass('active') ) {
      current_card.removeClass('active');
      next_card.addClass('active');

      current_counter.css('opacity','1.0');
      current_counter.removeClass('active');
      next_counter.addClass('active');

    // If a lesson message is visible, hide it.
    $('.lesson-message').removeClass('slideInUp').addClass('slideOutDown animated');

    // Then show pau!
    } else {
      $('#advance-lesson').hide();
      $('#finish-lesson').show();
    }

  });

  /**
   * Global: Finish Lesson
   */
  $('#finish-lesson').on('click', function() {
    var lessonOutcome = $(this).attr('data-lesson-outcome');
    var data = {
      "postID" : $(this).attr('data-post-id'),
      "userID" : $(this).attr('data-user-id'),
    };
    $.post(user_interactions_scripts.ajaxurl, {
      dataType: "jsonp",
      action: 'finish_lesson',
      nonce: user_interactions_scripts.nonce,
      lessonData: JSON.stringify(data),
    }, function(response) {
      if (response.success===true) {
        // Hide
        $('.lesson-header, .lesson-content, .lesson-footer').addClass('fadeOut animated');
        setTimeout(function() {
          $('.lesson-header, .lesson-content, .lesson-footer').hide();
          // Show appropriate response
          var lessonResultDiv;
          if ( lessonOutcome === 'success' ) {
            lessonResultDiv = $('.lesson-results.success');
          } else {
            lessonResultDiv = $('.lesson-results.fail');
          }
          lessonResultDiv.show().addClass('slideInDown animated');
        }, 1000);
      } else {
        // Bad Response message
        console.log('asdf');
      }
    });

  }); // #finish-lesson

  /**
   * Test Lesson
   */
  if ( $('.card.active').hasClass('test') ) {

    // Set current test health
    var lesson_health = $('.lesson-health').length;

    // Hide next card, show check
    $('#advance-lesson').hide();
    // $('#check-lesson').show();

    // Allow for choice selection & correct immediately
    $('.choice').on('click', function() {

      // Correct answer
      if ( $(this).hasClass('correct') ) {
        $('.lesson-message.correct').show().removeClass('slideOutDown').addClass('slideInUp animated');
      // Incorrect answer
      } else {
        var correct_answer = $(this).parents('ul').children('li').find('a.correct').text();
        $('.lesson-message.wrong strong').html(correct_answer);
        $('.lesson-message.wrong').show().removeClass('slideOutDown').addClass('slideInUp animated');
        // Subtract
        $('.lesson-health').first().addClass('fadeOut animated');
        lesson_health = lesson_health - 1;
      }

      // Fail Lesson
      if ( lesson_health === 0 ) {
        setTimeout(function(){
          $('#finish-lesson').attr('data-lesson-outcome', 'fail');
          $('#finish-lesson').click();
        },2000);
      // Advance Lesson
      } else {
        var last_card = $('.card').last();
        if ( last_card.hasClass('active') ) {
          $('#finish-lesson').show();
        } else {
          $('#advance-lesson').show();
        }
      }

    });
  }

  /**
   * Reading Lesson
   */
  if ( $('body').hasClass('single-readings') ) {

    // Play audio when user lands
    $('button.audio-toggle').click();

    // Toggle content
    $('button.toggle-content').on('click', function() {
      $('body').find('.toggled-content').hide();
      var id = '#' + $(this).attr('data-show-id');
      $(id).show();
      $('body').find('button.toggle-content').removeClass('selected');
      $(this).addClass('selected');
    });

    // Show the first available toggled content
    $('button.toggle-content.available').first().click();

  }


}); // end jQuery
