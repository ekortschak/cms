[include]
LOC_LAY/LAYOUT/main.tpl

[dic]
replicator = Site replicator

[dic.de]
replicator = Seiten übertragen


# ***********************************************************
[toc] <!-- toc.xfer -->
# ***********************************************************
<div class="container">
<h3><!DIC:replicator!></h3>
<!MOD:toc.xfer!>
</div>

# ***********************************************************
[body] <!-- body.xfer -->
# ***********************************************************
<div class="container">
<!MOD:body.xfer!>
</div>
