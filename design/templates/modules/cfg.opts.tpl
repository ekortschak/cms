[include]
LOC_TPL/modules/user.opts.tpl


# ***********************************************************
[nav]
# ***********************************************************
<div>
<div class="dropdown">
	<img class="flag" src="LOC_ICO/flags/CUR_LANG.gif" alt="CUR_LANG" />
	<div class="dropbody" style="min-width: 5rem; padding: 1px 4px 2px;">
		<!VAR:langs!>
	</div>
</div>
&nbsp;

<!BTN:reset!>
<!BTN:home!>
<!SEC:config!>

</div>

# ***********************************************************
[view]
# ***********************************************************
<div class="h4"><!DIC:view!></div>
<div>
<!BTN:view!>
</div>

# ***********************************************************
[edit]
# ***********************************************************
<div class="h4"><!DIC:edit!></div>
<div>
<!SEC:medit!> <br>
<!SEC:pedit!> <!SEC:xlate!>
</div>

# ***********************************************************
# hide options
# ***********************************************************
[admin]
[print]
