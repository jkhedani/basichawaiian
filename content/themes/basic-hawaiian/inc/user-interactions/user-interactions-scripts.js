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

  function administer_test() {
    // Set current test health
    var lesson_health = $('.lesson-health').length;
    // Hide next card, show check
    $('#advance-lesson').hide();
    // Allow for choice selection & correct immediately
    $('.choice').on('click', function() {
      // Correct answer
      if ( $(this).hasClass('correct') ) {
        // Increment O score
        $(this).attr('data-O',1);
        // Show message
        $('.lesson-message.correct').show().removeClass('slideOutDown').addClass('slideInUp animated');
      // Incorrect answer
      } else {
        var correct_answer_object = $(this).parents('ul').children('li').find('a.correct');
        var correct_answer = $(this).parents('ul').children('li').find('a.correct').text();
        // Increment X score on correct answer
        correct_answer_object.attr('data-X',1);
        // Show message
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
  // Restart audio after end
  $('audio').on('ended',function(){
    $(this).prev().removeClass('on').addClass('off'); // Change class
    $(this).prev().find('i').removeClass('fa-volume-up').addClass('fa-volume-off');
    $(this)[0].currentTime = 0;
    $(this)[0].pause();
  });
  // Play first active card
  $('.card.active').find('.audio-toggle').click();

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

      // If a lesson has audio
      $('.card.active').find('.audio-toggle').click();

      // If lesson is a test lesson, administer test.
      if ( $('.card.active').hasClass('test') ) {
        administer_test();
      }

      // Advance lesson instructions if necessary
      if ( $('.lesson-instructions').length > 1 ) {
        var current_instruction = $('.lesson-instructions.active');
        var next_instruction = current_instruction.next();
        current_instruction.removeClass('active');
        next_instruction.addClass('active');
      }
    }

    // Show pau on last card
    if ( last_card.hasClass('active') ) {
      $('#advance-lesson').hide();
      $('#finish-lesson').show();
    }
  });



  /**
   * Global: Finish Lesson
   */
  $('#finish-lesson').on('click', function() {

    // Global Data
    var lessonOutcome = $(this).attr('data-lesson-outcome');
    var data = {
      "postID"  : $(this).attr('data-post-id'),
      "userID"  : $(this).attr('data-user-id'),
      "outcome" : lessonOutcome,
    };

    // Test Data
    var results = {};
    $('a.choice.correct').each(function() {
      var choice_id = $(this).attr('data-id');
      var choice_O = $(this).attr('data-O');
      var choice_X = $(this).attr('data-X');
      results[choice_id] = { 'O' : choice_O, 'X' : choice_X };
    });
    data['results'] = results;

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
      }
    });

  }); // #finish-lesson

  /**
   * Test Lessons
   */
  if ( $('.card.active').hasClass('test') ) {
    administer_test();
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

  /**
   * Instructional Lesson
   */
  if ( $('body').hasClass('single-instruction_lessons') ) {

    // Show the first lesson-instruction
    $('h2.lesson-instructions').first().addClass('active');

    // Show Translations
    $('a.show-translation').on('click',function() {
      // Toggle class
      $('.translate').toggleClass('show-english');
      $('.translate').toggleClass('show-hawaiian');
      // Hide content, show translation
      $('a.show-translation').parents('.card').children('.instructional-slide-content').toggle();
      $('a.show-translation').parents('.card').children('.instructional-slide-translation').toggle();
    });
  }

  /**
   * Vocabulary Lessons
   */
  if ( $('body').hasClass('single-vocabulary_lessons') ) {
    // Show Translations
    $('a.show-translation').on('click',function() {
      // Toggle class
      $('.translate').toggleClass('show-english');
      $('.translate').toggleClass('show-hawaiian');
      // Hide content, show translation
      $('a.show-translation').parents('.card').children('.english').toggle();
      $('a.show-translation').parents('.card').children('.hawaiian').toggle();
    });
  }


}); // end jQuery
