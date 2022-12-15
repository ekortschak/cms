[include]
design/templates/input/selector.tpl

# ***********************************************************
[main]
# ***********************************************************
<!SEC:open!>
<!VAR:items!>
<!SEC:close!>

<!SEC:back!>


[open]
<table>
	<tr height=0>
		<td width=<!VAR:wid1!>></td>
		<td width=<!VAR:wid2!>></td>
	</tr>

[close]
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
