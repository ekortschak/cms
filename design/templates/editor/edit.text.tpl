[include]
LOC_TPL/editor/edit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
LOC_SCR/keyEvents.js
LOC_SCR/clipboard.js
LOC_SCR/inline.js

[vars]
rows = 40


# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?">
<!SEC:oid!>
<!SEC:ctarea!>
<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	obj = document.getElementById("content");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });
</script>
