requirejs.config({
    //By default load any module IDs from js/lib
    baseUrl: '../bower_components/',
    //except, if the module ID starts with "app",
    //load it from the js/app directory. paths
    //config is relative to the baseUrl, and
    //never includes a ".js" extension since
    //the paths config could be for a directory.
    paths: {
        'tui-editor': 'tui-editor/dist/tui-editor-Editor-all',
        'jquery': 'jquery/dist/jquery',
        'codemirror': 'codemirror/lib/codemirror',
        'markdown-it': 'markdown-it/dist/markdown-it',
        'to-mark': 'to-mark/dist/to-mark',
        'tui-code-snippet': 'tui-code-snippet/dist/tui-code-snippet',
        'tui-color-picker': 'tui-color-picker/dist/tui-color-picker',
        'highlight': 'highlightjs/highlight.pack.js',
        'squire-rte': 'squire-rte/build/squire-raw',
        'plantuml-encoder': 'plantuml-encoder/dist/plantuml-encoder',
        'tui-chart': 'tui-chart/dist/tui-chart',
        'raphael': 'raphael/raphael'

    }
});

// Start the main app logic.
requirejs(['jquery', 'tui-editor'],
    function ($, canvas, sub) {
        //jQuery, canvas and the app/sub module are all
        //loaded and can be used here now.
    });
