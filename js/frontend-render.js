var template = function () {
    var scripts_and_styles =
    '    <script src="../bower_components/jquery/dist/jquery.js"></script>\n' +
    '    <script src="../bower_components/markdown-it/dist/markdown-it.js"></script>\n' +
    '    <script src="../bower_components/to-mark/dist/to-mark.js"></script>\n' +
    '    <script src="../bower_components/tui-code-snippet/dist/tui-code-snippet.js"></script>\n' +
    '    <script src="../bower_components/tui-color-picker/dist/tui-color-picker.js"></script>\n' +
    '    <script src="../bower_components/codemirror/lib/codemirror.js"></script>\n' +
    '    <script src="../bower_components/highlightjs/highlight.pack.js"></script>\n' +
    '    <script src="../bower_components/squire-rte/build/squire-raw.js"></script>\n' +
    '    <link rel="stylesheet" href="../bower_components/codemirror/lib/codemirror.css">\n' +
    '    <link rel="stylesheet" href="../bower_components/highlightjs/styles/github.css">\n' +
    '    <script src="../bower_components/plantuml-encoder/dist/plantuml-encoder.js"></script>\n' +
    '    <script src="../bower_components/raphael/raphael.js"></script>\n' +
    '    <script src="../bower_components/tui-chart/dist/tui-chart.js"></script>\n' +
    '    <script src="../bower_components/tui-editor/dist/tui-editor-Editor-all.js"></script>\n' +
    '    <link rel="stylesheet" href="../bower_components/tui-editor/dist/tui-editor.css">\n' +
    '    <link rel="stylesheet" href="../bower_components/tui-editor/dist/tui-editor-contents.css">\n' +
    '    <link rel="stylesheet" href="../bower_components/tui-color-picker/dist/tui-color-picker.css">\n' +
    '    <link rel="stylesheet" href="../bower_components/tui-chart/dist/tui-chart.css">\n';
    return scripts_and_styles;
};

var editor;
// usage: make a div with class markdown, write it in markdown, and it will be converted into html
// warnning: your markdwon text must be aligned from left
var render = function () {
    $('.markdown').each(function () {
        var text = $(this).val() || $(this).html();
        var rendered = editor.convertor.toHTML(text);
        $(this).html(rendered);
    });
};
$(document).ready(function (){
    editor = new tui.Editor({
        el: document.createElement('div'),
        previewStyle: 'vertical',
        initialEditType: 'markdown',
        initialValue: '',
        exts: [{
            name: 'chart',
            minWidth: 100,
            maxWidth: 600,
            minHeight: 100,
            maxHeight: 300
        },
            'scrollSync',
            'colorSyntax',
            'uml',
            'mark',
            'table'
        ]
    });
    render();
});
