[include]
design/templates/editor/genEdit.tpl
design/templates/editor/toolbar.tpl

[dic]
ed.cpy = Provide a copy
ed.upd = Update now

[dic.de]
ed.cpy = Exportieren
ed.upd = Importieren


# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar flex">
	<div>
		<a href="?edit=provide&file=<!VAR:file!>"><button><!DIC:ed.cpy!></button></a>
		<a href="?edit=update&file=<!VAR:file!>"><button><!DIC:ed.upd!></button></a>
		<a href="?edit=clear"><button>BOOL_NO</button></a>
		&nbsp; <small>dir = <dfn><!VAR:path!></dfn></small>
	</div>
	<div>
		<!SEC:item.view!>
	</div>
</div>

<hr class="low">

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>
<code><!VAR:content!></code>
