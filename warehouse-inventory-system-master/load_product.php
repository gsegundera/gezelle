<?php
//upload CSV
  if(isset($_POST['submit'])) {
   $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
		
	$sql=	"LOAD DATA  INFILE '{$file}' INTO TABLE amazonus FIELDS TERMINATED BY ',' LINES TERMINATED BY '\r\n'
			Ignore 1 rows
			(AMZ_PO, AMZ_MODELNUM, AMZ_ASIN, AMZ_SHIPSTARTDATE,AMZ_SHIPENDDATE, AMZ_SHIPEXPECTDATE, AMZ_ACCEPTEDQTY, AMZ_UNITCOST)"
		    $result = $db->query($sql);
		if($result {
            $session->msg('s',"CSV Uploaded");
            redirect('orderline.php', false);
          } else {
            $session->msg('d',' Sorry failed to update!');
            redirect('orderline.ph.php', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('orderline.ph',false);
    }
		
		
    }
  }
?>