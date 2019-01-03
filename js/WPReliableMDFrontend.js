requirejs(['jquery'], function($){
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
	var hash = function(text){
		var h = 0;
		for(var i = 0; i < text.length; ++i){
			h = h * 10007 + text[i].charCodeAt();
			h %= 1e9 + 7;

		}
		return "" + h;
	};
	var callback = function ($node) {
        	//if($node.parent().attr('class') === 'markdown-block')
        if($node.parent().is(".markdown-block")) {
        	return $node.parent()
        }
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
		var text = $(this).text();
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

	$('.tui-editor-contents').each(function() {
		var text = $(this).html();
		console.log(ReliableMD);
        $.ajax({
            url: ReliableMD.api_root + 'WP-ReliableMD/markdown/render/' + ReliableMD.id,
            //url: ReliableMD.root + 'WPReliableMD/posts/' + post_id,
            method: 'PUT',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', ReliableMD.nonce);
            },
            data: text
        }).done(function (response) {
            console.log(response);
			post_id = response.id;
            console.log('Update Object Cached');
        });
	});
});
