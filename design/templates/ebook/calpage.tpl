[include]
LOC_TPL/ebook/main.tpl


# ***********************************************************
[main]
# ***********************************************************
<section>
<div class="flex">

<div>
<!SEC:text!>
</div>

<div style="margin-left: 25px;">
<!VAR:month!>
<!SEC:links!>
</div>

</div>
</section>

# ***********************************************************
[links]
# ***********************************************************
<div class="flex">
<!VAR:links!>
</div>

[link]
<div>
<a href="<!VAR:href!>"><!VAR:caption!></a>
<img src="<!VAR:qr!>" class="rgt">
</div>
