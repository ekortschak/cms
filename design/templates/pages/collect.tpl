[include]
LOC_TPL/msgs/sitemap.tpl

[vars]
head = Description

# ***********************************************************
[main]
# ***********************************************************
<!SEC:pic!>
<!SEC:text!>

[text]
<div>
#<h3><!VAR:head!></h3>
<!VAR:text!>
</div>

[pic]
<img class="max" src="<!VAR:pic!>" width="100%" oncontextmenu="return false;" />
<p><small>&copy; Unknown</small></p>

[thumb]
<img class="rgt" src="<!VAR:pic!>" width="THUMB_WID" oncontextmenu="return false;" />

