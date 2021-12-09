$(function() {
    let rotate = 180;
    $('#titre_recherche').click(function(e){
        $('#recherche_content').toggleClass('wrapper_content_close');
        $('.icon').css('transform', 'rotate('+ rotate +'deg)');
        if(rotate === 0){
            rotate = 180;
        }else{
            rotate = 0;
        }
    })

});