define(['jquery', 'tui-editor', 'mathsupport'], function ($, Editor) {
    var callback = function ($node) {
        return $node;
    };
    var renderer = {};
    renderer.setCallback = function (func) {
        callback = func;
    };
    renderer.entityToString = function (entity) {
        var div = document.createElement('div');
        div.innerHTML = entity;
        return div.innerText || div.textContent;
    };

    renderer.render = function () {
        $('.markdown').each(function () {
            var text = $(this).val() || $(this).html();
            var ele = callback($(this));
            ele.html('');
            text = renderer.entityToString(text);
            // text = text.replace(/\$\$(.*)\$\$/g, function (t) {
            //     return "<br><div class='latex' style='display: block;'>" + processLatex(t) + "</div>\n";
            // });
            // text = text.replace(/\$(.*)\$/g, function (t) {
            //     return "<div class='latex' style='display: inline;'>" + processLatex(t) + "</div>";
            // });
            var viewer = new Editor.factory({
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

