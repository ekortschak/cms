[include]
LOC_LAY/LAYOUT/main.tpl

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<div class="modPage"><!SEC:page!></div>


# ***********************************************************
[page] <!-- body.search -->
# ***********************************************************
<div class="sticky">
<div class="joker"><!SEC:joker!></div>
<div class="screen">
	<!MOD:toc/topics!>
	<!MOD:toc/current!>
</div>
</div>

<div id="scView">
	<!MOD:toc!>
</div>
