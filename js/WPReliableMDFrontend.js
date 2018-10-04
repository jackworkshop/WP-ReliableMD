// todo here
requirejs(['jquery',  'ReliableMD_render'], function ($, render) {
    render.setCallback(function (jqnode) {
        return jqnode[0];
    });
});

