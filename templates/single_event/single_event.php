<?php
session_start();
if (isset($message)) {
    if (stristr($message, "echec")) {
        echo '
		<div class="d-grid gap-2">
        <button class="btn btn-danger" type="button">
        ' . $message . '
        </button>
		</div>';
    } else {
        echo '
		<div class="d-grid gap-2">
        <button class="btn btn-success" type="button">
        ' . $message . '
        </button>
		</div>';
    }
}

$content = '
<div class="single_event">
    <div class="img" style="background-image: url(' . $events->getImgUrl() . ')">

    </div>
    <div class="infos">
        <h4 class="title">' . $events->getTitle() . '</h4>
        <p class="created_at">' . $events->getDatetime() . '</p>
        <p class="promotedBy">' . $events->getPromotedBy()->getFullname() . '</p>
        <p class="description">' . $events->getDescription() . '</p>
    </div>
</div>';

//require base.php file
require_once(dirname(__DIR__) . "/base.php");
