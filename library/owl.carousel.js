$ = jQuery;
$(document).ready(function() {
	if ($.owlCarousel) {
        /*portada*/
        $("#myCarousel").owlCarousel({
            //autoPlay : true,
            stopOnHover : false,
            navigation : true,
            navigationText : false,
            items : 3,
            slideSpeed : 300
        });

    }
    //owl.trigger('owl.play',6000);
});
jQuery = $;