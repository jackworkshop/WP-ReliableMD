import "./block.scss";
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, BlockControls } from '@wordpress/block-editor';
import CoreEditor from '@toast-ui/editor';
import { Editor } from '@toast-ui/react-editor';
import uml from '@toast-ui/editor-plugin-uml';
import chart from '@toast-ui/editor-plugin-chart';
import codeSyntaxHighlight from '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight-all.js';
import colorSyntax from '@toast-ui/editor-plugin-color-syntax';
import tableMergedCell from '@toast-ui/editor-plugin-table-merged-cell';
import mathsupport from "./math.js";

const zh_cn_loc= {
	Markdown: 'Markdown',
	WYSIWYG: '所见即所得',
	Write: '编辑',
	Preview: '预览',
	Headings: '标题',
	Paragraph: '文本',
	Bold: '加粗',
	Italic: '斜体字',
	Strike: '删除线',
	Code: '内嵌代码',
	Line: '水平线',
	Blockquote: '引用块',
	'Unordered list': '无序列表',
	'Ordered list': '有序列表',
	Task: '任务',
	Indent: '缩进',
	Outdent: '减少缩进',
	'Insert link': '插入链接',
	'Insert CodeBlock': '插入代码块',
	'Insert table': '插入表格',
	'Insert image': '插入图片',
	Heading: '标题',
	'Image URL': '图片网址',
	'Select image file': '选择图片文件',
	'Choose a file': '选择一个文件',
	'No file': '没有文件',
	Description: '说明',
	OK: '确认',
	More: '更多',
	Cancel: '取消',
	File: '文件',
	URL: 'URL',
	'Link text': '链接文本',
	'Add row to up': '向上添加行',
	'Add row to down': '在下方添加行',
	'Add column to left': '在左侧添加列',
	'Add column to right': '在右侧添加列',
	'Remove row': '删除行',
	'Remove column': '删除列',
	'Align column to left': '左对齐',
	'Align column to center': '居中对齐',
	'Align column to right': '右对齐',
	'Remove table': '删除表格',
	'Would you like to paste as table?': '需要粘贴为表格吗?',
	'Text color': '文字颜色',
	'Auto scroll enabled': '自动滚动已启用',
	'Auto scroll disabled': '自动滚动已禁用',
	'Choose language': '选择语言',
};

const reWidgetRule= /\[(@\S+)\]\((\S+)\)/;
const atWidgetRule= /\((@\S+)\)/;

const customHTMLRenderer= {
	htmlBlock: {
		iframe(node) {
			return [
				{ type: 'openTag', tagName: 'iframe', outerNewLine: true, attributes: node.attrs },
				{ type: 'html', content: node.childrenHTML },
				{ type: 'closeTag', tagName: 'iframe', outerNewLine: true },
			];
		},
	},
	htmlInline: {
		big(node, { entering }) {
			return entering
				? { type: 'openTag', tagName: 'big', attributes: node.attrs }
				: { type: 'closeTag', tagName: 'big' };
		},
	},
	linebreak(node, context) {
		return {
			type: 'html',
			content: '\n<br />\n'
		}
	 }
};

const customMarkdownRenderer=  {
	html(state, ConvertorContent) {
		if(state.node.type.name == 'iframe') {
			var convert = ConvertorContent.origin();
			if(convert) {
				convert.text = convert.text + '\n\n';
			}
			return convert;
		}
		return ConvertorContent.origin();
	}
};

const  plugins= [
	[chart, {
		minWidth: 100,
		maxWidth: 600,
		minHeight: 100,
		maxHeight: 300,
	}],
	colorSyntax,
	codeSyntaxHighlight,
	tableMergedCell,
	uml,
	mathsupport,
];

var editRef = React.createRef();

