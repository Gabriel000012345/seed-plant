<style>
	.img-responsive {
		border-radius: 50%;
		border: 1px solid #ebebeb;
		overflow: hidden;
	}
</style>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 product-col border">
	<div class="product-block radius-1x clearfix">
		<?php if( $blog['thumb'] && $cat_show_image )  { ?>
		<div class="image">
			<div class="product-img">
				<a class="img" title="ACTARA 25WG" href="<?php echo $blog['link'];?>">
					<img class="img-responsive" src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" alt="<?php echo $blog['title'];?>">
				</a>
			</div>
		</div>
		<?php } ?>

		<div class="product-meta">
			<h3><a href="<?php echo $blog['link'];?>"><?php echo $blog['title'];?></a></h3>
			<?php if( $cat_show_description ) { ?>
				<div><?php echo utf8_substr( $blog['description'],0, 180 );?></div>
			<?php } ?>
            <?php if( $cat_show_readmore ) { ?>
				<div class="action add-links clearfix">
				<div class="cart">
					<button data-loading-text="Loading..." class="btn-action radius-5" type="button" onclick="window.location('<?php echo $blog['link'];?>')">
						<span><?php echo $objlang->get('text_readmore'); ?></span>
						<i class="fa fa-external-link"></i>
					</button>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>


