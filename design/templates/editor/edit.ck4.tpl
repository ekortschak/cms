[include]
LOC_TPL/editor/edit.tpl


# ***********************************************************
[main]
# ***********************************************************
<script src="CK4_URL/ckeditor.js"></script>

<form id="inlineEdit" method="post" action="?">
<!SEC:ctarea!>
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
