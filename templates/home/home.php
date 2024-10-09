<?php
session_start();
$user_connected_id = isset($_SESSION["user"]) ? $_SESSION["user"]["id"] : 0;
// var_dump($user_connected_id);
// echo "<br><br><br><br>";
$content = '
<h3>' . $name . '
</h3>
<div class="row">';
// var_dump($events[0]);
// exit(1);
foreach ($events as $event) {
	$content .= '<div class="col">
					<div class="event">
						<div class="img">
							<img src="' . $event->getImgUrl() . '" class="event-img-top" alt="illust">
						</div>
						<div class="event-body">
    						<h5 class="event-title">' . $event->getTitle() . '</h5>
							<p class="event-author fw-bold">Promoter :
								' . $event->getPromotedBy()->getFullname() . '
							</p>
							<p class="event-created_at">' . $event->getDatetime() . '</p>
							<div class="action_todo d-flex justify-content-center gap-1">
								<a href="/single_event/' . $event->getSlug() . '" class="btn btn-primary flex-grow-1">More...</a>
								';
	// var_dump($event);
	// exit(1);
	$user_who_participate_table = $event->getEventParticipated()->getValues();
	$user_who_participate_id = [];
	foreach ($user_who_participate_table as $value) {
		$user_who_participate_id[] = $value->getId();
	}

	if (!in_array($user_connected_id, $user_who_participate_id)) {
		#si user n'est inscrit à cet evenement
		$content .= '<a href="/participate/' . $event->getSlug() . '/' . $user_connected_id . '" class="btn btn-primary flex-grow-1">Take part</a>';
	}
	$content .= '</div>
						</div>
					</div>
				</div>';
}
$content .= '</div>';

//require base.php file
require_once(dirname(__DIR__) . "/base.php");
