<!DOCTYPE html>
<html lang="en">
<?php

include_once './views/layouts/head.php' ?>

<body>
	<?php include_once './views/layouts/header.php' ?>
	{{ content }}
	<div class="notifications">
		<?php if (isset($clientErrors)) {
			$clientErrors->view();
		} ?>
	</div>
	<?php include_once './views/layouts/footer.php' ?>
</body>

</html>