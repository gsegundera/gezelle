<?php
  $page_title = 'Monthly Orders';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
 $year = date('Y');
 $sales = dailyOrders();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Monthly Orders</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
			    <th class="text-center" style="width: 10%;">SKU</th>
                <th class="text-center" style="width: 10%;">PO</th>
               
				<th class="text-center" style="width: 10%;">Date</th>
				 <th class="text-center" style="width: 5%;">Ordered QTY</th>
               
                <th class="text-center" style="width: 10%;"> Shipped Date</th>
                <th class="text-center" style="width: 10%;"> Shipped QTY </th>
                <th class="text-center" style="width: 10%;"> Status</th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               
               <td><?php echo remove_junk($sale['ORDLINE_PRODID']); ?></td>
			   <td class="text-center"><?php echo remove_junk($sale['ORDLINE_ORDHDRID']); ?></td>
			   <td class="text-center"><?php echo remove_junk($sale['ORDLINE_ORDERDATE']); ?></td>
               <td class="text-center"><?php echo (int)$sale['ORDLINE_ACCEPTED_QTY']; ?></td>
               <td class="text-center"><?php echo remove_junk($sale['ORDLINE_SHIPDATE']); ?></td>
			     <td class="text-center"><?php echo remove_junk($sale['ORDLINE_SHIPQTY']); ?></td>
				 <td class="text-center"><?php echo remove_junk($sale['ORDLINE_STATUS']); ?></td>
               
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
