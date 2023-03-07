[include]
LOC_TPL/msgs/sitemap.tpl

[vars]
head = Description

[main]
<!SEC:pic!>
<!SEC:text!>

[pic]
<div class="collection" style="background-image: url('<!VAR:pic!>');">
<img src="LOC_ICO/1x1.gif" width="100%" />
</div>

<p><small>(CR) Unknown</small></p>

[text]
<div>
<h3><!VAR:head!></h3>
<!VAR:text!>
</div>
