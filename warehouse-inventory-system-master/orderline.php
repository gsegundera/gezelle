<?php
  $page_title = 'Orders';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = orderline_table();
?>
<?php include_once('layouts/header.php'); ?>
<?php
//upload CSV
  if(isset($_POST['submit'])) {
   $fileName = $_FILES["file_name"]["tmp_name"];   
   if ($_FILES["file_name"]["size"] > 0) {        
        $file = fopen($fileName, "r");
		 $real = realpath($fileName);
		 $result;
		 
		 fgetcsv($file, 10000, ",");
	
	
	while (($column  = fgetcsv($file, 10000, ",")) !== FALSE) {			
		 $sql = "INSERT ignore into amazonus (AMZ_PO, AMZ_MODELNUM, AMZ_ASIN, AMZ_SHIPSTARTDATE,AMZ_SHIPENDDATE, AMZ_SHIPEXPECTDATE, AMZ_ACCEPTEDQTY, AMZ_UNITCOST)
                  values ('" . $column[0] . "','" . $column[3] . "','" . $column[4] . "','" . date('Y-m-d', strtotime($column[8])) . "','" . date('Y-m-d', strtotime($column[9])) . 
				  "' ,'" . date('Y-m-d', strtotime($column[8]))."','" . $column[11]."','". str_replace('$', '', $column[12])."')";
	
		    $result = $db->query($sql);	
	  
}
//end while		
		  
		  if (! empty($result))  {
            $session->msg('s',"CSV Uploaded");			
          redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
           redirect('orderline.php', false);
          }	  
  }   
  
  else {
    $session->msg("d", $errors);
     redirect('orderline.php',false);
   }		
    }
	
	//UPLOAD AMAZON MAIN
	if(isset($_POST['submit-amz'])) {
	  $current_user = current_user();
	   $fileName = $_FILES["file_name"]["tmp_name"];   
			if ($_FILES["file_name"]["size"] > 0) {        
				$file = fopen($fileName, "r");
				$result;		 
					fgetcsv($file, 10000, ",");	
	
				while (($column  = fgetcsv($file, 10000, ",")) !== FALSE) {	
				
				 $sql3=	"Insert ignore into order_line (ORDLINE_ORDHDRID, ORDLINE_PRODID, ORDLINE_ACCEPTED_QTY, ORDLINE_ORDERDATE, ORDLINE_UNIT_COST) 
				values ('" . $column[0] . "','" . $column[3] . "','" . $column[11] . "','" . date("Y-m-d") . "','" . str_replace('$', '', $column[12])."')";
				$result3 = $db->query($sql3);			

				$sql = "INSERT ignore into amazonus (AMZ_PO, AMZ_MODELNUM, AMZ_ASIN, AMZ_SHIPSTARTDATE,AMZ_SHIPENDDATE, AMZ_SHIPEXPECTDATE, AMZ_ACCEPTEDQTY, AMZ_UNITCOST)
                  values ('" . $column[0] . "','" . $column[3] . "','" . $column[4] . "','" . date('Y-m-d', strtotime($column[8])) . "','" . date('Y-m-d', strtotime($column[9])) . 
				  "' ,'" . date('Y-m-d', strtotime($column[8]))."','" . $column[11]."','". str_replace('$', '', $column[12])."')";
	
		    $result = $db->query($sql);	
				}					
				//end while	
				
				$sql2=	"insert ignore into orders (ORD_ID, ORD_CUSTID, ORD_ORDERDATE, ORD_CREATEDBY, ORD_CREATEDATE)select distinct AMZ_PO, 'AmazonMain', cast(AMZ_ORDERUPLOAD as DATE), '{$current_user['name']}', CURDATE() from amazonus";
				$result2 = $db->query($sql2);
		  
		  if ((! empty($result)) && (! empty($result3))) {
            $session->msg('s',"Order Updated");			
          redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
           redirect('orderline.php', false);
          }
		}   
			else {
			$session->msg("d", $errors);
			redirect('orderline.php',false);
			}		
		
		}  
		
		//UPLOAD walmart
	if(isset($_POST['submit-wal'])) {
	  $current_user = current_user();
	   $fileName = $_FILES["file_name"]["tmp_name"];   
			if ($_FILES["file_name"]["size"] > 0) {        
				$file = fopen($fileName, "r");
				$result;		 
					fgetcsv($file, 10000, ",");	
	
				while (($column  = fgetcsv($file, 10000, ",")) !== FALSE) {	
				
						

				$sql2 = "INSERT ignore into walmart (W_PO,W_GTIN, W_ITEMNUM, W_QUANTITY,  W_ORDERUPLOAD)
                  values ('" . $column[0] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','"  . date("Y-m-d")."')";
	
		    $result2 = $db->query($sql2);	
				}					
				//end while	
				
				$sql1=	"Insert ignore into order_line (ORDLINE_ORDHDRID, ORDLINE_PRODID, ORDLINE_ACCEPTED_QTY, ORDLINE_ORDERDATE) 
				select distinct W_PO, W_MGL_SKU,W_QUANTITY,W_ORDERUPLOAD from walmart left join walmart_modelnum on walmart.W_GTIN = walmart_modelnum.W_GTIN";
				$result1 = $db->query($sql1);	
				
				$sql3=	"insert ignore into orders (ORD_ID, ORD_CUSTID, ORD_ORDERDATE, ORD_CREATEDBY, ORD_CREATEDATE)
				select distinct W_PO, 'Walmart', cast(W_ORDERUPLOAD as DATE), '{$current_user['name']}', CURDATE() from walmart";
				$result3 = $db->query($sql3);
				
				
		  
		  if ((! empty($result2)) && (! empty($result1))) {
            $session->msg('s',"Order Updated");			
          redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
           redirect('orderline.php', false);
          }
		}   
			else {
			$session->msg("d", $errors);
			redirect('orderline.php',false);
			}		
		
		}  
		
	//UPLOAD AMZ Drop Ship
	if(isset($_POST['submit-amzds'])) {
	  $current_user = current_user();
	   $fileName = $_FILES["file_name"]["tmp_name"];   
			if ($_FILES["file_name"]["size"] > 0) {        
				$file = fopen($fileName, "r");
				$result;		 
					fgetcsv($file, 10000, ",");	
	
				while (($column  = fgetcsv($file, 10000, ",")) !== FALSE) {	
				
						

				$sql2 = "INSERT ignore into amazon_ds (AMZDS_PO, AMZDS_ORDERDATE, AMZDS_SKU,  AMZDS_QTY, AMZDS_TRACKINGID)
                  values ('" . $column[0] . "','" . date('Y-m-d', strtotime($column[1])) . "','" . $column[2] . "','" . $column[3] . "','"  . $column[4]."')";
	
					$result2 = $db->query($sql2);	
				}					
				//end while	
				
				$sql1=	"Insert ignore into order_line (ORDLINE_ORDHDRID, ORDLINE_PRODID, ORDLINE_ACCEPTED_QTY, ORDLINE_ORDERDATE) 
				select distinct AMZDS_PO, AMZDS_SKU, AMZDS_QTY, AMZDS_ORDERDATE from amazon_ds";
				$result1 = $db->query($sql1);	
				
				$sql3=	"insert ignore into orders (ORD_ID, ORD_CUSTID, ORD_ORDERDATE, ORD_CREATEDBY, ORD_CREATEDATE)
				select distinct AMZDS_PO, 'AMZ-DS', cast(AMZDS_ORDERDATE as DATE), '{$current_user['name']}', CURDATE() from amazon_ds";
				$result3 = $db->query($sql3);
				
				
		  
		  if ((! empty($result2)) && (! empty($result1))) {
            $session->msg('s',"Order Updated");			
          redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
           redirect('orderline.php', false);
          }
		}   
			else {
			$session->msg("d", $errors);
			redirect('orderline.php',false);
			}		
		
		}  
?>

     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">	
<!--<form action="" method="POST" enctype="multipart/form-data"style="display: inline;>		
		   <label class="form-label">Order Date</label>
		    <input type="text" style="width:10%; display: inline" placeholder ="yyyy-mm-dd" class="datepicker form-control" name="start-date"> 
		<input type="text" style="width:10%; display: inline" placeholder ="yyyy-mm-dd" class="datepicker form-control" name="end-date">             
        <button type="submit" name="filter-date" class="btn btn-info">Filter Order by Date</button>
	</form>	-->
	<form class="form" action="process_order.php" method="POST" enctype="multipart/form-data" style="display: inline;">		
		             
        <button type="submit" name="process-order" class="btn btn-warning">PROCESS ORDER</button>
	</form>	
			   
			 
		<div class="pull-right">   
		   <form class="form" action="orderline.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input value="Choose CSV" accept=".csv" style="width:90%; display: inline" type="file" name="file_name" id="file_name" class="btn btn-default btn-file"/>
				<!--<button type="submit" name="submit" class="btn btn-warning">Upload CSV</button>-->
			  </div>
			   <div class="form-group">
              <button type="submit" name="submit-amz" class="btn btn-info">Amazon</button>
			  <button type="submit" name="submit-wal" class="btn btn-info">Walmart</button>
			   <button type="submit" name="submit-amzds" class="btn btn-info">Amazon DS</button>
			  </div>
             </form>		   
		</div>
		
        <div class="panel-body">
          <table class="table table-bordered" id="order_table">
            <thead>
              <tr>
                
                 <th class="text-center" style="width: 10%;">SKU</th>
                <th class="text-center" style="width: 10%;">PO</th>
               
				<th class="text-center" style="width: 10%;">Date</th>
				 <th class="text-center" style="width: 5%;">Ordered QTY</th>
				 <th class="text-center" style="width: 10%;">Available QTY</th>				
				  <th class="text-center" style="width: 15%;">Actions</th>
				 <th class="text-center" style="width: 5%;">Status</th>
				  <th class="text-center" style="width: 5%;">PO RORDR</th>
				 <th class="text-center" style="width: 10%;">PO RCV Date</th>
             
                
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                
                
               
               <td class="text-center"> <?php echo remove_junk($product['ORDLINE_PRODID']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['ORDLINE_ORDHDRID']); ?></td>				 
				  <td class="text-center"> <?php echo remove_junk($product['ORDLINE_ORDERDATE']); ?></td>
				 <td class="text-center"> <?php echo remove_junk($product['ORDLINE_ACCEPTED_QTY']); ?></td>
				  <td class="text-center"> <?php echo remove_junk($product['prod_qty']); ?></td>
				  <td class="text-center">
                  <div class="btn-group">
				   <?php if(((string)$product['ORDLINE_STATUS']=="A") or ((string)$product['ORDLINE_STATUS']=="C") or ((string)$product['ORDLINE_STATUS']=="BO") ) {?>
             
                    <a style="pointer-events: none; cursor: default; color:#f2f2f2; background-color:#595959;" 
					href="accept_cancel_order.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . '&amp;id='.$product['ORDLINE_PRODID']. '&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'] ;?>" 
					class="btn btn-default btn-xs"  title="Edit" data-toggle="tooltip">                    
					 <span  class="glyphicon glyphicon-ok"></span>                   
                  </a>
				  
				  <a style="pointer-events: none; cursor: default; color:#f2f2f2;background-color:#595959;" 
				  href="cancel_order.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . '&amp;id='.$product['ORDLINE_PRODID']. '&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'] ;?>"  
				  class="btn btn-danger btn-xs"  title="Cancel" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-remove"></span>
                    </a>
					
					<a style="pointer-events: none; cursor: default; color:#f2f2f2;background-color:#595959;" href="backorder.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . 
				   '&amp;id='.$product['ORDLINE_PRODID']. 
				   '&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'].
				   '&amp;status='.$product['ORDLINE_STATUS'];?>" 
				   class="btn btn-primary btn-xs"  title="back order" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-tags"></span>
                    </a>
					
				   <?php } else {?>
				    <a  href="accept_cancel_order.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . 
					'&amp;id='.$product['ORDLINE_PRODID']. 
					'&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'].
					'&amp;status='.$product['ORDLINE_STATUS'];?>" 
					class="btn btn-info btn-xs"  title="Accept" data-toggle="tooltip">
                    
					 <span  class="glyphicon glyphicon-ok"></span>
                   
                  </a>
				   <a href="cancel_order.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . 
				   '&amp;id='.$product['ORDLINE_PRODID']. 
				   '&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'].
				   '&amp;status='.$product['ORDLINE_STATUS'];?>" 
				   class="btn btn-danger btn-xs"  title="Cancel" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-remove"></span>
                    </a>
					
					 <a href="backorder.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . 
				   '&amp;id='.$product['ORDLINE_PRODID']. 
				   '&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'].
				    '&amp;bo='.$product['SUP_BackOrder'].
				   '&amp;status='.$product['ORDLINE_STATUS'];?>" 
				   class="btn btn-primary btn-xs"  title="back order" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-tags"></span>
                    </a>
				  
				  
				  
				   <?php } ?>
				   
				   
                   
					<a href="refresh_order.php?po=<?php echo $product['ORDLINE_ORDHDRID'] . 
					'&amp;id='.$product['ORDLINE_PRODID']. 
					 '&amp;bo='.$product['SUP_BackOrder'].
					'&amp;qty='.$product['ORDLINE_ACCEPTED_QTY'].
					'&amp;status='.$product['ORDLINE_STATUS'];?>" 
					class="btn btn-info btn-xs"  title="Refresh" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-refresh"></span>
                    </a>
                  </div>
                </td>
				 <td class="text-center"> <?php echo remove_junk($product['ORDLINE_STATUS']); ?></td>
              
				   <td class="text-center"> <?php echo remove_junk($product['SUP_Available_Qty']); ?></td>
				    <td class="text-center"> <?php echo remove_junk($product['SUP_ExpectedReceiveDate']); ?></td>
				  
				
				
			
                
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
   var table = $('#order_table').DataTable({			
			
			 stateSave: true,
			 //responsive:true,			  
			 "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
});
});
</script>
  <?php include_once('layouts/footer.php'); ?>