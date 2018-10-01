jQuery(document).ready(
    function () {

        var content = [
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

        var editor = new tui.Editor({
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
