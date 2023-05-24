[include]
LOC_LAY/default/main.tpl

[vars]
height = 151

[layout] <!-- layout.divs -->
<body>
	<div class="modTabs"><!SEC:tabs!>  </div>
	<div class="modMenu"><!SEC:menu!>  </div>
	<div class="modBody"><!SEC:body!>  </div>
	<div class="modOpts"><!SEC:opts!>  </div>
</body>


# ***********************************************************
# horizontal panels
# ***********************************************************
[menu]
<div style="min-height: <!VAR:height!>px;">
<!MOD:app.banner!>
</div>
<!MOD:menu!>

# ***********************************************************
[toc] <!-- toc -->
[mbar] <!-- middle bar -->
