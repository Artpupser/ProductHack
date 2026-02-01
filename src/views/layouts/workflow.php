<?php

include_once './views/layouts/head.php' ?>

<body>
	<?php include_once './views/layouts/header.php' ?>
	{{ content }}
	<div class="notifications_container"> <?php if (isset($clientErrors)) { 
		foreach ($clientErrors as $error) 
		{ echo '<div class="notification error">' . htmlspecialchars($error) . 
		'</div>'; } } ?> </div>
	<?php include_once './views/layouts/footer.php' ?>
	<script src="/api/public/file/?name=js/notifications.js"></script>

</body>
