[include]
design/templates/input/selector.tpl

[dic.de]
upd = Änderungen speichern
ins = Als neuen Datensatz anlegen
del = Datensatz löschen
rom = Nur Leserechte
nxs = Zusätzliche Rechte erforderlich!
ron = <a href="?vmode=login">Anmelden</a>

field = Feld
value = Wert

mandatory = Mit * markierte Felder müssen ausgefüllt werden!
to.table = Zur Tabellenansicht wechseln


[dic.xx]
upd = Save current record
ins = Insert as new record
del = Delete this record
rom = Read Only
nxs = Additional permissions required!
ron = <a href="?vmode=login">Login</a>

field = Field
value = Value

mandatory = Fields marked with * must be supplied!
to.table = Switch to table view


[vars]
wid1 = 200
wid2 = 10

perms = r

# ***********************************************************
[main]
# ***********************************************************
<!SEC:open!>
<!VAR:items!>
<!SEC:close!>

[open]
<form method="post" action="?">
	<!SEC:hidden!>

	<table width="100%">
		<tr class="rh">
			<th width=<!VAR:wid1!>><!DIC:field!></th>
			<th width=<!VAR:wid2!>><!SEC:mandatory!></th>
			<th width="100%"><!DIC:value!></th>
		</tr>

[close]
	</table>

	<div class="flex rf" style="padding: 0px 5px;">
		<div><!SEC:buttons!></div>
		<div><!SEC:action.<!VAR:perms!>!></div>
	</div>
</form>


[mandatory]
<div class="dropdown">?
	<div class="dropdown-content"><!DIC:mandatory!></div>
</div>

# ***********************************************************
[rows]
# ***********************************************************
<tr class="rw">
	<td class="selHead"><!VAR:head!> </td>
	<td><!VAR:fnull!></td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
# return to table view
# ***********************************************************
[buttons]
	<div class="dropdown">
		<a href="?oid=<!VAR:oid!>&rec=list">
			<img class="button" src="core/icons/db/table.gif" />
		</a>
		<div class="dropdown-content"><!DIC:to.table!></div>
	</div>

# ***********************************************************
[hidden]
# ***********************************************************
	<input type="hidden" name="oid" value="<!VAR:oid!>" />
	<input type="hidden" name="tan" value="<!VAR:tan!>" />

# ***********************************************************
# Buttons
# ***********************************************************
[action.w]
<select name="rec.act">
	<option value="e"><!DIC:upd!></option>
	<option value="a"><!DIC:ins!></option>
	<option value="d"><!DIC:del!></option>
</select>
<!SEC:btn.ok!>

[action.aed]
<!SEC:Action.w!>

# ***********************************************************
[action.ae]
<select name="rec.act">
	<option value="e"><!DIC:upd!></option>
	<option value="a"><!DIC:ins!></option>
</select>
<!SEC:btn.ok!>

[action.ed]
<select name="rec.act">
	<option value="e"><!DIC:upd!></option>
	<option value="d"><!DIC:del!></option>
</select>
<!SEC:btn.ok!>

[action.ad]
<select name="rec.act">
	<option value="a"><!DIC:ins!></option>
	<option value="d"><!DIC:del!></option>
</select>
<!SEC:btn.ok!>

# ***********************************************************
[action.a]
<input type="hidden" name="rec.act" value="a">
<input type="submit" value="<!DIC:ins!>" />

[action.e]
<input type="hidden" name="rec.act" value="e">
<input type="submit" value="<!DIC:upd!>" />

[action.d]
<input type="hidden" name="rec.act" value="d">
<input type="submit" value="<!DIC:del!>" />

# ***********************************************************
[action.r]
<!DIC:ron!>

# ***********************************************************
[no.perms]
# ***********************************************************
<msg><!DIC:nxs!></msg>
