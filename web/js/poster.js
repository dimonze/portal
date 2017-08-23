$(document).ready(function () {

    $('.movie_poster').click(function () {
        var id = $(this).attr("data-id");
        $('.movie_poster').removeClass('selected');
        $('.movie_details').addClass('hidden');
        $('.content').addClass('preview');
        $('#' + id).removeClass("hidden");
        $(this).addClass('selected');
//        $('.details').addClass('mobile');
    });
    $('.movie_details').click(function () {
        $(this).addClass('hidden');
        $('.content').removeClass('preview');
        $('.details').removeClass('mobile');
        $('.movie_poster').removeClass('selected');
    });

    $('.slider.round').click(function () {

        if( $('body').attr("class") !== "dark"){
            $('.movie_poster').addClass('dark');
            $('#changeTheme').addClass('dark');;
            $('body').addClass('dark');;
        }else{
            $('.movie_poster').removeClass('dark');
            $('#changeTheme').removeClass('dark');;
            $('body').removeClass('dark');;
        }


    });

     $.get("http://kinokrad.co/301550-pod-pokrovom-nochi.html", function( data ) {
         $( "#trailer" ).html( data );
         //alert( "Load was performed." );
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
