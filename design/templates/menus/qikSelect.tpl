[include]
dropBox.tpl


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="navi">
<!VAR:items!>
</table>
</div>

[main.box]
<tr>
	<td class="selHead" width=<!VAR:width!>><!VAR:uniq!></td>
	<td class="selData">
		<div class="dropdown">
			<button class="dropdown-button"><!VAR:current!>&emsp;▾</button>
<!SEC:content!>
		</div>
	</td>
</tr>

[main.one]
<tr>
	<td width=<!VAR:width!>><!VAR:uniq!></td>
	<td><button class="dropdown-button"><!VAR:current!></button></td>
</tr>
