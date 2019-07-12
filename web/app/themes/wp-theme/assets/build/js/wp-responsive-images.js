(function($) {
    $.fn.replaceImages = function(options) {
    	var imgfeatures = {
    			url: '',
    			fullname: '',
    			shortname: '',
    			path: '',
    			ext: '',
    			displaywidth: '',
    			originalwidth: '',
    			ratio: ''
    	}
    	
    	var settings = $.extend({
    		debug: false,
    		loadedclass: 'loaded', 
    		excludedclass: 'excluded', 
    		fullclass: 'size-full', 
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
				 }
		     ]	
        }, options );
    	
        this.each( function() {
        	//only active slide images
        	var slide = $(this).closest('.slick-slide');
        	if(slide.length > 0 && !slide.hasClass('slick-current')){
        		return false;
        	}
        	
        	//only images in viewport
        	if(isImageInViewport(this)){
	        	//exlude loaded en excluded selectors
	        	if( !$(this).hasClass(settings.loadedclass) && 
	        		!$(this).hasClass(settings.excludedclass) && 
	        		!$(this).hasClass(settings.fullclass) ){
	        		//only image tha are not full sized already	
		        	if(isImageNotFullVersion(this)){
		        		loadBestOptionImage(this);
		        	}
	        	}
        	}
        	return false;
        });
        
        function isImageInViewport(obj) {
        	var elementTop = $(obj).offset().top;
        	var elementBottom = elementTop + $(obj).outerHeight();
        	var viewportTop = $(window).scrollTop();
        	var viewportBottom = viewportTop + $(window).height();
        	return ( elementBottom > viewportTop && elementTop < viewportBottom );
        };
        
        function isImageNotFullVersion(obj) {
        	imgfeatures.url 		= $(obj).attr('src');
        	imgfeatures.fullname 	= imgfeatures.url.substring(imgfeatures.url.lastIndexOf('/')+1);
    		if( imgfeatures.fullname.includes("x") ){
    			return true;
    		}
    		return false;
        };
        
        function loadBestOptionImage(obj) {
        	var index;
        	var imgname;
        	var newheight;
        	var imagesize;
        	var breakpoint;
        	getAllImageAttributes(obj);
        	if(index = getNewImageIndex()){
        		imagesize 	= settings.responsive[index].imagesize;
        		breakpoint 	= settings.responsive[index].breakpoint;
        		if( imagesize == 'full'){
        			imgname	= imgfeatures.shortname+'.'+imgfeatures.ext;
        		}
        		else{
        			newheight	= Math.round(imagesize/imgfeatures.ratio);
    	    		imgname		= imgfeatures.shortname+'-'+imagesize+'x'+newheight+'.'+imgfeatures.ext;
        		}
        		
        	}
        	$(obj).attr("src", imgfeatures.path+imgname);
    		$(obj).addClass("loaded");
        };
        
        function getNewImageIndex() {
        	for (index = 0; index <= settings.responsive.length - 1; ++index) {
        		var imagesize 	= settings.responsive[index].imagesize;
        		var breakpoint 	= settings.responsive[index].breakpoint;
        		if(imagesize == 'full'){
        			imagesize = imgfeatures.originalwidth;
        		}
        		if( imgfeatures.displaywidth >= breakpoint && imgfeatures.originalwidth >= imagesize  ){
        			return index;
        		}
        	}
        	//return last option
        	return (index-1);
        };
        
        function getAllImageAttributes(obj) {
        	var lasthyphen 				= imgfeatures.fullname.lastIndexOf('-');
        	var lastslash 				= imgfeatures.url.lastIndexOf('/');
    		var lastdot 				= imgfeatures.fullname.lastIndexOf('.');
    		var originalwidth			= $(obj).data('media-width');
    		var originalheight			= $(obj).data('media-height');
    		
    		imgfeatures.shortname 		= imgfeatures.fullname.substring(0,lasthyphen);
    		imgfeatures.path 			= imgfeatures.url.substring(0,lastslash)+'/';
    		imgfeatures.ext 			= imgfeatures.fullname.substring(lastdot+1);
    		imgfeatures.displaywidth	= $(obj).width();
    		imgfeatures.originalwidth	= originalwidth;
    		imgfeatures.ratio			= originalwidth/originalheight;
    		debug();
        };
        
        function debug() {
        	if(settings.debug){
	        	console.log("url:"+imgfeatures.url);
	    		console.log("fullname:"+imgfeatures.fullname);
	    		console.log("shortname:"+imgfeatures.shortname);
	    		console.log("path:"+imgfeatures.path);
	    		console.log("ext:"+imgfeatures.ext);
	    		console.log("display-wdth:"+imgfeatures.displaywidth);
	    		console.log("imgratio:"+imgfeatures.ratio);
	    		console.log("originalwidth:"+imgfeatures.originalwidth);
        	}
        };
        
    }
})(jQuery);

(function($) {
    $.fn.replaceImagesViewport = function(options) {
    	
    	var windowwidth = $(this).width();
    	var scrolltop 	= $(this).scrollTop();
    	
    	var settings = $.extend({
    		scrollsens: 150,
    		resizesens: 150, 
    		slickclass: 'slider-wrapper'
        }, options );

    	//on load
    	$(this).ready(function () {
    		$("img").each(function() {  
   				$(this).replaceImages(options);
   		    }); 
    	});
    	
    	//on scroll in steps
    	$(this).on("scroll", function() {
    		if( Math.abs($(this).scrollTop() - scrolltop) > settings.scrollsens ){
	    		$("img").each(function() {  
	    			 $(this).replaceImages(options);
	    	    }); 
	    		scrolltop = $(this).scrollTop();
    		}
    	});	
    	
    	//on resize in steps 
    	$(this).on("resize", function() {
	   		if( Math.abs($(this).width() - windowwidth) > settings.resizesens ){
	   			$("img").removeClass("loaded");
	   			$("img").each(function() {  
	   				$(this).replaceImages(options);
	   		    }); 
	   			windowwidth = $(this).width();
	   		}
   	 	});	
    	
    	//on load slide with slick slider
    	 $("."+settings.slickclass).on('afterChange', function(event, slick, currentSlide){
			$(this).find(".slick-current img").replaceImages(options);
		 });

    }
})(jQuery);
