<?php $ckey = time().rand(); ?>
<style type="text/css">
    .no-border-bottom {
        margin-bottom: 0px !important;
    }
    .accordion-group .accordion-heading {
        position: absolute; top: 20px; left: 25px; width: 90%;
    }
    .small-arrow .accordion-heading {
        position: absolute; left: -15px; top: 6px;

    }
    .accordion-heading .bg .fa {
        cursor: pointer;
        width: 100%;
    }
</style>
<div class="space-40 box box-category panel-default hightlight">
    <div class="panel-heading">
      <h3 class="panel-title"><span><?php echo $heading_title?></span></h3>
  </div>
    <div class="box-body">
      <div class="tree-menu">
        <?php echo $categories ?>
      </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('.collapse').on('show.bs.collapse', function (e) {
            e.stopPropagation();
            console.log('1111 : ' + $(this).attr('id'));
            $('span[data-target=#'+$(this).attr('id')+']').html("<i class='fa fa-angle-down'></i>");
        });

        $('.collapse').on('hide.bs.collapse', function (e) {
            e.stopPropagation();
            console.log('2222 : ' + $(this).attr('id'));
            $('span[data-target=#'+$(this).attr('id')+']').html("<i class='fa fa-angle-right'></i>");
        });
    });
</script>

