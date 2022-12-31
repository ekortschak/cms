[include]
LOC_TPL/input/selROnly.tpl

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
<input type="text" name="<!VAR:fname!>" value="<!VAR:curVal!>" placeholder="<!VAR:hint!>" size=35 />
<!SEC:info!>

[input.num]
<input type="text" name="<!VAR:fname!>" value="<!VAR:curVal!>" placeholder="<!VAR:hint!>" size=11 maxlength=11 />
<!SEC:info!>

# TODO: min, max, step
# https://www.w3schools.com.html.html_form_input_types.asp

[input.pwd]
<input type="password" name="<!VAR:fname!>" value="<!VAR:curVal!>" size=11 />
<div class="dropdown"><div class="info">i</div>
	<div class="dropdown-content"><!DIC:pwdinfo!></div>
</div>
<!SEC:info!>

[input.dat]
<input type="date" name="<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.dnt]
<input type="datetime-local" name="<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.eml]
<input type="email" name="<!VAR:fname!>" value="<!VAR:curVal!>" size=35 />
<!SEC:info!>

[input.col]
<input type="color" name="<!VAR:fname!>" value="<!VAR:curVal!>" />
<!SEC:info!>

[input.hid]
<input type="hidden" name="<!VAR:fname!>" value="<!VAR:curVal!>" />

# ***********************************************************
[input.tar]
# ***********************************************************
<textarea name="<!VAR:fname!>" cols="<!VAR:cols!>" rows=<!VAR:rows!>
	autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">_
<!VAR:curVal!>_
</textarea>

# ***********************************************************
[input.ron] # read only information
# ***********************************************************
<div class="ronly"><!VAR:curVal!></div>
<!SEC:info!>

[input.inf] # any comment
<div class="comment"><!VAR:curVal!></div>

[input.txt] # output for viewing
<!VAR:curVal!> <!SEC:info!>

[input.key]
<!VAR:curVal!>

# ***********************************************************
[input.chk]
# ***********************************************************
<input type="hidden"   name="<!VAR:fname!>" value=0 />
<input type="checkbox" name="<!VAR:fname!>" value=1 <!VAR:checked!> />
<small><!VAR:choice!></small>
<!VAR:sep!>

# ***********************************************************
[input.upl]
# ***********************************************************
<input type="hidden" name="MAX_FILE_SIZE" value="<!VAR:max!>" />
<label for="upload" id="label" class="upload"><!DIC:select!></label>
<input type="file" id="upload" name="fload[]" style="display:none;" accept="<!VAR:ext!>" multiple onChange="setCaption();" />
