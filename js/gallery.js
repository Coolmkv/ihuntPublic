/*

*Project Name: Calibre Admin Bootstrap Template;
*Author: Lancecoder;
*Website: lancecoder.com;
*Filename: extras/gallery.js;

*/

"use strict";

var $container = $('.masonry-container');

$(document).ready(function(){
	$('.lightgallery').lightGallery({
        thumbnail: true,
        selector: 'a'
    });

    
    loadGalleryMonsonry();


	var $isotope_gallery = $('.lightgallery');
	$isotope_gallery .isotope({
    	layoutMode: 'fitRows',
        itemSelector: '.item',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });


    $(".media-gallery-options > li > a").on("click", function(){
    	var selector = $(this).attr('data-filter');

        $isotope_gallery.isotope({filter: selector});

        setTimeout(function(){ loadGalleryMonsonry() }, 600);

        removeActiveOptions();
        $(this).addClass('active');
        return false;
    });

    $(".toggle-sidebar").on("click", function(){
        setTimeout(function(){ loadGalleryMonsonry() }, 600);
    });
});

function removeActiveOptions() {
    $.each($(".media-gallery-options > li > a"), function(){
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });
}

function loadGalleryMonsonry() {
    $container.imagesLoaded( function () {
        $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item',
            animate: true
        });
    });
}