(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['tui-editor', 'markdown-it-mathjax', 'katex'], factory);
    } else if (typeof exports === 'object') {
        factory(require('tui-editor'));
    } else {
        factory(root['tui']['Editor']);
    }
})(this, function (Editor) {
    Editor.defineExtension('mathsupport', function () {
        var option = {
            beforeMath: '',
            afterMath: '',
            beforeInlineMath: '$',
            afterInlineMath: '$',
            beforeDisplayMath: '$$',
            afterDisplayMath: '$$'
        };
        Editor.markdownitHighlight
            .use(require('markdown-it-mathjax')(option));
    })
});



