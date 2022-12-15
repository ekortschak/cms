
<?php

if (! IS_LOCAL) return;
if (! $cfg->get("uopts.uinfo")) return;

function getFS() {
	if (FS_ADMIN) return "admin";
	if (FS_LOGIN) return "user";
	return "none";
}

function getDB() {
	if (DB_ADMIN) return "admin";
	if (DB_LOGIN) return "user";
	return "no access";
}

?>

<h4>User-Info</h4>

<small>
<table>
	<tr>
		<td>User</td>
		<td><?php echo CUR_USER; ?></td>
	</tr>
	<tr>
		<td>Groups</td>
		<td><?php echo CFG::get("DB_GRPS", "-"); ?></td>
	</tr>
	<tr>
		<td>FS</td>
		<td><?php echo getFS(); ?></td>
	</tr>
	<tr>
		<td>DB</td>
		<td><?php echo getDB(); ?></td>
	</tr>
</table>
</small>
