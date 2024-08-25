[include]
LOC_TPL/editor/edit.tpl

[dic]
edit.none = No editable files ...
lev1 = First level links
edit = Edit source
drop = Detach link
redir = Redirection

[dic.de]
edit.none = Keine bearbeitbaren Dateien ...
lev1 = Erste Ebene verknüpfen
edit = Quelle bearbeiten
drop = Verknüpfung lösen
redir = Umleitung

# ***********************************************************
[main]
# ***********************************************************
<msg><!DIC:edit.none!></msg>

<!SEC:<!VAR:type!>!>


[redirect]
<h4><!DIC:redir!></h4>
<p>&rarr; <!VAR:target!></p>

<a href="<!VAR:source!>&vmode=view" target="sf">
<button><img src="LOC_ICO/buttons/view.png" class="icon"></button>
</a>
<a href="<!VAR:source!>&vmode=pedit" target="sf">
<button><img src="LOC_ICO/buttons/edit.png" class="icon"></button>
</a>
<a href="<!VAR:source!>&vmode=medit&btn.menu=P" target="sf">
<button><img src="LOC_ICO/buttons/props.png" class="icon"></button>
</a>


<h4>Import</h4>
<form method="post" action="?">
<!SEC:oid!>
	<input name="target" type="hidden" value="CUR_PAGE" />
	<input name="source" type="hidden" value="<!VAR:target!>" />
	<button name="file.act" value="import"><!DIC:lev1!></button><br>
	<button name="file.act" value="detach"><!DIC:drop!></button>
</form>
