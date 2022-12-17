[include]
design/templates/editor/genEdit.tpl


# ***********************************************************
[main]
# ***********************************************************
#<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="core/scripts/ck4/ckeditor.js"></script>
<script src="core/scripts/ck4/config.js"></script>

<form id="inlineEdit" method="post" action="?">
	<textarea id="txtEdit" name="content" tabindex=0 class="tarea" rows="<!VAR:rows!>" spellcheck="false"><!VAR:content!></textarea>
<!SEC:submit!>
</form>

<script>
	CKEDITOR.replace("content", {
		customConfig: '/cms/core/scripts/ck4.config.js'
	});
</script>

<style>
	.cke_wrapper {
		padding: 15px !IMPORTANT;
	}
</style>
