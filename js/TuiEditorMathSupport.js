(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['tui-editor', 'markdown-it-mathsupport', 'katex'], factory);
    } else if (typeof exports === 'object') {
        factory(require('tui-editor'));
    } else {
        factory(root['tui']['Editor']);
    }
})(this, function (Editor) {
    var math_render = require('katex').renderToString;
    Editor.defineExtension('mathsupport', function () {
        var option = {
            renderer: function (text, type) {
                if (type === 'InlineMath') {
                    return '<span style="display: inline;">' + math_render(text) + '</span>'
                }
                else // type === 'DisplayMath'
                {
                    return '<span style="display: block;">' + math_render(text) + '</span>'
                }
            }
        };
        Editor.markdownitHighlight
            .use(require('markdown-it-mathsupport')(option));

        Editor.codeBlockManager.setReplacer('latex', function(ltx) {
            return option.renderer(ltx, 'DisplayMath');
        });
    });
});



