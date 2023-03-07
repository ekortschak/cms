[include]
LOC_TPL/editor/edit.tpl
LOC_TPL/editor/toolbar.tpl

[register]
core/scripts/keyEvents.js
core/scripts/clipboard.js
core/scripts/inline.js


# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file_act=save">
<!SEC:ctarea!>
<!SEC:submit!>
</form>
