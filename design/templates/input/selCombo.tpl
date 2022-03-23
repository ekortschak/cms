[vars]
auto =
sep = &nbsp; &nbsp;
sep =

[head]
<!VAR:title!>

[main]

# ***********************************************************
[input.cmb]
# ***********************************************************
<select name="val.<!VAR:fname!>">
<!VAR:options!>
</select>
<small><!VAR:info!></small>

[input.cmbitem]
<option value="<!VAR:key!>" <!VAR:selected!>><!VAR:value!></option>

[input.auto]
<select name="val.<!VAR:name!>" onchange="this.form.<!VAR:auto!>()">
<!VAR:options!>
</select>

# ***********************************************************
[input.opt]
# ***********************************************************
<input type="radio" id="opt.<!VAR:key!>" name="val.<!VAR:fname!>" value="<!VAR:key!>" <!VAR:checked!> class="cb" />
<label for="opt.<!VAR:key!>" class="text"><!VAR:caption!></label>
<!VAR:sep!>

[input.rng]
<input type="range" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" min="<!VAR:min!>" max="<!VAR:max!>" class="cb" />
<small><!VAR:min!> - <!VAR:max!></small>

# ***********************************************************
[input.ron] # read only information
# ***********************************************************
<div class="ronly"><!VAR:curVal!></div>
<input type="hidden" name="val.<!VAR:fname!>" value="<!VAR:key!>" />

