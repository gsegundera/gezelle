<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}

/*--------------------------------------------------------------*/
/*  Function for Find data from table by sku mgl product
/*--------------------------------------------------------------*/
function find_by_productsku($table,$id)
{
  global $db;
  $id = (string)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE PROD_SKU='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}

/*--------------------------------------------------------------*/
/*  Function for Find data from table by sku mgl
/*--------------------------------------------------------------*/
function find_by_sku($table,$id)
{
  global $db;
  $id = (string)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE ORDLINE_PRODID='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}

function find_by_po($table,$id)
{
  global $db;
  $id = (string)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE ORDLINE_ORDHDRID='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}

/*--------------------------------------------------------------*/
/* Function for accept order update count mgl
/*--------------------------------------------------------------*/
function accept_order($po, $sku)
{
  global $db;
    
    $po_id = (string)$po;
	$sku_id = (string)$sku;
    $sql = "UPDATE order_line SET ORDLINE_STATUS='A' WHERE ORDLINE_ORDHDRID = '{$po_id}' and ordline_prodid ='{$sku_id}'";
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
   /*--------------------------------------------------------------*/
/* Function for reset order to null mgl
/*--------------------------------------------------------------*/
function reset_order($po, $sku)
{
  global $db;
    
    $po_id = (string)$po;
	$sku_id = (string)$sku;
    $sql = "UPDATE order_line SET ORDLINE_STATUS=NULL WHERE ORDLINE_ORDHDRID = '{$po_id}' and ordline_prodid ='{$sku_id}'";
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
   /*--------------------------------------------------------------*/
/* Function for cancel order, set to C mgl
/*--------------------------------------------------------------*/
function cancel_order($po, $sku)
{
  global $db;
    
    $po_id = (string)$po;
	$sku_id = (string)$sku;
    $sql = "UPDATE order_line SET ORDLINE_STATUS='C' WHERE ORDLINE_ORDHDRID = '{$po_id}' and ordline_prodid ='{$sku_id}'";
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
   /*--------------------------------------------------------------*/
/* Function for back order, set to BO mgl
/*--------------------------------------------------------------*/
function backorder($po, $sku)
{
  global $db;
    
    $po_id = (string)$po;
	$sku_id = (string)$sku;
    $sql = "UPDATE order_line SET ORDLINE_STATUS='BO' WHERE ORDLINE_ORDHDRID = '{$po_id}' and ordline_prodid ='{$sku_id}'";
	
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
    /*--------------------------------------------------------------*/
/* Function for back order, set to BO count mgl
/*--------------------------------------------------------------*/
	function backorder_count($sku, $bo_count){
	global $db;    
    $bo_count_id = (int)$bo_count;
	$sku_id = (string)$sku;
	$sql = "UPDATE supplier_po set SUP_BackOrder =SUP_BackOrder + {$bo_count_id} WHERE SUP_SKU ='{$sku_id}'";
	
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
    /*--------------------------------------------------------------*/
/* Function for revert back order, set to BO count mgl
/*--------------------------------------------------------------*/
	function revert_backorder_count($sku, $bo_count){
	global $db;    
    $bo_count_id = (int)$bo_count;
	$sku_id = (string)$sku;
	$sql = "UPDATE supplier_po set SUP_BackOrder =SUP_BackOrder - {$bo_count_id} WHERE SUP_SKU ='{$sku_id}'";
	
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
   
   
    /*--------------------------------------------------------------*/
/* Function for back order, set to BO count mgl
/*--------------------------------------------------------------*/
	function po_available_count($sku, $bo_count){
	global $db;    
    $bo_count_id = (int)$bo_count;
	$sku_id = (string)$sku;
	$sql = "UPDATE supplier_po set SUP_Available_Qty =SUP_Available_Qty - {$bo_count_id} WHERE SUP_SKU ='{$sku_id}'";
	
    $result = $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }


/*--------------------------------------------------------------*/
  /* Function for Update product quantity mgl
  /*--------------------------------------------------------------*/
  function update_product_count($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (string)$p_id;
    $sql = "UPDATE product2 SET PROD_QTY=PROD_QTY -{$qty} WHERE prod_sku = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  
  /*--------------------------------------------------------------*/
  /* Function for revert product quantity  mgl
  /*--------------------------------------------------------------*/
  function revert_product_count($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (string)$p_id;
    $sql = "UPDATE product2 SET PROD_QTY=PROD_QTY +{$qty} WHERE prod_sku = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  
  /*--------------------------------------------------------------*/
  /* Function for revert BO quantity  mgl
  /*--------------------------------------------------------------*/
  function revert_po_count($p_id, $qty){
    global $db;
    $qty1 = (int) $qty;
    $id  = (string)$p_id;
   	$sql = "UPDATE supplier_po set SUP_Available_Qty =SUP_Available_Qty + {$qty1} WHERE SUP_SKU ='{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}

/*--------------------------------------------------------------*/
/* Function for Count sku By table name
/*--------------------------------------------------------------*/

function count_by_sku($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(PROD_SKU) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}

function count_by_order($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(ORD_ID) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for checking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','This level user has been banned!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
   
    function product_table(){
     global $db;
     $sql  =" SELECT prod_sku, prod_description, prod_qty";
    
    $sql  .=" FROM product2";
   
    $sql  .=" ORDER BY prod_sku";
    return find_by_sql($sql);

   }
   //mgl
    function orderline_table(){
     global $db;
	
	$sql = "SELECT ORDLINE_ORDERDATE , ORDLINE_ORDHDRID , ORDLINE_PRODID , ORDLINE_ACCEPTED_QTY , 
	prod_qty, ORDLINE_STATUS,SUP_Quantity, SUP_ExpectedReceiveDate, SUP_BackOrder, SUP_Available_Qty ";
	$sql .="FROM order_line left join product2 on order_line.ORDLINE_PRODID = product2.PROD_SKU 
	left join supplier_po on product2.PROD_SKU = supplier_po.SUP_SKU where ORDLINE_CREATEDBY is NULL
	  order by ORDLINE_ORDERDATE desc  limit 1000";
  
    return find_by_sql($sql);

   }
   
    //mgl
    function process_table(){
     global $db;
	
	$sql = "SELECT ORDLINE_ORDERDATE , ORDLINE_ORDHDRID , ORDLINE_PRODID , ORDLINE_ACCEPTED_QTY , ORDLINE_CREATEDBY  ";
	$sql .="FROM order_line order by ORDLINE_PRODID   limit 1000";
  
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_selling_product($limit){
   global $db;
   $sql  = "select ordline_prodid, prod_description, count(ordline_accepted_qty) as Count  from order_line ";
   $sql .= "join product2 on ordline_prodid = prod_sku  group by ordline_prodid ";
  
   $sql .= "ORDER BY Count desc LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT ordline_prodid, ord_custid, ordline_orderdate from order_line ";
  $sql .= " join orders on ORDLINE_ORDHDRID  = ord_id  group by ordline_prodid";
 
  $sql .= " ORDER BY ordline_orderdate DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Generate Monthly order report mgl
/*--------------------------------------------------------------*/
function  monthlyOrder(){
  global $db;
  $sql  = "SELECT * FROM order_line where date_format(ORDLINE_ORDERDATE, '%Y-%m')  = date_format(curdate(), '%Y-%m') order by ordline_orderdate desc;";
  
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Generate Daily order report mgl
/*--------------------------------------------------------------*/
function  dailyOrders(){
  global $db;
  $sql  = "SELECT * FROM order_line where ORDLINE_ORDERDATE  = curdate()order by ordline_orderdate desc;";
  
  return find_by_sql($sql);
}

?>
