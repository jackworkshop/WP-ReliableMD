"use strict";
/*global marked:false, hljs:false, $:false, _:false*/

$(function () {

});
// Adapted from markdown-render.js
function highlightSyntax(targetDocument, syntaxHighlighter, codeText, codeLanguage) {
    var codeElem, preElem, textNode;

    // highlight.js requires a `<code>` element to be passed in that has a
    // `<pre>` parent element.

    preElem = targetDocument.createElement('pre');
    codeElem = targetDocument.createElement('code');
    textNode = targetDocument.createTextNode(codeText);
    codeElem.appendChild(textNode);
    preElem.appendChild(codeElem);

    // If we're told the language, set it as a class so that the highlighter
    // doesn't have to guess it. This is part of the HTML5 standard. See:
    // http://www.whatwg.org/specs/web-apps/current-work/multipage/text-level-semantics.html#the-code-element
    if (codeLanguage && codeLanguage.length > 0) {
        codeElem.setAttribute('class', 'language-' + codeLanguage);
    }
    else {
        codeElem.setAttribute('class', 'no-highlight');
    }

    syntaxHighlighter.highlightBlock(codeElem);

    return codeElem.innerHTML;
}


function makeUpdateMD($rendered) {
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

    return function (text) {
        var html = marked(text, markedOptions);
        $rendered.html(html);
        // Make links in the rendered view open in a new tab.
        $rendered.find('a').attr('target', '_blank');
    }

}
function duplacateSingnal(text) {
//todo
}

