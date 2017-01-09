

// ============================================================================
//                            SLIDE DES BOUTTONS
// ============================================================================
  $( ".sendMessage" ).click(function() {
    $( ".formulaire" ).slideToggle( "slow");
  });

  $( ".messagesEnvoyes" ).click(function() {
    $( ".envoyes" ).slideToggle( "slow");
  });

// ============================================================================
//                            FORM MATERIAL DESING
// ============================================================================
jQuery(function($) {
  $('.field-input').focus(function(){
    $(this).parent().addClass('is-focused has-label');
  });

  $('.field-input').each(function(){
    if($(this).val() != ''){
      $(this).parent().addClass('has-label');
    }
  });

  $('.field-input').blur(function(){
    $parent = $(this).parent();
    if($(this).val() == ''){
      $parent.removeClass('has-label');
    }
    $parent.removeClass('is-focused');
  });
})
