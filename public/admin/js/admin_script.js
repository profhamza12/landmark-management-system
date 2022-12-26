$(function () {
    "use strict";
    $('select').select2();
    $(".nav-link").click(function () {
        let active_tab = $(this).data('tab');
        $(".tab-pane").hide();
        $(".tab-content").find("#"+active_tab).show();
    });
    /* Start toggle in sidebar */
    $(".toggle-ul").click(function (e) {
        let toggledUl, mainList;
        e.preventDefault();
        // access the direct ul that have the current list details
        toggledUl = $(this).parent().find("> ul.data");
        mainList = $(this).parents("li.main").find("> ul.data");
        // access the main ul that hold all details 
        toggledUl.slideToggle();
        $("ul.data").not(toggledUl).not(mainList).slideUp();
    });

    if ($(window).width() < 767) {
        // hide sidebar
        $(".wrapper aside").addClass("toggle-aside");
        // remove the left margin
        $(".wrapper .content-wrapper").removeClass("content-wrapper-toggle");
        // add the full width to coontent wrapper
        $(".wrapper .content-wrapper").addClass("full-wrapper-content");
    }

    // hide sidebar in media screen (less than 767)
    $(window).resize(function () {
        $(".wrapper aside").addClass("toggle-aside");
        $(".wrapper .content-wrapper").removeClass("content-wrapper-toggle");
        $(".wrapper .content-wrapper").addClass("full-wrapper-content");
        $(".overlay").css("display", "none");
    });

    // toggle sidebar on pressing the list icon
    $(".list-icon").click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        if ($(window).width() < 767) {
            $(".wrapper .content-wrapper").removeClass("content-wrapper-toggle");
            $(".wrapper .content-wrapper").addClass("full-wrapper-content");
            $(".overlay").css("display", "block");
        }
        else {
            $(".wrapper .content-wrapper").toggleClass("content-wrapper-toggle");
            // make the content warpper width = 100%
            $(".wrapper .content-wrapper").toggleClass("full-wrapper-content");
            $(".overlay").css("display", "none");
        }
        $(".wrapper aside").toggleClass("toggle-aside");
    });

    // hide sidebar on pressing the window
    $(".overlay").click(function (e) {
        $(".wrapper aside").addClass("toggle-aside");
        $(".wrapper .content-wrapper").removeClass("content-wrapper-toggle");
        $(".wrapper .content-wrapper").addClass("full-wrapper-content");
        $(this).css("display", "none");
    });
    $(".show-text-box").click(function () {
        $(".text-box").show();
    });
    $(".close").click(function () {
        $(".text-box").hide();
    });
    /* End toggle in sidebar */
    /* Start Request Full Screen Mode */
    $(".full-screen").click(function () {
        toggleFullscreen();
    });
    /* End Request Full Screen Mode */
});