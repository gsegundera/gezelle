<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = product_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product_mgl.php" class="btn btn-primary">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="product_table">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                
                <th class="text-center" style="width: 10%;"> SKU </th>
                <th class="text-center" style="width: 10%;"> Quantity  </th>
                <th > Description</th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                
               
                <td class="text-center"> <?php echo remove_junk($product['prod_sku']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['prod_qty']); ?></td>
                <td > <?php echo remove_junk($product['prod_description']); ?></td>
                
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_products.php?id=<?php echo(int)$product['prod_sku'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                   
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
    <script> 
  $(document).ready( function () {
   var table = $('#product_table').DataTable({			
			
			 stateSave: true,
			 //responsive:true,			  
			 "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
});
});
</script>
  <?php include_once('layouts/footer.php'); ?>
