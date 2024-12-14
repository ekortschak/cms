[include]
LOC_LAY/LAYOUT/main.tpl

[dic]
replicator = Site replicator
whatsup = Transfer content

[dic.de]
replicator = Replikator
whatsup = Inhalte übertragen


# ***********************************************************
[toc] <!-- toc.xfer -->
# ***********************************************************
<div class="h3"><!DIC:replicator!></div>
<!MOD:toc/topics!>
<!MOD:toc/current!>
<!MOD:toc/xfer!>

# ***********************************************************
# overruled sections
# ***********************************************************
[body] <!-- body.xfer -->
<!MOD:xfer!>

[head]
<div class="h3"><!DIC:whatsup!></div>
