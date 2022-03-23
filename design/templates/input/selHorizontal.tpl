[include]
design/templates/input/selector.tpl


# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
	<!SEC:hidden!>
	<!FRM:body!>
	<!SEC:button!>
</form>


# ***********************************************************
[rows]
# ***********************************************************
<div style="display: inline-block;">
	<font size=1><!SEL:head!> &nbsp;</font><br>
	<!SEL:input!> &nbsp;
</div>

# ***********************************************************
[button]
# ***********************************************************
<div style="display: inline-block;">
	<font size=1>&nbsp;</font><br>
	<input type="submit" name="act" value="OK" />
</div>
