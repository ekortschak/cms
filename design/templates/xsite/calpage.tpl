[include]
LOC_TPL/xsite/main.tpl

[vars]
wid = 75

# ***********************************************************
[main]
# ***********************************************************
<section style="clear: both; margin-bottom: <!VAR:mrg!>px;">
<div class="flex">

<div>
<!SEC:qrcode!>
<!SEC:head!>
<!SEC:text!>
</div>

<div style="margin-left: 25px;">
<!VAR:month!>
</div>

</div>
</section><dolf>

[qrcode]
<img src="<!VAR:qr!>", align="right" width=<!VAR:wid!> style="margin: 0px 0px 5px 10px;" />
