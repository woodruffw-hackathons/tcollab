<?php
function get_twilio_client() {
	require_once('twilio-php-master/Services/Twilio.php');
	$sid = 'AC735a473a1e737c406e02b3fce386b9a3';
	$token = '23ee6ae5e580e9190d66a414901d3f4f';
	return new Services_Twilio($sid, $token);
}

function match_exists($query, $parameters) {
	$db = get_database();
	$stmt = $db->prepare('SELECT EXISTS( ' . $query . ' ) AS result');
	$stmt->execute($parameters);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows[0]['result'];
}

class GroupDoesNotExistException extends Exception {}
class AlreadyGroupMemberExcpetion extends Exception {}

function join_group($group_name, $phone_number) {
	if (match_exists('SELECT id FROM people' .
	                 'WHERE number = ? AND group_id IS NOT NULL',
	                 array($number))) {
		
		$db = get_database();
		$stmt = $db->prepare('SELECT id FROM groups WHERE name = ?');
		$stmt->execute(array($group_name));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if (count($rows) == 0) {
			throw new GroupDoesNotExistException();
		}
		else {
			$group_id = $rows[0]['id'];
			
			if (match_exists('SELECT id FROM people' .
			                 'WHERE number = ? AND group_id IS NULL',
			                 array($number))) {
				
				$stmt = $db->prepare('INSERT INTO people(number, group_id)' .
				                     'VALUES(:number, :group_id)');
				$stmt->execute(array(':number' => $number,
				                     ':group_id' => $group_id));
				
				$client = get_twilio_client();
				$response = $client
					->account
					->outgoing_caller_ids
					->create($number, array('CallDelay' => 10));
				
				return $response->validationCode;
			}
			else {
				$stmt = $db->prepare('UPDATE people SET group_id = ?' .
				                     'WHERE number=?');
				$stmt->execute(array($group_id, $number));
			}
		}
	}
	else {
		throw new AlreadyGroupMemberException();
	}
}
?>