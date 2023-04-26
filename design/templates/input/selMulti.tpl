[include]
LOC_TPL/input/selROnly.tpl

[register]
LOC_SCR/selRec.js

[dic]
multi = Multiple choices possible
invert = Invert selection

[dic.de]
multi = Mehrfach-Auswahl möglich
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
	<td><img src="LOC_ICO/nav/toggle.gif" class="icon" onClick="toggleCB('<!VAR:cls!>');"></td>
	<td nowrap style="min-width: 150px;"><small><!DIC:multi!></small></td>
</tr>


# ***********************************************************
[input.mul]
# ***********************************************************
<tr>
<td style="padding-left: 8px;"> # TODO: why not aligned with heading without additional padding
	<input type="hidden"   name="<!VAR:fname!>[<!VAR:key!>]" value=0>
	<input type="checkbox" name="<!VAR:fname!>[<!VAR:key!>]" value=1 <!VAR:checked!> class="<!VAR:cls!>">
</td>
<td nowrap style="padding: 0px 30px 0px 5px;">
	<!VAR:curVal!>
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
