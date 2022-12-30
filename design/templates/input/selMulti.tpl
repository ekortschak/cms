[include]
LOC_TPL/input/selROnly.tpl

[vars]
auto =
sep = <br>

[dic]
multi = Multiple selections possible

[dic.de]
multi = Mehrfach-Auswahl möglich

# ***********************************************************
[main]
# ***********************************************************
#<small><blue><!DIC:multi!></blue></small>
<div>
<!VAR:items!>
</div>

# ***********************************************************
[input.mul]
# ***********************************************************
<label class="text" style="line-height: 24px;">
	<input type="hidden"   name="<!VAR:fname!>[<!VAR:key!>]" value=0 />
	<div style="display: table-cell;">
	<input type="checkbox" name="<!VAR:fname!>[<!VAR:key!>]" value=1 <!VAR:checked!> />
	</div>&nbsp;

	<div style="display: table-cell; max-width: 650px;">
	<!VAR:curVal!>
	</div>
</label> <!VAR:sep!>

# ***********************************************************
[input.txt] # output for viewing
# ***********************************************************
<!VAR:curVal!>: <!VAR:checked!> <!SEC:info!>

# ***********************************************************
[input.skip]
# ***********************************************************
