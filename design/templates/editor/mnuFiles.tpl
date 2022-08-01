[include]
design/templates/modules/fview.gallery.tpl

[register]
core/scripts/upload.js

[vars]
chkOvr =
chkFst = CHECKED

[dic]
head = Files
sure = Sure?
cont = Create system file
load = Upload other file(s)

select = Select file(s)
add.files = Create files
addfile = Create a new file
create = OK
inifiles = Ini file(s)

recurse = whole project

[dic.de]
head = Dateien
sure = Sicher?
cont = Systemdatei
load = Datei(en) hochladen

select  = Datei(en) wählen
add.files = Dateien erstellen
addfile = Andere Datei
create  = Erstellen
inifiles = Ini-Datei(en)

recurse = gesamtes Projekt

# ***********************************************************
[main]
# ***********************************************************
<h4><!DIC:head!></h4>
<!SEC:files!>

<h4><!DIC:add.files!></h4>
<form method="post" action="?" enctype="multipart/form-data">
<!SEC:append!>
</form>

# ***********************************************************
[files]
# ***********************************************************
<!SEC:location!>

<table>
<!VAR:files!>
</table>

[file]
<tr>
	<td nowrap>
		<a href="?file_act=drop&fil=<!VAR:file!>" onclick="return confirm('<!DIC:ask.sure!>');"><maroon>&cross;</maroon></a>
		<a href="?file_act=hide&fil=<!VAR:file!>"><img src="core/icons/menu/bulb_<!VAR:vis!>.gif" /></a>
	</td>

	<td nowrap width=175><a href="?vmode=pedit&pic.file=<!VAR:file!>"><!VAR:file!></a></td>
	<td nowrap align="right"><grey><!VAR:sfmt!></grey></td>
	<td class="nopad">&nbsp;</td>
	<td><grey><!VAR:date!></grey></td>
	<td><hint><!VAR:md5!></hint></td>
</tr>

# ***********************************************************
# file options
# ***********************************************************
[append]
<table>

<!SEC:addIniFile!>
<!SEC:addSysFile!>
<!SEC:addAnyFile!>

	<tr><td colspan="100%"><hr class="weak"></td></tr>
	<tr>
		<td colspan=2><!VAR:overwrite!></td>
	</tr>
</table>

[addIniFile]
<tr>
	<td style="vertical-align: middle;" width=175><!DIC:inifiles!></td>
	<td><input type="checkbox" name="ini.rec" value="1" /> <!DIC:recurse!></td>
	<td><button name="file_act" value="ini"><!DIC:create!></button></td>
</tr>

[addSysFile]
<tr><td colspan="100%" height=5></td></tr>
<tr>
	<td style="vertical-align: middle;" ><!DIC:cont!></td>
	<td>
		<select name="sys.name" style="min-width:25px;">
			<option value="banner">Banner</option>
			<option value="head">Head</option>
			<option value="content" selected>Content</option>
			<option value="help">Help</option>
			<option value="tail">Tail</option>
			<option value="trailer">Trailer</option>
		</select>

		<select name="sys.lang" style="min-width:25px;">
			<option value=CUR_LANG selected>CUR_LANG</option>
			<option value="xx">xx</option>
		</select>

		<select name="sys.ext" style="min-width:25px;">
			<option value="htm">htm</option>
			<option value="php">php</option>
		</select>
	</td>
	<td><button name="file_act" value="sys"><!DIC:create!></button></td>
</tr>

[addAnyFile]
<tr><td colspan="100%" height=5></td></tr>
<tr>
	<td style="vertical-align: middle;" ><!DIC:addfile!></td>
	<td><input name="any.name" type="text" value="" placeholder="newfile.txt" /></td>
	<td><button name="file_act" value="any"><!DIC:create!></button></td>
</tr>
