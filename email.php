<!doctype html>
<head>
  <meta charset="ISO-8859-1">
  <title>Message</title>
  <link rel="stylesheet" href="css/style.css">
  
</head>

<body>

<?php require_once('email.class.php'); ?>


<div id="email">

<?php
    $getMessage = new email(urldecode($_GET['filename']));

    echo '<h1>'.htmlspecialchars($getMessage->subject).'</h1>';
    echo '<p><strong>From:</strong>'.htmlspecialchars($getMessage->from).'</p>';
    echo '<p><strong>To:</strong>'.htmlspecialchars($getMessage->to).'</p>';
    echo '<p><strong>Date:</strong>'.htmlspecialchars($getMessage->date).'</p>';		
    echo '<div class="message">'.$getMessage->message.'</div>';
        
?>
</div>
</body>
</html>