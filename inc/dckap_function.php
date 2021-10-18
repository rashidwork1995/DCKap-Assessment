<?php
    
    class DCKAP  
	{
        //Login 
        public function LoginCheck()
		{
            global $db;
            $output=array();
            $user_name=$_POST['singin_username'];
            $password=md5($_POST['singin_password']);
            $sql = 'SELECT id, email, mobile_number, `name`, `password`, `user_type` FROM ' . DCKAP_USER . " WHERE (email='" . $user_name . "' OR mobile_number='" . $user_name . "') AND password='" . $password . "' AND is_delete=0 ";
            $res = $db->line($sql);
            if (!empty($res)){
                $_SESSION['login_user_name']=$res['name'];
                $_SESSION['login_user_id']=$res['id'];
                $_SESSION['login_user_type']=$res['user_type'];
                $output['status']='0';
                $output['messsage']='User Details added';
                $output['val']='Success';

            }else{
                $output['status']='1';
                $output['messsage']='Invalid Login Details';
                $output['val']='Error';
            }
            return $output;
        }
        //User Registration
        function UserRegister()
		{
            global $db;
            $output=array();
            $s_val = array('email' => $_POST['email'],
            'mobile_number' => $_POST['mobile_number'],
            'name' => $_POST['name'],
            'password' => md5($_POST['password']),
            'address' => $_POST['address'],
            'user_type' => $_POST['user_type'],
            );
            if(!empty($s_val)){
                $dup_val = array('is_delete' => 0, 'user_type'=> 2,'mobile_number' => $_POST['mobile_number'], 'email' =>$_POST['email']);
                $dup_sql = 'SELECT COUNT(id) AS tot FROM ' . DCKAP_USER . '  WHERE 1 AND (mobile_number=:mobile_number OR email=:email)AND is_delete=:is_delete AND user_type=:user_type';
                $res_tot = $db->one($dup_sql, $dup_val);
                if ($res_tot == 0) {
                    if ($db->insert(DCKAP_USER, $s_val)) {
                        $output['status']='0';
                        $output['messsage']='User Details Registered..';
                        $output['val']='Success';
                    }
                }else{
                    $output['status']='1';
                    $output['messsage']='User Email/Mobile Number already Exist';
                    $output['val']='Error';
                }
            }
            return $output;
        }
        //View User List
        public function ViewUser()
		{
            global $db;
            $outputData=array();
            $serach=$_REQUEST['search_customer'];
			$columns = array(0 => 'id', 1 => 'name', 2 => 'email',3=>'mobile_number', 4 => 'address');
			$where='';
			$where.=($serach!='') ? " AND (`name` LIKE '%" .$serach."%' OR `email` LIKE  '%" .$serach."%' OR `mobile_number` LIKE '%" .$serach."%' OR `address` LIKE '%" .$serach. "%' )":"";
			$s_val = array('is_delete' => 0,'user_type'=> 2);
			$sql_count = 'SELECT count(id) as count '
            . ' FROM '.DCKAP_USER. ' WHERE 1 AND is_delete=:is_delete AND user_type=:user_type '.$where;
			$res_total = $db->one($sql_count, $s_val);
			$sql = 'SELECT id, email, mobile_number, `name`, `password`, `address` FROM '.DCKAP_USER.' WHERE 1 AND is_delete=:is_delete AND user_type=:user_type '.$where.' ORDER BY ' . $columns[$_REQUEST['order'][0]['column']] . ' ' . $_REQUEST['order'][0]['dir']
            . ' LIMIT ' . $_REQUEST['start'] . ', ' . (($_REQUEST['length']!='-1')? $_REQUEST['length']:$res_total);
			$res = $db->qc($sql, $s_val);
			$res_v = $res[0];
			$res_c = $res[1];
            $jj=1; 
			for($i=0;$i<$res_c;$i++){
                $nestedData=array(); 
				$nestedData[] = $jj;
                $nestedData[] = $res_v[$i]['name'];
                $nestedData[] = $res_v[$i]['email'];
                $nestedData[] = $res_v[$i]['mobile_number'];
                $nestedData[] = $res_v[$i]['address'];
                $outputData[] = $nestedData; 
                $jj++;
			}
			$json_data = array("draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($res_total),
            "recordsFiltered" => intval($res_total),
            "data" => $outputData);
			return $json_data;
        }
        //Add New Product
        public function ProductAdd()
		{
            global $db;
            $output=array();
            $s_val = array('product_id' => $_POST['product_id'],
            'product_name' => $_POST['product_name'],
            'description' => $_POST['descritpiton'],
            'spec' => $_POST['spec'],
            'featues' => $_POST['features'],
            'guest_price' => $_POST['guest_price'],
            'customer_price' => $_POST['customer_price'],
            'created_by' => $_SESSION['login_user_id']
            );
            if(!empty($s_val)){
                $dup_val = array('is_delete' => 0, 'product_name' => $_POST['product_name']);
                $dup_sql = 'SELECT COUNT(id) AS tot FROM ' . DCKAP_PRODUCT . '  WHERE 1 AND product_name=:product_name AND is_delete=:is_delete';
                $res_tot = $db->one($dup_sql, $dup_val);
                if ($res_tot == 0) {
                    if ($db->insert(DCKAP_PRODUCT, $s_val)) {
                        $last_id = $db->lastID();
                        if($_FILES['image']['name']!=''){
                            $allowTypes = array(".jpg", ".jpeg", ".gif", ".png");
                            $k=1; 
                            $fileNames = array_filter($_FILES['image']['name']); 
                            if(!empty($fileNames)){ 
                                foreach($_FILES['image']['name'] as $key=>$val){  
                                    $default=($k==1?1:'');
                                    $uploadedfile = $_FILES['image']['tmp_name'][$key];
                                    $f_size = $_FILES['image']['size'][$key];
                                    $a_size = (20 * 1048576);
                                    $fileName = uniqid().$_FILES['image']['name'][$key]; 
                                    $targetFilePath = 'product/images/' . $fileName;
                                    $file_extension = strrchr($_FILES["image"]["name"][$key], "."); 
                                    if (in_array($file_extension, $allowTypes)) {
                                        if ($f_size < $a_size) {
                                            if (is_uploaded_file($uploadedfile)) {
                                                if (move_uploaded_file($uploadedfile, $targetFilePath)) {   
                                                    $image_value = array(
                                                    'product_id' =>  $last_id,
                                                    'file_name' => $fileName,
                                                    'file_original_name' =>$_FILES['image']['name'][$key],
                                                    'type' =>1,
                                                    'default_image' => $default,
                                                    'created_by'=>$_SESSION['login_user_id']);
                                                   if($db->insert(DCKAP_PRODUCT_FILE, $image_value)){
                                                        $output['status']='0';
                                                        $output['messsage']='Product Added';
                                                        $output['val']='Success';
                                                   }
                                                } 
                                            }
                                        }
                                    }
                                    else{
                                        $output['status']='1';
                                        $output['messsage']='Allow only Image file format';
                                        $output['val']='Error';
                                    }
                                    $k++;
                                }
                            }
                        }
                        if($_FILES['doc']['name']!=''){
                            $allowTypes = array(".xlsx", ".xls", ".XLSX", ".XLS", ".csv", ".CSV", ".pdf", ".PDF", ".zip", ".ZIP", ".doc", ".DOC", ".docx", ".DOCX", ".ppt", ".PPT", ".pptx", ".PPTX");
                           $fileNames = array_filter($_FILES['doc']['name']); 
                            if(!empty($fileNames)){  
                                foreach($_FILES['doc']['name'] as $key=>$val){  
                                    $uploadedfile = $_FILES['doc']['tmp_name'][$key];
                                    $f_size = $_FILES['doc']['size'][$key];
                                    $a_size = (20 * 1048576);
                                    $fileName = uniqid().$_FILES['doc']['name'][$key]; 
                                    $targetFilePath = 'product/doc/' . $fileName;
                                    $file_extension = strrchr($_FILES["doc"]["name"][$key], "."); 
                                    if (in_array($file_extension, $allowTypes)) {  
                                        if ($f_size < $a_size) {
                                            if (is_uploaded_file($uploadedfile)) {
                                                if (move_uploaded_file($uploadedfile, $targetFilePath)) {   
                                                    $doc_value = array(
                                                    'product_id' =>  $last_id,
                                                    'file_name' => $fileName,
                                                    'file_original_name' =>$_FILES['doc']['name'][$key],
                                                    'type' =>2,
                                                    'created_by'=>$_SESSION['login_user_id']);
                                                    $db->insert(DCKAP_PRODUCT_FILE, $doc_value);
                                                } 
                                            }
                                        }
                                    }
                                    else{
                                        $output['status']='1';
                                        $output['messsage']='Allow only Image file format';
                                        $output['val']='Error';
                                    }
                                }
                            }
                        }
                        
                       
                    }
                }else{
                    $output['status']='1';
                    $output['messsage']='Product already Exist';
                    $output['val']='Error';
                }
            }
            return $output;
        }
        //View list of products
        public function ProductView()
		{
            global $db;
            $output=array();
            $data='';
			$s_val = array('is_delete' => 0);
            $prod_sql='SELECT `id`, `product_id`, `product_name`, `description`, `spec`, `featues`, `guest_price`, `customer_price` FROM ' . DCKAP_PRODUCT . ' WHERE 1 AND is_delete=:is_delete'; 
			$prod_res = $db->qc($prod_sql, $s_val);
            $res_v = $prod_res[0];
			$res_c = $prod_res[1];
            $data = array();
            $output['data'].='<div class="row">';
			for ($i = 0; $i < $res_c; $i++) {
                $img='';
                $output['data'].='<div class="col-md-3">'
                        .'<div class="product product-11 text-center" style="width:270px;">'
                        .'<figure class="product-media">'
                        .'<div id="carouselExampleControls'.$i.'" class="carousel slide" data-ride="carousel">'
                        .'<div class="carousel-inner">';
                $s_image_val = array('is_delete' => 0,'type' =>1);
                $prod_imag_sql='SELECT  `id`, `product_id`, `file_name`, `type` FROM ' . DCKAP_PRODUCT_FILE . ' WHERE 1 AND is_delete=:is_delete AND type=:type AND product_id='.$res_v[$i]['id']; 
                $prod_imag_res = $db->qc($prod_imag_sql, $s_image_val);
                $res_imag_v = $prod_imag_res[0];
                $res_imag_c = $prod_imag_res[1];
                for ($j = 0; $j < $res_imag_c; $j++) {
                    if($j==0){ $act='active'; }else{ $act=''; };
                    $img.='<div class="carousel-item '.$act.'"><img src="inc/product/images/'.$res_imag_v[$j]['file_name'].'" alt="Product image" style="width: 270px;height: 250px;"></div>';
                }
                $output['data'].=$img;
                $output['data'].='</div>';
                if($res_imag_c>1){
                    $output['data'].='<a class="carousel-control-prev" href="#carouselExampleControls'.$i.'" role="button" data-slide="prev">'
                    .'<span class="carousel-control-prev-icon bg-pre-nex" aria-hidden="true"></span>'
                    .'<span class="sr-only">Previous</span>'
                    .'</a>'
                    .'<a class="carousel-control-next" href="#carouselExampleControls'.$i.'" role="button" data-slide="next">'
                    .'<span class="carousel-control-next-icon bg-pre-nex" aria-hidden="true"></span>'
                    .'<span class="sr-only">Next</span>'
                    .'</a>';
                }
                if($_SESSION['login_user_id']!=''){
                    $qty='<input type="number" name="qty" id="qty'.$res_v[$i]['id'].'" value="1" class="form-control num" placeholder="Qty"/>';
                    $price ='Actual $'.$res_v[$i]['guest_price'].' / Yours $'.$res_v[$i]['customer_price'];
                }else{
                    $price ='$'.$res_v[$i]['guest_price'];
                }
                $output['data'].='</div>'
                        .'</figure>'
                        .'<div class="product-body">'
                        .'<h3 class="product-title"><a href="product.html">'.$res_v[$i]['product_name'].'</a></h3>'
                        .'<div class="product-price">'.$price.'</div>'
                        .'<p>'.$res_v[$i]['description'].'</p>'
                        .'<p>'.$res_v[$i]['spec'].'</p>'
                        .'<p>'.$res_v[$i]['featues'].'</p>'.$qty
                        .'<button  class="btn-primary addcart" data-id="'.$res_v[$i]['id'].'"><span>add to cart</span></button>';
                $output['data'].='</div>'
                        .'</div>'
                        .'</div>';
			}
            $output['data'].='</div>';
			return $output;
        }
        //Add Cart Details
        public function AddCart()
		{
            $output=array();
            if(isset($_SESSION['login_user_name'])) {
            $output['f']=1;
            global $db;
            $qty=($_POST['qty']!=''?$_POST['qty']:1);
            $s_val = array('user_id' => $_SESSION['login_user_id'],
            'product_id' => $_POST['product_id'],
            'qty' => $qty
            );
            if(!empty($s_val)){
                $dup_val = array('is_delete' => 0, 'user_id'=> $_SESSION['login_user_id'],'product_id' => $_POST['product_id']);
                $dup_sql = 'SELECT COUNT(id) AS tot FROM ' . DCKAP_CART . '  WHERE 1 AND user_id=:user_id AND product_id=:product_id AND is_delete=:is_delete';
                $res_tot = $db->one($dup_sql, $dup_val);
                if ($res_tot == 0) {
                    if ($db->insert(DCKAP_CART, $s_val)) {
                        $output['status']='0';
                        $output['messsage']='Product Added on Cart';
                        $output['val']='Success';
                    }
                }else{
                    $output['status']='1';
                    $output['messsage']='Already Same Product added';
                    $output['val']='Error';
                }
            }
            }else{
                $output['f']=0;
            }
            return $output;
        }
        //View List of Cart details
        public function ViewCart()
		{
            global $db;
            $output=array();
            $data='';
			$s_val = array('is_delete' => 0, 'user_id'=> $_SESSION['login_user_id'], 'cart_status'=>0 );
            $cart_sql='SELECT a.id, a.user_id, a.product_id, a.qty, a.cart_status,b.product_name,b.id,b.customer_price, (b.customer_price*a.qty) as total FROM ' . DCKAP_CART . ' as a LEFT JOIN ' . DCKAP_PRODUCT . ' as b ON a.product_id=b.id WHERE 1 AND a.is_delete=:is_delete AND a.user_id=:user_id AND a.cart_status=:cart_status'; 
			$cart_res = $db->qc($cart_sql, $s_val); 
            $cart_res_v = $cart_res[0]; 
			$cart_res_c = $cart_res[1]; 
            $data = array();
            $page=$_POST['page'];
            if($cart_res_c>0){
                //Product page cart list
                if($page=='product_page'){
                    $output['data'].='<div class="dropdown-cart-products">';
                    for ($i = 0; $i < $cart_res_c; $i++) {
                        $output['data'].= '<div class="product">'
                                        .'<div class="product-cart-details">'
                                        .'<h4 class="product-title">'
                                        .'<a href="javascript:void(0)">'.$cart_res_v[$i]['product_name'].'</a>'
                                        .'</h4>'
                                        .'<span class="cart-product-info"><span class="cart-product-qty">'.$cart_res_v[$i]['qty'].'</span> x $'.$cart_res_v[$i]['customer_price'].'</span><span> = $'.$cart_res_v[$i]['total'].'</span>'
                                        .'</div>'
                                        .'<a href="javascript:void(0)" data-id="'.$cart_res_v[$i]['product_id'].'" class="btn-remove remove-prod" title="Remove Product"><i class="icon-close"></i></a>'
                                        .'</div>';
                        $sub_total += $cart_res_v[$i]['total'];
                    }
                    $output['data'].='<div class="dropdown-cart-total">'
                                    .'<span>Total</span>'
                                    .'<span class="cart-total-price">$'.$sub_total.'</span>'
                                    .'</div>'
                                    .'<div class="dropdown-cart-action">'
                                    .'<a href="checkout.php" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>'
                                    .'</div>'
                                    .'</div>';
                    $output['data'].='</div>';
                }else if($page=='checkout_page'){
                    //checkout page cart list
                    for ($i = 0; $i < $cart_res_c; $i++) {
                        $output['data'].= '<tr>'
                                        .'<td>'.$cart_res_v[$i]['product_name'].'</td>'
                                        .'<td>'.$cart_res_v[$i]['qty'].' X $'.$cart_res_v[$i]['customer_price'].'</td>'
                                        .'<input type="hidden" name="product_ids[]" value='.$cart_res_v[$i]['product_id'].'>'
                                        .'</tr>';
                        $sub_total += $cart_res_v[$i]['total'];
                    }
                    $output['data'].= '<tr>'
                                    .'<td>Shipping:</td>'
                                    .'<td>Free shipping</td>'
                                    .'</tr>'
                                    .'<tr class="summary-total">'
                                    .'<td>Total:</td>'
                                    .'<td>$'.$sub_total.'<input type="hidden" value="'.$sub_total.'" id="subtotal"></td>'
                                    .'</tr>';
                }
            }
			return $output;
        }
        //View Customer address in  checkout page
        public function customer_address(){
            $output=array();
            global $db;
            $s_val=array('is_delete'=>0,'id'=>$_SESSION['login_user_id']);
            $sql = 'SELECT id, email, mobile_number, `name`, `address` FROM '.DCKAP_USER.' WHERE 1 AND is_delete=:is_delete AND id=:id ';
			$res = $db->line($sql, $s_val);
            $output['name']=$res['name'];
            $output['mobile_number']=$res['mobile_number'];
            $output['address']=$res['address'];
            return $output;
        }
        //Add Order
        public function AddOrder()
		{
            global $db;
            $output=array();
            $s_val = array('is_delete' => 0, 'user_id'=> $_SESSION['login_user_id'], 'cart_status'=>0 );
            $cart_sql='SELECT id ,product_id FROM ' . DCKAP_CART . ' as a WHERE 1 AND a.is_delete=:is_delete AND a.user_id=:user_id AND a.cart_status=:cart_status'; 
			$cart_res = $db->qc($cart_sql, $s_val); 
            $cart_res_v = $cart_res[0]; 
			$cart_res_c = $cart_res[1];
            $prod_val=array(); 
            for ($i = 0; $i < $cart_res_c; $i++) {
                $prod_val[].=$cart_res_v[$i]['product_id'];
                $db->update(DCKAP_CART, array('cart_status' => 1), array('id' => $cart_res_v[$i]['id']));
            } 
            $prod_val_serialize=serialize($prod_val);
            $s_val = array('order_id' => 'ORD'.rand(),
            'user_id' => $_SESSION['login_user_id'],
            'product_details' => $prod_val_serialize,
            'Total_amount' => $_POST['total_amount'],
            'payment_type' => 1
            );
            if(!empty($s_val)){
                if ($db->insert(DCKAP_ORDER, $s_val)) {
                    $output['status']='0';
                    $output['messsage']='Your Order has Placed';
                    $output['val']='Success';
                }
            }
            return $output;
        }
        //Delete Product from cart
        public function DeleteCart()
		{
            global $db;
            if($db->update(DCKAP_CART, array('is_delete' => 1), array('id' => $_POST['cart_id']))){
                $output['status']='0';
                $output['messsage']='Product Removed from cart';
                $output['val']='Success';
            }
            return $output;
        }
        //View List of Order
        public function ViewOrder()
		{
            global $db;
            $outputData=array();
            $serach=$_REQUEST['search_customer'];
			$where='';
			$where.=($serach!='') ? " AND (b.`name` LIKE '%" .$serach."%' OR a.`order_id` LIKE  '%" .$serach."%' OR b.`address` LIKE '%" .$serach."%' OR a.`Total_amount` LIKE '%" .$serach. "%' )":"";
            if($_SESSION['login_user_type']==1){
                $where.='';
                $columns = array(0 => 'a.order_id', 1=> 'a.created_date',2 => 'b.name', 3 => 'b.address',4=>'a.Total_amount', 5 => 'a.payment_type');
            }else{
                $where.='AND a.user_id='.$_SESSION['login_user_id']; 
                $columns = array(0 => 'a.order_id', 1=> 'a.created_date' , 2=>'a.Total_amount', 3 => 'a.payment_type');
            }
			$s_val = array('is_delete' => 0);
            $sql_count = 'SELECT count(id) as count '
            . ' FROM '.DCKAP_USER. ' as a LEFT JOIN ' . DCKAP_USER .' as b ON user_id = b.id WHERE 1 AND is_delete=:is_delete '.$where;
			$res_total = $db->one($sql_count, $s_val);
			$sql = 'SELECT a.id, a.order_id, a.user_id, a.product_details, a.Total_amount, a.payment_type,b.name,b.address,DATE_FORMAT(a.created_date, "%m/%d/%Y") as order_date FROM '.DCKAP_ORDER.' as a LEFT JOIN ' . DCKAP_USER .' as b ON user_id = b.id WHERE 1 AND a.is_delete=:is_delete '.$where.' ORDER BY ' . $columns[$_REQUEST['order'][0]['column']] . ' ' . $_REQUEST['order'][0]['dir']
            . ' LIMIT ' . $_REQUEST['start'] . ', ' . (($_REQUEST['length']!='-1')? $_REQUEST['length']:$res_total);
			$res = $db->qc($sql, $s_val); 
			$res_v = $res[0];
			$res_c = $res[1];
			for($i=0;$i<$res_c;$i++){
                if($res_v[$i]['payment_type']==1){ $payment="COD"; }
                $nestedData=array(); 
				$nestedData[] = $res_v[$i]['order_id'];
                $nestedData[] = $res_v[$i]['order_date'];
                if($_SESSION['login_user_type']==1){
                    $nestedData[] = $res_v[$i]['name'];
                    $nestedData[] = $res_v[$i]['address'];
                }
                $nestedData[] = '$'.$res_v[$i]['Total_amount'];
                $nestedData[] = $payment;
                $outputData[] = $nestedData; 
			}
			$json_data = array("draw" => intval($_REQUEST['draw']),
            "recordsTotal" => intval($res_total),
            "recordsFiltered" => intval($res_total),
            "data" => $outputData);
			return $json_data;
        }
    }
?>