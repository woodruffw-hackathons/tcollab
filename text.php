<?xml version="1.0" encoding="UTF-8"?>
<Response>
	<?php
	$db = new PDO('mysql:host=localhost;dbname=wuday;charset=utf8', 'wuday', 'password');
	if (substr($_POST['Body'], 0, 6)  == '+join ') {
		$stmt = $db->prepare('SELECT id FROM people WHERE number=? AND group_id IS NOT NULL');
		$stmt->execute(array($_POST['From']));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) == 0) {
			$group_name = trim(substr($_POST['Body'], 6));
			$stmt = $db->prepare('SELECT id FROM groups WHERE name=?');
			$stmt->execute(array($group_name));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (count($rows) == 0) {
				?><Message>That group doesn't exist. Text "+create [groupname]" to create it.</Message><?php
			}
			else {
				$group_id = $rows[0]['id'];
				$stmt = $db->prepare('SELECT id FROM people WHERE number=? AND group_id IS NULL');
				$stmt->execute(array($_POST['From']));
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if (count($rows) == 0) {
					$stmt = $db->prepare('INSERT INTO people(number, group_id) VALUES(:number, :group_id)');
					$stmt->execute(array(':number' => $_POST['From'], ':group_id' => $group_id));

					$client = new Services_Twilio($sid, $token);
					$response = $client->account->outgoing_caller_ids->create($number, array('CallDelay' => 20));
					?><Message>
					Joined group! You're about to recieve a call to verify your phone number. When prompted, enter this code:
					<?php echo $response->validationCode; ?>
					</Message><?php
				}
				else {
					$stmt = $db->prepare('UPDATE people SET group_id=? WHERE number=?');
					$stmt->execute(array($group_id, $_POST['From']));
					?><Message>Group joined.</Message><?php
				}
			}
		}
		else {
			?><Message>You're already in a group! Text "+leave" to leave your current group</Message><?php
		}
	}
	else if (substr($_POST['Body'], 0, 8) == '+create ') {
		$group_name = trim(substr($_POST['Body'], 8));
		$stmt = $db->prepare('SELECT id FROM groups WHERE name=?');
		$stmt->execute(array($group_name));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) == 0) {
			$stmt = $db->prepare('INSERT INTO groups(name) VALUES(:name)');
			$stmt->execute(array(':name' => $group_name));
			?><Message>Group created.</Message><?php
		}
		else {
			?><Message>That group name is unavailable. Sorry!</Message><?php
		}
	}
	else if (substr($_POST['Body'], 0, 7) == '+leave') {
		$stmt = $db->prepare('UPDATE people SET group_id=NULL WHERE number=?');
		$stmt->execute(array($_POST['From']));
		?><Message>Left group.</Message><?php
	}
	else if (substr($_POST['Body'], 0, 8) == '+delete ') {
		$group_name = trim(substr($_POST['Body'], 8));
		$stmt = $db->prepare('SELECT id FROM groups WHERE name=?');
		$stmt->execute(array($group_name));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) == 0) {
			?><Message>That group does not exist.</Message><?php
		}
		else {
			$group_id = $rows[0]['id'];
			$stmt = $db->prepare('DELETE FROM groups WHERE id=?');
			$stmt->execute(array($group_id));
			
			$stmt = $db->prepare('UPDATE people SET group_id=NULL WHERE group_id=?');
			$stmt->execute(array($group_id));
			?><Message>Group deleted.</Message><?php
		}
	}
	else {
		$stmt = $db->prepare('SELECT group_id FROM people WHERE number=?');
		$stmt->execute(array($_POST['From']));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($rows) == 0) { ?>
			<Message>
				You're not a member of a group! Text "+join [groupname]" to join a group, or "+create [groupname]" to create one.
			</Message><?php
		}
		else {
			$group_id = $rows[0]['group_id'];
			$stmt = $db->prepare('SELECT number FROM people WHERE group_id=?');
			$stmt->execute(array($group_id));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($rows as $row) { ?>
				<Message to="<?php echo $row['number'] ?>">
					<?php echo $_POST['Body'] ?>
				</Message>
			<?php }
		}
	}
	?>
</Response>
