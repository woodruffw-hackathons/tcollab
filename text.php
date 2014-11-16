<?xml version="1.0" encoding="UTF-8"?>
<Response>
	<?php
	if (substr($_POST['Body'], 0, 6)  == '+join ') {
		$group_name = trim(substr($_POST['Body'], 6));
		try {
			$verification_code = join_group($group_name, $_POST['From'])
			if ($verification_code) { ?>
				<Message>
			    	Joined group! You're about to recieve a call to verify your
					phone number. When prompted, enter this code:
					<?php echo $verification_code; ?>
				</Message> <?php
			}
			else { ?>
				<Message>Group joined.</Message> <?php
			}
		}
		catch (GroupDoesNotExistException $e) { ?>
			<Message>
				That group doesn't exist. Text "+create [groupname]" to create
				it.
			</Message> <?php
		}
		catch (AlreadyGroupMemberException $e) { ?>
			<Message>
				You're already in a group! Text "+leave" to leave your current
				group.
			</Message> <?php
		}
	}
	else if (substr($_POST['Body'], 0, 8) == '+create ') {
		$group_name = trim(substr($_POST['Body'], 8));
		try {
			create_group($group_name);
			?><Message>Group created.</Message><?php
		}
		catch (GroupNameInUseException $e) {
			?><Message>That group name is unavailable. Sorry!</Message><?php
		}
	}
	else if (substr($_POST['Body'], 0, 7) == '+leave') {
		try {
			leave_group($_POST['From']);
			?><Message>Left group.</Message><?php
		}
		catch (NotGroupMemberException $e) {
			?><Message>You're not a member of any groups.</Message><?php
		}
	}
	else if (substr($_POST['Body'], 0, 8) == '+delete ') {
		$group_name = trim(substr($_POST['Body'], 8));
		try {
			delete_group($group_name);
			?><Message>Group deleted.</Message><?php
		}
		catch (GroupDoesNotExistException $e) {
			?><Message>That group does not exist.</Message><?php
		}
	}
	else {
		$db = get_database();
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
