<?php

Abstract Class baseController {
	/*
     * @registry object
     */
	protected $registry;
	function __construct($registry) {
		// error_reporting(0);
		$this->registry = $registry;
		$currentsource=$this->registry->sessionhandler->get('currentlink');
		if ( $currentsource==""){
			$currentsource="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->registry->sessionhandler->put('currentlink',$currentsource);
		}
		//echo $currentsource;
		$this->registry->template->currentpage=get('page');
		$userlink=  get('user');
		$helper =$this->registry->objects;
		$footer_blog_category =$this->registry->articles->getarticles_category(' limit 6');
		$this->registry->template->footer_blog_category= $footer_blog_category;
		$this->registry->template->helper= $helper;
		if ($userlink>0){$this->registry->sessionhandler->put( $this->registry->useridstr,$userlink);}
		if (self::getuserid()>0){
			$this->registry->template->IsLogin=TRUE;
			$this->registry->template->getuserid=$this->registry->encryption->encode(self::getuserid());
			self::initialdata();

		}
		else {
			$this->registry->template->IsLogin=FALSE;
		}
	}
	protected function isRequest($type){
		return(isset($_SERVER['REQUEST_METHOD'])&&$_SERVER['REQUEST_METHOD']==strtoupper($type))?true:false;
	}
	protected function isAjax(){
		return(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')?true:false;
	}
	protected function validCSF(){
		return (isset($_SESSION['tokenNumber'],$_POST['_token'])&&$_SESSION['tokenNumber']==$_POST['_token']&&(time() - $_SESSION['tokenNumberTime'])<= 300)?true:false;
	}
	public function getuserid()
	{
		$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
		$profileid=$this->registry->encryption->decode($id);

		return $profileid;
	}
	public function initialdata()
	{
		$id=$this->registry->sessionhandler->get( $this->registry->useridstr);
		$profileid=$this->registry->encryption->decode($id);
		//echo 'profile_id' . $profileid;
		$user_id=$profileid;
		$result =$this->registry->users->getuserdetails($user_id);
		$this->registry->template->user= $result;
		$this->registry->template->messagecount=$this->registry->message->get_count_message($user_id);
	}

	public  function checkuser()
	{
		if (self::getuserid()>0){
			self::initialdata();}
		else {
			$currentpage=$this->registry->template->currentpage=get('page');
			if ($currentpage!='index'&&$currentpage!=''&&$currentpage!='contact'
					&&$currentpage!='faqs'&&$currentpage!='about' &&$currentpage!='fb'    )
				header('Location:?page=login');
		}
	}
	function merge_json_array($arr1,$arr2)
	{
		if (!is_array(json_decode($arr1, true))){$arr1="[]";}if (!is_array(json_decode($arr2, true))){$arr2="[]";}
		$merage=array_merge(json_decode($arr1, true),json_decode($arr2, true));
		$uniq = json_encode(array_unique($merage));
		return $uniq;
	}
	function fix_search($value)
	{
		if($value=="" || $value==null || $value=='null')
		{
			return "";
		}
		else
		{
			$value= str_replace('["','"%',$value);
			$value= str_replace('"]','%"',$value);
			$value= str_replace('","','%" or "%',$value);
			return $value;
		}

	}
	public function getpicpath( $target_dir)
	{
		$fullname=$_FILES["fileToUpload"]["name"];
		$fullname=trim($fullname);
		$fullname=  str_replace(" ","_", $fullname);
		$target_file = $target_dir .  $fullname;
		$filearray=0;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$filename = pathinfo($target_file,PATHINFO_FILENAME);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"]) && $fullname!="") {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
			xx:if (file_exists($target_file)) {

				$filearray++;
				$target_file = $target_dir . $filename . "($filearray)." . $imageFileType  ;
				goto xx;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 2097152) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				//echo $target_file;
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					//  echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					// echo "Sorry, there was an error uploading your file.";
				}
			}
		}
		if ($fullname=="")$target_file="";

		/*	if ($fullname!="")
            {
            $path=	$host.$cv;
            }*/
		return $target_file;
	}
	/**
	 * @all controllers must contain an index method
	 */
	abstract function index();
}
function getviewslink()
{
	return 'views';
}
function check_input($value)
{
	// Stripslashes
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	// Quote if not a number

	return $value;
}
function get($key)
{
	$value="";
	// Stripslashes
	if (isset($_GET[$key]))
	{
		$value = stripslashes($_GET[$key]);
	}
	// Quote if not a number

	return $value;
}
function post($key)
{
	$value="";
	// Stripslashes
	if (isset($_POST[$key]))
	{
		$value = stripslashes($_POST[$key]);
	}
	// Quote if not a number

	return $value;
}


