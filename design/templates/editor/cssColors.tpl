[include]
LOC_CFG/css.colors.def

[dic]
on = on

[dic.de]
on = auf

[main]
<form method="post" action="?">
<!SEC:oid!>

	<table>
<!VAR:items!>
		<tr height=10px></tr>
		<tr>
			<td colspan="100%" align="right">
				<input type="submit" name="colEdit" value="OK" />
			</td>
		</tr>
	</table>
</form>

# ***********************************************************
[section]
# ***********************************************************
<tr style="height: 12px;"></tr>
<tr class="selSection">
	<td colspan="100%"><!VAR:title!><hr></td>
</tr>

# ***********************************************************
[item]
# ***********************************************************
<tr>
	<td width=100><!VAR:set!></td>
	<td><input type="text" name="<!VAR:FCN!>" value="<!VAR:FCV!>" size=15></td>
	<td style="color:<!VAR:FCV!>; background-color:<!VAR:BCV!>; border-radius: BR_IMG;" align="center">
		Sample
	</td>
	<td>
		<input type="text" name="<!VAR:BCN!>" value="<!VAR:BCV!>" size=15 />
	</td>
</tr>

