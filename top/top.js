
// トップ検索窓

$(document).ready(function () {
   $('.search_textbox').blur(function() {
        if($(this).val().length === 0){
          $('.search-label').removeClass("focus");
        }
        else { returns; }
      })
      .focus(function() {
        $('.search-label').addClass("focus")
      });
});

  AOS.init();