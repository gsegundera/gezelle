<?php
  $page_title = 'Accept or Cancel order';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product_sku = find_by_sku('order_line',(string)$_GET['id']);
$order_product = find_by_po('order_line',(string)$_GET['po']);
//$all_categories = find_all('categories');
//$all_photo = find_all('media');
if((!$order_product)&& (!$product_sku)){
  $session->msg("d","Missing product sku or PO Number.");
  redirect('orderline.php');
}
?>


<?php
	$update_count = update_product_count((int)$_GET['qty'],(string)$_GET['id']);
	$update_status = accept_order((string)$_GET['po'],(string)$_GET['id']);
  if($update_status){
    // $session->msg("s","Order added.");
     redirect('orderline.php');
  } else {
      $session->msg("d","Order was not added.");
      redirect('orderline.php');
  }
?>
