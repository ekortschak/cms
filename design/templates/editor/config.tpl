[include]
LOC_TPL/editor/explorer.tpl


[main]
<h4><!DIC:head!></h4>
<!SEC:folders!>
<!SEC:files!>

# ***********************************************************
[files]
# ***********************************************************
<table>
<!VAR:files!>
</table>

[file]
<tr>
	<td width=145><a href="?file=<!VAR:file!>"><!VAR:file!></a></td>
	<td align="right"><grey><!VAR:size!></grey></td>
	<td class="nopad">&nbsp;</td>
	<td><grey><!VAR:DATE!></grey></td>
</tr>

