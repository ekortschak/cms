[include]
LOC_LAY/default/main.tpl

[vars]
height = 151

[layout] <!-- layout.divs -->
<body>
	<div class="modTabs"><!SEC:tabs!></div>
	<div class="colMain">
		<div class="horMenu"><!SEC:menu!> </div>
		<div class="joker"  ><!SEC:joker!></div>
		<div class="modBody"><!SEC:body!> </div>
	</div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>


# ***********************************************************
# horizontal panels
# ***********************************************************
[menu]
<!MOD:menu!>

# ***********************************************************
[toc]  <!-- toc -->
[mbar] <!-- middle bar -->
