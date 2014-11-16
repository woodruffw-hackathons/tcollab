<?php
class GroupNameInUseException extends Exception {}

function create_group($name) {
	if (match_exists('SELECT id FROM groups WHERE name=?', array(name))) {
		throw new GroupNameInUseException();
	}
	else {
		$db = get_database();
		$stmt = $db->prepare('INSERT INTO groups(name) VALUES(:name)');
		$stmt->execute(array(':name' => $group_name));
	}
}
?>