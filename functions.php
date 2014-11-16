<?php
function get_database() {
	return new PDO('mysql:host=localhost;dbname=wuday;charset=utf8',
	               'wuday',
	               'password');
}

function get_twilio_client() {
	require_once('twilio-php-master/Services/Twilio.php');
	$sid = 'AC735a473a1e737c406e02b3fce386b9a3';
	$token = '23ee6ae5e580e9190d66a414901d3f4f';
	return new Services_Twilio($sid, $token);
}

function match_exists($query, $parameters) {
	$db = get_database();
	$stmt = $db->prepare($query);
	$stmt->execute($parameters);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return count($rows) != 0;
}

class AlreadyGroupMemberException extends Exception {}
class GroupDoesNotExistException extends Exception {}
class GroupNameInUseException extends Exception {}
class NotGroupMemberException extends Exception {}

function create_group($name) {
	if (match_exists('SELECT id FROM groups WHERE name=?', array($name))) {
		throw new GroupNameInUseException();
	}
	else {
		$db = get_database();
		$stmt = $db->prepare('INSERT INTO groups(name) VALUES(:name)');
		$stmt->execute(array(':name' => $name));
	}
}

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

function join_group($group_name, $phone_number) {
	if (match_exists('SELECT id FROM people' .
	                 'WHERE number = ? AND group_id IS NOT NULL',
	                 array($phone_number))) {
		throw new AlreadyGroupMemberException();
	}
	else {
		$db = get_database();
		$stmt = $db->prepare('SELECT id FROM groups WHERE name = ?');
		$stmt->execute(array($group_name));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($rows) == 0) {
			throw new GroupDoesNotExistException();
		}
		else {
			$group_id = $rows[0]['id'];
			
			if (match_exists('SELECT number FROM people WHERE number = ?',
			                 array($phone_number))) {
				$stmt = $db->prepare('UPDATE people SET group_id = ?' .
				                     'WHERE number = ?');
				$stmt->execute(array($group_id, $phone_number));
			}
			else {
				$stmt = $db->prepare('INSERT INTO people(number, group_id)' .
				                     'VALUES(:number, :group_id)');
				$stmt->execute(array(':number' => $phone_number,
				                     ':group_id' => $group_id));
				
				$client = get_twilio_client();
				$response = $client
					->account
					->outgoing_caller_ids
					->create($phone_number, array('CallDelay' => 10));
				
				return $response->validationCode;
			}
		}
	}
}

function leave_group($phone_number) {
	if (match_exists('SELECT number FROM people' .
	                 'WHERE number = ? AND group_id IS NOT NULL',
	                 array($phone_number)) ) {
		$db = get_database();
		$stmt = $db->prepare('UPDATE people SET group_id = NULL WHERE number = ?');
		$stmt->execute(array($phone_number));
	}
	else {
		throw new NotGroupMemberException();
	}
}