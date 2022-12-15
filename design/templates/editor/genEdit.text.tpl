[include]
design/templates/editor/genEdit.tpl
design/templates/editor/toolbar.tpl

[vars]
rows = 40


# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div>
		<!SEC:edit!>
		<!SEC:characters!>&nbsp;
		<!SEC:formatting!>
		<!SEC:addImg!>
		<!SEC:addLFs!>&nbsp;
		<!SEC:addLink!>
	</div>
	<div>
		<!SEC:item.view!>
	</div>
</div>
</div>

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file_act=save">
	<textarea id="txtEdit" tabindex=0 name="content" class="tarea" rows="<!VAR:rows!>" _
		spellcheck="false"><!VAR:content!></textarea>
<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	doStore();

	obj = document.getElementById("txtEdit");
	obj.addEventListener("keydown", function(e) { e = doTextKeys(e); });
</script>
