[include]
design/templates/input/selector.tpl

[dic.de]
upd = Änderungen speichern
ins = Als neuen Datensatz anlegen
del = Datensatz löschen
rom = Nur Leserechte
nxs = Zusätzliche Rechte erforderlich!
ron = Keine Schreibrechte!

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
ron = Read only permissions!

field = Field
value = Value

mandatory = Fields marked with * must be supplied!
to.table = Switch to table view


[vars]
wid1 = 125
wid2 = 10
wid3 = 150

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
	<!SEC:hidden!>

	<table>
		<tr class="rh">
			<th width=<!VAR:wid1!>><!DIC:field!></th>
			<th width=<!VAR:wid2!>><!SEC:mandatory!></th>
			<th width=<!VAR:wid3!>><!DIC:value!></th>
		</tr>
		<tr>
			<td colspan=3></th>
			<td rowspan="100%"><!SEC:tblLink!></th>
		</tr>
<!VAR:items!>
		<tr><td></td></tr>
		<tr class="rf">
			<td width="<!VAR:wid1!>">&nbsp;</td>
			<td></td>
			<td width="<!VAR:wid3!>" class="selData" align="right">
<!SEC:action.<!VAR:perms!>!>
			</td>
		</tr>
	</table>
</form>

[mandatory]
<div class="dropdown">?
	<div class="dropdown-content"><!DIC:mandatory!></div>
</div>

# ***********************************************************
[rows]
# ***********************************************************
<tr class="rw">
	<td class="selHead"><!VAR:head!> &nbsp; </td>
	<td><!VAR:fnull!></td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
# return to table view
# ***********************************************************
[tblLink]
<div style="padding: 2px 0px 0px 15px;">
	<div class="dropdown">
		<a href="?oid=<!VAR:oid!>&rec=list">
			<dmbtn><img class="button" src="core/icons/db/table.gif" /></dmbtn>
		</a>
		<div class="dropdown-content"><!DIC:to.table!></div>
	</div>
</div>

# ***********************************************************
[hidden]
# ***********************************************************
	<input type="hidden" name="oid" value="<!VAR:oid!>" />
	<input type="hidden" name="tan" value="<!VAR:tan!>" />
	<!VAR:hidden!>

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
<input name="rec.act" type="hidden" value="a">
<input type="submit" value="<!DIC:ins!>" />

[action.e]
<input name="rec.act" type="hidden" value="e">
<input type="submit" value="<!DIC:upd!>" />

[action.d]
<input name="rec.act" type="hidden" value="d">
<input type="submit" value="<!DIC:del!>" />

# ***********************************************************
[action.r]
<!DIC:ron!>

# ***********************************************************
[no.perms]
# ***********************************************************
<msg><!DIC:nxs!></msg>
