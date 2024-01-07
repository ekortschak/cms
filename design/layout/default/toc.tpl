[include]
LOC_LAY/LAYOUT/main.tpl

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="colToc">
		<!SEC:body!>
	</div>
</body>

# ***********************************************************
[body] <!-- body.search -->
# ***********************************************************
<div class="joker">
	<!SEC:joker!>
</div>

<div style="padding: 3px 20px 0px;">
	<!MOD:toc.topics!>

	<div id="scView">
		<!MOD:toc!>
	</div>
</div>
