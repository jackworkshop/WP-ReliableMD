function configure_requirejs() {
    var lib_dep = typeof ReliableMD !== 'undefined' ? ReliableMD.js_dep_lib_root : '../bower_components/';
    var lib_js = typeof ReliableMD !== 'undefined' ? ReliableMD.js_root : '../js/';
    requirejs.config({
        //By default load any module IDs from js/lib
        baseUrl: lib_dep,
        //except, if the module ID starts with "app",
        //load it from the js/app directory. paths
        //config is relative to the baseUrl, and
        
        //never require the same module with different names
        
        //never includes a ".js" extension since
        //the paths config could be for a directory.
        
        //***********fixed**********
        // Do not define a module name like "highlight.js"
        // for it will be explained as a path, rather than a module name
        // fixed by QiuJiangkun before 2018/10/8
        //**************************
        
        
        paths: {
            'tui-editor': lib_js + 'tui-editor/dist/tui-editor-Editor-all',
            'tui-viewer': lib_js + 'tui-editor/dist/tui-editor-Viewer-all',
            'jquery': 'jquery/dist/jquery',
            'codemirror': 'codemirror/lib/codemirror',
            'markdown-it': 'markdown-it/dist/markdown-it',
            'to-mark': 'to-mark/dist/to-mark',
            'tui-code-snippet': lib_js + 'tui-code-snippet/dist/tui-code-snippet',
            'tui-color-picker': lib_js + 'tui-color-picker/dist/tui-color-picker',
            'highlight.js': 'highlightjs/highlight.pack',
            'squire-rte': 'squire-rte/build/squire-raw',
            'plantuml-encoder': lib_js + 'plantuml-encoder/dist/plantuml-encoder',
            'tui-chart': lib_js + 'tui-chart/dist/tui-chart',
            'viewer-mathsupport': lib_js + 'TuiViewerMathSupport',
            'editor-mathsupport': lib_js + 'TuiEditorMathSupport',
            'tui-mathsupport': lib_js + 'TuiMathSupport',
            'katex': 'katex/dist/katex',
            'eve': 'eve/eve',
            'raphael-core': lib_js + 'raphael/raphael.core',
            'raphael-svg': lib_js + 'raphael/raphael.svg',
            'raphael-vml': lib_js + 'raphael/raphael.vml',
            'raphael': lib_js + 'raphael/raphael.amd',
            'markdown-it-mathsupport': lib_js + 'markdown-it-mathsupport/markdown-it-mathsupport',
            'ReliableMD_render': lib_js + 'WPReliableMD_render',
            'htmlToText': lib_js + 'jsHtmlToText'
        },
        shim: {
            'raphael': {
                exports: 'Raphael'
            }
        },
        waitSeconds: 30
    });
}

configure_requirejs();

