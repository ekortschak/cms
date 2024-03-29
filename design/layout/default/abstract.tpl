[include]
LOC_LAY/LAYOUT/main.tpl

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" ><!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="colMain">
		<div class="joker"><!SEC:joker!></div>
		<div class="titBody"><!SEC:head!></div>
		<div class="modBody"><!SEC:body!></div>
	</div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>

# ***********************************************************
[toc] <!-- toc.abstract -->
# ***********************************************************
<!MOD:toc/banner!>
<!MOD:toc/topics!>
<!MOD:toc/current!>
<!MOD:toc/stats!>
<!MOD:toc/blocks!>
<!MOD:toc/status!>

[head] <!-- sticky info -->
<!MOD:body/head!>

 # ***********************************************************
[body] <!-- body.abstract -->
# ***********************************************************
<!MOD:body/abstract!>
