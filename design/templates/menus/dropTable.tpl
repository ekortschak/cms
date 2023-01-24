[include]
dropBox.tpl


# ***********************************************************
[main]
# ***********************************************************
<table class="nomargin">
<!VAR:items!>
</table>

[main.box]
<tr>
	<td class="selHead" width="<!VAR:wid!>"><!VAR:uniq!></td>
	<td class="selData" width="*">
		<div class="dropdown">
			<button><!VAR:current!>COMBO_DOWN</button>
<!SEC:content!>
		</div>
	</td>
</tr>

[main.one]
<tr>
	<td width="<!VAR:wid!>"><!VAR:uniq!></td>
	<td width="*"><button><!VAR:current!></button></td>
</tr>
