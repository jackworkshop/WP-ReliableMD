requirejs(['jquery'], function($){
	var hash = function(text){
		var h = 0;
		for(var i = 0; i < text.length; ++i){
			h = h * 10007 + text[i].charCodeAt();
			h %= 1e9 + 7;

		}
		return "" + h;
	};
	var callback = function ($node) {
        	if($node.parent().attr('class') === 'markdown-block')
			return $node.parent()
		var $new_node = $("<div></div>");
		$node.after($new_node);
		$node.remove();
		return $new_node;
    	};
	var cached = function(text)
	{
		return window.localStorage.getItem(hash(text));
	};
	var cnt = 0;
	
	$('.markdown').each(function () {
		var text = $(this).val() || $(this).html();
		var ca = cached(text);
		if(ca === null)
			++cnt;
		else{
			console.log("used cache", hash(text));
			callback($(this)).html(ca).attr('class','tui-editor-contents');
		}
	});
	if(cnt > 0) {
		requirejs(['ReliableMD_render'], function (render) {
    		render.setCallback(callback);
		});
	}
});
