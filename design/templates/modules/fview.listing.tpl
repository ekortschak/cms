[include]
LOC_TPL/modules/fview.gallery.tpl

[dic]
head = Files

[dic.de]
head = Dateien

[main]
<h4><!DIC:head!></h4>

<table>
<!VAR:files!>
</table>

[file]
<tr>
	<td><img src="LOC_ICO/files/file.gif" /></td>
	<td><a href="<!VAR:url!>" target="_blank"><!VAR:text!></a></td>
	<td>&nbsp;</td>
	<td><!VAR:ext3!></td>
	<td align="right"><!VAR:size!></td>
	<td><!VAR:date!></td>
#	<td><!VAR:md5!></td>
</tr>
