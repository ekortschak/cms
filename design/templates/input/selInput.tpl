[vars]
max = 1500000
cols = 50
rows = 5
sep = <br>
ext = audio/*

[dic]
pwdinfo = min. 6 letters<br>A-z + 0-9 + special chars
select = Select file(s)

[dic.de]
pwdinfo = min. 6 Zeichen<br>A-z + 0-9 + Sonderzeichen
select = Datei(en) wählen


# ***********************************************************
[main]
# ***********************************************************
&nbsp;

[head]
<!VAR:title!>

[info]
<small><!VAR:unit!> <!VAR:info!></small>

# ***********************************************************
[input.std]
# ***********************************************************
<input type="text" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" placeholder="<!VAR:hint!>" size=35 />
<!SEC:info!>

[input.num]
<input type="text" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" placeholder="<!VAR:hint!>" size=11 maxlength=11 />
<!SEC:info!>

# TODO: min, max, step
# https://www.w3schools.com.html.html_form_input_types.asp

[input.pwd]
<input type="password" name="val.<!VAR:fname!>" size=11 />
<div class="dropdown"><div class="info">i</div>
	<div class="dropdown-content"><!DIC:pwdinfo!></div>
</div>
<!SEC:info!>

[input.dat]
<input type="date" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.dnt]
<input type="datetime-local" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.eml]
<input type="email" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" size=35 />
<!SEC:info!>

[input.col]
<input type="color" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

# ***********************************************************
[input.box]
# ***********************************************************
<textarea name="val.<!VAR:fname!>" cols="<!VAR:cols!>" rows=<!VAR:rows!>
	autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">_
<!VAR:curVal!>_
</textarea>

[input.inf] # any comment
<div class="comment"><!VAR:curVal!></div>

[input.ron] # read only information
<div class="ronly" style="min-height: 24px;"><!VAR:curVal!></div>
<input type="hidden" name="val.<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.txt] # output for viewing
<!SEC:info!>

 min-width:150px;
[input.csv] # output for csv files
"<!VAR:curVal!>"

[input.key]
<!VAR:curVal!>

# ***********************************************************
[input.cmb]
# ***********************************************************
using combo.tpl

# ***********************************************************
[input.chk]
# ***********************************************************
<label class="cb">
	<input type="hidden"   name="val.<!VAR:fname!>" value=0 />
	<input type="checkbox" name="val.<!VAR:fname!>" value=1 <!VAR:checked!> />
	<small><!VAR:choice!></small>
</label><!VAR:sep!>

# ***********************************************************
[input.upl]
# ***********************************************************
<input type="hidden" name="opt_act" value="upload">
<input type="hidden" name="MAX_FILE_SIZE" value="<!VAR:max!>" />
<label for="upload" id="label" class="upload"><!DIC:select!></label>
<input type="file" id="upload" name="fload[]" style="display:none;" accept="<!VAR:ext!>" multiple onChange="setCaption();" />
