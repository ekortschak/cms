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

[trailer] <!-- trailer -->
<!MOD:app.status!>

# ***********************************************************
# vertical panels
# ***********************************************************
[tabs] <!-- tabs -->
<div class="container" style="padding: 7px 0px;">
<!MOD:tabs!>
</div>

# ***********************************************************
[toc] <!-- toc -->
[mbar] <!-- middle bar -->

# ***********************************************************
[body] <!-- body -->
<div class="hedBody">
<!MOD:body.head!>
</div>

<div class="container" id="scView">
<!MOD:body.feedback!>
<!MOD:body!>
</div>

# ***********************************************************
[opts] <!-- opts -->
<div class="container conOpts">
<!MOD:app.info!>
<!MOD:user.opts!>
<!MOD:user.tags!>
<!MOD:msgs!>
<!MOD:debug.timer!>
</div>
