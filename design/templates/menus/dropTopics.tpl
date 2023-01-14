[include]
dropBox.tpl

[dic]
topic = Topic

[dic.de]
topic = Thema

[vars]
class = dropMenu


# ***********************************************************
[main]
# ***********************************************************
<table class="nomargin" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="<!VAR:class!>">
				<!VAR:items!>
			</div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=26 align="center">
			<div class="<!VAR:class!>">
				<a style="color: white; vertical-align: top; font-family: monospace;" href="?vmode=abstract">?</a>
			</div>
		</td>
	</tr>
</table>

[main.box]
<div class="dropdown">
<!DIC:tpc.list!>COMBO_DOWN
<!SEC:content!>
</div> &ensp;

[main.one]
<!DIC:topic!> &ensp;
