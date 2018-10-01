jQuery(window).on("load", function () {
    // Animate loader off screen
    jQuery("body").removeClass("stuck");
    for (var progress = 0; progress < 100; progress++) {
        jQuery(".progress-bar").css("width", progress + "%");
    }
    setTimeout(function () {
        jQuery("#loader").fadeOut(500);
    }, 700);
});


jQuery(document).ready(function ($) {

    if ($(".sliderSlick").length > 0) {
        $(".sliderSlick").slick({
                arrows: false,
                speed: 0
            }
        );
        $(".navSlideHome").mouseenter(function () {
            $(".sliderSlick").slick("slickGoTo", parseInt($(this).data("toslide")));
        })
    }
    lightbox.option({
        "albumLabel" : "Image %1 sur %2"
    });
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).lightbox();
    });


    $('[data-toggle="tooltip"]').tooltip();

    $("#search-block-form .input-group, #search-form .input-group").append('<div class="form-actions js-form-wrapper form-wrapper">' +
        '<div class="input-group-append">' +
        '<button class="btn btn-white" type="submit">' +
        '<i class="fa fa-search"></i>' +
        '</button>' +
        '</div>' +
        '</div>');
    $('.home form select').change(function () {
        var form = $(this).closest('form');
        form.submit();
    });

    $(".js-do-form-control input, .js-do-form-control select, .js-do-form-control textarea").addClass("form-control");

    $('#block-site-content table').each(function () {
        if (!$(this).hasClass("table")) {
            $(this).addClass("table").addClass("table-bordered");
        }
    });

    $('img').each(function () {
        if (!$(this).hasClass("img-fluid")) {
            $(this).addClass("img-fluid");
        }
    });

    $('input[type=search]').each(function () {
        if (!$(this).hasClass("form-control")) {
            $(this).addClass("form-control");
        }
        $(this).removeAttr("size");
    });
    $(".accordion a").each(function () {
        if (!$(this).hasClass('collapsed')) {
            $(this).parent().parent().addClass("is-open")
        }
    });
    $(".accordion a").click(function () {
        $(this).parent().parent().toggleClass("is-open");
    });
    if ($('#mapmultiple').length > 0) {

        var map = L.map('mapmultiple').setView([49.05, 1.35], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
        }).addTo(map);

        var markerArray = [];
        var markers = L.markerClusterGroup();

        var hIcon = L.icon({
            iconUrl: 'img/marker.png',
            iconSize: [52, 51],
            iconAnchor: [25, 47],
        });
        $(".marker").each(function () {
            var marker = L.marker([$(this).data("lat"), $(this).data("lng")], {icon: hIcon}).addTo(map);
            marker.addTo(map);
            markers.addLayer(marker);
            markerArray.push(marker);
        });
        map.addLayer(markers);
        var group = L.featureGroup(markerArray);
        map.fitBounds(group.getBounds(), {padding: [25, 25]});
    }
    if ($('#mapid').length > 0) {
        var map = L.map('mapid').setView([$(".marker").data("lat"), $(".marker").data("lng")], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
        }).addTo(map);

        var hIcon = L.icon({
            iconUrl: '/themes/site/img/marker.png',
            iconSize: [52, 51],
            iconAnchor: [25, 47]
        });
        L.marker([$(".marker").data("lat"), $(".marker").data("lng")], {icon: hIcon}).addTo(map);
    }
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    $(window).resize(function () {
        width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width > 1200) {
            $(".main_menu  li.dropdown").on("mouseenter", function () {
                $(this).addClass("is-active");
                $(this).children("ul").show();
            }).on("mouseleave", function () {
                $(this).children("ul").hide();
                $(this).removeClass("is-active");
            });
        } else {
            $('.hamburger').click(function () {
                $(this).toggleClass("is-active");
                $(".main_menu").addClass("is-active");
            });
            $('body').on("click", ".removeMenu", function (e) {
                e.preventDefault();
                $(this).parent().removeClass('is-active');
                if ($(this).parent().hasClass("main_menu")) {
                    $(".hamburger").removeClass("is-active");
                }
                ;
            });
            $(".main_menu .dropdown > a").click(function (e) {
                e.preventDefault();
                $(this).parent().children("ul").addClass("is-active");
            });
            $(".main_menu, .main_menu ul").append('<li class="removeMenu text-right"><a href="#"><i class="fa fa-arrow-left"></a></li>');

        }
    });

    $(window).trigger('resize');


});

