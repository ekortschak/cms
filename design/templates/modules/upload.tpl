
[register]
core/scripts/upload.js

[dic]
head = Which file(s) are to be uploaded?
over = overwrite existing file(s)
load = Selection
opts = Options
select = Choose file(s)

[dic.de]
head = Welche Datei(en) sollen hochgeladen werden?
over = Betstehende Datei(en) überschreiben
load = Auswahl
opts = Optionen
select = Datei(en) wählen

[vars]
chkOvr =
ftypes = "image/*"

# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:head!></h4>

<table>
<tr>
	<td class="selHead" width=120><!DIC:maxSize!></td>
	<td class="selData" colspan=2><input type="text" size=10 name="opt_max" value="1500" /> MB</td>
</tr>
<tr>
	<td class="selHead"><!DIC:load!></td>
	<td class="selData">
		<input type="hidden" name="opt_act" value="upload" />
		<label for="upload" id="label" class="upload"><!DIC:select!></label>
		<input type="file" id="upload" name="fload[]" style="display:none;" accept="<!VAR:ftypes!>" multiple onChange="setCaption();" />
	</td>
	<td><button name="file_act" value="upl">OK</button></td>
</tr>

<tr><td colspan="100%"><hr class="weak"></td></tr>
<tr>
	<td style="vertical-align: middle;"><b><!DIC:opts!></b></td>
	<td colspan=2><input type="checkbox" name="overwrite" value="1" <!VAR:chkOvr!> /> <red><!DIC:opt.Overwrite!></red></td>
</tr>
</table>
