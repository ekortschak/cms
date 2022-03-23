[include]
design/layout/LAYOUT/main.tpl

[dic]
replicator = Site replicator

[dic.de]
replicator = Seiten kopieren


# ***********************************************************
[toc] <!-- toc -->
# ***********************************************************
<div class="container">
<h3><!DIC:replicator!></h3>
<!MOD:toc.topics!>
<!MOD:toc.xform!>
</div>

# ***********************************************************
[body] <!-- body -->
# ***********************************************************
<div class="container">
<!MOD:msgs!>
<!MOD:body.xform!>
</div>
