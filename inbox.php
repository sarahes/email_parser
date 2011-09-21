<!doctype html>
<head>
  <meta charset="utf-8">
  <title>Inbox</title>
  <link rel="stylesheet" href="css/style.css">
  
</head>

<body>

<?php require_once('inbox.class.php'); ?>

<h1 class="c">Inbox</h1>

<?php	
	$getInbox = new inbox(getcwd().'\rawemails');	
	
	echo '<div id="inbox">';
	if(!empty($getInbox->fileNames)){	
		echo '<ol class="nobullet">';
		for($i = 0; $i < sizeof($getInbox->fileNames); $i++)
		{				
			echo '<li><a id="email'.$i.'" href="email.php?filename='.urlencode($getInbox->fileNames[$i]).'" />'.$getInbox->fileNames[$i].'</a></li>';			
		}
		echo '</ol>';
	}
	else{
		echo '<p>You do not have any e-mails. :(</p>';
	}	
	echo '</div>';
?>

</body>
</html>