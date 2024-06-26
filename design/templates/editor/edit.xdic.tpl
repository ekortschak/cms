[include]
LOC_TPL/editor/edit.tpl

[register]
LOC_SCR/clipboard.js

[dic]
xlate = Translation
protected = File is write protected ...
preview = Preview
step = Step

head = How to proceed
copy = <a href="javascript:clip();">Copy</a> textarea to clipboard (Textfeld wird automatisch geleert)
paste = Paste copied text into online <a href="https://translate.google.com/" target="sf">translator</a>.
return = Paste translated text into textarea above. <kbd>Ctrl</kbd><kbd>v</kbd>
edit = <a href="?pic.editor=html">Edit</a> translation

[dic.de]
xlate = Übersetzung
protected = Datei ist schreibgeschützt ...
preview = Vorschau
step = Schritt

head = Anleitung
copy = Textfeld <a href="javascript:clip();">kopieren</a> (Textfeld wird automatisch geleert)
paste = Kopierten Text in online <a href="https://translate.google.com/" target="sf">Übersetzer</a> einfügen.
return = Übersetzten Text in das Textfeld einfügen. <kbd>Strg</kbd><kbd>v</kbd>
edit = Übersetzung <a href="?pic.editor=html">nachbearbeiten</a>

[vars]
rows = 7

# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:head!></h4>

<form id="inlineEdit" method="post" action="?">
<!SEC:oid!>

	<table>
		<tr>
			<td class="selHead"><!DIC:step!> 1</td>
			<td class="selData"><!DIC:copy!>
			</td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 2</td>
			<td class="selData"><!DIC:paste!></td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 3</td>
			<td class="selData"><!DIC:return!></td>
		</tr><tr>
			<td class="selHead">&nbsp;</td>
			<td class="selData"><!SEC:ctarea!></td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 4</td>
			<td class="selData" align="right">+
				<input type="submit" name="act.xlate" value="<!DIC:apply!>" />
			</td>
		</tr><tr>
			<td class="selHead"><!DIC:step!> 5</td>
			<td class="selData"><!DIC:edit!>
		</tr>
	</table>
</form>

[done]
<h4><!DIC:preview!></h4>
<div class="cold"><!VAR:content!></div>

[protected]
<h4><!DIC:head!></h4>

<p><!DIC:protected!></p>
