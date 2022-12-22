[include]
design/templates/editor/genEdit.tpl


# ***********************************************************
[main]
# ***********************************************************
<script src="CK4_URL/ckeditor.js"></script>

<form id="inlineEdit" method="post" action="?">
	<textarea id="content" name="content" tabindex=0 class="tarea" rows="<!VAR:rows!>" spellcheck="false"><!VAR:content!></textarea>
<!SEC:submit!>
</form>

<script>
	CKEDITOR.replace("content", {
		customConfig: 'CK4_URL/config.js'
	});
</script>

<style>
	.cke_wrapper {
		padding: 15px !IMPORTANT;
	}
</style>
