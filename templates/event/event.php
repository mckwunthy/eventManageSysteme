<div class="event">
	<div class="img">
		<img src="<?php $event->getImgUrl() ?>" class="event-img-top" alt="illust">
	</div>
	<div class="event-body">
		<h5 class="event-title"><?php $event->getTitle() ?></h5>
		<p class="event-resume"><?php $event->getDescription() ?></p>
		<p class="event-author fw-bold">Promoter :
			<?php $event->getPromotedBy()->getFullname() ?>
		</p>
		<p class="event-created_at"><?php $event->getDatetime() ?></p>
		<div class="action_todo d-flex justify-content-center gap-1">
			<a href="/single_event/<?php $event->getSlug() ?>" class="btn btn-primary flex-grow-1">More...</a>
			<a href="/participate/<?php $event->getSlug() ?>" class="btn btn-primary flex-grow-1">Take part</a>
		</div>
	</div>
</div>