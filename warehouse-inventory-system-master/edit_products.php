<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_productsku('product2',(string)$_GET['id']);
//$all_categories = find_all('categories');
//$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product sku." . $_GET['id']);
  redirect('product2.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-desc','product-quantity', 'status' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-desc']));
    //   $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     //  $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
      if(empty($p_buy )) {
		  $p_buy =0;
	  }
       $query   = "UPDATE product2 SET";
       $query  .=" prod_description ='{$p_name}', prod_qty ='{$p_qty}',";
       $query  .=" prod_price ='{$p_buy}'";
       $query  .=" WHERE prod_sku ='{$product['PROD_SKU']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('product2.php', false);
               } else {
                 $session->msg('d',' Sorry failed to update!');
                 redirect('edit_products.php?id='.$product['PROD_SKU'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_products.php?id='.$product['PROD_SKU'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_products.php?id=<?php echo $product['PROD_SKU'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-desc" value="<?php echo remove_junk($product['PROD_DESCRIPTION']);?>">
               </div>
           

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['PROD_QTY']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Price</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-usd"></i>
                      </span>
                      <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['PROD_PRICE']);?>">
                      <span class="input-group-addon"></span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Status</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-usd"></i>
                       </span>
                       <input type="text" class="form-control" name="status" value="<?php echo remove_junk($product['PROD_STATUS']);?>">
                       <span class="input-group-addon"></span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
