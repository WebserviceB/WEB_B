// welcomスプラッシュ


// マップフェードイン
AOS.init();

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


// トップへ戻るボタン

let $pagetop = $('.scrolltop');
$(window).on('scroll', function () {
  if ($(this).scrollTop() < 40) {
    $pagetop.removeClass('active');
  } else {
    $pagetop.addClass('active');
  }
});

$('a[href^="#"').on('click', function () {
  var href = $(this).attr("href");
  var target = $(href == "#" || href == "" ? 'html' : href);
  var position = target.offset().top;
  $("html,body").animate({ scrollTop: position }, 550, "swing");
  return false;
});
  
