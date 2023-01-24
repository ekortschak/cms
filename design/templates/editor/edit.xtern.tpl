[include]
LOC_TPL/editor/edit.tpl

[dic]
ed.cpy = Provide a copy
ed.upd = Update now

[dic.de]
ed.cpy = Exportieren
ed.upd = Importieren


# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>
<div class="cold"><!VAR:content!></div>

# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div>
		<a href="?edit=provide&file=<!VAR:file!>"><button><!DIC:ed.cpy!></button></a>
		<a href="?edit=update&file=<!VAR:file!>"> <button><!DIC:ed.upd!></button></a>
		<a href="?edit=clear"><button>BOOL_NO</button></a>
		&nbsp; <small>dir = <dfn><!VAR:path!></dfn></small>
	</div>
	<div>
		<!SEC:item.view!>
	</div>
</div>
