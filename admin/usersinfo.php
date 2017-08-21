<?php

// Global variable for table object
$users = NULL;

//
// Table class for users
//
class cusers extends cTable {
	var $id;
	var $name;
	var $_email;
	var $password;
	var $companyname;
	var $servicetime;
	var $country;
	var $phone;
	var $skype;
	var $website;
	var $linkedin;
	var $facebook;
	var $twitter;
	var $active_code;
	var $identification;
	var $link_expired;
	var $isactive;
	var $pio;
	var $google;
	var $instagram;
	var $account_type;
	var $logo;
	var $profilepic;
	var $mailref;
	var $deleted;
	var $deletefeedback;
	var $account_id;
	var $start_date;
	var $end_date;
	var $year_moth;
	var $registerdate;
	var $login_type;
	var $accountstatus;
	var $ispay;
	var $profilelink;
	var $source;
	var $agree;
	var $balance;
	var $job_title;
	var $projects;
	var $opportunities;
	var $isconsaltant;
	var $isagent;
	var $isinvestor;
	var $isbusinessman;
	var $isprovider;
	var $isproductowner;
	var $states;
	var $cities;
	var $offers;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'users';
		$this->TableName = 'users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`users`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('users', 'users', 'x_id', 'id', '`id`', '`id`', 20, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// name
		$this->name = new cField('users', 'users', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['name'] = &$this->name;

		// email
		$this->_email = new cField('users', 'users', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['email'] = &$this->_email;

		// password
		$this->password = new cField('users', 'users', 'x_password', 'password', '`password`', '`password`', 200, -1, FALSE, '`password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['password'] = &$this->password;

		// companyname
		$this->companyname = new cField('users', 'users', 'x_companyname', 'companyname', '`companyname`', '`companyname`', 200, -1, FALSE, '`companyname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['companyname'] = &$this->companyname;

		// servicetime
		$this->servicetime = new cField('users', 'users', 'x_servicetime', 'servicetime', '`servicetime`', '`servicetime`', 200, -1, FALSE, '`servicetime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['servicetime'] = &$this->servicetime;

		// country
		$this->country = new cField('users', 'users', 'x_country', 'country', '`country`', '`country`', 200, -1, FALSE, '`country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['country'] = &$this->country;

		// phone
		$this->phone = new cField('users', 'users', 'x_phone', 'phone', '`phone`', '`phone`', 200, -1, FALSE, '`phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['phone'] = &$this->phone;

		// skype
		$this->skype = new cField('users', 'users', 'x_skype', 'skype', '`skype`', '`skype`', 200, -1, FALSE, '`skype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['skype'] = &$this->skype;

		// website
		$this->website = new cField('users', 'users', 'x_website', 'website', '`website`', '`website`', 200, -1, FALSE, '`website`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['website'] = &$this->website;

		// linkedin
		$this->linkedin = new cField('users', 'users', 'x_linkedin', 'linkedin', '`linkedin`', '`linkedin`', 200, -1, FALSE, '`linkedin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['linkedin'] = &$this->linkedin;

		// facebook
		$this->facebook = new cField('users', 'users', 'x_facebook', 'facebook', '`facebook`', '`facebook`', 200, -1, FALSE, '`facebook`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['facebook'] = &$this->facebook;

		// twitter
		$this->twitter = new cField('users', 'users', 'x_twitter', 'twitter', '`twitter`', '`twitter`', 200, -1, FALSE, '`twitter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['twitter'] = &$this->twitter;

		// active_code
		$this->active_code = new cField('users', 'users', 'x_active_code', 'active_code', '`active_code`', '`active_code`', 200, -1, FALSE, '`active_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['active_code'] = &$this->active_code;

		// identification
		$this->identification = new cField('users', 'users', 'x_identification', 'identification', '`identification`', '`identification`', 3, -1, FALSE, '`identification`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->identification->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['identification'] = &$this->identification;

		// link_expired
		$this->link_expired = new cField('users', 'users', 'x_link_expired', 'link_expired', '`link_expired`', 'DATE_FORMAT(`link_expired`, \'%Y/%m/%d\')', 135, 5, FALSE, '`link_expired`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->link_expired->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['link_expired'] = &$this->link_expired;

		// isactive
		$this->isactive = new cField('users', 'users', 'x_isactive', 'isactive', '`isactive`', '`isactive`', 3, -1, FALSE, '`isactive`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->isactive->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isactive'] = &$this->isactive;

		// pio
		$this->pio = new cField('users', 'users', 'x_pio', 'pio', '`pio`', '`pio`', 201, -1, FALSE, '`pio`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['pio'] = &$this->pio;

		// google
		$this->google = new cField('users', 'users', 'x_google', 'google', '`google`', '`google`', 200, -1, FALSE, '`google`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['google'] = &$this->google;

		// instagram
		$this->instagram = new cField('users', 'users', 'x_instagram', 'instagram', '`instagram`', '`instagram`', 200, -1, FALSE, '`instagram`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['instagram'] = &$this->instagram;

		// account_type
		$this->account_type = new cField('users', 'users', 'x_account_type', 'account_type', '`account_type`', '`account_type`', 200, -1, FALSE, '`account_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['account_type'] = &$this->account_type;

		// logo
		$this->logo = new cField('users', 'users', 'x_logo', 'logo', '`logo`', '`logo`', 200, -1, FALSE, '`logo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['logo'] = &$this->logo;

		// profilepic
		$this->profilepic = new cField('users', 'users', 'x_profilepic', 'profilepic', '`profilepic`', '`profilepic`', 200, -1, FALSE, '`profilepic`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['profilepic'] = &$this->profilepic;

		// mailref
		$this->mailref = new cField('users', 'users', 'x_mailref', 'mailref', '`mailref`', '`mailref`', 200, -1, FALSE, '`mailref`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['mailref'] = &$this->mailref;

		// deleted
		$this->deleted = new cField('users', 'users', 'x_deleted', 'deleted', '`deleted`', '`deleted`', 3, -1, FALSE, '`deleted`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->deleted->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['deleted'] = &$this->deleted;

		// deletefeedback
		$this->deletefeedback = new cField('users', 'users', 'x_deletefeedback', 'deletefeedback', '`deletefeedback`', '`deletefeedback`', 200, -1, FALSE, '`deletefeedback`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['deletefeedback'] = &$this->deletefeedback;

		// account_id
		$this->account_id = new cField('users', 'users', 'x_account_id', 'account_id', '`account_id`', '`account_id`', 20, -1, FALSE, '`account_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->account_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['account_id'] = &$this->account_id;

		// start_date
		$this->start_date = new cField('users', 'users', 'x_start_date', 'start_date', '`start_date`', 'DATE_FORMAT(`start_date`, \'%Y/%m/%d\')', 135, 5, FALSE, '`start_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->start_date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['start_date'] = &$this->start_date;

		// end_date
		$this->end_date = new cField('users', 'users', 'x_end_date', 'end_date', '`end_date`', 'DATE_FORMAT(`end_date`, \'%Y/%m/%d\')', 135, 5, FALSE, '`end_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->end_date->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['end_date'] = &$this->end_date;

		// year_moth
		$this->year_moth = new cField('users', 'users', 'x_year_moth', 'year_moth', '`year_moth`', '`year_moth`', 200, -1, FALSE, '`year_moth`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['year_moth'] = &$this->year_moth;

		// registerdate
		$this->registerdate = new cField('users', 'users', 'x_registerdate', 'registerdate', '`registerdate`', 'DATE_FORMAT(`registerdate`, \'%Y/%m/%d\')', 135, 5, FALSE, '`registerdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->registerdate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['registerdate'] = &$this->registerdate;

		// login_type
		$this->login_type = new cField('users', 'users', 'x_login_type', 'login_type', '`login_type`', '`login_type`', 200, -1, FALSE, '`login_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['login_type'] = &$this->login_type;

		// accountstatus
		$this->accountstatus = new cField('users', 'users', 'x_accountstatus', 'accountstatus', '`accountstatus`', '`accountstatus`', 200, -1, FALSE, '`accountstatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['accountstatus'] = &$this->accountstatus;

		// ispay
		$this->ispay = new cField('users', 'users', 'x_ispay', 'ispay', '`ispay`', '`ispay`', 3, -1, FALSE, '`ispay`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->ispay->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ispay'] = &$this->ispay;

		// profilelink
		$this->profilelink = new cField('users', 'users', 'x_profilelink', 'profilelink', '`profilelink`', '`profilelink`', 200, -1, FALSE, '`profilelink`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['profilelink'] = &$this->profilelink;

		// source
		$this->source = new cField('users', 'users', 'x_source', 'source', '`source`', '`source`', 200, -1, FALSE, '`source`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['source'] = &$this->source;

		// agree
		$this->agree = new cField('users', 'users', 'x_agree', 'agree', '`agree`', '`agree`', 200, -1, FALSE, '`agree`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->fields['agree'] = &$this->agree;

		// balance
		$this->balance = new cField('users', 'users', 'x_balance', 'balance', '`balance`', '`balance`', 20, -1, FALSE, '`balance`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->balance->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['balance'] = &$this->balance;

		// job_title
		$this->job_title = new cField('users', 'users', 'x_job_title', 'job_title', '`job_title`', '`job_title`', 200, -1, FALSE, '`job_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['job_title'] = &$this->job_title;

		// projects
		$this->projects = new cField('users', 'users', 'x_projects', 'projects', '`projects`', '`projects`', 3, -1, FALSE, '`projects`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->projects->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['projects'] = &$this->projects;

		// opportunities
		$this->opportunities = new cField('users', 'users', 'x_opportunities', 'opportunities', '`opportunities`', '`opportunities`', 3, -1, FALSE, '`opportunities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->opportunities->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['opportunities'] = &$this->opportunities;

		// isconsaltant
		$this->isconsaltant = new cField('users', 'users', 'x_isconsaltant', 'isconsaltant', '`isconsaltant`', '`isconsaltant`', 3, -1, FALSE, '`isconsaltant`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isconsaltant->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isconsaltant'] = &$this->isconsaltant;

		// isagent
		$this->isagent = new cField('users', 'users', 'x_isagent', 'isagent', '`isagent`', '`isagent`', 3, -1, FALSE, '`isagent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isagent->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isagent'] = &$this->isagent;

		// isinvestor
		$this->isinvestor = new cField('users', 'users', 'x_isinvestor', 'isinvestor', '`isinvestor`', '`isinvestor`', 3, -1, FALSE, '`isinvestor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isinvestor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isinvestor'] = &$this->isinvestor;

		// isbusinessman
		$this->isbusinessman = new cField('users', 'users', 'x_isbusinessman', 'isbusinessman', '`isbusinessman`', '`isbusinessman`', 3, -1, FALSE, '`isbusinessman`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isbusinessman->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isbusinessman'] = &$this->isbusinessman;

		// isprovider
		$this->isprovider = new cField('users', 'users', 'x_isprovider', 'isprovider', '`isprovider`', '`isprovider`', 3, -1, FALSE, '`isprovider`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isprovider->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isprovider'] = &$this->isprovider;

		// isproductowner
		$this->isproductowner = new cField('users', 'users', 'x_isproductowner', 'isproductowner', '`isproductowner`', '`isproductowner`', 3, -1, FALSE, '`isproductowner`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->isproductowner->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isproductowner'] = &$this->isproductowner;

		// states
		$this->states = new cField('users', 'users', 'x_states', 'states', '`states`', '`states`', 200, -1, FALSE, '`states`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['states'] = &$this->states;

		// cities
		$this->cities = new cField('users', 'users', 'x_cities', 'cities', '`cities`', '`cities`', 200, -1, FALSE, '`cities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['cities'] = &$this->cities;

		// offers
		$this->offers = new cField('users', 'users', 'x_offers', 'offers', '`offers`', '`offers`', 3, -1, FALSE, '`offers`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->offers->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['offers'] = &$this->offers;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`users`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("usersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("usersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["id"]) : ew_StripSlashes(@$_GET["id"]); // id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->password->setDbValue($rs->fields('password'));
		$this->companyname->setDbValue($rs->fields('companyname'));
		$this->servicetime->setDbValue($rs->fields('servicetime'));
		$this->country->setDbValue($rs->fields('country'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->skype->setDbValue($rs->fields('skype'));
		$this->website->setDbValue($rs->fields('website'));
		$this->linkedin->setDbValue($rs->fields('linkedin'));
		$this->facebook->setDbValue($rs->fields('facebook'));
		$this->twitter->setDbValue($rs->fields('twitter'));
		$this->active_code->setDbValue($rs->fields('active_code'));
		$this->identification->setDbValue($rs->fields('identification'));
		$this->link_expired->setDbValue($rs->fields('link_expired'));
		$this->isactive->setDbValue($rs->fields('isactive'));
		$this->pio->setDbValue($rs->fields('pio'));
		$this->google->setDbValue($rs->fields('google'));
		$this->instagram->setDbValue($rs->fields('instagram'));
		$this->account_type->setDbValue($rs->fields('account_type'));
		$this->logo->setDbValue($rs->fields('logo'));
		$this->profilepic->setDbValue($rs->fields('profilepic'));
		$this->mailref->setDbValue($rs->fields('mailref'));
		$this->deleted->setDbValue($rs->fields('deleted'));
		$this->deletefeedback->setDbValue($rs->fields('deletefeedback'));
		$this->account_id->setDbValue($rs->fields('account_id'));
		$this->start_date->setDbValue($rs->fields('start_date'));
		$this->end_date->setDbValue($rs->fields('end_date'));
		$this->year_moth->setDbValue($rs->fields('year_moth'));
		$this->registerdate->setDbValue($rs->fields('registerdate'));
		$this->login_type->setDbValue($rs->fields('login_type'));
		$this->accountstatus->setDbValue($rs->fields('accountstatus'));
		$this->ispay->setDbValue($rs->fields('ispay'));
		$this->profilelink->setDbValue($rs->fields('profilelink'));
		$this->source->setDbValue($rs->fields('source'));
		$this->agree->setDbValue($rs->fields('agree'));
		$this->balance->setDbValue($rs->fields('balance'));
		$this->job_title->setDbValue($rs->fields('job_title'));
		$this->projects->setDbValue($rs->fields('projects'));
		$this->opportunities->setDbValue($rs->fields('opportunities'));
		$this->isconsaltant->setDbValue($rs->fields('isconsaltant'));
		$this->isagent->setDbValue($rs->fields('isagent'));
		$this->isinvestor->setDbValue($rs->fields('isinvestor'));
		$this->isbusinessman->setDbValue($rs->fields('isbusinessman'));
		$this->isprovider->setDbValue($rs->fields('isprovider'));
		$this->isproductowner->setDbValue($rs->fields('isproductowner'));
		$this->states->setDbValue($rs->fields('states'));
		$this->cities->setDbValue($rs->fields('cities'));
		$this->offers->setDbValue($rs->fields('offers'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// name
		// email
		// password

		$this->password->CellCssStyle = "white-space: nowrap;";

		// companyname
		// servicetime
		// country
		// phone
		// skype
		// website
		// linkedin
		// facebook
		// twitter
		// active_code
		// identification
		// link_expired
		// isactive
		// pio
		// google
		// instagram
		// account_type
		// logo
		// profilepic
		// mailref
		// deleted
		// deletefeedback
		// account_id
		// start_date
		// end_date
		// year_moth
		// registerdate
		// login_type
		// accountstatus
		// ispay
		// profilelink
		// source
		// agree
		// balance
		// job_title
		// projects
		// opportunities
		// isconsaltant
		// isagent
		// isinvestor
		// isbusinessman
		// isprovider
		// isproductowner
		// states
		// cities
		// offers
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// companyname
		$this->companyname->ViewValue = $this->companyname->CurrentValue;
		$this->companyname->ViewCustomAttributes = "";

		// servicetime
		$this->servicetime->ViewValue = $this->servicetime->CurrentValue;
		$this->servicetime->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// skype
		$this->skype->ViewValue = $this->skype->CurrentValue;
		$this->skype->ViewCustomAttributes = "";

		// website
		$this->website->ViewValue = $this->website->CurrentValue;
		$this->website->ViewCustomAttributes = "";

		// linkedin
		$this->linkedin->ViewValue = $this->linkedin->CurrentValue;
		$this->linkedin->ViewCustomAttributes = "";

		// facebook
		$this->facebook->ViewValue = $this->facebook->CurrentValue;
		$this->facebook->ViewCustomAttributes = "";

		// twitter
		$this->twitter->ViewValue = $this->twitter->CurrentValue;
		$this->twitter->ViewCustomAttributes = "";

		// active_code
		$this->active_code->ViewValue = $this->active_code->CurrentValue;
		$this->active_code->ViewCustomAttributes = "";

		// identification
		$this->identification->ViewValue = $this->identification->CurrentValue;
		$this->identification->ViewCustomAttributes = "";

		// link_expired
		$this->link_expired->ViewValue = $this->link_expired->CurrentValue;
		$this->link_expired->ViewValue = ew_FormatDateTime($this->link_expired->ViewValue, 5);
		$this->link_expired->ViewCustomAttributes = "";

		// isactive
		$this->isactive->ViewValue = $this->isactive->CurrentValue;
		$this->isactive->ViewCustomAttributes = "";

		// pio
		$this->pio->ViewValue = $this->pio->CurrentValue;
		$this->pio->ViewCustomAttributes = "";

		// google
		$this->google->ViewValue = $this->google->CurrentValue;
		$this->google->ViewCustomAttributes = "";

		// instagram
		$this->instagram->ViewValue = $this->instagram->CurrentValue;
		$this->instagram->ViewCustomAttributes = "";

		// account_type
		$this->account_type->ViewValue = $this->account_type->CurrentValue;
		$this->account_type->ViewCustomAttributes = "";

		// logo
		$this->logo->ViewValue = $this->logo->CurrentValue;
		$this->logo->ViewCustomAttributes = "";

		// profilepic
		$this->profilepic->ViewValue = $this->profilepic->CurrentValue;
		$this->profilepic->ViewCustomAttributes = "";

		// mailref
		$this->mailref->ViewValue = $this->mailref->CurrentValue;
		$this->mailref->ViewCustomAttributes = "";

		// deleted
		$this->deleted->ViewValue = $this->deleted->CurrentValue;
		$this->deleted->ViewCustomAttributes = "";

		// deletefeedback
		$this->deletefeedback->ViewValue = $this->deletefeedback->CurrentValue;
		$this->deletefeedback->ViewCustomAttributes = "";

		// account_id
		$this->account_id->ViewValue = $this->account_id->CurrentValue;
		$this->account_id->ViewCustomAttributes = "";

		// start_date
		$this->start_date->ViewValue = $this->start_date->CurrentValue;
		$this->start_date->ViewValue = ew_FormatDateTime($this->start_date->ViewValue, 5);
		$this->start_date->ViewCustomAttributes = "";

		// end_date
		$this->end_date->ViewValue = $this->end_date->CurrentValue;
		$this->end_date->ViewValue = ew_FormatDateTime($this->end_date->ViewValue, 5);
		$this->end_date->ViewCustomAttributes = "";

		// year_moth
		$this->year_moth->ViewValue = $this->year_moth->CurrentValue;
		$this->year_moth->ViewCustomAttributes = "";

		// registerdate
		$this->registerdate->ViewValue = $this->registerdate->CurrentValue;
		$this->registerdate->ViewValue = ew_FormatDateTime($this->registerdate->ViewValue, 5);
		$this->registerdate->ViewCustomAttributes = "";

		// login_type
		$this->login_type->ViewValue = $this->login_type->CurrentValue;
		$this->login_type->ViewCustomAttributes = "";

		// accountstatus
		$this->accountstatus->ViewValue = $this->accountstatus->CurrentValue;
		$this->accountstatus->ViewCustomAttributes = "";

		// ispay
		$this->ispay->ViewValue = $this->ispay->CurrentValue;
		$this->ispay->ViewCustomAttributes = "";

		// profilelink
		$this->profilelink->ViewValue = $this->profilelink->CurrentValue;
		$this->profilelink->ViewCustomAttributes = "";

		// source
		$this->source->ViewValue = $this->source->CurrentValue;
		$this->source->ViewCustomAttributes = "";

		// agree
		$this->agree->ViewValue = $this->agree->CurrentValue;
		$this->agree->ViewCustomAttributes = "";

		// balance
		$this->balance->ViewValue = $this->balance->CurrentValue;
		$this->balance->ViewCustomAttributes = "";

		// job_title
		$this->job_title->ViewValue = $this->job_title->CurrentValue;
		$this->job_title->ViewCustomAttributes = "";

		// projects
		$this->projects->ViewValue = $this->projects->CurrentValue;
		$this->projects->ViewCustomAttributes = "";

		// opportunities
		$this->opportunities->ViewValue = $this->opportunities->CurrentValue;
		$this->opportunities->ViewCustomAttributes = "";

		// isconsaltant
		$this->isconsaltant->ViewCustomAttributes = "";

		// isagent
		$this->isagent->ViewCustomAttributes = "";

		// isinvestor
		$this->isinvestor->ViewCustomAttributes = "";

		// isbusinessman
		$this->isbusinessman->ViewCustomAttributes = "";

		// isprovider
		$this->isprovider->ViewCustomAttributes = "";

		// isproductowner
		$this->isproductowner->ViewCustomAttributes = "";

		// states
		$this->states->ViewValue = $this->states->CurrentValue;
		$this->states->ViewCustomAttributes = "";

		// cities
		$this->cities->ViewValue = $this->cities->CurrentValue;
		$this->cities->ViewCustomAttributes = "";

		// offers
		$this->offers->ViewValue = $this->offers->CurrentValue;
		$this->offers->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// password
		$this->password->LinkCustomAttributes = "";
		$this->password->HrefValue = "";
		$this->password->TooltipValue = "";

		// companyname
		$this->companyname->LinkCustomAttributes = "";
		$this->companyname->HrefValue = "";
		$this->companyname->TooltipValue = "";

		// servicetime
		$this->servicetime->LinkCustomAttributes = "";
		$this->servicetime->HrefValue = "";
		$this->servicetime->TooltipValue = "";

		// country
		$this->country->LinkCustomAttributes = "";
		$this->country->HrefValue = "";
		$this->country->TooltipValue = "";

		// phone
		$this->phone->LinkCustomAttributes = "";
		$this->phone->HrefValue = "";
		$this->phone->TooltipValue = "";

		// skype
		$this->skype->LinkCustomAttributes = "";
		$this->skype->HrefValue = "";
		$this->skype->TooltipValue = "";

		// website
		$this->website->LinkCustomAttributes = "";
		$this->website->HrefValue = "";
		$this->website->TooltipValue = "";

		// linkedin
		$this->linkedin->LinkCustomAttributes = "";
		$this->linkedin->HrefValue = "";
		$this->linkedin->TooltipValue = "";

		// facebook
		$this->facebook->LinkCustomAttributes = "";
		$this->facebook->HrefValue = "";
		$this->facebook->TooltipValue = "";

		// twitter
		$this->twitter->LinkCustomAttributes = "";
		$this->twitter->HrefValue = "";
		$this->twitter->TooltipValue = "";

		// active_code
		$this->active_code->LinkCustomAttributes = "";
		$this->active_code->HrefValue = "";
		$this->active_code->TooltipValue = "";

		// identification
		$this->identification->LinkCustomAttributes = "";
		$this->identification->HrefValue = "";
		$this->identification->TooltipValue = "";

		// link_expired
		$this->link_expired->LinkCustomAttributes = "";
		$this->link_expired->HrefValue = "";
		$this->link_expired->TooltipValue = "";

		// isactive
		$this->isactive->LinkCustomAttributes = "";
		$this->isactive->HrefValue = "";
		$this->isactive->TooltipValue = "";

		// pio
		$this->pio->LinkCustomAttributes = "";
		$this->pio->HrefValue = "";
		$this->pio->TooltipValue = "";

		// google
		$this->google->LinkCustomAttributes = "";
		$this->google->HrefValue = "";
		$this->google->TooltipValue = "";

		// instagram
		$this->instagram->LinkCustomAttributes = "";
		$this->instagram->HrefValue = "";
		$this->instagram->TooltipValue = "";

		// account_type
		$this->account_type->LinkCustomAttributes = "";
		$this->account_type->HrefValue = "";
		$this->account_type->TooltipValue = "";

		// logo
		$this->logo->LinkCustomAttributes = "";
		$this->logo->HrefValue = "";
		$this->logo->TooltipValue = "";

		// profilepic
		$this->profilepic->LinkCustomAttributes = "";
		$this->profilepic->HrefValue = "";
		$this->profilepic->TooltipValue = "";

		// mailref
		$this->mailref->LinkCustomAttributes = "";
		$this->mailref->HrefValue = "";
		$this->mailref->TooltipValue = "";

		// deleted
		$this->deleted->LinkCustomAttributes = "";
		$this->deleted->HrefValue = "";
		$this->deleted->TooltipValue = "";

		// deletefeedback
		$this->deletefeedback->LinkCustomAttributes = "";
		$this->deletefeedback->HrefValue = "";
		$this->deletefeedback->TooltipValue = "";

		// account_id
		$this->account_id->LinkCustomAttributes = "";
		$this->account_id->HrefValue = "";
		$this->account_id->TooltipValue = "";

		// start_date
		$this->start_date->LinkCustomAttributes = "";
		$this->start_date->HrefValue = "";
		$this->start_date->TooltipValue = "";

		// end_date
		$this->end_date->LinkCustomAttributes = "";
		$this->end_date->HrefValue = "";
		$this->end_date->TooltipValue = "";

		// year_moth
		$this->year_moth->LinkCustomAttributes = "";
		$this->year_moth->HrefValue = "";
		$this->year_moth->TooltipValue = "";

		// registerdate
		$this->registerdate->LinkCustomAttributes = "";
		$this->registerdate->HrefValue = "";
		$this->registerdate->TooltipValue = "";

		// login_type
		$this->login_type->LinkCustomAttributes = "";
		$this->login_type->HrefValue = "";
		$this->login_type->TooltipValue = "";

		// accountstatus
		$this->accountstatus->LinkCustomAttributes = "";
		$this->accountstatus->HrefValue = "";
		$this->accountstatus->TooltipValue = "";

		// ispay
		$this->ispay->LinkCustomAttributes = "";
		$this->ispay->HrefValue = "";
		$this->ispay->TooltipValue = "";

		// profilelink
		$this->profilelink->LinkCustomAttributes = "";
		$this->profilelink->HrefValue = "";
		$this->profilelink->TooltipValue = "";

		// source
		$this->source->LinkCustomAttributes = "";
		$this->source->HrefValue = "";
		$this->source->TooltipValue = "";

		// agree
		$this->agree->LinkCustomAttributes = "";
		$this->agree->HrefValue = "";
		$this->agree->TooltipValue = "";

		// balance
		$this->balance->LinkCustomAttributes = "";
		$this->balance->HrefValue = "";
		$this->balance->TooltipValue = "";

		// job_title
		$this->job_title->LinkCustomAttributes = "";
		$this->job_title->HrefValue = "";
		$this->job_title->TooltipValue = "";

		// projects
		$this->projects->LinkCustomAttributes = "";
		$this->projects->HrefValue = "";
		$this->projects->TooltipValue = "";

		// opportunities
		$this->opportunities->LinkCustomAttributes = "";
		$this->opportunities->HrefValue = "";
		$this->opportunities->TooltipValue = "";

		// isconsaltant
		$this->isconsaltant->LinkCustomAttributes = "";
		$this->isconsaltant->HrefValue = "";
		$this->isconsaltant->TooltipValue = "";

		// isagent
		$this->isagent->LinkCustomAttributes = "";
		$this->isagent->HrefValue = "";
		$this->isagent->TooltipValue = "";

		// isinvestor
		$this->isinvestor->LinkCustomAttributes = "";
		$this->isinvestor->HrefValue = "";
		$this->isinvestor->TooltipValue = "";

		// isbusinessman
		$this->isbusinessman->LinkCustomAttributes = "";
		$this->isbusinessman->HrefValue = "";
		$this->isbusinessman->TooltipValue = "";

		// isprovider
		$this->isprovider->LinkCustomAttributes = "";
		$this->isprovider->HrefValue = "";
		$this->isprovider->TooltipValue = "";

		// isproductowner
		$this->isproductowner->LinkCustomAttributes = "";
		$this->isproductowner->HrefValue = "";
		$this->isproductowner->TooltipValue = "";

		// states
		$this->states->LinkCustomAttributes = "";
		$this->states->HrefValue = "";
		$this->states->TooltipValue = "";

		// cities
		$this->cities->LinkCustomAttributes = "";
		$this->cities->HrefValue = "";
		$this->cities->TooltipValue = "";

		// offers
		$this->offers->LinkCustomAttributes = "";
		$this->offers->HrefValue = "";
		$this->offers->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// password
		$this->password->EditAttrs["class"] = "form-control";
		$this->password->EditCustomAttributes = "";
		$this->password->EditValue = $this->password->CurrentValue;
		$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

		// companyname
		$this->companyname->EditAttrs["class"] = "form-control";
		$this->companyname->EditCustomAttributes = "";

		// servicetime
		$this->servicetime->EditAttrs["class"] = "form-control";
		$this->servicetime->EditCustomAttributes = "";

		// country
		$this->country->EditAttrs["class"] = "form-control";
		$this->country->EditCustomAttributes = "";
		$this->country->EditValue = $this->country->CurrentValue;
		$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

		// phone
		$this->phone->EditAttrs["class"] = "form-control";
		$this->phone->EditCustomAttributes = "";
		$this->phone->EditValue = $this->phone->CurrentValue;
		$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

		// skype
		$this->skype->EditAttrs["class"] = "form-control";
		$this->skype->EditCustomAttributes = "";
		$this->skype->EditValue = $this->skype->CurrentValue;
		$this->skype->PlaceHolder = ew_RemoveHtml($this->skype->FldCaption());

		// website
		$this->website->EditAttrs["class"] = "form-control";
		$this->website->EditCustomAttributes = "";
		$this->website->EditValue = $this->website->CurrentValue;
		$this->website->PlaceHolder = ew_RemoveHtml($this->website->FldCaption());

		// linkedin
		$this->linkedin->EditAttrs["class"] = "form-control";
		$this->linkedin->EditCustomAttributes = "";
		$this->linkedin->EditValue = $this->linkedin->CurrentValue;
		$this->linkedin->PlaceHolder = ew_RemoveHtml($this->linkedin->FldCaption());

		// facebook
		$this->facebook->EditAttrs["class"] = "form-control";
		$this->facebook->EditCustomAttributes = "";
		$this->facebook->EditValue = $this->facebook->CurrentValue;
		$this->facebook->PlaceHolder = ew_RemoveHtml($this->facebook->FldCaption());

		// twitter
		$this->twitter->EditAttrs["class"] = "form-control";
		$this->twitter->EditCustomAttributes = "";
		$this->twitter->EditValue = $this->twitter->CurrentValue;
		$this->twitter->PlaceHolder = ew_RemoveHtml($this->twitter->FldCaption());

		// active_code
		$this->active_code->EditAttrs["class"] = "form-control";
		$this->active_code->EditCustomAttributes = "";

		// identification
		$this->identification->EditAttrs["class"] = "form-control";
		$this->identification->EditCustomAttributes = "";

		// link_expired
		$this->link_expired->EditAttrs["class"] = "form-control";
		$this->link_expired->EditCustomAttributes = "";
		$this->link_expired->CurrentValue = ew_FormatDateTime($this->link_expired->CurrentValue, 5);

		// isactive
		$this->isactive->EditAttrs["class"] = "form-control";
		$this->isactive->EditCustomAttributes = "";

		// pio
		$this->pio->EditAttrs["class"] = "form-control";
		$this->pio->EditCustomAttributes = "";

		// google
		$this->google->EditAttrs["class"] = "form-control";
		$this->google->EditCustomAttributes = "";
		$this->google->EditValue = $this->google->CurrentValue;
		$this->google->PlaceHolder = ew_RemoveHtml($this->google->FldCaption());

		// instagram
		$this->instagram->EditAttrs["class"] = "form-control";
		$this->instagram->EditCustomAttributes = "";
		$this->instagram->EditValue = $this->instagram->CurrentValue;
		$this->instagram->PlaceHolder = ew_RemoveHtml($this->instagram->FldCaption());

		// account_type
		$this->account_type->EditAttrs["class"] = "form-control";
		$this->account_type->EditCustomAttributes = "";
		$this->account_type->EditValue = $this->account_type->CurrentValue;
		$this->account_type->PlaceHolder = ew_RemoveHtml($this->account_type->FldCaption());

		// logo
		$this->logo->EditAttrs["class"] = "form-control";
		$this->logo->EditCustomAttributes = "";

		// profilepic
		$this->profilepic->EditAttrs["class"] = "form-control";
		$this->profilepic->EditCustomAttributes = "";

		// mailref
		$this->mailref->EditAttrs["class"] = "form-control";
		$this->mailref->EditCustomAttributes = "";

		// deleted
		$this->deleted->EditAttrs["class"] = "form-control";
		$this->deleted->EditCustomAttributes = "";

		// deletefeedback
		$this->deletefeedback->EditAttrs["class"] = "form-control";
		$this->deletefeedback->EditCustomAttributes = "";

		// account_id
		$this->account_id->EditAttrs["class"] = "form-control";
		$this->account_id->EditCustomAttributes = "";

		// start_date
		$this->start_date->EditAttrs["class"] = "form-control";
		$this->start_date->EditCustomAttributes = "";
		$this->start_date->CurrentValue = ew_FormatDateTime($this->start_date->CurrentValue, 5);

		// end_date
		$this->end_date->EditAttrs["class"] = "form-control";
		$this->end_date->EditCustomAttributes = "";
		$this->end_date->CurrentValue = ew_FormatDateTime($this->end_date->CurrentValue, 5);

		// year_moth
		$this->year_moth->EditAttrs["class"] = "form-control";
		$this->year_moth->EditCustomAttributes = "";

		// registerdate
		$this->registerdate->EditAttrs["class"] = "form-control";
		$this->registerdate->EditCustomAttributes = "";
		$this->registerdate->EditValue = ew_FormatDateTime($this->registerdate->CurrentValue, 5);
		$this->registerdate->PlaceHolder = ew_RemoveHtml($this->registerdate->FldCaption());

		// login_type
		$this->login_type->EditAttrs["class"] = "form-control";
		$this->login_type->EditCustomAttributes = "";
		$this->login_type->EditValue = $this->login_type->CurrentValue;
		$this->login_type->PlaceHolder = ew_RemoveHtml($this->login_type->FldCaption());

		// accountstatus
		$this->accountstatus->EditAttrs["class"] = "form-control";
		$this->accountstatus->EditCustomAttributes = "";
		$this->accountstatus->EditValue = $this->accountstatus->CurrentValue;
		$this->accountstatus->PlaceHolder = ew_RemoveHtml($this->accountstatus->FldCaption());

		// ispay
		$this->ispay->EditAttrs["class"] = "form-control";
		$this->ispay->EditCustomAttributes = "";

		// profilelink
		$this->profilelink->EditAttrs["class"] = "form-control";
		$this->profilelink->EditCustomAttributes = "";
		$this->profilelink->EditValue = $this->profilelink->CurrentValue;
		$this->profilelink->PlaceHolder = ew_RemoveHtml($this->profilelink->FldCaption());

		// source
		$this->source->EditAttrs["class"] = "form-control";
		$this->source->EditCustomAttributes = "";

		// agree
		$this->agree->EditAttrs["class"] = "form-control";
		$this->agree->EditCustomAttributes = "";

		// balance
		$this->balance->EditAttrs["class"] = "form-control";
		$this->balance->EditCustomAttributes = "";
		$this->balance->EditValue = $this->balance->CurrentValue;
		$this->balance->PlaceHolder = ew_RemoveHtml($this->balance->FldCaption());

		// job_title
		$this->job_title->EditAttrs["class"] = "form-control";
		$this->job_title->EditCustomAttributes = "";
		$this->job_title->EditValue = $this->job_title->CurrentValue;
		$this->job_title->PlaceHolder = ew_RemoveHtml($this->job_title->FldCaption());

		// projects
		$this->projects->EditAttrs["class"] = "form-control";
		$this->projects->EditCustomAttributes = "";
		$this->projects->EditValue = $this->projects->CurrentValue;
		$this->projects->PlaceHolder = ew_RemoveHtml($this->projects->FldCaption());

		// opportunities
		$this->opportunities->EditAttrs["class"] = "form-control";
		$this->opportunities->EditCustomAttributes = "";
		$this->opportunities->EditValue = $this->opportunities->CurrentValue;
		$this->opportunities->PlaceHolder = ew_RemoveHtml($this->opportunities->FldCaption());

		// isconsaltant
		$this->isconsaltant->EditCustomAttributes = "";

		// isagent
		$this->isagent->EditCustomAttributes = "";

		// isinvestor
		$this->isinvestor->EditCustomAttributes = "";

		// isbusinessman
		$this->isbusinessman->EditCustomAttributes = "";

		// isprovider
		$this->isprovider->EditCustomAttributes = "";

		// isproductowner
		$this->isproductowner->EditCustomAttributes = "";

		// states
		$this->states->EditAttrs["class"] = "form-control";
		$this->states->EditCustomAttributes = "";
		$this->states->EditValue = $this->states->CurrentValue;
		$this->states->PlaceHolder = ew_RemoveHtml($this->states->FldCaption());

		// cities
		$this->cities->EditAttrs["class"] = "form-control";
		$this->cities->EditCustomAttributes = "";
		$this->cities->EditValue = $this->cities->CurrentValue;
		$this->cities->PlaceHolder = ew_RemoveHtml($this->cities->FldCaption());

		// offers
		$this->offers->EditAttrs["class"] = "form-control";
		$this->offers->EditCustomAttributes = "";
		$this->offers->EditValue = $this->offers->CurrentValue;
		$this->offers->PlaceHolder = ew_RemoveHtml($this->offers->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->companyname->Exportable) $Doc->ExportCaption($this->companyname);
					if ($this->servicetime->Exportable) $Doc->ExportCaption($this->servicetime);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->skype->Exportable) $Doc->ExportCaption($this->skype);
					if ($this->website->Exportable) $Doc->ExportCaption($this->website);
					if ($this->linkedin->Exportable) $Doc->ExportCaption($this->linkedin);
					if ($this->facebook->Exportable) $Doc->ExportCaption($this->facebook);
					if ($this->twitter->Exportable) $Doc->ExportCaption($this->twitter);
					if ($this->active_code->Exportable) $Doc->ExportCaption($this->active_code);
					if ($this->identification->Exportable) $Doc->ExportCaption($this->identification);
					if ($this->link_expired->Exportable) $Doc->ExportCaption($this->link_expired);
					if ($this->isactive->Exportable) $Doc->ExportCaption($this->isactive);
					if ($this->pio->Exportable) $Doc->ExportCaption($this->pio);
					if ($this->google->Exportable) $Doc->ExportCaption($this->google);
					if ($this->instagram->Exportable) $Doc->ExportCaption($this->instagram);
					if ($this->account_type->Exportable) $Doc->ExportCaption($this->account_type);
					if ($this->logo->Exportable) $Doc->ExportCaption($this->logo);
					if ($this->profilepic->Exportable) $Doc->ExportCaption($this->profilepic);
					if ($this->mailref->Exportable) $Doc->ExportCaption($this->mailref);
					if ($this->deleted->Exportable) $Doc->ExportCaption($this->deleted);
					if ($this->deletefeedback->Exportable) $Doc->ExportCaption($this->deletefeedback);
					if ($this->account_id->Exportable) $Doc->ExportCaption($this->account_id);
					if ($this->start_date->Exportable) $Doc->ExportCaption($this->start_date);
					if ($this->end_date->Exportable) $Doc->ExportCaption($this->end_date);
					if ($this->year_moth->Exportable) $Doc->ExportCaption($this->year_moth);
					if ($this->registerdate->Exportable) $Doc->ExportCaption($this->registerdate);
					if ($this->login_type->Exportable) $Doc->ExportCaption($this->login_type);
					if ($this->accountstatus->Exportable) $Doc->ExportCaption($this->accountstatus);
					if ($this->ispay->Exportable) $Doc->ExportCaption($this->ispay);
					if ($this->profilelink->Exportable) $Doc->ExportCaption($this->profilelink);
					if ($this->source->Exportable) $Doc->ExportCaption($this->source);
					if ($this->agree->Exportable) $Doc->ExportCaption($this->agree);
					if ($this->balance->Exportable) $Doc->ExportCaption($this->balance);
					if ($this->job_title->Exportable) $Doc->ExportCaption($this->job_title);
					if ($this->projects->Exportable) $Doc->ExportCaption($this->projects);
					if ($this->opportunities->Exportable) $Doc->ExportCaption($this->opportunities);
					if ($this->isconsaltant->Exportable) $Doc->ExportCaption($this->isconsaltant);
					if ($this->isagent->Exportable) $Doc->ExportCaption($this->isagent);
					if ($this->isinvestor->Exportable) $Doc->ExportCaption($this->isinvestor);
					if ($this->isbusinessman->Exportable) $Doc->ExportCaption($this->isbusinessman);
					if ($this->isprovider->Exportable) $Doc->ExportCaption($this->isprovider);
					if ($this->isproductowner->Exportable) $Doc->ExportCaption($this->isproductowner);
					if ($this->states->Exportable) $Doc->ExportCaption($this->states);
					if ($this->cities->Exportable) $Doc->ExportCaption($this->cities);
					if ($this->offers->Exportable) $Doc->ExportCaption($this->offers);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->companyname->Exportable) $Doc->ExportCaption($this->companyname);
					if ($this->servicetime->Exportable) $Doc->ExportCaption($this->servicetime);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->skype->Exportable) $Doc->ExportCaption($this->skype);
					if ($this->website->Exportable) $Doc->ExportCaption($this->website);
					if ($this->linkedin->Exportable) $Doc->ExportCaption($this->linkedin);
					if ($this->facebook->Exportable) $Doc->ExportCaption($this->facebook);
					if ($this->twitter->Exportable) $Doc->ExportCaption($this->twitter);
					if ($this->active_code->Exportable) $Doc->ExportCaption($this->active_code);
					if ($this->identification->Exportable) $Doc->ExportCaption($this->identification);
					if ($this->link_expired->Exportable) $Doc->ExportCaption($this->link_expired);
					if ($this->isactive->Exportable) $Doc->ExportCaption($this->isactive);
					if ($this->google->Exportable) $Doc->ExportCaption($this->google);
					if ($this->instagram->Exportable) $Doc->ExportCaption($this->instagram);
					if ($this->account_type->Exportable) $Doc->ExportCaption($this->account_type);
					if ($this->logo->Exportable) $Doc->ExportCaption($this->logo);
					if ($this->profilepic->Exportable) $Doc->ExportCaption($this->profilepic);
					if ($this->mailref->Exportable) $Doc->ExportCaption($this->mailref);
					if ($this->deleted->Exportable) $Doc->ExportCaption($this->deleted);
					if ($this->deletefeedback->Exportable) $Doc->ExportCaption($this->deletefeedback);
					if ($this->account_id->Exportable) $Doc->ExportCaption($this->account_id);
					if ($this->start_date->Exportable) $Doc->ExportCaption($this->start_date);
					if ($this->end_date->Exportable) $Doc->ExportCaption($this->end_date);
					if ($this->year_moth->Exportable) $Doc->ExportCaption($this->year_moth);
					if ($this->registerdate->Exportable) $Doc->ExportCaption($this->registerdate);
					if ($this->login_type->Exportable) $Doc->ExportCaption($this->login_type);
					if ($this->accountstatus->Exportable) $Doc->ExportCaption($this->accountstatus);
					if ($this->ispay->Exportable) $Doc->ExportCaption($this->ispay);
					if ($this->profilelink->Exportable) $Doc->ExportCaption($this->profilelink);
					if ($this->source->Exportable) $Doc->ExportCaption($this->source);
					if ($this->agree->Exportable) $Doc->ExportCaption($this->agree);
					if ($this->balance->Exportable) $Doc->ExportCaption($this->balance);
					if ($this->job_title->Exportable) $Doc->ExportCaption($this->job_title);
					if ($this->projects->Exportable) $Doc->ExportCaption($this->projects);
					if ($this->opportunities->Exportable) $Doc->ExportCaption($this->opportunities);
					if ($this->isconsaltant->Exportable) $Doc->ExportCaption($this->isconsaltant);
					if ($this->isagent->Exportable) $Doc->ExportCaption($this->isagent);
					if ($this->isinvestor->Exportable) $Doc->ExportCaption($this->isinvestor);
					if ($this->isbusinessman->Exportable) $Doc->ExportCaption($this->isbusinessman);
					if ($this->isprovider->Exportable) $Doc->ExportCaption($this->isprovider);
					if ($this->isproductowner->Exportable) $Doc->ExportCaption($this->isproductowner);
					if ($this->states->Exportable) $Doc->ExportCaption($this->states);
					if ($this->cities->Exportable) $Doc->ExportCaption($this->cities);
					if ($this->offers->Exportable) $Doc->ExportCaption($this->offers);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->companyname->Exportable) $Doc->ExportField($this->companyname);
						if ($this->servicetime->Exportable) $Doc->ExportField($this->servicetime);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->skype->Exportable) $Doc->ExportField($this->skype);
						if ($this->website->Exportable) $Doc->ExportField($this->website);
						if ($this->linkedin->Exportable) $Doc->ExportField($this->linkedin);
						if ($this->facebook->Exportable) $Doc->ExportField($this->facebook);
						if ($this->twitter->Exportable) $Doc->ExportField($this->twitter);
						if ($this->active_code->Exportable) $Doc->ExportField($this->active_code);
						if ($this->identification->Exportable) $Doc->ExportField($this->identification);
						if ($this->link_expired->Exportable) $Doc->ExportField($this->link_expired);
						if ($this->isactive->Exportable) $Doc->ExportField($this->isactive);
						if ($this->pio->Exportable) $Doc->ExportField($this->pio);
						if ($this->google->Exportable) $Doc->ExportField($this->google);
						if ($this->instagram->Exportable) $Doc->ExportField($this->instagram);
						if ($this->account_type->Exportable) $Doc->ExportField($this->account_type);
						if ($this->logo->Exportable) $Doc->ExportField($this->logo);
						if ($this->profilepic->Exportable) $Doc->ExportField($this->profilepic);
						if ($this->mailref->Exportable) $Doc->ExportField($this->mailref);
						if ($this->deleted->Exportable) $Doc->ExportField($this->deleted);
						if ($this->deletefeedback->Exportable) $Doc->ExportField($this->deletefeedback);
						if ($this->account_id->Exportable) $Doc->ExportField($this->account_id);
						if ($this->start_date->Exportable) $Doc->ExportField($this->start_date);
						if ($this->end_date->Exportable) $Doc->ExportField($this->end_date);
						if ($this->year_moth->Exportable) $Doc->ExportField($this->year_moth);
						if ($this->registerdate->Exportable) $Doc->ExportField($this->registerdate);
						if ($this->login_type->Exportable) $Doc->ExportField($this->login_type);
						if ($this->accountstatus->Exportable) $Doc->ExportField($this->accountstatus);
						if ($this->ispay->Exportable) $Doc->ExportField($this->ispay);
						if ($this->profilelink->Exportable) $Doc->ExportField($this->profilelink);
						if ($this->source->Exportable) $Doc->ExportField($this->source);
						if ($this->agree->Exportable) $Doc->ExportField($this->agree);
						if ($this->balance->Exportable) $Doc->ExportField($this->balance);
						if ($this->job_title->Exportable) $Doc->ExportField($this->job_title);
						if ($this->projects->Exportable) $Doc->ExportField($this->projects);
						if ($this->opportunities->Exportable) $Doc->ExportField($this->opportunities);
						if ($this->isconsaltant->Exportable) $Doc->ExportField($this->isconsaltant);
						if ($this->isagent->Exportable) $Doc->ExportField($this->isagent);
						if ($this->isinvestor->Exportable) $Doc->ExportField($this->isinvestor);
						if ($this->isbusinessman->Exportable) $Doc->ExportField($this->isbusinessman);
						if ($this->isprovider->Exportable) $Doc->ExportField($this->isprovider);
						if ($this->isproductowner->Exportable) $Doc->ExportField($this->isproductowner);
						if ($this->states->Exportable) $Doc->ExportField($this->states);
						if ($this->cities->Exportable) $Doc->ExportField($this->cities);
						if ($this->offers->Exportable) $Doc->ExportField($this->offers);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->companyname->Exportable) $Doc->ExportField($this->companyname);
						if ($this->servicetime->Exportable) $Doc->ExportField($this->servicetime);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->skype->Exportable) $Doc->ExportField($this->skype);
						if ($this->website->Exportable) $Doc->ExportField($this->website);
						if ($this->linkedin->Exportable) $Doc->ExportField($this->linkedin);
						if ($this->facebook->Exportable) $Doc->ExportField($this->facebook);
						if ($this->twitter->Exportable) $Doc->ExportField($this->twitter);
						if ($this->active_code->Exportable) $Doc->ExportField($this->active_code);
						if ($this->identification->Exportable) $Doc->ExportField($this->identification);
						if ($this->link_expired->Exportable) $Doc->ExportField($this->link_expired);
						if ($this->isactive->Exportable) $Doc->ExportField($this->isactive);
						if ($this->google->Exportable) $Doc->ExportField($this->google);
						if ($this->instagram->Exportable) $Doc->ExportField($this->instagram);
						if ($this->account_type->Exportable) $Doc->ExportField($this->account_type);
						if ($this->logo->Exportable) $Doc->ExportField($this->logo);
						if ($this->profilepic->Exportable) $Doc->ExportField($this->profilepic);
						if ($this->mailref->Exportable) $Doc->ExportField($this->mailref);
						if ($this->deleted->Exportable) $Doc->ExportField($this->deleted);
						if ($this->deletefeedback->Exportable) $Doc->ExportField($this->deletefeedback);
						if ($this->account_id->Exportable) $Doc->ExportField($this->account_id);
						if ($this->start_date->Exportable) $Doc->ExportField($this->start_date);
						if ($this->end_date->Exportable) $Doc->ExportField($this->end_date);
						if ($this->year_moth->Exportable) $Doc->ExportField($this->year_moth);
						if ($this->registerdate->Exportable) $Doc->ExportField($this->registerdate);
						if ($this->login_type->Exportable) $Doc->ExportField($this->login_type);
						if ($this->accountstatus->Exportable) $Doc->ExportField($this->accountstatus);
						if ($this->ispay->Exportable) $Doc->ExportField($this->ispay);
						if ($this->profilelink->Exportable) $Doc->ExportField($this->profilelink);
						if ($this->source->Exportable) $Doc->ExportField($this->source);
						if ($this->agree->Exportable) $Doc->ExportField($this->agree);
						if ($this->balance->Exportable) $Doc->ExportField($this->balance);
						if ($this->job_title->Exportable) $Doc->ExportField($this->job_title);
						if ($this->projects->Exportable) $Doc->ExportField($this->projects);
						if ($this->opportunities->Exportable) $Doc->ExportField($this->opportunities);
						if ($this->isconsaltant->Exportable) $Doc->ExportField($this->isconsaltant);
						if ($this->isagent->Exportable) $Doc->ExportField($this->isagent);
						if ($this->isinvestor->Exportable) $Doc->ExportField($this->isinvestor);
						if ($this->isbusinessman->Exportable) $Doc->ExportField($this->isbusinessman);
						if ($this->isprovider->Exportable) $Doc->ExportField($this->isprovider);
						if ($this->isproductowner->Exportable) $Doc->ExportField($this->isproductowner);
						if ($this->states->Exportable) $Doc->ExportField($this->states);
						if ($this->cities->Exportable) $Doc->ExportField($this->cities);
						if ($this->offers->Exportable) $Doc->ExportField($this->offers);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
