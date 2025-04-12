[include]
LOC_TPL/editor/edit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
LOC_SCR/keyEvents.js
LOC_SCR/clipboard.js
LOC_SCR/inline.js

[vars]
rows = 30


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

# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div><!SEC:buttons!> </div>
	<div><!SEC:clear!> </div>
</div>


[buttons]
<button class="icon" onclick="doUndo();"><img src="LOC_ICO/edit/undo.png" /></button>
&nbsp;
&nbsp;

<a href="javascript:insAny('\nPAGE_BREAK\n');"><button>PBr</button></a>
<a href="javascript:insAny('\n<hr>\n');"><button>HR</button></a>
<a href="javascript:insAny('<br>\n');"><button>BR</button></a>
<a href="javascript:insAny('&shy;');"><button>-</button></a>
&nbsp;
&nbsp;
<a href="javascript:repAny('[...] ');"><button>[...]</button></a>

[clear]
<a href="?file.act=clearPbr&filName=<!VAR:file!>"><button>BOOL_NO PBr</button></a>

# ***********************************************************
[ctarea]
# ***********************************************************
<textarea id="content" name="content" tabindex=0  style="height: calc(100vh - 200px"_
autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">_
<!VAR:content!></textarea>
