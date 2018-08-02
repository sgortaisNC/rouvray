

jQuery(window).on("load", function () {
    // Animate loader off screen
    jQuery("body").removeClass("stuck");
    var progress = 0;
    for (progress = 0 ; progress < 100 ; progress ++){
        jQuery(".progress-bar").css("width",progress+"%");
    }
    setTimeout(function(){
        jQuery("#loader").fadeOut(500);
    }, 700);
});


$( document ).ready(function() {
    $(".accordion a").each(function(){
        if   (!$(this).hasClass('collapsed')){
            $(this).parent().parent().addClass("is-open")
        }
    });
    $(".accordion a").click(function(){
        $(this).parent().parent().toggleClass("is-open"); 
    });
    if   ($('#mapmultiple').length > 0){
        var map = L.map('mapmultiple').setView([49.05, 1.35], 11); L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
        }).addTo(map);

        var hIcon = L.icon({
            iconUrl: 'img/marker.png',
            iconSize:     [52, 51],
            iconAnchor:   [25, 47],
        });
        $(".marker").each(function(){
            L.marker([$(this).data("lat"), $(this).data("lng")], {icon: hIcon}).addTo(map);
        });
    }
    if  ($('#mapid').length > 0){
        var map = L.map('mapid').setView([47.9, 3.6667], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
        }).addTo(map);

        var hIcon = L.icon({
            iconUrl: 'img/marker.png',
            iconSize:     [52, 51],
            iconAnchor:   [25, 47],
        });
        L.marker([47.9, 3.6667], {icon: hIcon}).addTo(map);
    }
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    $( window ).resize(function() {
        width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if  (width > 1200 ){ $(".main_menu  li.dropdown").on("mouseenter",function(){
            $(this).addClass("is-active");
            $(this).children("ul").show();
        }).on("mouseleave",function(){
            $(this).children("ul").hide();
            $(this).removeClass("is-active");
        });
                           }else{
                               $('.hamburger').click(function(){
                                   $(this).toggleClass("is-active"); 
                                   $(".main_menu").addClass("is-active");
                               });
                               $('body').on("click",".removeMenu",function(e){
                                   e.preventDefault();
                                   $(this).parent().removeClass('is-active');
                                   if  ($(this).parent().hasClass("main_menu")){
                                       $(".hamburger").removeClass("is-active");  
                                   };
                               });
                               $(".main_menu .dropdown > a").click(function(e){
                                   e.preventDefault();
                                   $(this).parent().children("ul").addClass("is-active");
                               });
                               $(".main_menu, .main_menu ul").append('<li class="removeMenu text-right"><a href="#"><i class="fa fa-arrow-left"></a></li>');

                           }
    });

    $(window).trigger('resize');


});

