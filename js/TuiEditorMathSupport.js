console.log('fuck');

(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['tui-editor'], factory);
    } else if (typeof exports === 'object') {
        factory(require('tui-editor'));
    } else {
        factory(root['tui']['Editor']);
    }
})(this, function(Editor) {
    Editor.defineExtension('mathsupport', function() {
        var options = {
            inlineOpen: '$',
            inlineClose: '$',
            blockOpen: '$$',
            blockClose: '$$',
            renderingOptions: {},
            inlineRenderer: require('ascii2mathml')(this.rendererOptions),
            blockRenderer: require('ascii2mathml')(Object.assign({ display: 'block' },
                this.renderingOptions))
        };
        previewer.convertor.constructor.getMarkdownitHighlightRenderer()
            .use(require('markdown-it-math'), options);
    });

});
