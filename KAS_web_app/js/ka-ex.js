$(function() {
    $('#refresh').click(function() {
        location.reload();
    });
    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $("#toTop").click(function () {
        $("html,body").animate({scrollTop:0},800);
    });
});