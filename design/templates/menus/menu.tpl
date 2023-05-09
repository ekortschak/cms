
# ***********************************************************
[main]
# ***********************************************************
<div class="topMenu flexleft">
<!VAR:items!>
</div>

[item]
<div class="topItem">
	<div class="topText <!VAR:class!>"><!VAR:text!></div>
	<div class="topList"><!VAR:entry!></div>
</div>

[empty]
<div class="topItem">
	<div class="topText <!VAR:class!>"><a href="?pge=<!VAR:link!>"><!VAR:text!></a></div>
</div>

[entry]
	<a href="?pge=<!VAR:link!>"><!VAR:text!></a>
