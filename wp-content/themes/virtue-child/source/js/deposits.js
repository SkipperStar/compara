$( "#slider" ).slider({
    range: 'min',
    min: 10000,
    max: 1000000,
    step: 1000,
    slide: function( event, ui ) {
        $('.js-deposits-search-value').val(ui.value);
    }
});

$('.js-deposits-search-value').change(function(){
    let inputValue = $('.js-deposits-search-value').val();

    $('#slider').slider('value', inputValue);

    // Check for maximum number 
    if( $('.js-deposits-search-value').val() > 1000000 ) {
        $('.js-deposits-search-value').val(1000000);
    }
});


$(document).ready(function(){

    $('.show-modal-info').on('click', function () {
        let postId = $(this).data('id');

        $.ajax({
            url: ajaxurl,
            data: {
                'action': 'post_ajax_request',
                'postId' : postId
            },
            success:function(data) {
                // This outputs the result of the ajax request
                $('.modal-dialog .modal-content').html(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });



    });

});
