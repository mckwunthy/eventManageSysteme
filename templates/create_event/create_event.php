<?php
session_start();
if (isset($user)) {
	if (gettype($user) == "object") {
		if (sha1($pwdEnter) == $user->getPassword()) {
			$_SESSION["user"]["id"] = $user->getId();
			$_SESSION["user"]["email"] = $user->getEmail();
			$_SESSION["user"]["fullname"] = $user->getFullname();
			$_SESSION["user"]["sexe"] = $user->getSexe();
			$_SESSION["user"]["age"] = $user->getAge();
			$_SESSION["user"]["created_at"] = $user->getCreated_at();
		}
	}
}

if (!isset($_SESSION["user"])) {
	//pas de donnee de connexion -> redirection vers home
	header('Location: /');
	exit();
}
if (isset($requestData)) {
	if ($requestData["title"] == "AUCUN" || $requestData["description"] == "AUCUN") {
		echo '
		<div class="d-grid gap-2">
			<button class="btn btn-danger" type="button">
				donnees incorrects !
			</button>
		</div>';
	} else {
		echo '
		<div class="d-grid gap-2">
			<button class="btn btn-success" type="button">
				event saved with success !
			</button>
		</div>';
	}
}
$content = '
<h2>
	' . $name . '
</h2>
<div class="row">
	<div class="col-5 create_form">
		<form method="POST" action="create_event" enctype="multipart/form-data">
			<div class="mb-3">
				<label for="title" class="form-label">Title</label>
				<input type="text" class="form-control" id="title" name="title">
			</div>
			<div class="mb-3">
				<label for="description" class="form-label">Description</label>
				<input type="text" class="form-control" id="description" name="description">
			</div>
			<div class="mb-3">
				<label for="imgUrl" class="form-label">image url</label>
				<input type="text" class="form-control" id="igmUrl" name="imgUrl">
			</div>
			<input type="hidden" id="hidden" name="promotedBy" value="' . $_SESSION["user"]["id"] . '">
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	<div class="col-7 right-box"></div>
</div>';

//require base.php file
require_once(dirname(__DIR__) . "/base.php");
