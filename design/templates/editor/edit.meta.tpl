[register]
LOC_SCR/metakeys.js

[dic]
ed.key = Meta-Keywords
ed.dsc = Meta-Description

[dic.de]
ed.key = Meta-Schlüsselworte
ed.dsc = Meta-Beschreibung

[vars]
sep = ,

# ***********************************************************
[main]
# ***********************************************************
<!SEC:toolbar!>

<script type="text/javascript" language="JavaScript1.2">
	sep = <!VAR:sep!>;
</script>

# followed by page content

# ***********************************************************
[toolbar]
# ***********************************************************
<div class="toolbar">

<form id="inlineEdit" method="post" action="?meta.act=save" style="margin-bottom: 10px;">
<!SEC:oid!>

	<div class="flex">
	<textarea id="content" name="data" spellcheck="false" placeholder="<!VAR:what!>" _
		style="width: calc(100% - 45px); height: 7rem; background-color: white;"><!VAR:data!></textarea>
	<input type="submit" name="meta.act" value="OK" style="height:7rem; padding: 0px 7px;">
	</div>
</form>

<div style="padding: 0px 5px;">
<!SEC:hint!>
</div>

</div>

# ***********************************************************
[hint]
# ***********************************************************
[hint.keys]
<p class="hint">To add keywords: select any text below, then press <kbd>F4</kbd><br>
(will copy formats as well).</p>

[hint.keys.de]
<p class="hint">Wörter im folgenden Text markieren, dann <kbd>F4</kbd> drücken<br>
(übernimmt auch Formatierung).</p>

[hint.desc]
<p class="hint">To add description: drag text into data field while holding <kbd>Ctrl</kbd> key<br>
or use Copy & Paste.</p>

[hint.desc.de]
<p class="hint">Text bei gedrückter <kbd>Strg</kbd>-Taste in das Datenfeld ziehen<br>
oder Kopieren & Einfügen.</p>
