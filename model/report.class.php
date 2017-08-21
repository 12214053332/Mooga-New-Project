<?php

class report extends db {
    /*     * * Declare instance ** */

	  
    public function __construct() {
 
	}

  //report
 public static function summary()
	 
	 {
	$query = "select (select count('x') from users where DATE_FORMAT (users.registerdate,'%d-%m-%Y')= DATE_FORMAT (NOW(),'%d-%m-%Y')) as users
,(select count('x') from projects where DATE_FORMAT (projects.createdtime,'%d-%m-%Y')= DATE_FORMAT (NOW(),'%d-%m-%Y') and  ifnull(deleted,0)=0)  as projects
,(select count('x') from offers where DATE_FORMAT (offers.createdtime,'%d-%m-%Y')= DATE_FORMAT (NOW(),'%d-%m-%Y') and  ifnull(deleted,0)=0)  as offers
,(select count('x') from opportunities where DATE_FORMAT (opportunities.createdtime,'%d-%m-%Y')= DATE_FORMAT (NOW(),'%d-%m-%Y')  and  ifnull(deleted,0)=0)as opportunities
,(select count('x') from users ) as allusers
,(select count('x') from projects )  as allprojects
,(select count('x') from projects where deleted=0 AND pending=0)  as allprojectsviewed
,(select count('x') from projects where deleted=1)  as deletedprojects
,(select count('x') from projects where pending=1 AND deleted=0)  as pendingprojects
,(select count('x') from offers)  as alloffers
,(select count('x') from offers where deleted=0 AND pending=0)  as alloffersviewed
,(select count('x') from offers where deleted=1)  as deletedoffers
,(select count('x') from offers where pending=1 AND deleted=0)  as pendingoffers
,(select count('x') from opportunities where ifnull(deleted,0)=0 )as allopportunities ";
		
			 $result=self::execquery($query);
			 if ($result) {
				
			       $obj = $result->fetch_object();
				
				
				   
			 }
         return  $obj;
		
       
	 }
	//AND delete=0
	public static function getProjectsDU(){
		//projects not duplicated and pending
		$query="select * from projects where pending=1 AND deleted=0";
		$result=self::execquery($query);
		$array=[
			'duplicated_active'=>0,
			'duplicated_active_data'=>[],
			'duplicated'=>0,
			'duplicated_data'=>[],
			'want_to_active'=>0,
			'want_to_active_data'=>[],
		];
		if ($result) {
			$ids=[];
			while($obj = $result->fetch_object()){
				$query="SELECT count(description) as count FROM `projects` WHERE pending=0 and deleted=0 and description=N'$obj->description'";
				$countResult=self::execquery($query);
				$count=$countResult->fetch_object();
				if($count->count>0){
					$array['duplicated_active']+=1;
					$array['duplicated_active_data'][]=$obj;
					$ids[]=$obj->id;
				}else{
					$query="SELECT COUNT(`description`) AS `count` FROM `projects` WHERE  deleted=0 and description=N'$obj->description' GROUP BY `description` HAVING  COUNT(`description`) > 1 ORDER BY COUNT(`description`) ASC";
					$countResult=self::execquery($query);
					while($count=$countResult->fetch_object()){
						if($count->count>1){
							$array['duplicated']+=1;
							$array['duplicated_data'][]=$obj;
							$ids[]=$obj->id;
						}
					}
				}
			}
			$idsS=implode("','",$ids);
			$query="select * from projects where pending=1 AND deleted=0 AND id NOT IN ('$idsS')";
			$result=self::execquery($query);
			while($data=$result->fetch_object()){
				$array['want_to_active']+=1;
				$array['want_to_active_data'][]=$data;
			}
		}
		$array['total']=$array['duplicated_active']+$array['duplicated'];
		return  (object)$array;
	}
	public static function getOffersDU(){
		//offers not duplicated and pending
		$query="select * from offers where pending=1 AND deleted=0";
		$result=self::execquery($query);
		$array=[
				'duplicated_active'=>0,
				'duplicated_active_data'=>[],
				'duplicated'=>0,
				'duplicated_data'=>[],
				'want_to_active'=>0,
				'want_to_active_data'=>[],
		];
		if ($result) {
			while($obj = $result->fetch_object()){
				$query="SELECT count(description) as count FROM `offers` WHERE pending=0 and deleted=0 and description=N'$obj->description'";
				$countResult=self::execquery($query);
				$count=$countResult->fetch_object();
				if($count->count>0){
					$array['duplicated_active']+=1;
					$array['duplicated_active_data'][]=$obj;
					$ids[]=$obj->id;
				}else{
					$query="SELECT COUNT(`description`) AS `count` FROM `offers` WHERE  deleted=0 and description=N'$obj->description' GROUP BY `description` HAVING  COUNT(`description`) > 1 ORDER BY COUNT(`description`) ASC";
					$countResult=self::execquery($query);
					while($count=$countResult->fetch_object()){
						if($count->count>1){
							$array['duplicated']+=1;
							$array['duplicated_data'][]=$obj;
							$ids[]=$obj->id;
						}
					}
				}
			}
			$idsS=implode("','",$ids);
			$query="select * from offers where pending=1 AND deleted=0 AND id NOT IN ('$idsS')";
			$result=self::execquery($query);
			while($data=$result->fetch_object()){
				$array['want_to_active']+=1;
				$array['want_to_active_data'][]=$data;
			}
		}
		$array['total']=$array['duplicated_active']+$array['duplicated'];
		return  (object)$array;
	}
		 	 public static function balance_spend()
	 
