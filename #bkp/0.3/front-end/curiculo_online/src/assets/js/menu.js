jQuery(document).ready(function() {
    jQuery("*").click(function(event) { //all element clicked 
        var element = jQuery(event.target); //element clicked
        if (element.attr("id") != "iconAcount"){
            element = jQuery(event.target).closest('#iconAcount'); //element id is iconAcount if not load parent element with id iconAcount
        }    
        if (element.length != 0) { //element have id = iconAcount
            jQuery('.containerMiniMenu').toggleClass('d-none'); //toggle hidde show div className containerMiniMenu
            return 0; //exit function
        }
        if (!jQuery('.containerMiniMenu').hasClass('d-none')){
            jQuery('.containerMiniMenu').addClass('d-none'); //hidde div className containerMiniMenu
        }
    });
});