<?php
function delete_group($name) {
	$db = get_database();

	$stmt = $db->prepare('SELECT id FROM groups WHERE name = ?');
	$stmt->execute(array($name));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($rows) == 0) {
		throw new GroupDoesNotExistException();
	}
	else {
		$group_id = $rows[0]['id'];

		$stmt = $db->prepare('DELETE FROM groups WHERE id = ?');
		$stmt->execute(array($group_id));

		$stmt = $db->prepare('UPDATE people SET group_id = NULL' .
		                     'WHERE group_id = ?');
		$stmt->execute(array($group_id));
	}
}
?>