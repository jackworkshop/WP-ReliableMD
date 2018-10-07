define(['jquery', 'tui-viewer', 'viewer-mathsupport'], function ($, Viewer) {
    var callback = function ($node) {
        return $node;
    };
    var renderer = {};
    renderer.setCallback = function (func) {
        callback = func;
    };
    renderer.entityToString = function (s) {
        s = s.replace(/&#8211;/g, '-');
        s = s.replace(/&lt;/g, '<');
        s = s.replace(/&gt;/g, '>');
        return s;
    };

    renderer.render = function () {
        $('.markdown').each(function () {
            var text = $(this).val() || $(this).html();
            var ele = callback($(this));
            ele.html('');
            text = renderer.entityToString(text);

            console.log(text);

            var viewer = new Viewer({
                el: ele[0],
                viewer: true,
                initialValue: text,
                exts: [
                    {
                        name: 'chart',
                        minWidth: 100,
                        maxWidth: 600,
                        minHeight: 100,
                        maxHeight: 300
                    },
                    'colorSyntax',
                    'uml',
                    'mark',
                    'table',
                    'mathsupport'
                ]
            });
            $('[data-te-task]').removeAttr('data-te-task');
        });
    };
    // usage: make a div with class markdown, write it in markdown, and it will be converted into html
    // warnning: your markdwon text must be aligned from left
    $(document).ready(function () {
        renderer.render();
    });
    //module.exports = renderer;
    return renderer;
});

