[include]
design/templates/msgs/sitemap.tpl

[vars]
head = Description

[main]
<!SEC:pic!>
<!SEC:text!>

[pic]
<div class="collection" style="background-image: url('<!VAR:pic!>');">
<img src="core/icons/1x1.gif" width="100%" />
</div>

<p><small>&copy; Unknown</small></p>

[text]
<div>
<h3><!VAR:head!></h3>
<!VAR:text!>
</div>
