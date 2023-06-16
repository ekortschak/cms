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
<div style="position: relative; height: 100%;">
<!MOD:banner!>

<div style="position: absolute; bottom: 0px; width: 100%;">
<!MOD:menu!>
</div>
</div>

# ***********************************************************
[toc]  <!-- toc -->
[mbar] <!-- middle bar -->
