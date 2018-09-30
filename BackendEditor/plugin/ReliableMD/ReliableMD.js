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

            this.initialize = function () {
                $editable.bind("input propertychange", function () {
                    var range = $note.summernote('createRange');
                    console.log(range);
                    range.pasteHTML('!!rmd-cursor!!');
                    var raw_html = context.invoke('code');
                    var fnrCode = htmlToText(raw_html);
                    var text = marked(fnrCode, markedOptions);
                    text = text.replace('!!rmd-cursor!!', '<rmd-cursor/>');
                    text = text.replace(/(<strong>)(.*)(<\/strong>)/g, "$1\*\*$2\*\*$3");
                    text = text.replace(/(<em>)(.*)(<\/em>)/g, "$1\*$2\*$3");

                    $note.summernote('code', text);

                    var newrange = $note.summernote('createRange');
                    console.log(newrange);
                    newrange.sc = newrange.ec = $('rmd-cursor')[0];
                    newrange.so = newrange.eo = 0;
                    console.log(newrange);


                    range.select();
                    $editor.focus();

                });
                console.log("ReliableMD is ready");
            };

        }
    });
}));
