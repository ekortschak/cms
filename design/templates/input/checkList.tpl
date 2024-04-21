
# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?" enctype="multipart/form-data">
<!SEC:oid!>

<div width="100%">
	<!VAR:items!>

	<div class="rf" align="right">
		<input type="reset" value="Reset" />
		<input type="submit" name="act" value="OK" />
	</div>
</div>

</form>

# ***********************************************************
[section]
# ***********************************************************
<h5><!VAR:text!></h5>

# ***********************************************************
[item]
# ***********************************************************
<div>
<input type="hidden"   name="<!VAR:fname!>" value=0 />
<input type="checkbox" name="<!VAR:fname!>" value=1 <!VAR:checked!> />
<!VAR:text!>
</div>

# ***********************************************************
[empty]
# ***********************************************************
