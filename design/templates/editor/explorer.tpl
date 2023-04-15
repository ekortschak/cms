[include]
LOC_TPL/modules/fview.gallery.tpl

# ***********************************************************
[main]
# ***********************************************************
<form method="post" action="?">
	<input type="hidden" name="opt_act" value="upload" />
<!SEC:addNode!>
<!SEC:perms!>
</form>

<h4><!DIC:head!></h4>
<!SEC:files!>

<form method="post" action="?" enctype="multipart/form-data">
<!SEC:append!>
</form>
