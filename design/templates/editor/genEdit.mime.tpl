[include]
LOC_TPL/editor/genEdit.tpl

[dic]
not.editable = File not editable!

[dic.de]
not.editable = Datei ist nicht zum Bearbeiten vorgesehen!


# ***********************************************************
[edit]
# ***********************************************************
#<p><!DIC:not.editable!></p>
<embed id="pic" src="<!VAR:file!>" width="100%" height=500 />

<form method="post" action="?">
<!SEC:submit!>
</form>
