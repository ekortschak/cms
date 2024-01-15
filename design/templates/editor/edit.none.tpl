[include]
LOC_TPL/editor/edit.tpl

[dic]
edit.none = No editable files ...
lev1 = First level links

[dic.de]
edit.none = Keine bearbeitbaren Dateien ...
lev1 = Erste Ebene verknüpfen

# ***********************************************************
[main]
# ***********************************************************
<msg><!DIC:edit.none!></msg>

<h4><!SEC:<!VAR:type!>!></h4>


[redirect]
<h4><!VAR:type!></h4>
<p>&rarr; <!VAR:target!></p>


<h4>Import</h4>
<form method="post" action="?">
<!SEC:oid!>
	<input name="target" type="hidden" value="CUR_PAGE" />
	<input name="source" type="hidden" value="<!VAR:target!>" />
	<button name="file.act" value="import"><!DIC:lev1!></button>
</form>

DOC_ROOT<br>
APP_DIR<br>
CMS_DIR
