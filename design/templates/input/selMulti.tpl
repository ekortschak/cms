[include]
LOC_TPL/input/selROnly.tpl

[register]
core/scripts/selRec.js

[dic]
multi = Multiple choices
invert = Invert selection

[dic.de]
multi = Mehrfach-Auswahl
invert = Auswahl umkehren

[vars]
cls = ms


# ***********************************************************
[main]
# ***********************************************************
<table>
<!SEC:input.head!>
<!VAR:items!>
</table>


# ***********************************************************
[input.head]
# ***********************************************************
<tr class="toolbar">
	<td><img src="ICONS/nav/toggle.gif" class="icon" onClick="toggleCB('<!VAR:cls!>');"></td>
	<td nowrap><small><!DIC:multi!></small></td>
	<td> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; </td> # TOOD: &emsp; for optical reasons
</tr>


# ***********************************************************
[input.mul]
# ***********************************************************
<tr>
<td style="padding-left: 8px;"> # TODO: why not aligned with heading without additional padding
	<input type="hidden"   name="<!VAR:fname!>[<!VAR:key!>]" value=0>
	<input type="checkbox" name="<!VAR:fname!>[<!VAR:key!>]" value=1 <!VAR:checked!> class="<!VAR:cls!>">
</td>
<td nowrap><!VAR:curVal!>
</td>
</tr>

# ***********************************************************
[input.txt] # output for viewing
# ***********************************************************
<tr>
<td>&nbsp;</td>
<td><!VAR:curVal!>: <!VAR:checked!> <!SEC:info!></td>
</tr>

# ***********************************************************
[input.skip]
# ***********************************************************
