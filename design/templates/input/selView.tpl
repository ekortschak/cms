[include]
LOC_TPL/input/selector.tpl

# ***********************************************************
[main]
# ***********************************************************
<table>
	<tr height=0>
		<td width=<!VAR:wid1!>></td>
		<td width=<!VAR:wid2!>></td>
	</tr>
<!VAR:items!>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td><!VAR:head!> &nbsp; </td>
	<td><!VAR:data!></td>
</tr>

[back]
<div class="flex">&nbsp; <a href="?">OK</a></div>
