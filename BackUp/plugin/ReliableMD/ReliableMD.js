(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(window.jQuery);
    }
}(function ($) {
    $.extend($.summernote.plugins, {
        'ReliableMD': function (context) {
            var $note = context.layoutInfo.note;
            var $editable = context.layoutInfo.editable;
            var $editor = context.layoutInfo.editor;

            var highlightSyntax = function (targetDocument, syntaxHighlighter, codeText, codeLanguage) {
                var codeElem, preElem, textNode;

                preElem = targetDocument.createElement('pre');
                codeElem = targetDocument.createElement('code');
                textNode = targetDocument.createTextNode(codeText);
                codeElem.appendChild(textNode);
                preElem.appendChild(codeElem);

                if (codeLanguage && codeLanguage.length > 0) {
                    codeElem.setAttribute('class', 'language-' + codeLanguage);
                }
                else {
                    codeElem.setAttribute('class', 'no-highlight');
                }

                syntaxHighlighter.highlightBlock(codeElem);

                return codeElem.innerHTML;
            };

            var markedOptions = {
                gfm: true,
                pedantic: false,
                sanitize: false,
                tables: true,
                smartLists: true,
                breaks: true,
                langPrefix: 'language-',
                math: null,
                highlight: function (codeText, codeLanguage) {
                    return highlightSyntax(
                        $rendered.get(0).ownerDocument,
                        hljs,
                        codeText,
                        codeLanguage);
                }
            };
            var printRange = function (r, text) {
                console.log(text !== undefined ? text : '', r.isOnEditable(), r.so, r.so, r.sc, r.ec);
            };
            var cursor_raw_end = 'rmd-cursor-end';
            var cursor_end = '!!' + cursor_raw_end + '!!';
            var cursor_dom_end = '<' + cursor_raw_end + '>' + '</' + cursor_raw_end + '>';
            var cursor_raw_begin = 'rmd-cursor-begin';
            var cursor_begin = '!!' + cursor_raw_begin + '!!';
            var cursor_dom_begin = '<' + cursor_raw_begin + '>' + '</' + cursor_raw_begin + '>';
            var saveSelection = function () {
                var temp_end = $note.summernote('createRange');
                temp_end.so = temp_end.eo;
                temp_end.pasteHTML(cursor_end);

                var temp_begin = $note.summernote('createRange');
                temp_begin.eo = temp_begin.so;
                temp_begin.pasteHTML(cursor_begin);

            };
            var restoreSelection = function () {
                newrange = $note.summernote('createRange');
                newrange.sc = $(cursor_raw_begin)[0];
                newrange.ec = $(cursor_raw_end)[0];
                newrange.so = newrange.eo = 0;

                $editor.focus();
                newrange.select();
            };
            var renderMD = function () {
                var raw_html = context.invoke('code');
                var fnrCode = htmlToText(raw_html);

                var text = marked(fnrCode, markedOptions);

                text = text.replace(cursor_begin, cursor_dom_begin);
                text = text.replace(cursor_end, cursor_dom_end);


                text = text.replace(/(<strong>)(.*?)(<\/strong>)/g, "$1\*\*$2\*\*$3");
                text = text.replace(/(<em>)(.*?)(<\/em>)/g, "$1\*$2\*$3");
                text = text.replace(/<h1.*?>(.*?)<\/h1>/g, "<h1>#$1</h1>");
                text = text.replace(/<h2.*?>(.*?)<\/h2>/g, "<h2>##$1</h2>");
                text = text.replace(/<h3.*?>(.*?)<\/h3>/g, "<h3>###$1</h3>");
                text = text.replace(/<h4.*?>(.*?)<\/h4>/g, "<h4>####$1</h4>");
                text = text.replace(/<h5.*?>(.*?)<\/h5>/g, "<h5>#####$1</h5>");
                text = text.replace(/<h6.*?>(.*?)<\/h6>/g, "<h6>######$1</h6>");


                text = text.replace(/ /g, "&nbsp;");
                $note.summernote('code', text);
            };
            var update = function () {
                saveSelection();
                renderMD();
                restoreSelection();

            };

            this.initialize = function () {
                context.modules.editor.bold = function () {
                    saveSelection();
                    var range = $note.summernote('createRange');
                    range.pasteHTML('**' + range.toString() + '**');

                    renderMD();
                    restoreSelection();
                };
                $editable.bind("input propertychange", update);
                console.log("ReliableMD is ready");
            };

        }
    });
}));
