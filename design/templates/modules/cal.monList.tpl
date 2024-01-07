[include]
LOC_TPL/menus/dropDate.tpl

[vars]
class = std
weekday = MO
numday = 1
info = Staatsfeiertag

# ***********************************************************
[main] # vertical list showing whole month
# ***********************************************************
<!SEC:styles!>

<style>
html, body {
	height: 97vh;
}

@page {
	margin: 1.5cm;
}
</style>


<table class="nomargin" width=275>
	<tr>
		<th colspan="100%"><!VAR:caption!></th>
	</tr>
	<!VAR:items!>
</table>

# ***********************************************************
[dayx]
# ***********************************************************
<tr class="<!VAR:class!>">
	<td class="nopad" width=10 align="right"><div class="daynum"><!VAR:numday!></div></td>
	<td width=10 align="center"><font size="-3"><!VAR:weekday!></font></td>
	<td width="*"><font size="-3"><!VAR:info!></font></td>
</tr>
