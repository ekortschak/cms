[vars]
wid = THUMB_WID
hgt = THUMB_HGT

# ***********************************************************
[main]
# ***********************************************************
<section>
<!M:pic!>
<!SEC:head!>
<!SEC:text!>
</section>

[pic]
<img class='rgt' src='<!VAR:pic!>' align='right' width=<!VAR:wid!> style='margin: 0px 0px 5px 10px;' />

[head]
<h<!VAR:level!>><!VAR:head!></h<!VAR:level!>>

[text]
<!VAR:text!>
