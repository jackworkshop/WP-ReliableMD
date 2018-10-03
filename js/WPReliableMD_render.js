// require(['tui-editor'], function (r) {
//     function entityToString(entity) {// function entityToString(entity) {
//         var div = document.createElement('div');
//         div.innerHTML = entity;
//         return div.innerText || div.textContent;
//     }
//     var render = function () {
//         $('.markdown').each(function () {
//             var text = $(this).val() || $(this).html();
//             $(this).val('');
//             $(this).html('');
//             text = entityToString(text);
//             // text = text.replace(/\$\$(.*)\$\$/g, function (t) {
//             //     return "<br><div class='latex' style='display: block;'>" + processLatex(t) + "</div>\n";
//             // });
//             // text = text.replace(/\$(.*)\$/g, function (t) {
//             //     return "<div class='latex' style='display: inline;'>" + processLatex(t) + "</div>";
//             // });
//             var viewer = new require('tui-editor').factory({
//                 el: $(this)[0],
//                 viewer: true,
//                 initialValue: text,
//                 exts: [
//                     {
//                         name: 'chart',
//                         minWidth: 100,
//                         maxWidth: 600,
//                         minHeight: 100,
//                         maxHeight: 300
//                     },
//                     'colorSyntax',
//                     'uml',
//                     'mark',
//                     'table',
//                     'mathsupport'
//                 ]
//             });
//
//
//         });
//     };
//     // usage: make a div with class markdown, write it in markdown, and it will be converted into html
//     // warnning: your markdwon text must be aligned from left
//     $(document).ready(function () {
//         render();
//     });
// });
