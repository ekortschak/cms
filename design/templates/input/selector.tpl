[dic]
mandatory = marks mandatory field
hint = Info
header = User input required

[dic.de]
mandatory = markiert Pflichtfelder
hint = Hinweis
header = Eingabe erforderlich


[vars]
cols = 69
header = <!DIC:header!>

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" enctype="multipart/form-data">
<!SEC:oid!>

<table width="100%">
	<!SEC:header!>
	<!SEC:data!>
	<!SEC:buttons!>
</table>

</form>

[data]
<tr>
<td class="nopad">
	<table><!VAR:items!></table>
</td>
</tr>

[header]

[header.x]
<tr class="rh"><th colspan="100%"><!VAR:header!></th></tr>

# ***********************************************************
[rows]
# ***********************************************************
<tr>
	<td class="selHead"><!VAR:head!></td>
	<td class="selData"><!VAR:data!></td>
</tr>

# ***********************************************************
[line] # separate sections in form
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
<p><!DIC:no.data!></p>

# ***********************************************************
[buttons]
# ***********************************************************
<tr class="rf" align="right">
	<td class="nopad" colspan="100%">
<!SEC:btn.reset!>
<!SEC:btn.ok!>
	</td>
</tr>


[btn.ok]
<input type="submit" name="act" value="OK" />

[btn.reset]
<input type="reset" value="Reset" />
