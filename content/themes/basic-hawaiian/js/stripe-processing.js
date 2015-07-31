Stripe.setPublishableKey(stripe_vars.publishable_key);

jQuery(document).ready(function($) {

  function stripeResponseHandler(status, response) {
    var $form = $('#payment-form');
     if (response.error) {
       // Show the errors on the form
       $form.find('.payment-errors').text(response.error.message);
       $form.find('button').prop('disabled', false);
     } else {
       // response contains id and card, which contains additional card details
       var token = response.id;
       // Insert the token into the form so it gets submitted to the server
       $form.append($('<input type="hidden" name="stripeToken" />').val(token));
       // and submit
       $form.get(0).submit();
     }
  }

  $('#payment-form').submit(function(event) {
    var $form = $(this);
    // Disable the submit button to prevent repeated clicks
    $form.find('button').prop('disabled', true);
    Stripe.card.createToken($form, stripeResponseHandler);
    // Prevent the form from submitting with the default action
    return false;
  });

  /**
   * Payment Page Scripts
   */
  if ( $('body').hasClass('page-template-page-payment') ) {

    // Allow users to select enrollment
    $('.enroll').on('click', function() {
      // Hide show enrollment/payment
      $('.slide').removeClass('active');
      $('#payment').addClass('active');
      // Add cost attribute to payment form
      var cost = $(this).attr('data-cost');
      $('body').find('input[name="cost"]').val(cost);
      // Add cost type to payment form
      var cost_type = $(this).attr('data-cost-type');
      $('body').find('input[name="cost_type"]').val(cost_type);
      // Update payment details
      var cost_human_readable = '$' + cost/100;
      var cost_blurb = $(this).attr('data-cost-blurb');
      $('body').find('.payment-cost h2').html(cost_human_readable);
      $('body').find('.payment-cost p').html(cost_blurb);
    });

    // Allow users to
    $('#back-to-enrollment').on('click',function() {
      // Hide show enrollment/payment
      $('.slide').removeClass('active');
      $('#enrollment').addClass('active');
    });

    // Catch parameter value
    function getParameterByName(name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
          results = regex.exec(location.search);
      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    var paymentStatus = getParameterByName('payment');
    if ( paymentStatus === 'paid' ) {
      $('.slide').removeClass('active');
      $('#results').addClass('active');
    }

  }

});
