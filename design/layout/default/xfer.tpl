[include]
LOC_LAY/LAYOUT/main.tpl

[dic]
replicator = Site replicator

[dic.de]
replicator = Seiten übertragen

# ***********************************************************
[layout] <!-- layout -->
# ***********************************************************
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="modToc" ><!SEC:toc!> </div>
	<div class="modMbar"><!SEC:mbar!></div>
	<div class="colMain">
		<div class="joker"><!SEC:joker!></div>
		<div class="modBody"><!SEC:body!></div>
	</div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>


# ***********************************************************
[toc] <!-- toc.xfer -->
# ***********************************************************
<div class="h3"><!DIC:replicator!></div>
<!MOD:toc/topics!>
<!MOD:toc/current!>
<!MOD:toc/xfer!>

# ***********************************************************
[body] <!-- body.xfer -->
# ***********************************************************
<!MOD:body/xfer!>
