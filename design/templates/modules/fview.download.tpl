[include]
design/templates/modules/fview.gallery.tpl

[dic]
resp = Disclaimer
info = Downloads from this page are at your own risk.
free = Free downloads

[dic.de]
resp = Haftungsausschluß
info = Downloads von dieser Seite erfolgen auf eigenes Risiko.
free = Kostenlose Downloads


[main]
<h4><!DIC:resp!></h4>
<p><!DIC:info!></p>

<h4><!DIC:free!></h4>
<!SEC:files!>


[files]
<table>
<!VAR:files!>
</table>

[file]
<tr>
	<td><img src="core/icons/files/file.gif" /></td>
	<td nowrap><a href="<!VAR:url!>" target="_blank"><!VAR:caption!></a></td>
	<td>&nbsp;</td>
	<td><!VAR:ext3!></td>
	<td nowrap align="right"><grey><!VAR:size!></grey></td>
	<td><grey><!VAR:date!></grey></td>
	<td><grey><!VAR:md5!></grey></td>
</tr>