registerBlockType( 'wp-reliablemd/toast-editor', {
    apiVersion: 2,
    title: 'Markdown',
    icon: 'insert',
    category: 'design',

	attributes: {
		content: {
			type: 'string',
			source: 'text',
			selector: '.render_text'
		},
		markdown: {
			type: 'string',
			source: 'text',
			selector: '.markdown',
		}
	},

    edit: (props) => {
        const blockProps = useBlockProps({
			className: 'markdown_viewer'
		});
		const {
            attributes: { content,markdown },
            setAttributes,
        } = props;

		const widgetRules= [
			{
				rule: atWidgetRule ,
				toDOM(text) {
					const rule = props.atWidgetRule;
					const matched = text.match(rule);
					const span = document.createElement('span');

					span.innerHTML = `<a class="widget-anchor">${matched[1]}</a>`;
					return span;
				},
			},
			{
				rule: reWidgetRule,
				toDOM(text) {
					const rule = props.reWidgetRule;
					const matched = text.match(rule);
					const span = document.createElement('span');

					span.innerHTML = `<a class="widget-anchor" href="${matched[2]}">${matched[1]}</a>`;
					return span;
				},
			},
		];

		const toolbarItems = [
			['heading', 'bold', 'italic', 'strike'],
			['hr', 'quote'],
			['ul', 'ol', 'task', 'indent', 'outdent'],
			['table', 'image', 'link'],
			['code', 'codeblock'],
			// Using Option: Customize the last button
			[
				{
					el: createLatexButton(),
					command: 'latex',
					tooltip: 'Latex'
				},
				{
					el: createCustomBlockButton(),
					command: 'customblock',
					tooltip: 'Custom block'
				}
			],
			['scrollSync']
		];

		function createLatexButton() {
			const button = document.createElement('button');

			button.className = 'toastui-editor-toolbar-icons last';
			button.style.backgroundImage = 'none';
			button.style.margin = '0';
			button.innerHTML = `<i>L</i>`;
			button.addEventListener('click', () => {
				editRef.current.getInstance().insertText('latex');
			});

			return button;
		}

		function createCustomBlockButton() {
			const button = document.createElement('button');

			button.className = 'toastui-editor-toolbar-icons last';
			button.style.backgroundImage = 'none';
			button.style.margin = '0';
			button.innerHTML = `<i>CuB</i>`;
			button.addEventListener('click', () => {
				editRef.current.getInstance().insertText('customblock');
			});

			return button;
		}

		CoreEditor.setLanguage('zh-CN', zh_cn_loc);

		const onLatex = () => {
			editRef.current.getInstance().insertText('$$latex\n$$\n');
		};

		const onCustomblock = () => {
			editRef.current.getInstance().insertText('$$\n$$\n');
		};

		const onChangeContent = () => {
			setAttributes( { markdown: editRef.current.getInstance().getMarkdown() } );
			setAttributes( { content: editRef.current.getInstance().getHTML() } );
		};

        return (
			<div { ...blockProps }>
			<BlockControls>
				<button onClick={ onLatex }>Latex</button>
				<button onClick={ onCustomblock }>Customblock</button>
			</BlockControls>
			<Editor
				previewStyle="vertical"
				height="400px"
				initialEditType="markdown"
				initialValue={ markdown }
				ref={ editRef }
				useCommandShortcut={ true }
				extendedAutolinks={ true }
				referenceDefinition={ false }
				hideModeSwitch={ false }
				frontMatter={ false }
				language={ navigator.language }
				onChange={ onChangeContent }
				customHTMLRenderer={ customHTMLRenderer }
				customMarkdownRenderer={ customMarkdownRenderer }
				widgetRules={ widgetRules }
				toolbarItems={ toolbarItems }
				plugins={plugins}
			/>
			</div>
		);
    },



	save: (props) => {
        const blockProps = useBlockProps.save();

        return (
			<div { ...blockProps }>
				<div class="markdown" style="display:none">{props.attributes.markdown}</div>
				<div class="render_text" style="display: none">{props.attributes.content}</div>
				<div class="display" dangerouslySetInnerHTML={{__html:props.attributes.content}}></div>
			</div>
        );
	},

} );
