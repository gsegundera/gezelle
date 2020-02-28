<?php
  $page_title = 'Refresh order';
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
$status = (string)$_GET['status'];
if($status == "A") {

	$revert_count = revert_product_count((int)$_GET['qty'],(string)$_GET['id']);
	$update_status = reset_order((string)$_GET['po'],(string)$_GET['id']);
}

else if ($status == "BO"){
	$update_status = reset_order((string)$_GET['po'],(string)$_GET['id']);
	$update_po = revert_po_count((string)$_GET['id'],(int)$_GET['qty']);
	$update_bo = revert_backorder_count((string)$_GET['id'],(int)$_GET['qty']);
}

else {
	$update_status = reset_order((string)$_GET['po'],(string)$_GET['id']);
}

  if($update_status){
  //   $session->msg("s","Order reverted.");
      redirect('orderline.php');
  } else {
      $session->msg("d","Order was not added.");
      redirect('orderline.php');
  }
?>
