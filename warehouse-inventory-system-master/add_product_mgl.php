<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-desc','product-sku','product-quantity' ,'product-moq', 'price', 'product-supplier');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-desc']));
     $p_sku   = remove_junk($db->escape($_POST['product-sku']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
	 $p_moq   = remove_junk($db->escape($_POST['product-moq']));
     $p_price   = remove_junk($db->escape($_POST['price']));
     $p_supplier  = remove_junk($db->escape($_POST['product-supplier']));
     
     $date    = make_date();
     $query  = "INSERT INTO product2(";
     $query .=" PROD_SKU,PROD_PRICE,PROD_QTY,PROD_DESCRIPTION, PROD_MANUFACTURER, PROD_STATUS, PROD_MOQ";
     $query .=") VALUES (";
     $query .=" '{$p_sku}', '{$p_price}', '{$p_qty}', '{$p_name}', '{$p_supplier}', 'Y', '{$p_moq}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE PROD_DESCRIPTION='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Product added ");
       redirect('add_product_mgl.php', false);
     } else {
       $session->msg('d',' Sorry failed to add!');
       redirect('product2.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product_mgl.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product_mgl.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-desc" placeholder="Product Description">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                     
                     
                     <input type="text" class="form-control" name="product-sku" placeholder="SKU">
                  </div>
                  
                  <div class="col-md-6">
                   
                     
                     <input type="text" class="form-control" name="product-supplier" placeholder="Supplier">
                 
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                  </div>
				  </div>
				   <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-moq" placeholder="Product MOQ">
                  </div>
                 </div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="number" class="form-control" name="price" placeholder="Price">
                    
                  </div>
                 </div>
                 
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
