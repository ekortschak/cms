[dic]
create = Create new tab
default = Default
visible = Visible
std.always = Default-Tab will always be visible!

[dic.de]
create = Neuen Tab anlegen
default = Standard
visible = Anzeigen
std.always = Standard-Tab kann nicht ausgeblendet werden!


# ***********************************************************
[main]
# ***********************************************************
<small><b>Info</b>: <!DIC:std.always!></small>

<form method="post" action="?">
	<input type="hidden" name="tabset" value="<!VAR:tabset!>" />

    <table>
		<tr class="rh">
			<th><!DIC:default!></th>
			<th><!DIC:visible!></th>
			<th width=250>Tab</th>
		</tr>
		</tr>
<!VAR:items!>
		<tr class="rf">
			<td colspan="100%" style="vertical-align: middle; text-align: right;">
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
	<td align="center">
		<label class="text">
			<input type="hidden" name="tabs[<!VAR:tab!>]" value="0" />
			<input type="checkbox" name="tabs[<!VAR:tab!>]" value="1" <!VAR:visible!> />
		</label>
	</td>
	<td>
		<!VAR:title!>
	</td>
</tr>
