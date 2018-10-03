(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['tui-editor', 'markdown-it-mathjax', 'katex'], factory);
    } else if (typeof exports === 'object') {
        factory(require('tui-editor'));
    } else {
        factory(root['tui']['Editor']);
    }
})(this, function (Editor) {
    // Editor.defineExtension('youtube', function () {
    //     Editor.codeBlockManager.setReplacer('youtube', function (youtubeId) {
    //         var wrapperId = 'yt' + Math.random().toString(36).substr(2, 10);
    //         setTimeout(renderYoutube.bind(null, wrapperId, youtubeId), 0);
    //
    //         return '<div id="' + wrapperId + '"></div>';
    //     });
    // });
    //
    // function renderYoutube(wrapperId, youtubeId) {
    //     var el = document.querySelector('#' + wrapperId);
    //     el.innerHTML = '<iframe width="420" height="315" src="https://www.youtube.com/embed/' + youtubeId + '"></iframe>';
    // }
    window.edt = Editor;
    Editor.defineExtension('mathsupport', function () {
        console.log('enabled');
        var options = {
                inlineOpen: '$',
                inlineClose: '$',
                blockOpen: '$$',
                blockClose: '$$',
                renderingOptions: {},
                inlineRenderer: function (lt) {
                    console.log(lt);
                    var html = require('katex').renderToString(lt);
                    console.log(html);
                    return html;
                },
                blockRenderer: function (lt) {
                    console.log(lt);
                    var html = require('katex').renderToString(lt);
                    console.log(html);
                    return html;
                }

            }
        ;
        Editor.markdownitHighlight
            .use(require('markdown-it-mathjax'));
    })
});



