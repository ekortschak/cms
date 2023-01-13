[register]
core/scripts/metakeys.js

[dic]
ed.key = Meta-Keywords
ed.dsc = Meta-Description

[dic.de]
ed.key = Meta-Schlüsselworte
ed.dsc = Meta-Beschreibung

[vars]
sep = ,
wid = 85px

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

<form id="inlineEdit" method="post" action="?meta_act=save" style="margin-bottom: 10px;">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

	<div class="flex">
	<textarea id="metaEdit" name="<!VAR:what!>" cols=83 rows=4 spellcheck="false" placeholder="<!VAR:what!>"><!VAR:data!></textarea>
	<input type="submit" name="meta_act" value="OK" style="height:75px; padding: 0px 7px;"/>
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
<p class="hint">To add keywords: select any text below, then press <kbd>F4</kbd> (will copy formats as well).</p>

[hint.keys.de]
<p class="hint">Wörter im folgenden Text markieren, dann <kbd>F4</kbd> drücken (übernimmt auch Formatierung).</p>

[hint.desc]
<p class="hint">To add description: drag text into data field while holding <kbd>Ctrl</kbd> key or use Coyp & Paste.</p>

[hint.desc.de]
<p class="hint">Text bei gedrückter <kbd>Strg</kbd>-Taste in das Datenfeld ziehen oder Kopieren & Einfügen.</p>
