$(function () {
    $(".sidebar .sidebar-nav li:not(li.main)").addClass("submenu-padding");
    $("li.has-sub >a").click(function (e) {
        e.preventDefault();
        // get the submenu of the selected list
        let subMenu = $(this).parent().find("> .sub-menu-wraper >ul.sub-menu");
        // get all parent sub menu of the opened sub menu
        let subParents = subMenu.parents("ul.sub-menu");
        // if the sidebar in the large size
        if (!$(".sidebar").hasClass("tog-sidebar"))
        {
            // close all sub menu opened
            $("li.has-sub ul.sub-menu").not(subMenu).not(subParents).slideUp();
            // and toggle the current sub menu
            subMenu.slideToggle();
        }
        // if the sidebar in the small shape
        // and the opened sub menu has parent sub menu
        // this means that the selected sub menu not main menu
        if ($(".sidebar").hasClass("tog-sidebar") && subParents.length > 0)
        {
            // toggle the current sub menu
            subMenu.slideToggle();
        }
    });

    $("li.has-sub").hover(function (e) {
        e.preventDefault();
        // if the sidebar in the small shape
        // and the hovered list not has any parent sub menu
        // this means that the selected menu is main menu
        if ($(".sidebar").hasClass("tog-sidebar") && $(this).parents("li.has-sub").length === 0)
        {
            // show the submenu
            $(this).find(">.sub-menu-wraper").show();
            $(this).find(">.sub-menu-wraper >ul.sub-menu").show();
            // show list item with the name of list [users || stores]
            $(this).find(">.sub-menu-wraper >ul.sub-menu >li.sub-hovered-info").show();
            // add this classes to style the submenu in the hover mode
            $(this).find(">.sub-menu-wraper").addClass("sub-hover-wraper");
            $(this).find(">.sub-menu-wraper >ul.sub-menu").addClass("sub-menu-hover");
        }
    }, function () {
        if ($(".sidebar").hasClass("tog-sidebar") && $(this).parents("li.has-sub").length === 0)
        {
            // hide the submenu
            $(this).find(">.sub-menu-wraper").hide();
            $(this).find(">.sub-menu-wraper >ul.sub-menu").hide();
            $(this).find(">.sub-menu-wraper >ul.sub-menu li.sub-hovered-info").hide();
            $(this).find(">.sub-menu-wraper").removeClass("sub-hover-wraper");
            $(this).find(">.sub-menu-wraper >ul.sub-menu").removeClass("sub-menu-hover");
        }
    });


    $(".show-side").click(function (e) {
        e.preventDefault();
        $(".sidebar").toggleClass("tog-sidebar");
        $(".sidebar .sidebar-nav li:not(li.main)").toggleClass("submenu-padding");
        $(".wraper .main-content").toggleClass("content-small");
        // toggle control class that hold content of li except the icon
        $(".control").toggle(200);
    });

    $(".show-side-mobile").click(function (e) {
        e.preventDefault();
        $(".sidebar").toggleClass("sidebar-toggle-small");
    });

    // tap script
    $(".tap-links a").click(function (e) {
        e.preventDefault();
        $(".tap-links a").removeClass("active-link");
        $(this).addClass("active-link");
        $(".tap-content .tap-box").addClass("disabled");
        let box_id = $(this).data("id");
        $("." + box_id).removeClass("disabled").addClass("active-content");
    });


    $(".btn-back").click(function (e) {
        e.preventDefault();
        return history.back();
    });
});
