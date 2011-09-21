<?php require_once('inbox.class.php'); ?>

<h1>Inbox</h1>

<?php
	
	$getEmail = new inbox(getcwd().'\rawemails');	

	if(!empty($getEmail->fileNames)){	
		echo '<ul class="nobullet">';
		foreach($getEmail->fileNames as $fileName){		
			echo '<li><a href="'.$fileName.'" />'.$fileName.'</a></li>';
		}
		echo '</ul>';
	}
	else{
		echo '<p>You do not have any e-mails.</p>';
	}		
	
	echo '<h2>'.htmlspecialchars($getEmail->subject).'</h2>';
		echo '<dl><dt><strong>From:</strong></dt><dd>'.htmlspecialchars($getEmail->from).'</dd>';
		echo '<dt><strong>To:</strong></dt><dd>'.htmlspecialchars($getEmail->to).'</dd>';
		echo '<dt><strong>Date:</strong></dt><dd>'.htmlspecialchars($getEmail->date).'</dd></dl>';
		
		echo $getEmail->message;
	
	
?>