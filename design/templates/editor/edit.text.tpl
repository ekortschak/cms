[include]
LOC_TPL/editor/edit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
core/scripts/keyEvents.js
core/scripts/clipboard.js
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
	</div>
	<div>
		<!SEC:item.view!>
	</div>
</div>

asdf

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file_act=save">
<!SEC:ctarea!>
<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	obj = document.getElementById("content");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });
</script>
