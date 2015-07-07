( function ($) {
    
    /**
     * Show success alert init
     */
    function showSuccessAlert(text) {
        var elem = $('.fixed-alert-success');
        elem.find('.text').text(text);
        elem.show();
        setTimeout(function(){
            elem.hide();
            elem.find('.text').text('');
        }, 5000);
    }
    /**
     * Document ready
     */
    $(function () {
        /**
         * Rating stars
         */
        var ratingElem = $('#rating_id');
        ratingElem.rating({
            'size': 'xs',
            'showClear': false,
            'showCaption': false,
        }).on('rating.change', function (event, value, caption) {
            var id = ratingElem.data('id');
            if(value >= 0 && id > 0 ) {
                $.post('/rating', {id: id, rate: value}, function (result) {
                    if(result.status === 1) {
                        ratingElem.rating('update', result.rate)
                                  .rating('refresh', {'readonly': true})
                                  .data('readonly', true);
                        showSuccessAlert('Your rate is counted.');
                    }
                });
            }
        });

        var ratingPopover = $('#popover-rating');
        ratingElem.parent().on('click', function (event) {
            if(ratingElem.data('readonly') && ratingElem.data('access')) {
                
                if(ratingPopover.is(':visible')) {
                    ratingPopover.hide();
                }else {
                    ratingPopover.show();
                }
                

            }
        });

        $('body').on('click', function (event) {
            if(!$(event.target).closest('#popover-rating').length) {
                ratingPopover.hide();
            }
        });

        ratingPopover.find('a').on('click', function(event) {
            ratingElem.data('readonly', false).rating('refresh', {'readonly': false});
            ratingPopover.hide();
        });


    });
})(jQuery);