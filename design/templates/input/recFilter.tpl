[include]
LOC_TPL/input/selector.tpl

[dic.de]
filter = Datenfilter
filtered = Gefilterte Daten

[dic.xx]
filter = Use record filter
filtered = Filtered Records

[vars]
equal = &sime;

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" style="padding: 0px; margin: 0px;">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

	<table>
		<tr>
			<td class="nopad" colspan="100%"><h5><!DIC:filter!></h5></td>
		</tr>
		<tr>
			<td class="nopad"><!SEC:data!></td>
			<td rowspan="100%" style="vertical-align:bottom;"><!SEC:btn.ok!></td>
		</tr>
	</table>
</form>


<h5><!DIC:filtered!></h5>


# ***********************************************************
[data]
# ***********************************************************
<table>
<!VAR:items!>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!>  <!VAR:equal!>  </td>
	<td class="selData"><!VAR:data!></td>
</tr>
