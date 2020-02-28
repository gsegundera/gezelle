<?php
  $page_title = 'Cancel Order';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   $products = process_table();
   $current_user = current_user();
?>

<?php 

if(isset($_POST['process-order'])) {
foreach ($products as $product):
	  
	 
	 $sql="UPDATE order_line SET ORDLINE_CREATEDBY ='{$current_user['name']}' WHERE ORDLINE_PRODID = '{$product['ORDLINE_PRODID']}' and ORDLINE_ORDHDRID = '{$product['ORDLINE_ORDHDRID']}' and ORDLINE_STATUS is not NULL";
	
	 $result = $db->query($sql);
    
endforeach; 
 if (! empty($result))  {
            $session->msg('s',"Order Processed");			
          redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
           redirect('orderline.php', false);
          }

}
	 
		

?>



	

