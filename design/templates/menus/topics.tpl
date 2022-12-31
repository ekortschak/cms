[include]
dropBox.tpl

[dic]
topic = Topic

[dic.de]
topic = Thema


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="nomargin" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="localmenu">
				<!VAR:items!>
			</div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=26 align="center">
			<div class="localmenu">
				<a style="color: white; vertical-align: top; font-family: monospace;" href="?vmode=abstract">?</a>
			</div>
		</td>
	</tr>
</table>
</div>

[main.box]
<div class="dropdown">
<!DIC:tpc.list!>&ensp;▾
<!SEC:content!>
</div> &ensp;

[main.one]
<!DIC:topic!> &ensp;
