[include]
dropBox.tpl


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="nomargin">
<!VAR:items!>
</table>
</div>

[main.box]
<tr>
	<td class="selHead" width=<!VAR:width!>><!VAR:uniq!></td>
	<td class="selData">
		<div class="dropdown">
			<button><!VAR:current!>&ensp;▾</button>
<!SEC:content!>
		</div>
	</td>
</tr>

[main.one]
<tr>
	<td width=<!VAR:width!>><!VAR:uniq!></td>
	<td><button><!VAR:current!></button></td>
</tr>
