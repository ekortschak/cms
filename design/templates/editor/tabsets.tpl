[dic]
default = Default
visible = Visible
local = Local only
std.always = Default-Tab will always be visible!

[dic.de]
default = Vorauswahl
visible = Anzeigen
local = Nur lokal
std.always = Standard-Tab kann nicht ausgeblendet werden!


# ***********************************************************
[main]
# ***********************************************************
<small><b>Info</b>: <!DIC:std.always!></small>

<form method="post" action="?">
<!SEC:oid!>
	<input type="hidden" name="tabset" value="<!VAR:tabset!>" />

    <table>
		<tr class="rh">
			<th><!DIC:default!></th>
			<th>Tab</th>
			<th><!DIC:visible!></th>
			<th><!DIC:local!></th>
		</tr>
		</tr>
<!VAR:items!>
		<tr class="rf">
			<td colspan="100%" style="text-align: right;">
				<input type="submit" name="set.act" value="OK" />
			</td>
		</tr>
	</table>
</form>

# ***********************************************************
[row]
# ***********************************************************
<tr class="rw">
	<td align="center">
		<input type="radio" name="tab.default" value="<!VAR:tab!>" <!VAR:default!> />
	</td>
	<td>
		<div class="cbtext"><!VAR:title!></div>
	</td>
	<td align="center">
		<label class="text">
			<input type="hidden" name="tabs[<!VAR:tab!>]" value="0" />
			<input type="checkbox" name="tabs[<!VAR:tab!>]" value="1" <!VAR:visible!> />
		</label>
	</td>
	<td align="center">
		<label class="text">
			<input type="hidden" name="tabl[<!VAR:tab!>]" value="0" />
			<input type="checkbox" name="tabl[<!VAR:tab!>]" value="1" <!VAR:local!> />
		</label>
	</td>
</tr>
