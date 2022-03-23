[vars]
auto =
sep = <br>

[dic.xx]
multi = Multiple selections possible

[dic.de]
multi = Mehrfach-Auswahl möglich

# ***********************************************************
[main]
# ***********************************************************
<small><blue>Info: <!DIC:multi!></blue></small>
<div>
<!VAR:items!>
</div>

# ***********************************************************
[input.mul]
# ***********************************************************
<label class="text" style="line-height: 24px;">
	<input type="hidden"   name="val.<!VAR:fname!>[<!VAR:key!>]" value=0 />
	<div style="display: table-cell;">
	<input type="checkbox" name="val.<!VAR:fname!>[<!VAR:key!>]" value=1 <!VAR:checked!> />
	</div>&nbsp;

	<div style="display: table-cell; max-width: 650px;">
	<!VAR:curVal!>
	</div>
</label> <!VAR:sep!>
