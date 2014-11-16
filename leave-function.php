<?php
class NotGroupMemberException extends Exception {}

function leave_group($phone_number) {
	if (match_exists('SELECT number FROM people' .
	                 'WHERE number = ? AND group_id IS NOT NULL',
	                 array($number)) ) {
		$db = get_database();
		$stmt = $db->prepare('UPDATE people SET group_id = NULL WHERE number = ?');
		$stmt->execute(array($number));
	}
	else {
		throw new NotGroupMemberException();
	}
}
?>