[include]
LOC_TPL/menus/dropNav.tpl

[styles]
<style>
.dropbody {
	min-width: 50px;
}
.dropbody a {
	display: inline-block;
	text-align: right;
	width: 15px;
}

.cal {
	text-align: right;
}

a.inactive {
	color: grey;
}

</style>

# ***********************************************************
[combo.mon]
# ***********************************************************
<!SEC:styles!>

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
<!SEC:styles!>

<div class="dropdown">
<div class="droptext"><!VAR:current!>COMBO_DOWN &emsp;</div>
<div class="dropbody">
<table>
	<tr class="rh">
		<td class="cal">MO</td>
		<td class="cal">DI</td>
		<td class="cal">MI</td>
		<td class="cal">DO</td>
		<td class="cal">FR</td>
		<td class="cal">SA</td>
		<td class="cal">SO</td>
	</tr>
	<tr><!VAR:links!>
	</tr>
</table>
</div>
</div>
</div>

[link.day]
<td><a class="<!VAR:myday!> cal" href="?<!VAR:dparm!>=<!VAR:value!>"><!VAR:caption!></a></td>
