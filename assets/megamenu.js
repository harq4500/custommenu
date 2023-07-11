(($)=>{
    
    /**
     * Small script to help css to show Mega menu block full screen
     */
    for(let i = 0; i < $('.custom-mega-menu').eq(0).parents().length; i++){
        if(!['HTML','BODY','HEADER'].includes($('.custom-mega-menu').eq(0).parents()[i].nodeName)){
            $($('.custom-mega-menu').eq(0).parents()[i]).css('position','static')
        }
    }
})(jQuery)