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
		<div class="titBody"><!SEC:head!></div>
		<div class="modBody"><!SEC:body!></div>
	</div>
	<div class="modBord"><!SEC:bord!></div>
	<div class="modOpts"><!SEC:opts!></div>
</body>

# ***********************************************************
[opts] <!-- opts -->
<div class="tabicon">
<a href="?vmode=view">
	<img src="LOC_ICO/buttons/view.png" alt="View" />
</a>
</div>

<div class="tabicon" style="font-size: 1rem;">
<a href="?fsize=1">A</a>
</div>

<div class="tabicon" style="font-size: 1.25rem;">
<a href="?fsize=1.25">A</a>
</div>

<div class="tabicon" style="font-size: 1.5rem;">
<a href="?fsize=1.5">A</a>
</div>

<div class="tabicon" style="font-size: 1.75rem;">
<a href="?fsize=1.75">A</a>
</div>

<div class="tabicon" style="font-size: 2rem;">
<a href="?fsize=2">A</a>
</div>