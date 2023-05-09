[include]
LOC_TPL/editor/edit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
LOC_SCR/keyEvents.js
LOC_SCR/clipboard.js
LOC_SCR/inline.js


# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div>
		<!SEC:edit!>
		<!SEC:characters!>
	</div>
	<div>
		<!SEC:formatting!>
		<!SEC:addLFs!>
	</div>
	<div>
		<!SEC:listings!>
		<!SEC:tables!>
		<!SEC:images!>
		<!SEC:links!>
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
<!SEC:ctarea!>
<!SEC:submit!>
</form>
