[register]
core/scripts/slide.js

[dic]
login = Log in (to enter data or deny usage)
email = or send an <a href="mailto:copyright@glaubeistmehr.at;">email</a>
empty = No graphic files!
nodb  = Database is inaccessible!
claim = Claim &copy; or deny usage
unknown = Unknown
no.info	= No further info available

[dic.de]
login = Anmelden (Daten eingeben oder Verwendung untersagen)
email = EMail senden
empty = Keine Grafik-Dateien!
nodb  = Datenbank ist nicht erreichbar!
claim = &copy; reklamieren
unknown = Unbekannt
no.info	= Keine weitere Info vorhanden


# ***********************************************************
[main]
# ***********************************************************
<div style="position:relative;">

<table width="100%">
	<tr>
		<td colspan="100%" class="nopad">
			<div style="background-image: url('<!VAR:pfile!>'); background-size: cover;">
				<img src="ICONS/copyprot.gif" width=100% />
			</div>
		</td>
	</tr>

	<tr class="rf">
		<td width="100%"><!SEC:cr!></td>
		<td nowrap>
			<a href="?act=0">           <black>◂◂</black></a> &nbsp;
			<a href="?act=<!VAR:prev!>"><black>◂ </black></a> &nbsp; <!VAR:cur!>/<!VAR:count!> &nbsp;
			<a href="?act=<!VAR:next!>"><black> ▸</black></a> &nbsp;
			<a href="?act=<!VAR:last!>"><black>▸▸</black></a>
		</td>
	</tr>

	<tr id="crinfo" style="visibility: collapse;">
		<td colspan="100%">
			<!VAR:text!>x
		</td>
	</tr>
</table>

</div>

<div>
<!VAR:text!>
</div>

# ***********************************************************
[cr] # copyright
# ***********************************************************
<!SEC:cr.known!>

[cr.known]
<div class="dropdown">
<!SEC:cr.short!>COMBO_DOWN
<!SEC:cinfo!>
</div>

[cr.short]
&copy; <a href="<!VAR:source!>"><!VAR:holder!></a>

[cr.user]
<div class="dropdown"><!DIC:claim!>COMBO_DOWN
<!SEC:cinfo!>
</div>

[cr.unknown]
<div class="dropdown">&copy; <!DIC:unknown!>COMBO_DOWN
	<div class="dropdown-content">
		<!SEC:login!>
		<!SEC:email!>
	</div>
</div>

[cr.nodb]
<div class="dropdown">Sorry - <!DIC:nodb!>
	<div class="dropdown-content">
		<!SEC:email!>
	</div>
</div>

# ***********************************************************
[no.files]
# ***********************************************************
<msg><!DIC:empty!></msg>

[login]
<a href="?tab=user&pge=login"><!DIC:login!></a>

[email]
<a href="mailto:copyright@glaubeistmehr.at?subject=copyright&body=pfile:<!VAR:pfile!>"><!DIC:email!></a>

[cinfo]
<div class="dropdown-content">
	<!VAR:cinfo!>
</div>
