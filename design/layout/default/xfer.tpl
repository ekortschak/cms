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
		<div style="height: 1rem;"></div>
		<div class="modBody"><!SEC:body!></div>
	</div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>


# ***********************************************************
[toc] <!-- toc.xfer -->
# ***********************************************************
<h3><!DIC:replicator!></h3>
<!MOD:toc/topics!>
<!MOD:toc/xfer!>

# ***********************************************************
[body] <!-- body.xfer -->
# ***********************************************************
<!MOD:body/xfer!>
