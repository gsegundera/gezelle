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
	
	$update_status = backorder((string)$_GET['po'],(string)$_GET['id']);
	$backorder_status = backorder_count((string)$_GET['id'],(string)$_GET['qty']);
	$po_available = po_available_count((string)$_GET['id'],(string)$_GET['qty']);
  if(($update_status)){
   //  $session->msg("s","Back Ordered.");
      redirect('orderline.php');
  } else {
      $session->msg("d","Cannot back order the product.");
      redirect('orderline.php');
  }
?>
