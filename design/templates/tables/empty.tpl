[dic]
nodata = No data
recNew = Append a new record

[dic.de]
nodata = Keine Daten
recNew = Neuen Datensatz anlegen

# ***********************************************************
[main]
# ***********************************************************
<p>
<table>
	<tr>
		<td class="nopad"><!SEC:sorry!></td>
		<td class="nopad"><!SEC:cmds!></td>
	</tr>
</table>
</p>


[sorry]
<table width=250>
	<tr class="rh">
		<th align="center">Sorry</th>
	</tr>
	<tr>
		<td align="center">
			<img src="core/icons/db/empty.gif" />
		</td>
	</tr>
	<tr class="rf">
		<td align="center"><!DIC:nodata!></td>
	</tr>
</table>

[cmds]
<div style="padding: 0px 15px;">
	<div class="dropdown">
		<a href="?oid=<!VAR:oid!>&rec=-1">
			<button class="icon"><img src="core/icons/buttons/file.png" /></button>
		</a>
		<div class="dropdown-content"><!DIC:recNew!></div>
	</div>
</div>
