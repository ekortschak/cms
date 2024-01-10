[include]
LOC_LAY/LAYOUT/main.tpl


# ***********************************************************
[layout] <!-- layout pres -->
# ***********************************************************
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" ><!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="colMain">
		<div class="modBody"><!SEC:body!></div>
	</div>
</body>

[toc]
<!MOD:toc/search!>


# ***********************************************************
[body] <!-- body.search -->
# ***********************************************************
<div id="scView">
<!MOD:body/search!>
</div>
