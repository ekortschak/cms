[include]
dropBox.tpl

[vars]
class = dropMenu


# ***********************************************************
[main]
# ***********************************************************
<table class="nomargin" width="100%">
	<tr>
		<td class="nopad" width="*">
			<div class="<!VAR:class!>"><!VAR:items!></div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10 align="right"><!SEC:nav.left!></td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10 align="right"><!SEC:nav.right!></td>
	</tr>
</table>

[main.box]
<div class="dropdown">
<!VAR:current!>COMBO_DOWN
<!SEC:content!>
</div>&ensp;

[main.one]
<!VAR:current!>&ensp;

# ***********************************************************
# navigation buttons
# ***********************************************************
[nav.left]
<a href="?<!VAR:parm!>=<!VAR:prev!>">
	<div class="localicon <!VAR:class!>">&ltrif;</div>
</a>

[nav.right]
<a href="?<!VAR:parm!>=<!VAR:next!>">
	<div class="localicon <!VAR:class!>">&rtrif;</div>
</a>

[nav.null]
<div class="<!VAR:class!>">&emsp;</div>

