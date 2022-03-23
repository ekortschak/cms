[include]
design/templates/input/selector.tpl

[open]
<h5><!DIC:apply.to!></h5>

<table width=550>

[close]
	<tr>
		<td colspan="100%" align="right">
			<a href="?">OK</a>
		</td>
	</tr>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td width=100><!VAR:head!> &nbsp; </td>
	<td width="*"><!VAR:data!></td>
</tr>

# ***********************************************************
[input.ron] # read only information
# ***********************************************************
<!VAR:curVal!>
