[include]
LOC_TPL/menus/dropBox.tpl

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
			<div class="<!VAR:class!>"><!VAR:items!></div>
		</td>
		<td class="nopad" width=5></td>
		<td class="nopad" width=26 align="center">
			<!SEC:nav!>
		</td>
	</tr>
</table>

[main.box]
<div class="dropdown">
#<div class="droptext"><!DIC:tpc.list!>COMBO_DOWN</div>
<div class="droptext"><!VAR:current!>COMBO_DOWN</div>
<div class="dropbody"><!VAR:links!></div>
</div> &ensp;

[main.one]
<!DIC:topic!> &ensp;

# ***********************************************************
[nav]
# ***********************************************************
<div class="<!VAR:class!> droptext"> _
<a style="color: white;" href="?vmode=abstract">?</a> _
</div>

[nav.back]
<div class="<!VAR:class!> droptext"> _
<a href="?vmode=view"><img src="LOC_ICO/buttons/view.png"></a> _
</div>
