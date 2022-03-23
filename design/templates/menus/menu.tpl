
# ***********************************************************
[main]
# ***********************************************************
<div class="topmenu">
<!VAR:items!>
</div>

[item]
<div class="topmenu-item">
	<div class="topmenu-button <!VAR:class!>">
		<a href="?pge=<!VAR:link!>"><!VAR:text!></a>
	</div>
	<div class="topmenu-content">
<!VAR:entry!>
	</div>
</div>

[empty]
<div class="topmenu-item">
	<div class="topmenu-button <!VAR:class!>">
		<a href="?pge=<!VAR:link!>"><!VAR:text!></a>
	</div>
</div>

[entry]
	<a href="?pge=<!VAR:link!>"><!VAR:text!></a>
