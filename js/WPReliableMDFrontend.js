// todo here
requirejs(['jquery',  'ReliableMD_render'], function ($, render) {
    render.setCallback(function (jqnode) {
        //return jQuery('markdown-block');
        return $('.markdown-block');
    });
});

