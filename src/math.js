import katex from 'katex';
import 'katex/contrib/mhchem';
export default function latex() {
	const toHTMLRenderers = {
	latex(node) {
		const html = katex.renderToString(node.literal);

		return [
			{ type: 'openTag', tagName: 'div', outerNewLine: true },
			{ type: 'html', content: html },
			{ type: 'closeTag', tagName: 'div', outerNewLine: true }
		];
		}
	}
    return { toHTMLRenderers };
};
