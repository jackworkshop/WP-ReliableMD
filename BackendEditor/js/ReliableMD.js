var $_GET = (function () {
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if (typeof(u[1]) === "string") {
        u = u[1].split("&");
        var get = {};
        for (var i in u) {
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();

var editor;
jQuery(document).ready(
    function () {
        console.log($_GET);
        var content;
        if (typeof $_GET['postid'] !== 'undefined')
        {

        }
        else
        {

        }
        content = [
            'title: Your title here',
            '| @cols=2:merged |',
            '| --- | --- |',
            '| table | table |',
            '```uml',
            'partition Conductor {',
            '  (*) --> "Climbs on Platform"',
            '  --> === S1 ===',
            '  --> Bows',
            '}',
            '',
            'partition Audience #LightSkyBlue {',
            '  === S1 === --> Applauds',
            '}',
            '',
            'partition Conductor {',
            '  Bows --> === S2 ===',
            '  --> WavesArmes',
            '  Applauds --> === S2 ===',
            '}',
            '',
            'partition Orchestra #CCCCEE {',
            '  WavesArmes --> Introduction',
            '  --> "Play music"',
            '}',
            '```',
            '```chart',
            ',category1,category2',
            'Jan,21,23',
            'Feb,31,17',
            '',
            'type: column',
            'title: Monthly Revenue',
            'x.title: Amount',
            'y.title: Month',
            'y.min: 1',
            'y.max: 40',
            'y.suffix: $',
            '```'
        ].join('\n');

        editor = new tui.Editor({
            el: document.querySelector('#editSection'),
            previewStyle: 'vertical',
            height: '400px',
            initialEditType: 'markdown',
            useCommandShortcut: true,
            initialValue: content,
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
    }
);
