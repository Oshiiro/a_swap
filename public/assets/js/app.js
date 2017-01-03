
  $( ".sendMessage" ).click(function() {
    $( ".formulaire" ).slideToggle( "slow");
  });

  $( ".MessagesEnvoyes" ).click(function() {
    $( ".envoyes" ).slideToggle( "slow");
  });

  jQuery(function($) {
    //  Au focus
    $('.field-input').focus(function(){
      $(this).parent().addClass('is-focused has-label formbar');
    });

    // à la perte du focus
    $('.field-input').blur(function(){
      $parent = $(this).parent();
      if($(this).val() == ''){
        $parent.removeClass('is-focused');
      }
      $parent.removeClass('formbar');
    });

    // si un champs est rempli on rajoute directement la class has-label
    $('.field-input').each(function(){
      if($(this).val() != ''){
        $(this).parent().addClass('has-label is-focused');
      }
    });
  })
