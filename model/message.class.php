<?php

class message extends db {
    /*     * * Declare instance ** */

    private static $success_message = "تم ارسال الرساله بنجاح";
    private static $emailexsist_message = "this email exist before";
	private static $project_credit = 1;
	private static $user_credit = 1;
	private static $opportunity_credit = 1;
	private static $message_credit = 1;

	private static $user_expired_after = 30;
		private static $project_expired_after = 30;
			private static $opportunity_expired_after = 30;
			private static $message_expired_after = 30;

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */
      private  static $encryption;
	    private  static $sessionhandler2;


    public function __construct() {
        /*         * * maybe set the db name here later ** */
        self::$encryption=new Encryption();
			 self::$sessionhandler2=new SecureSessionHandler();
    }

    /**
     *
     * Return DB instance or create intitial connection
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
    public static function get_inbox_message($userid) {
        $leadsmessagelist = array();
        $query = "SELECT users.profilepic,inbox_msg.id,inbox_msg.user1_id,users.name 
                    ,inbox_msg.title,inbox_msg.message,inbox_msg.readmsg,inbox_msg.msgtime,inbox_msg.msg_id_reply
                     FROM inbox_msg 
                    Inner Join users ON inbox_msg.user1_id = users.id 
                    where inbox_msg.user2_id =$userid  and inbox_msg.archive=0 order by inbox_msg.id ";

//die($query);
        $result = self::execquery($query);
        $element=[];
        $ids=[];
        if ($result) {

            while ($obj = $result->fetch_object()) {
                $count=0;
                $readmsg=$obj->readmsg;
                $query="SELECT (select COUNT(id) FROM inbox_msg WHERE msg_id_reply='$obj->id') as countall,COUNT(id) as count,SUM(readmsg) AS readmsg FROM inbox_msg WHERE msg_id_reply='$obj->id' AND user2_id=$userid";
                //echo$query.'<br>==<br>';
                $countResult = self::execquery($query);
                $mesgCount=$countResult->fetch_object();
                $count+=$mesgCount->countall;
                $readmsg=($mesgCount->count!=$mesgCount->readmsg&&$mesgCount->readmsg!=NULL&&$readmsg=1)?0:$readmsg;
                if($obj->msg_id_reply!=0){
                    $query="SELECT (select COUNT(id) FROM inbox_msg WHERE msg_id_reply='$obj->msg_id_reply') as countall, COUNT(id) as count,SUM(readmsg) AS readmsg FROM inbox_msg WHERE msg_id_reply='$obj->msg_id_reply'  AND user2_id=$userid";
                    //echo$query.'<br><br>';
                    $countResult = self::execquery($query);
                    $msgRCount=$countResult->fetch_object();
                    $count+=$msgRCount->countall;
                    $readmsg=($msgRCount->count!=$msgRCount->readmsg&&$mesgCount->readmsg!=NULL&&$readmsg=1)?0:$readmsg;
                }
                if($obj->msg_id_reply!=0&&(in_array($obj->id,$ids)||in_array($obj->msg_id_reply,$ids))){continue;}
                $ids[]=$obj->id;
                if($obj->msg_id_reply!=0){$ids[]=$obj->msg_id_reply;}
                $element []=[
                    'id' => ($obj->msg_id_reply==0)?self::$encryption->encode($obj->id):self::$encryption->encode($obj->msg_id_reply),
                    'user1_id' => self::$encryption->encode( $obj->user1_id),
                    'name' => $obj->name,
                    'title' => $obj->title,
                    'message' => $obj->message,
                    'msgtime' => $obj->msgtime,
                    'readmsg' => $readmsg,
                    'profilepic' => $obj->profilepic,
                    'msg_id_reply'=>$obj->msg_id_reply,
                    'related'=>$count
                ];
            }
        }

        return $element;
    }
    public static function get_sent_message($userid) {

        $messagelist = array();
        $query = "SELECT users.profilepic,inbox_msg.id,inbox_msg.user1_id,inbox_msg.user2_id,users.name
                    ,inbox_msg.title,inbox_msg.message,inbox_msg.readmsg,inbox_msg.msgtime,inbox_msg.msg_id_reply
                     FROM inbox_msg
                    Inner Join users ON inbox_msg.user2_id = users.id
                    where inbox_msg.user1_id =$userid  and msg_id_reply=0 and inbox_msg.archive=0 order by inbox_msg.id ";

//die($query);
        $result = self::execquery($query);
        $element=[];
        $ids=[];
        if ($result) {
            while ($obj = $result->fetch_object()) {
                $count=0;
                $readmsg=$obj->readmsg;
                $query="SELECT (select COUNT(id) FROM inbox_msg WHERE msg_id_reply='$obj->id') as countall,COUNT(id) as count,SUM(readmsg) AS readmsg FROM inbox_msg WHERE msg_id_reply='$obj->id' AND user2_id=$userid";
                //echo$query.'==';
                $countResult = self::execquery($query);
                $mesgCount=$countResult->fetch_object();
                $count+=$mesgCount->countall;
                $readmsg=($mesgCount->count!=$mesgCount->readmsg&&$mesgCount->readmsg!=NULL&&$readmsg=1)?0:$readmsg;
                if($obj->msg_id_reply!=0){
                    $query="SELECT (select COUNT(id) FROM inbox_msg WHERE msg_id_reply='$obj->msg_id_reply') as countall, COUNT(id) as count,SUM(readmsg) AS readmsg FROM inbox_msg WHERE msg_id_reply='$obj->msg_id_reply'  AND user2_id=$userid";
                    //echo$query.'<br>';
                    $countResult = self::execquery($query);
                    $msgRCount=$countResult->fetch_object();
                    $count+=$msgRCount->countall;
                    $readmsg=($msgRCount->count!=$msgRCount->readmsg&&$mesgCount->readmsg!=NULL&&$readmsg=1)?0:$readmsg;
                }
                if($obj->msg_id_reply!=0&&(in_array($obj->id,$ids)||in_array($obj->msg_id_reply,$ids))){continue;}
                $ids[]=$obj->id;
                if($obj->msg_id_reply!=0){$ids[]=$obj->msg_id_reply;}
                $element[]= array('id' => self::$encryption->encode($obj->id),
                    'user1_id' => self::$encryption->encode( $obj->user1_id),
                    'name' => $obj->name,
                    'title' => $obj->title,
                    'message' => $obj->message,
                    'msgtime' => $obj->msgtime,
                    'readmsg' => $readmsg,
                    'profilepic' => $obj->profilepic,
                    'msg_id_reply'=>$obj->msg_id_reply,
                    'related'=>$count
                );
            }
        }

        return $element;

    }


	    public static function get_message_byid($id) {

        $userid=$id;

        $messagelist = array();
        $query = "SELECT inbox_msg.*,users.profilepic,user2.profilepic as profilepic2 FROM inbox_msg inner join users on user1_id=users.id
		inner join users as user2 on user2_id=user2.id
                      where inbox_msg.id= $id
                     ";
					// die($query );
       $obj ="";
        $result = self::execquery($query);
        if ($result) {

           $obj = $result->fetch_object();

             $obj->user1_id=self::$encryption->encode($obj->user1_id);
			  $obj->user2_id=self::$encryption->encode($obj->user2_id); $obj->id=self::$encryption->encode($obj->id);

			 self::set_message_read($id);
        }


        return $obj;
    }

       public static function get_user($id) {

        $query = "SELECT * FROM users
                      where id= $id
                     ";
       $obj ="";
        $result = self::execquery($query);
        if ($result) {

           $obj = $result->fetch_object();
		   $obj->id=  self::$encryption->encode($obj->id);

        }

        return $obj;
    }

    public static function get_inbox_msg_byid($id,$userID=0) {

        $userid=$id;

        $messagelist = array();
        $query = "SELECT users.profilepic, inbox_msg.id,inbox_msg.user1_id,users.name
                    ,inbox_msg.title,inbox_msg.message,inbox_msg.readmsg,inbox_msg.msgtime
                    ,inbox_msg.msg_id_reply,inbox_msg.user2_id
                     FROM inbox_msg
                    Inner Join users ON inbox_msg.user1_id = users.id

                     where inbox_msg.id=$userid
                     and inbox_msg.archive=0 
                    UNION
                    SELECT users.profilepic,inbox_msg.id,inbox_msg.user1_id,users.name  
                    ,inbox_msg.title,inbox_msg.message,inbox_msg.readmsg,inbox_msg.msgtime,inbox_msg.msg_id_reply,inbox_msg.user2_id
                     FROM inbox_msg 
                    Inner Join users ON inbox_msg.user1_id = users.id 

                   where inbox_msg.msg_id_reply=$userid
                     and inbox_msg.archive=0 
                    ORDER BY msgtime desc 
                     ";
//die($query);
        $result = self::execquery($query);
        if ($result) {
            while ($obj = $result->fetch_object()) {
                if($obj->user2_id==$userID){
                    self::set_message_read($obj->id);
                }
                $element = array('id' =>self::$encryption->encode( $obj->id),
                    'user1_id' => self::$encryption->encode( $obj->user1_id),
                    'user2_id' => self::$encryption->encode( $obj->user2_id),
                    'name' => $obj->name,
                    'title' => $obj->title,
                    'message' => $obj->message,
                    'msgtime' => $obj->msgtime,
                    'readmsg' => $obj->readmsg,
                    'profilepic' => $obj->profilepic,
                    'msg_id_reply' => $obj->msg_id_reply,

                );
                array_push($messagelist, $element);
            }
        }

        return $messagelist;
    }



    public static function get_archive_message($userid) {
        $leadsmessagelist = array();
        $query = "SELECT inbox_msg.id,inbox_msg.user1_id,users.name 
                    ,inbox_msg.title,inbox_msg.message,inbox_msg.readmsg,inbox_msg.msgtime
                     FROM inbox_msg 
                    Inner Join users ON inbox_msg.user1_id = users.id 
                    where inbox_msg.user2_id =$userid  and inbox_msg.archive=1 order by inbox_msg.id ";


        $result = self::execquery($query);
        if ($result) {

            while ($obj = $result->fetch_object()) {

                $element = array('id' => self::$encryption->encode( $obj->id),
                    'user1_id' => self::$encryption->encode( $obj->user1_id),
                    'name' => $obj->name,
                    'title' => $obj->title,
                    'message' => $obj->message,
                    'msgtime' => $obj->msgtime,
                    'readmsg' => $obj->readmsg
                );
                array_push($leadsmessagelist, $element);
            }
        }

        return $leadsmessagelist;
    }


    public static function addmessage($parameters) {
        $keys = "";
        $values = "";
		$msg_id_reply=0;
		$user2_id=0;
		$user1_id=0;
        foreach ($parameters as $parameter) {
            //echo $parameter;

            $json = json_decode($parameter);
            $key = $json->name;
            $value = $json->value;
            $type = $json->type;
            $keys = $keys . $key . ',';

             if ($key=='msg_id_reply'){$msg_id_reply=$value;}
            if ($key=='user2_id'){$user2_id=$value;}
			if ($key=='user1_id'){$user1_id=$value;}
			if ($type == 'string') {

                $values = $values . "'$value'" . ',';
            } else {
                $values = $values . $value . ',';
            }
        }
        $query = "insert into inbox_msg (" . substr($keys, 0, -1) . ')' .
                " Values (" . substr($values, 0, -1) . ")";
//echo $query;
        $id = self::execquery_id($query);
		//if ($msg_id_reply!=0){self::set_message_unread($msg_id_reply);}
      $errorMessage= self::$success_message;
      include_once 'views/message/success_message.php';
          self::addownerphonelog($user2_id,$user1_id,'message');
		return $id;
    }

   public static function get_count_message($user1_id) {

        $query = "select count(id) as countmsg from inbox_msg where user2_id=$user1_id and readmsg=0 ";

        $messagecount=0;
        $result = self::execquery($query);
        if ($result) {

           $obj = $result->fetch_object();

             $messagecount= $obj->countmsg ;

            }


        return $messagecount;

    }


	   public static function set_message_read($message_id) {

        $query = "update inbox_msg set readmsg=1 where id=$message_id";

        $messagecount=0;
        self::execquery($query);


    }
		   public static function set_message_unread($message_id) {

        $query = "update inbox_msg set readmsg=0 where id=$message_id";

        $messagecount=0;
        self::execquery($query);


    }




	public static function  addownerphonelog($src_user_id,$user_id,$type)
		{

		global $useridstr;
			$myuser_id=self::$sessionhandler2->get($useridstr);
			 $myuser_id=self::$encryption->decode($myuser_id);
			 $query = "select Count(src_id) as count_1  from show_owner_phone where  src_id=$src_user_id and user_id=$myuser_id and expiredate>=NOW() and type='$type'";



			 $result=self::execquery($query);
			 if ($result) {
			       $obj = $result->fetch_object();
				   if ( $obj->count_1==0 || $type=='message'){
					  //echo $myuser_id;
			           if ($src_user_id!=$myuser_id){
						   if ($type=='project'){
						   $user_expired_after= self::$project_expired_after;
						  $user_credit =self::$project_credit;
						   }
					      elseif($type=='user'){
						   $user_expired_after= self::$user_expired_after;
						   $user_credit =self::$user_credit;
						   }
						  elseif($type=='opportunity'){
						    $user_expired_after= self::$opportunity_expired_after;
						    $user_credit =self::$opportunity_credit;
						   }
						   elseif($type=='message'){
						    $user_expired_after= self::$message_expired_after;
						    $user_credit =self::$message_credit;
						   }

					      $query = "insert into show_owner_phone set src_id=$src_user_id ,user_id=$myuser_id ,type='$type',amount='$user_credit',expiredate=DATE_ADD(NOW(),INTERVAL $user_expired_after DAY)";

			              $result=self::execquery($query);

						   self::updateuserbalance($myuser_id,-1*$user_credit);
						 }
				   }

			 }

		}


	 	 public static function updateuserbalance($user_id,$balance)

	 {


                    //update
					$query = " update users set balance=ifnull(balance,0)+$balance  where id=$user_id";

       // echo $query ;
		$result = self::execquery($query);
		//echo self::$success_message;


	 }


    private function __clone() {

    }

}

/* * * end of class ** */
?>
