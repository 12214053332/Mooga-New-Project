<?php

class articles extends db {
    /*     * * Declare instance ** */

    private static $success_message = "شكرا لتسجيلك فى موقع موجة";
    private static $emailexsist_message = "هذا البريد الإلكتروني موجود من قبل";
    private static $emailnotexsist_message = "خطأفى البريد الإلكترونى او كلمة المرور";
    private static $problem_message = "خطأ فى تسجيل البيانات";
	 private static $picpath = "assets/uploads/blog/";
	 
	 
	 	private static $artical_credit = 10;

	private static $artical_expired_after = 30;
    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */

    private  static $encryption;
	  private  static $sessionhandler2;
	  
    public function __construct() {
  /*** maybe set the db name here later ***/
  
  
	 self::$encryption=new Encryption();
	 self::$sessionhandler2=new SecureSessionHandler();
	}

	public static function getarticles_category($condition="") {
	
	 $allarticles_cat = array();
	 
        $query = "select * from articles_category   $condition";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
				$file= self::$picpath.$obj->picpath ;
   if (!file_exists($file)){$obj->picpath="none.png";}
                $element = array('id' => self::$encryption->encode($obj->id),
                    'name' => $obj->name,
					'picpath' => self::$picpath.$obj->picpath,
						);
                array_push($allarticles_cat, $element);
            }
        }
		
        return $allarticles_cat;
		
		
     
        
    }
	public static function getsingle_category_block($cat_id) {
	
	 $allarticles_cat = array();
        $query = "select * from articles_category  where id not in($cat_id) LIMIT 4";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
				$file= self::$picpath.$obj->picpath ;
                 if (!file_exists($file)){$obj->picpath="none.png";}
                $element = array('id' => self::$encryption->encode($obj->id) ,
                    'name' => $obj->name,
					'picpath' => self::$picpath.$obj->picpath,
						);
                array_push($allarticles_cat, $element);
            }
        }
		
        return $allarticles_cat;
		
        
    }
	public static function get_home_articles($limit=4) {
	
	 $allarticles = array();
        $query = "select * from articles  order by RAND( )   LIMIT $limit";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
				$file= self::$picpath.$obj->picpath ;
				
 if (!file_exists($file) || $obj->picpath==null ||$obj->picpath=="" ){ $obj->picpath="none.png";}
             // echo  self::$picpath.$obj->picpath ;
			if ($obj->public!=""){ $obj->description=$obj->public;}
				$element = array('id' => self::$encryption->encode($obj->id),
                    'name' => $obj->name,
					'picpath' => self::$picpath.$obj->picpath,
					'description' => $obj->description,
					'public' => $obj->public,
                                         'views' => $obj->views,
						);
                array_push($allarticles, $element);
            }
        }
		
        return $allarticles;
		
		
     
        
    }
	public static function getarticlesLimit_bycategoryid($cat_id,$condition="") {

		$allarticles = array();
		$query = "select  articles.*,articles_category.`name` as cat_name from articles inner join articles_category on articles.category_id=articles_category.id where category_id=$cat_id $condition ";
		//echo$query;
		$result = self::execquery($query);
		if ($result) {

			while ($obj = $result->fetch_object()) {
				$file= self::$picpath.$obj->picpath ;
				if ($obj->public!=""){ $obj->description=$obj->public;}
				if (!file_exists($file)){$obj->picpath="none.png";}
				$element = array('id' => $obj->id,
						'name' => $obj->name,
						'description' => $obj->description,
						'picpath' => self::$picpath.$obj->picpath,
						'category_id' => $obj->category_id,
						'article_date'=> $obj->article_date,
						'views'=> $obj->views,
						'cat_name'=>$obj->cat_name,
				);
				array_push($allarticles, $element);
			}
		}

		return $allarticles;




	}
	public static function getarticles_bycategoryid($cat_id) {
	
	 $allarticles = array();
        $query = "select  articles.*,articles_category.`name` as cat_name from articles inner join articles_category on articles.category_id=articles_category.id where category_id=$cat_id  order by id  desc ";
		
        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {
					$file= self::$picpath.$obj->picpath ;
					if ($obj->public!=""){ $obj->description=$obj->public;}
 if (!file_exists($file)){$obj->picpath="none.png";}
                $element = array('id' => $obj->id,
                    'name' => $obj->name,
					'description' => $obj->description,
					'picpath' => self::$picpath.$obj->picpath,
					'category_id' => $obj->category_id,
					'article_date'=> $obj->article_date,
					'views'=> $obj->views,
					'cat_name'=>$obj->cat_name,
				);
                array_push($allarticles, $element);
            }
        }
		
        return $allarticles;
		
		
     
        
    }
    public static function getarticle_byid($article_id,$type=0) {
     
        $article_data = array();
       
		
        $query = "select articles.*,author.name as author_name,author.email,author.country from articles inner join author on articles.author_id=author.id where articles.id=$article_id";
      
	  
        $result = self::execquery($query);
        if ($result) {
           
            $obj = $result->fetch_object();
	$file= self::$picpath.$obj->picpath ;
	
             if (!file_exists($file)){$obj->picpath="none.png";}
			 $obj->picpath =self::$picpath.$obj->picpath;
			 if ($obj->public!="" and $type!=1){ $obj->description=$obj->public;}
			 $facebook=new StdClass();
			$facebook->image=$obj->picpath;
             $obj->facebook=$facebook;
			$obj->id =self::$encryption->encode($obj->id);
         $article_data = array('id' => $obj->id,
                'name' => $obj->name,
                'description' => $obj->description,
                'picpath' => self::$picpath.$obj->picpath,
                'category_id' => $obj->category_id,
				'article_date' => $obj->article_date,
				'author_name' => $obj->author_name,
				'email' => $obj->email,
				'country' => $obj->country,
              );
			   self::addarticalviewlog($article_id);
			  self::getarticalownerphone( $obj->id);
        }

     
        return $obj;
    }
	
	
	
		public static function  addownerphonelog($src_user_id,$user_id,$type)
		{ 
		
		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$src_user_id and user_id=$myuser_id and expiredate>=NOW() and type='$type'";
			 
//echo  $query;
		
			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					  //echo $myuser_id;
			           if ($src_user_id!=$myuser_id){
					
						   $user_expired_after= self::$artical_expired_after;
						   $user_credit =self::$artical_credit;
						   
						  
					      $query = "insert into show_owner_phone set src_id=$src_user_id ,user_id=$myuser_id ,type='$type',amount='$user_credit',expiredate=DATE_ADD(NOW(),INTERVAL $user_expired_after DAY)";
						 
			              $result=self::execquery($query);
						 
						   self::updateuserbalance($myuser_id,-1*$user_credit);
						 }
				   }
				   
			 }
		
		}
		
		
	public static function getarticalownerphone($artical_id)
	{
		   global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			
			
				   self::addownerphonelog($artical_id,$myuser_id,'artical');
				   
					
	}

	 	 public static function updateuserbalance($user_id,$balance)
	 
	 {
	

                    //update
					$query = " update users set balance=ifnull(balance,0)+$balance  where id=$user_id";
              
       // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;
		
       
	 }
	
	
	
	public static function  addarticalviewlog($src_id)
		{ 
		
		global $useridstr;
			$user_id=self::$sessionhandler2->get($useridstr);
			 $user_id=self::$encryption->decode($user_id);
			 $query = "select Count(src_id) as count_1  from artical_views where  src_id=$src_id and user_id=$user_id ";
			 //echo $query;
                self::updatearticalviews($src_id);

			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0){
					  
			 
					    $query = "insert into artical_views set src_id=$src_id ,user_id=$user_id";

			             $result=self::execquery($query);
						   //self::updatearticalviews($src_id);
				   }
				   
			 }
		
		}
		
		
			public static function  updatearticalviews($src_id)
		{
			
			 $query = "update articles set views=ifnull(views,0)+1 where  id=$src_id";
			 	//echo $query;
              self::execquery($query);
		
		
		}
		
	
    private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>