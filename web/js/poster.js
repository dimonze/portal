$(document).ready(function () {

    $('.movie_poster').click(function () {
        var id = $(this).attr("data-id");
        $('.movie_details').addClass('hidden');
        $('.content').addClass('preview');
        $('#' + id).removeClass("hidden");
//        $('.details').addClass('mobile');
    });
    $('.movie_details').click(function () {
        $(this).addClass('hidden');
        $('.content').removeClass('preview');
        $('.details').removeClass('mobile');
    });
    //
    //
    //
    // $(window).resize(function () {
    //     if (window.innerWidth < 801) {
    //         $('.content').addClass("mobile");
    //         $('.details').addClass("mobile");
    //         $('.movieDetails').addClass("mobile");
    //     } else {
    //         $('.movieDetails').removeClass("mobile");
    //         $('.content').removeClass("mobile");
    //         $('.details').removeClass("mobile");
    //     }
    // });
});
