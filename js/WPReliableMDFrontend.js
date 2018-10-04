
requirejs(['jquery', 'ReliableMD_render'], function ($, render) {
    render.setCallback(function (jqnode) {
        //return jQuery('markdown-block');
        var $markdown = $('.markdown-block');
        return $markdown;
    });
});

