[include]
design/templates/editor/genEdit.tpl
design/templates/editor/toolbar.tpl

[register]
core/scripts/keyEvents.js
core/scripts/inline.js


# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<form id="inlineEdit" method="post" action="?file_act=save">
<textarea id="txtEdit" name="content" class="tarea" rows="<!VAR:rows!>" spellcheck="false" onkeydown="doStore();">_
<!VAR:content!>_
</textarea>
<!SEC:submit!>
</form>
