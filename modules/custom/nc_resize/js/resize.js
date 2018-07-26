jQuery(document).ready(function($){
    $('.resize').on('click', function(){
        if($(this).hasClass('resize-plus')){
            $('body').css('font-size', parseInt($('body').css('font-size')) + 1);
        }else{
            $('body').css('font-size', parseInt($('body').css('font-size')) - 1);
        }
    });
});