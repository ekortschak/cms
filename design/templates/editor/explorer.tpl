[include]
LOC_TPL/modules/fview.gallery.tpl

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
<!SEC:oid!>
<!SEC:addNode!>
<!SEC:perms!>
</form>

<h4><!DIC:head!></h4>
<!SEC:files!>

<form method="post" action="?" enctype="multipart/form-data">
<!SEC:oid!>
<!SEC:append!>
</form>
