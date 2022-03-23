[vars]
auto =

# ***********************************************************
[input.cmb]
# ***********************************************************
<select name="val.<!VAR:name!>">
<!VAR:items!>
</select>
<small><!VAR:info!></small>

[input.cmbitem]
<option value="<!VAR:key!>" <!VAR:selected!>><!VAR:value!></option>

[input.auto]
<select name="val.<!VAR:name!>" onchange="this.form.<!VAR:auto!>()">
<!VAR:items!>
</select>
