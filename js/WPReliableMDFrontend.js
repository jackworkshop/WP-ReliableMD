// todo here
requirejs(['jquery', 'ReliableMD_render'], function ($, render) {
    window.renderer.setCallback(function (jqnode) {
        //return jQuery('markdown-block');
        var $markdown = $('.markdown-block');
        return $markdown;
    });
});

