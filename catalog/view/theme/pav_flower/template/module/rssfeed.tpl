<br/>
<div class="space-40 box box-category panel-default hightlight">
	<div class="panel-heading">
		<h3 class="panel-title"><span><?php echo $heading_title; ?></span></h3>
	</div>
	<div class="box-body">
		<div class="tree-menu">
			<div class="newsticddker-jcarousellite">
			<ul class="list-unstyled">
				<?php if ($news) { ?>
				<?php foreach ($news as $rss) { ?>
				<li class="panel no-border-bottom list-group-item accordion-group">
					<h4><b><?php echo $rss['title']; ?></b></h4>
					<p>
						<?php echo $rss['content']; ?>
						<a style="color: #81cd30;" href="<?php echo $rss['link']; ?>" target="_blank"><?php echo $text_more; ?></a>
					</p>
				</li>
				<?php } ?>
				<?php } ?>
			</ul>
			</div>
		</div>
	</div>
</div>
