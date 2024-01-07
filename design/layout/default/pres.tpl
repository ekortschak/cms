[include]
LOC_LAY/default/main.tpl


[styles]
<link rel="StyleSheet" href="CSS_URL?layout=LAYOUT" type="text/css" />
<link rel="StyleSheet" href="LOC_CSS/other/present.css" type="text/css" />
<!MOD:zzz.styles!>

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" ><!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="colMain">
		<div class="titBody"><!SEC:head!></div>
		<div class="modPres"><!SEC:body!></div>
	</div>
</body>
