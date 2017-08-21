<?php

Class _productactionController Extends baseController {

    public function index() {
		
	}

    public function addproduct() {
		
		 $this->checkuser();
	
	      $picpath= $this->getpicpath( "assets/uploads/products/");
			$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
		$decoded_id=$this->registry->encryption->decode($id);
	
         $parameters_db=array();
		  $parameters=$this->registry->objects->addproduct();
		  foreach ($parameters as $parameter) {
          //  echo $parameter;
            //return;
            $json = json_decode($parameter);

            $key = $json->name;
            $$key =post($key);
			//echo $json->type . "  " . $key . " = " . $$key . ';<br>';
            if ($$key == "") {
                if (isset($json->requier)) {
                    echo "filed  $key  requier";
                    $isuccess = FALSE;
                    // return ;
                }
            } else {
                $data['name'] = $key;
                $data['value'] = $$key;
                $data['type'] = $json->type;
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
            }
        }
		
		if (  $picpath!=""){
		        $data['name'] = 'picpath';
                $data['value'] = $picpath ;
                $data['type'] = 'string';
                $jsondb = json_encode($data);
                array_push($parameters_db, $jsondb);
		}
	
		

	
	$product_id=$this->registry->encryption->decode(post('product_id'));
		
		if ($product_id>0){
			$this->registry->product->updateproduct($product_id,$decoded_id,$parameters_db);
		}else{
            	$id=	$this->registry->product->addproduct($decoded_id,$parameters_db);
	
	}
	
	}
	
	
		public function deleteproduct()
	{
	
    	 $this->checkuser();
	   $product_id=$this->registry->encryption->decode(post('product_id'));
	   
	   $this->registry->users->deleteproduct($product_id);
	   
	}
	
	
	}

?>
