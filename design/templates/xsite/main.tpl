[vars]
wid = THUMB_WID
hgt = THUMB_HGT
mrg = 5

# ***********************************************************
[main]
# ***********************************************************
<section style="clear: both; margin-bottom: <!VAR:mrg!>px;">
<!SEC:pic!>
<!SEC:head!>
<!SEC:text!>
</section>

[pic]
#<img src="<!VAR:pic!>" class="rgt" align="right" width=<!VAR:wid!> height=<!VAR:hgt!> />
<img src='<!VAR:pic!>', align='right' width=198 style='margin: 0px 0px 5px 10px;' />

[head]
<h<!VAR:level!>><!VAR:head!></h<!VAR:level!>>

[text]
<!VAR:text!>

[pbr]
<hr class="pbr">'
