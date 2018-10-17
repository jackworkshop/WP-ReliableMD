<?php

namespace WPReliableMD\View;

use WPReliableMD\View\Parser as Parser;
	/*
	Utf-8、gb2312都支持的汉字截取函数
	cut_str(字符串, 截取长度, 开始长度, 编码);
	编码默认为 utf-8
	*/

	function cut_str($string, $start, $sublen, $code = 'UTF-8')
	{
		if($code == 'UTF-8')
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);

			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
			return join('', array_slice($t_string[0], $start, $sublen));
		}
		else
		{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';

			for($i=0; $i< $strlen; $i++)
			{
				if($i>=$start && $i< ($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129)
					{
						$tmpstr.= substr($string, $i, 2);
					}
					else
					{
						$tmpstr.= substr($string, $i, 1);
					}
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			return $tmpstr;
		}
	}
class Controller {

	public function __construct() {

		//Javascript 文件
		add_filter( 'wp_head', array( $this, 'enqueue_scripts' ), 2 );
		//CSS
		add_filter( 'wp_head', array( $this, 'enqueue_style' ), 2 );
		//markdown解析
		add_filter( 'the_content', array( $this, 'WPReliableMD_the_Content' ) );
		add_filter( 'the_excerpt', array( $this, 'the_excerpt' ) );
		add_filter('markdown_backend_rendered',array($this,'WPReliableMD_BackendRendered'),1,3);
		add_filter('markdown_text',array($this,'WPReliableMD_MarkdownText_Transference'),1,2);
		add_filter('markdown_shortcode_text',array($this,'WPReliableMD_MarkdownShortcodeText_AntiTransfer'),1);
		add_filter('widget_text', 'do_shortcode');

		add_shortcode('markdown',array($this,'WPReliableMD_Shortcode_Markdown'));

	}

	function the_excerpt( $post_excerpt ) {
		$post_id = get_the_ID();
		$post = get_post( $post_id );
		if ( ! has_excerpt() ) {
			$post_excerpt = $post->post_content;
		}

		if ( get_post_meta( $post_id, 'markdown', true ) === 'true' ) {
			/*
			 * filter  : markdown_backend_rendered($backend_rendered,$content,$excerpt_bool)
			 * comment : The original markdown data is preprocessed by the back end, and the rendering result is returned.
			 * params  :
			 *   - $backend_rendered : The output of a summary or the back end of an article.
			 *   - $content : Subject before treatment
			 *   - $excerpt_bool : If it is an article, it is false, if it is a summary, then it is true.
			 */
			$post_excerpt = apply_filters('markdown_backend_rendered',$post_excerpt,$post->post_content,true);
			if ( preg_match( '#<p>((\w|\d|[^x00-xff]).+?)</p>#', $post_excerpt, $mc ) ) {
				$post_excerpt = $mc[1];
				/*
			 	 * filter  : markdown_the_excerpt($post_excerpt)
			 	 * comment : This filter Hook process extracts the summary processing when extracting the abstract.
			 	 * params  :
			 	 *   - $post_excerpt : Subject before treatment
			 	 *   - $is_auto_get_excerpt : Do you extract abstract text?
			 	 */
				$post_excerpt = apply_filters('markdown_the_excerpt',$post_excerpt,true);
			} else {
				$post_excerpt = __('This post has no common text');
				/*
			 	 * filter  : markdown_the_excerpt_no_text_extract($post_excerpt)
			 	 * comment : This filter Hook processing does not extract the summary processing when extracting the abstract.
			 	 * params  :
			 	 *   - $post_excerpt : Subject before treatment
			 	 *   - $is_auto_get_excerpt : Do you extract abstract text?
			 	 */
				$post_excerpt = apply_filters('markdown_the_excerpt',$post_excerpt,false);
			}
		}

		return do_shortcode(cut_str( $post_excerpt, 0, apply_filters('excerpt_length',50) ));
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'require' );
		wp_enqueue_script( 'require-paths' );
		wp_enqueue_script( 'WPReliableMDFrontend' );
	}

	public function enqueue_style() {
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'codemirror' );
		wp_enqueue_style( 'github' );
		wp_enqueue_style( 'tui-editor' );
		wp_enqueue_style( 'tui-editor-contents' );
		wp_enqueue_style( 'tui-color-picker' );
		wp_enqueue_style( 'tui-chart' );
		wp_enqueue_style( 'katex' );
		wp_enqueue_style( 'WPReliableMDFrontend' );
	}

	public function WPReliableMD_the_Content( $content ) {
		if ( get_post_meta( get_the_ID(), 'markdown', true ) === 'true' ) {
			//如果是markdown文章，则输出，不使用前面处理的结果，直接取文章数据
			$post    = get_post( get_the_ID() );
			$content = $post->post_content;
			$content = $this->WPReliableMD_Content( $content );
		}

		return do_shortcode($content);
	}

	public function WPReliableMD_Shortcode_Markdown( $attr, $content ) {
		/*
		 * filter  : markdown_shortcode_text($markdown)
		 * comment : Markdown text for short code parser.
		 * params  :
		 *   - $markdown : Markdown text before input processing.
		 */
		$content = apply_filters('markdown_shortcode_text',$content);
		return do_shortcode($this->WPReliableMD_Content($content));  //解析，执行
	}

	public function WPReliableMD_MarkdownShortcodeText_AntiTransfer($markdown)  {
		$AntiTransfer = array(
			'&gt;' => '>',
			'&lt;' => '<',
		);

		/*
		 * filter  : markdown_antiTransfer($AntiTransfer)
		 * comment : Filter Hook for handling inverted tables.
		 * params  :
		 *   - $AntiTransfer : Input inverted meaning table and output inversion table.
		 */
		$AntiTransfer = apply_filters('markdown_antiTransfer',$AntiTransfer);


		foreach ($AntiTransfer as $key => $value) {
			$markdown = str_replace($key,$value,$markdown);
		}
		return $markdown;
	}

	public function WPReliableMD_Content( $content ) {

		$backend_rendered = null;

		$backend_rendered_text = $content;

		/*
		* filter  : markdown_text($markdown)
		* comment : The original content of markdown is processed and then processed.
		* params  :
		*   - $markdown : Subject before treatment
		*   - $is_backend_rendered : If the result is input to the pre renderer, it is true, otherwise it is false.
		*/

		$backend_rendered_text = apply_filters('markdown_text',$backend_rendered_text,true);  //执行HOOK，进行处理

		/*
		* filter  : markdown_backend_rendered($backend_rendered,$content,$excerpt_bool)
		* comment : The original markdown data is preprocessed by the back end, and the rendering result is returned.
		* params  :
		*   - $backend_rendered : The output of a summary or the back end of an article.
		*   - $content : Subject before treatment
		*   - $excerpt_bool : If it is an article, it is false, if it is a summary, then it is true.
		*/
		$backend_rendered = apply_filters('markdown_backend_rendered',$backend_rendered,$backend_rendered_text,false);  //可由用户覆盖解析效果

		/*
		* filter  : markdown_text($markdown)
		* comment : The original content of markdown is processed and then processed.
		* params  :
		*   - $markdown : Subject before treatment
		*   - $is_backend_rendered : If the result is input to the pre renderer, it is true, otherwise it is false.
		*/

		$content = apply_filters('markdown_text',$content,false);  //执行HOOK，进行处理


		$new_content      = "<div class='markdown-block'>";
		$new_content      .= "<pre class='markdown' style='display:none;'>{$content}</pre>";
		$new_content      .= "<div class='markdown-backend-rendered'>{$backend_rendered}</div>";
		$new_content      .= "</div>";
		$content          = $new_content;

		/*
		* filter  : markdown_content($content)
		* comment : The results returned by the markdown server are processed, and then returned to the browser.
		* params  :
		*   - $content : Subject before treatment
		*/

		$content = apply_filters('markdown_content',$content);  //执行HOOK，进行处理

		return $content;
	}

	public function WPReliableMD_MarkdownText_Transference($markdown,$is_backend_rendered) {
		//转义处理

		if(!$is_backend_rendered) {
			$markdown = str_replace(array("\r\n", "\r", "\n"),'&br;',$markdown);
		}
		
		
		return $markdown;
	}

	public function WPReliableMD_BackendRendered($backend_rendered,$content,$excerpt_bool) {
		$post_id = get_the_ID();
		if($excerpt_bool) {
			//如果是摘要缓存
			$backend_rendered = wp_cache_get($post_id,'markdown_backend_rendered:excerpt');
			if($backend_rendered === false) {
				$parser = new Parser();
				$backend_rendered = $parser->makeHtml( $content );
				wp_cache_set($post_id,$backend_rendered,'markdown_backend_rendered:excerpt');
			}
		} else {
			//如果是文章缓存
			$backend_rendered = wp_cache_get($post_id,'markdown_backend_rendered');
			if($backend_rendered === false) {
				$parser = new Parser();
				$backend_rendered = $parser->makeHtml( $content );
				wp_cache_set($post_id,$backend_rendered,'markdown_backend_rendered');
			}
		}
		
		return $backend_rendered;
	}
}

?>
