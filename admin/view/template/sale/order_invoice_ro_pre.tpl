<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> Factura</h3>
      </div>
      <div class="panel-body">
        <div class="row">
        <div class="col-md-4">
          <div class="pull-right">
            <button type="submit" form="form-rofactura" data-toggle="tooltip" title="Salveaza" class="btn btn-primary"><i class="fa fa-save"></i></button>
          </div>
          <div class="well">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-rofactura">
          <table class="table table-hover table-stripped">
          <tr>
            <td> ID/Numar Factura </td>
            <td>
              <?php if (!$invoice_auto_number) { ?>
                <input class="form-control" type="text" name="invoice_id" value="<?php echo $invoice_id; ?>" />
              <?php } else { ?>
                <input class="form-control" type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
                <?php echo $invoice_id; ?>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td> Data pe Factura </td>
            <td><input class="form-control date" type="text" name="data" value="<?php echo $data; ?>" /></td>
          </tr>
          <tr>
            <td> Anulare Factura </td>
            <td>
              <select name="void" class="form-control">
                <option value="0" <?php if (!$void) { ?>selected="selected"<?php } ?>>Nu</option>
                <option value="1" <?php if ($void) { ?>selected="selected"<?php } ?>>Da</option>
              </select>
            </td>
          </tr>
          <tr>
            <td> Prescrie datele cumparatorului </td>
            <td><textarea class="form-control" type="text" name="cumparator"><?php echo $cumparator; ?></textarea></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 1) </td>
            <td><input class="form-control" type="text" name="pb1" value="<?php echo $pb1; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 2) </td>
            <td><input class="form-control" type="text" name="pb2" value="<?php echo $pb2; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 3) </td>
            <td><input class="form-control" type="text" name="pb3" value="<?php echo $pb3; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 4) </td>
            <td><input class="form-control" type="text" name="pb4" value="<?php echo $pb4; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 5) </td>
            <td><input class="form-control" type="text" name="pb5" value="<?php echo $pb5; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 6) </td>
            <td><input class="form-control" type="text" name="pb6" value="<?php echo $pb6; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 7) </td>
            <td><input class="form-control" type="text" name="pb7" value="<?php echo $pb7; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 8) </td>
            <td><input class="form-control" type="text" name="pb8" value="<?php echo $pb8; ?>" /></td>
          </tr>
          <tr>
            <td> Page Break dupa X produse (Pagina 9) </td>
            <td><input class="form-control" type="text" name="pb9" value="<?php echo $pb9; ?>" /></td>
          </tr>
          </table>
          </form>
          </div>
        </div>
        <div class="col-md-8">
          <div class="pull-right"><a onclick="printFrame();" class="btn btn-default">Print</a> <a href="<?php echo $roinvoiceurl; ?>" class="btn btn-primary">Fullscreen</a> <a href="<?php echo $roinvoiceurldld ; ?>" class="btn btn-success">Descarca PDF</a></div>
          <iframe id="facturaHTML" name="facturaHTML" style="border: none;" width="100%" height="700" src="<?php echo $roinvoiceurl; ?>"></iframe>
        </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
$('.date').datetimepicker({
        pickTime: false
      });
function printFrame() {
  var newWin = window.frames["facturaHTML"];
newWin.print();
newWin.document.close();
}
</script>
<?php echo $footer; ?>