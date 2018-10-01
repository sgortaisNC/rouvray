jQuery(document).ready(function($) {
    //Popup - Default config
    var popupCenter = function(url, title, width, height){
        var popupWidth = width || 640;
        var popupHeight = height || 320;
        var windowLeft = window.screenLeft || window.screenX;
        var windowTop = window.screenTop || window.screenY;
        var windowWidth = window.innerWidth || document.documentElement.clientWidth;
        var windowHeight = window.innerHeight || document.documentElement.clientHeight;
        var popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2 ;
        var popupTop = windowTop + windowHeight / 2 - popupHeight / 2;
        var popup = window.open(url, title, 'scrollbars=yes, width=' + popupWidth + ', height=' + popupHeight + ', top=' + popupTop + ', left=' + popupLeft);
        popup.focus();
        return true;
    };

    //Récupération des informations de la page en cours de consultation
    var url = window.location.href;
    var title = document.title;

    //Bouton Twitter
    $('#share-twitter').on('click', function(e){
        e.preventDefault();
        var shareUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) +
            "&url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Twitter");
    });

    //Bouton Facebook
    $('#share-facebook').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('data-url');
        var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);;
        popupCenter(shareUrl, "Partager sur Facebook");
    });

    //Bouton Google
    $('#share-google').on('click', function(e){
        e.preventDefault();
        var shareUrl = "https://plus.google.com/share?url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Google+");
    });

    //Bouton LinkedIn
    $('#share-linkedin').on('click', function(e){
        e.preventDefault();
        var shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Linkedin");
    });

    //Bouton Pinterest
    $('#share-pinterest').on('click', function(e){
        e.preventDefault();
        var shareUrl = "http://www.pinterest.com/pin/create/button/?url=" + encodeURIComponent(url) +
            "&description=" + encodeURIComponent(document.title) +
            "&media=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Pinterest");
    });

    //Bouton Email
    $('#share-email').on('click', function(){
        $('#share-email-container').modal();
    });
    $('#share-email-send').on('click', function(e){
        e.preventDefault();
        $('#share-email-alerte .alert').hide();
        var titre = title.split('|');
        $.ajax({
            url: '/share/email',
            type: 'POST',
            data: {
                name: $('#share-email-body #name').val(),
                email: $('#share-email-body #email').val(),
                link: '<a href="'+ url +'" title="'+ titre[0] +'">'+ titre[0] +'</a>',
            },
            dataType: 'json',
            success: function(data){
                $('#share-email-body #name').val('');
                $('#share-email-body #email').val('');
                if(data.response === true){
                    $('#share-email-alerte .alert-success').show();
                }else{
                    $('#share-email-alerte .alert-warning').show();
                }
            }
        });
    });

    //Bouton RSS
    $('#share-rss').on('click', function(e){
        e.preventDefault();
        window.open($(this).data('url'), "_blank");
    });

    //Bouton Print
    $('#share-print').on('click', function(e){
        e.preventDefault();
        window.print();
    });
});
