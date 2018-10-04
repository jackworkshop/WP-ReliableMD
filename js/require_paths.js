function configure_requirejs() {
    var lib_dep = typeof ReliableMD !== 'undefined' ? ReliableMD.js_dep_lib_root : '../bower_components/';
    var lib_js = typeof ReliableMD !== 'undefined' ? ReliableMD.js_root : '../js/';
    requirejs.config({
        //By default load any module IDs from js/lib
        baseUrl: '.',
        //except, if the module ID starts with "app",
        //load it from the js/app directory. paths
        //config is relative to the baseUrl, and
        //never includes a ".js" extension since
        //the paths config could be for a directory.
        paths: {
            'tui-editor': lib_dep + 'tui-editor/dist/tui-editor-Editor-all',
            'jquery': lib_dep + 'jquery/dist/jquery',
            'codemirror': lib_dep + 'codemirror/lib/codemirror',
            'markdown-it': lib_dep + 'markdown-it/dist/markdown-it',
            'to-mark': lib_dep + 'to-mark/dist/to-mark',
            'tui-code-snippet': lib_dep + 'tui-code-snippet/dist/tui-code-snippet',
            'tui-color-picker': lib_dep + 'tui-color-picker/dist/tui-color-picker',
            'highlight.js': lib_dep + 'highlightjs/highlight.pack',
            'squire-rte': lib_dep + 'squire-rte/build/squire-raw',
            'plantuml-encoder': lib_dep + 'plantuml-encoder/dist/plantuml-encoder',
            'tui-chart': lib_dep + 'tui-chart/dist/tui-chart',
            'mathsupport': lib_js + 'TuiEditorMathSupport',
            'katex': lib_dep + 'katex/dist/katex',
            'eve': lib_dep + 'eve/eve',
            'raphael-core': lib_js + 'raphael/raphael.core',
            'raphael-svg': lib_js + 'raphael/raphael.svg',
            'raphael-vml': lib_js + 'raphael/raphael.vml',
            'raphael': lib_js + 'raphael/raphael.amd',
            'markdown-it-mathsupport': lib_js + 'markdown-it-mathsupport/markdown-it-mathsupport',
            'ReliableMD_render': lib_js + 'WPReliableMD_render',
        },
        shim: {
            'raphael': {
                exports: 'Raphael'
            }
        }
    });
}

configure_requirejs();

