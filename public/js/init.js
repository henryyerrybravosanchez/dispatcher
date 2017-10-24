(function($){
  $(function(){

    $('.button-collapse').sideNav();


    $(".obligatorio").keyup(function()
    {
      probar($(this));

    }).focusout(function()
    {
      probar($(this));
    });

  }); // end of document ready
  function probar(v)
  {
    if(v.val()=="")
    {
      v.addClass('invalid');
    }
    else
      v.removeClass('invalid');


  }
})(jQuery); // end of jQuery name space