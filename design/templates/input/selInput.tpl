[include]
LOC_TPL/input/selROnly.tpl

[dic]
pwdinfo = min. 6 letters<br>A-z + 0-9 + special chars
select = Select file(s)

[dic.de]
pwdinfo = min. 6 Zeichen<br>A-z + 0-9 + Sonderzeichen
select = Datei(en) wählen

[vars]
max = 15000
rows = 4
sep = <br>
type = */*


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
	<div class="dropbody"><!DIC:pwdinfo!></div>
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
<textarea name="<!VAR:fname!>" width="100%" rows=<!VAR:rows!>
	autocomplete="off" autocorrect="off" autocapitalize="off"
	spellcheck="false"><!VAR:curVal!></textarea>

# ***********************************************************
[input.ron] # read only information
# ***********************************************************
<label class="ronly"><!VAR:curVal!></kabek>
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
<div style="position: relative; width: 300px;">
<input type="hidden"   name="<!VAR:fname!>" value=0 />
<input type="checkbox" name="<!VAR:fname!>" value=1 id="<!VAR:fname!>" <!VAR:checked!> />
<small style="position: absolute; top: 2px; display: inline-block;"><!VAR:choice!></small>
</div>

# ***********************************************************
[input.upl]
# ***********************************************************
<input type="hidden" name="MAX_FILE_SIZE" value="<!VAR:max!>" />
<label for="upload" id="label" class="upload"><!DIC:select!>COMBO_DOWN</label>
<input type="file" id="upload" name="fload[]" style="display:none;" accept="<!VAR:type!>" multiple onChange="setCaption();" />
