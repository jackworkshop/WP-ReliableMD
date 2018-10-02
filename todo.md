```css
.md-content{
	display: none /*default*/
}
or
.md-content{
	display: block /*show for noscript*/
}
```
```html
<script type="text/javascript">
	change css .md-content{display: none};
</script>
<div class="content">
	<div class="using-md">
		you are viewing markdwon text
	</div>
	<div class="md-content">
		# blablabla
		xxxx
		## blabalsd
		xxxxx
	</div>
</div>
<script type="text/javascript">
	md_result = parser.parse($(".md-content").html());
	$(".content").html(md_result);
</script>
```
```html
<iframe src="./main.html" frameborder="0" id="contentIframe"></iframe>

```
