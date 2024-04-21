[vars]
links = Missing links ...

# ***********************************************************
[main]
# ***********************************************************
<div class="flex">

<div>
<!VAR:text!>
</div>

<div style="margin-left: 25px;">
<!VAR:month!><br>
<!SEC:links!>
</div>

</div>

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
