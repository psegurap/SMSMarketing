function SetSidebarActiveOption(selector){
    let menues = $('.menu-categories').find('.menu .dropdown-toggle');
    menues.map(function(){
        $(this).attr('data-active', false);
    });
    $('.menu-categories').find(".menu " + selector).attr('data-active', true)
}
