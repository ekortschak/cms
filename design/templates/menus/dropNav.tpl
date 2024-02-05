[include]
LOC_TPL/menus/dropBox.tpl

[vars]
class = dropMenu


# ***********************************************************
[main]
# ***********************************************************
<table class="nomargin" width="100%">
	<tr>
		<td class="nopad" width="*" align="<!var:align!>">
			<div class="<!VAR:class!>"><!VAR:items!></div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10><!SEC:nav.left!></td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=10><!SEC:nav.right!></td>
	</tr>
</table>

[main.box]
<!SEC:combo!>

[main.one]
<!SEC:text!>

# ***********************************************************
[combo]
# ***********************************************************
<div class="dropdown">
<div class="droptext"><!VAR:current!>COMBO_DOWN</div>
<div class="dropbody"><!VAR:links!></div>
</div> &ensp;

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
<div class="<!VAR:class!> droptext">&emsp;</div>

