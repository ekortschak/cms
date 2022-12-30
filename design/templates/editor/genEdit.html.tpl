[include]
LOC_TPL/editor/genEdit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
core/scripts/keyEvents.js
core/scripts/inline.js

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
		<!SEC:switch.htm!>
	</div>
	<div>
		<!SEC:item.view!>
	</div>
</div>

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file_act=save">
	<div id="divEdit" class="cold" tabindex=0 contenteditable="true" spellcheck="false" _
		onfocus="this.className='hot';" _
		onblur="this.className='cold';">
		<!VAR:content!>
	</div>

	<div id="curEdit" class="hidden"> _
		<textarea id="content" name="content" class="tarea" rows="<!VAR:rows!>" spellcheck="false"><!VAR:content!></textarea>
	</div>

<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	obj = document.getElementById("divEdit");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });

	obj = document.getElementById("content");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });
</script>
