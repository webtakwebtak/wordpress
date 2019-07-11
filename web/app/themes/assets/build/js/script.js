import $ from 'jquery';
window.jQuery = $;
window.$ = $;
import 'slick-carousel';

require('./wp-responsive-images.js');

$( document ).ready(function() {
	
    $( ".porta" ).click(function() {
        var data = {
            'action': 'my_action',
            'whatever': ajax_object.we_value
        };
        $.post(ajax_object.ajax_url, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
     });
    
    $(".slider-wrapper").slick({     		
    	dots: true,
    	  infinite: false,
    	  speed: 300,
    });

    //call responsive-image-plugin
    $(window).replaceImagesViewport({
    	debug: true,
		loadedclass: 'loaded', 
		excludedclass: 'excluded', 
		slickclass: 'slider-wrapper',
		responsive: [
			 {
				 breakpoint: 1140,
				 imagesize: 'full'
			 },
			 {
				 breakpoint: 960,
				 imagesize: 1140
			 },
			 {
				 breakpoint: 720,
				 imagesize: 960
			 },
			 {
				 breakpoint: 540,
				 imagesize: 720
			 },
			 {
				 breakpoint: 300,
				 imagesize: 540
			 },
			 {
				 breakpoint: 150,
				 imagesize: 50
			 }
	     ]	
    });
      
});
