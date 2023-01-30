[include]
LOC_CFG/css.colors.def

[dic]
on = on

[dic.de]
on = auf

[main]
<form method="post" action="?">
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
	<td colspan="100%"><!VAR:title!><hr class="low"></td>
</tr>

# ***********************************************************
[item]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:set!></td>
	<td class="selData">
		<input type="text" name="<!VAR:FCN!>" value="<!VAR:FCV!>" size=15 /> &nbsp;
	</td>
	<td width=20 class="selHead" style="color:<!VAR:FCN!>; background-color:<!VAR:BCN!>; border-radius: 7px;">
		Xyz
	</td>
	<td class="selData"> &nbsp;
		<input type="text" name="<!VAR:BCN!>" value="<!VAR:BCV!>" size=15 />
	</td>
</tr>

