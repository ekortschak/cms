[include]
LOC_TPL/menus/dropNav.tpl

[styles]
<style>
.dropbody {
	text-align: right;
	min-width: 50px;
	max-width: 285px;
}
.dropbody a {
	display: inline-block;
	border-radius: 7px;
	min-width: 20px;
}

.calhead {
	text-align: right;
}

.cal {
	position: relative;
	display: block;
	margin: 0px;
 	border: 1px solid OUTLINE;
	border-radius: 7px;
	padding: 3px;

	color: FC_DROP;
	background: BC_DROP;
	text-align: right;
}

a.inactive {
	color: grey;
}

</style>


# ***********************************************************
[main] # simple combo box
# ***********************************************************
<!SEC:styles!>

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

<!VAR:cal!>

<br>

# ***********************************************************
[combo.mon]
# ***********************************************************
<div class="dropdown">
<div class="droptext"><!VAR:current!>COMBO_DOWN &emsp;</div>
<div class="dropbody">
<div><!VAR:links!></div>
</div>
</div>

[link.mon]
<a href="?<!VAR:parm!>=<!VAR:value!>"><!VAR:value!></a>

# ***********************************************************
[combo.day]
# ***********************************************************
<div class="dropdown">
<div class="droptext"><!VAR:current!>COMBO_DOWN &emsp;</div>
<div class="dropbody" style="position: relative; display: block; margin: 0px;">
<!SEC:cal!>
</div>
</div>
</div>

# ***********************************************************
[table.day]
# ***********************************************************
<div class="dropbody cal">
<div class="cal">
<!SEC:cal!>
</div>
</div>

[cal]
<table class="nomargin">
	<tr class="rh">
		<td class="calhead">MO</td>
		<td class="calhead">DI</td>
		<td class="calhead">MI</td>
		<td class="calhead">DO</td>
		<td class="calhead">FR</td>
		<td class="calhead">SA</td>
		<td class="calhead">SO</td>
	</tr>
	<tr><!VAR:links!>
	</tr>
</table>

[link.day]
<td><a class="<!VAR:myday!>" href="?<!VAR:dparm!>=<!VAR:value!>"><!VAR:caption!></a></td>

# ***********************************************************
# navigation buttons
# ***********************************************************
[nav.left]
<a href="?<!VAR:dparm!>=<!VAR:prev!>">
	<div class="localicon <!VAR:class!>">&ltrif;</div>
</a>

[nav.right]
<a href="?<!VAR:dparm!>=<!VAR:next!>">
	<div class="localicon <!VAR:class!>">&rtrif;</div>
</a>
