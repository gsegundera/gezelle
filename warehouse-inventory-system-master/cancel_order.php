<?php
  $page_title = 'Cancel Order';
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
	
	$update_status = cancel_order((string)$_GET['po'],(string)$_GET['id']);
  if($update_status){
   //  $session->msg("s","Order cancelled.");
      redirect('orderline.php');
  } else {
      $session->msg("d","Order was not cancelled.");
      redirect('orderline.php');
  }
?>
