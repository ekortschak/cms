[include]
LOC_LAY/LAYOUT/main.tpl

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="colMain">
		<!SEC:body!>
	</div>
</body>

# ***********************************************************
[body] <!-- body.search -->
# ***********************************************************
<div class="joker"><!SEC:joker!></div>
<div class="titBody"><!MOD:toc/topics!></div>
<div class="titBody"><!MOD:toc/current!></div>

<div id="scView">
	<!MOD:toc!>
</div>