	 {
	//$query = "SELECT sum(`amount`) as sum ,type  FROM `show_owner_phone` group by type";
	$query = "SELECT sum(`amount`) as sum ,type  FROM `show_owner_phone` group by type";
			 $result=self::execquery($query);
			 if ($result) {
				 $balance=new StdClass();
			    while(   $obj = $result->fetch_object())
				{
					if ($obj->type=='artical')
					 $balance->artical=$obj->sum;
				 elseif ($obj->type=='opportunity')
					 $balance->opportunity=$obj->sum;
				 elseif ($obj->type=='project')
					 $balance->project=$obj->sum;
				 elseif ($obj->type=='user')
					 $balance->user=$obj->sum;
				 elseif ($obj->type=='offer')
					 $balance->offer=$obj->sum;
				}
			 }
         return  $balance;
	 }
	public function pointsCount($type,$cond='',$short=''){
		$resultData=[];
		if(in_array($type,['offer','project'])){
			switch($type){
				case 'offer':
					$query="SELECT count(`show_owner_phone`.`id`) as count,offers.* FROM `show_owner_phone` INNER JOIN offers ON offers.id=show_owner_phone.src_id WHERE show_owner_phone.type='$type' $cond GROUP BY show_owner_phone.src_id $short";
					break;
				case 'project':
					$query="SELECT count(`show_owner_phone`.`id`) as count,projects.* FROM `show_owner_phone` INNER JOIN projects ON projects.id=show_owner_phone.src_id WHERE show_owner_phone.type='$type' $cond GROUP BY show_owner_phone.src_id $short";
					break;
			}
			$result=self::execquery($query);
			while($obj=$result->fetch_object()){
				$resultData[]=$obj;
			}
		}
		return $resultData;
	}
	public function views($type,$cond='',$short=''){
		$resultData=[];
		if(in_array($type,['offer','project'])){
			switch($type){
				case 'offer':
					$query="SELECT count(`offer_views`.`id`) as count,offers.* FROM `offer_views` INNER JOIN offers ON offers.id=offer_views.offer_id  $cond GROUP BY offer_views.offer_id $short";
					break;
				case 'project':
					$query="SELECT count(`project_views`.`id`) as count,projects.* FROM `project_views` INNER JOIN projects ON projects.id=project_views.project_id  $cond GROUP BY project_views.project_id $short";
					break;
			}
			$result=self::execquery($query);
			while($obj=$result->fetch_object()){
				$resultData[]=$obj;
			}
		}
		return $resultData;
	}

    private function __clone() {
        
    }

    
    
}

/* * * end of class ** */
?>