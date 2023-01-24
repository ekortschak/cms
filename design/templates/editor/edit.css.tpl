[include]
LOC_TPL/editor/edit.tpl

[vars]
rows = 40


# ***********************************************************
[main]
# ***********************************************************
<form id="inlineEdit" method="post" action="?file_act=save">
<textarea id="content" name="content" class="max" rows="<!VAR:rows!>" spellcheck="false">_
<!VAR:content!>_
</textarea>
<!SEC:submit!>
</form>
