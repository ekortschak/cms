[include]
design/templates/input/selROnly.tpl

[vars]
auto =
sep = &emsp;
sep =

[head]
<!VAR:title!>

# ***********************************************************
[main]
# ***********************************************************
<select name="<!VAR:fname!>">
<!VAR:options!>
</select>
<small><!VAR:info!></small>

[item]
<option value="<!VAR:key!>" <!VAR:selected!>><!VAR:option!></option>

# ***********************************************************
[input.one]
# ***********************************************************
<input type="hidden" name="<!VAR:fname!>" value="<!VAR:curVal!>" class="cb" />
<div class="ronly"><!VAR:option!></div>


# ***********************************************************
[input.opt]
# ***********************************************************
<input type="radio" id="opt.<!VAR:key!>" name="<!VAR:fname!>" value="<!VAR:key!>" <!VAR:checked!> class="cb" />
<label for="opt.<!VAR:key!>" class="text"><!VAR:caption!></label>
<!VAR:sep!>


# ***********************************************************
[input.rng]
# ***********************************************************
<input type="range" name="<!VAR:fname!>" value="<!VAR:curVal!>" min="<!VAR:min!>" max="<!VAR:max!>" class="cb" />
<small><!VAR:min!> - <!VAR:max!></small>

[empty]
<div class="ronly">No data ...</div>
