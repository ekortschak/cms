[dic]
nodata = No filter specified!
mandatory = marks mandatory field
hint = Info

[dic.de]
nodata = Keine Daten vorhanden!
mandatory = markiert Pflichtfelder
hint = Hinweis


[vars]
cols = 69

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" enctype="multipart/form-data">
	<input type="hidden" name="oid" value="<!VAR:oid!>" />

	<div class="flex flexbottom">
		<div><!SEC:data!></div>
		<div><!SEC:btn.ok!></div>
	</div>
</form>

[data]
<table>
<!VAR:items!>
</table>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!></td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
[line]
# ***********************************************************
<tr>
	<td colspan="100%" class="selSection">
		<!VAR:head!>
	</td>
</tr>

# ***********************************************************
[span]
# ***********************************************************
<tr>
	<td colspan="100%" style="padding: 0px 7px;">
		<!VAR:head!>
	</td>
</tr>

# ***********************************************************
[hidden]
# ***********************************************************
<!VAR:data!>

# ***********************************************************
[NoData]
# ***********************************************************
<h5><!DIC:hint!></h5>
<p><!DIC:nodata!></p>

# ***********************************************************
[btn.ok]
# ***********************************************************
<input type="submit" name="act" value="OK" />

[btn.reset]
#<input type="reset" value="Reset" /> &emsp;
