// maybe u have to use jQuery 3+
var rmd_plugin_directory = $("script").last().attr("src") + '/../../';
var tui_scripts_and_styles =
//    '    <script src="'+rmd_plugin_directory+'bower_components/jquery/dist/jquery.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/markdown-it/dist/markdown-it.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/to-mark/dist/to-mark.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/tui-code-snippet/dist/tui-code-snippet.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/tui-color-picker/dist/tui-color-picker.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/codemirror/lib/codemirror.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/highlightjs/highlight.pack.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/squire-rte/build/squire-raw.js"></script>\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/codemirror/lib/codemirror.css">\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/highlightjs/styles/github.css">\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/plantuml-encoder/dist/plantuml-encoder.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/raphael/raphael.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/tui-chart/dist/tui-chart.js"></script>\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/tui-editor/dist/tui-editor-Editor-all.js"></script>\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/tui-editor/dist/tui-editor.css">\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/tui-editor/dist/tui-editor-contents.css">\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/tui-color-picker/dist/tui-color-picker.css">\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/tui-chart/dist/tui-chart.css">\n' +
    '    <link rel="stylesheet" href="' + rmd_plugin_directory + 'bower_components/katex/dist/katex.css">\n' +
    '    <script src="' + rmd_plugin_directory + 'bower_components/katex/dist/katex.js"></script>\n' +
    '';

//document.write(tui_scripts_and_styles);

function entityToString(entity) {
    var div = document.createElement('div');
    div.innerHTML = entity;
    var res = div.innerText || div.textContent;
    return res;
}

var processLatex = function (t) {
    t = t.replace(/\\/g, '\\\\');
    t = t.replace(/_/g, '\\_');
    t = t.replace(/\*/g, '\\*');
    t = t.replace(/\$/g, '');
    return t;
}
var render = function () {
    $('.markdown').each(function () {
        var text = $(this).val() || $(this).html();
        $(this).val('');
        $(this).html('');
        text = entityToString(text);
        text = text.replace(/\$\$(.*)\$\$/g, function (t) {
            return "<br><div class='latex' style='display: block;'>" + processLatex(t) + "</div>\n";
        });
        text = text.replace(/\$(.*)\$/g, function (t) {
            return "<div class='latex' style='display: inline;'>" + processLatex(t) + "</div>";
        });
        var viewer = tui.Editor.factory({
            el: $(this)[0],
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
                'table'
            ]
        });

    });
    $('.latex').each(function () {
        katex.render($(this).val() || $(this).html(), $(this)[0]);
    });
};
// usage: make a div with class markdown, write it in markdown, and it will be converted into html
// warnning: your markdwon text must be aligned from left
$(document).ready(function () {
    render();
});
