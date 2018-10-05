
requirejs(['jquery', 'ReliableMD_render'], function ($, render) {
    render.setCallback(function ($node) {
        //return jQuery('markdown-block');
        return $node.parent().attr('class') === 'markdown-block' ? $node.parent() : $node;
    });
});

