[include]
LOC_TPL/editor/edit.tpl

[register]
LOC_SCR/keyEvents.js
LOC_SCR/clipboard.js
LOC_SCR/inline.js

[vars]
rows = 40


# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div><!SEC:edit!> <!SEC:characters!> </div>
	<div><!SEC:formatting!> <!SEC:addLFs!> </div>
	<div><!SEC:listings!> <!SEC:tables!> <!SEC:images!> <!SEC:links!> </div>
	<div><!SEC:addSnips!></div>
	<div><!SEC:switch.htm!> <!SEC:item.view!></div>
</div>

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file.act=save">
<!SEC:oid!>

<div id="divEdit" class="cold" tabindex=0 contenteditable="true" spellcheck="false"
	onfocus="this.className='hot';"
	onblur="this.className='cold';"><!VAR:content!>
</div>

<div id="curEdit" class="hidden">_
<!SEC:ctarea!>
</div>

<!SEC:submit!>
</form>

<script type="text/javascript" language="JavaScript1.2">
	obj = document.getElementById("divEdit");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });

	obj = document.getElementById("content");
	obj.addEventListener("keydown", function(e) { e = exKey(e); });
</script>
