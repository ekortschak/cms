<?php

DBG::file(__FILE__);

// ***********************************************************
// check if applicable
// ***********************************************************
if (SEARCH_BOT) return;
if (VMODE == "joker") return;

if (! IS_LOCAL) return;
if (! CFG::mod("uopts.uinfo")) return;

// ***********************************************************
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

if (! defined("USR_GRPS")) define("USR_GRPS", "not set");

?>

<div class="h4">User-Info</div>

<small>
<table>
	<tr>
		<td>User</td>
		<td><?php echo CUR_USER; ?></td>
	</tr>
	<tr>
		<td>Groups</td>
		<td><?php echo USR_GRPS; ?></td>
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
