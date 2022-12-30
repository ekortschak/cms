[include]
dropBox.tpl


# ***********************************************************
[main]
# ***********************************************************
<div style="margin: <!VAR:tspace!>px 0px <!VAR:bspace!>px;">
<table class="navi" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="localmenu">
				<!VAR:items!>
			</div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10 align="right"><!SEC:nav.left!></td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10 align="right"><!SEC:nav.right!></td>
	</tr>
</table>
</div>

[main.box]
<div class="dropdown"><!VAR:current!>&ensp;▾
<!SEC:content!>
</div>

[main.one]
<!VAR:current!>

# ***********************************************************
# navigation
# ***********************************************************
[nav.left]
<a class="localicon" href="?<!VAR:parm!>=<!VAR:prev!>">
	<div style="padding: 0 10px;">&ltrif;</div>
</a>

[nav.right]
<a class="localicon" href="?<!VAR:parm!>=<!VAR:next!>">
	<div style="padding: 0 10px;">&rtrif;</div>
</a>

[nav.null]
<div class="localmenu">&emsp;</div>

