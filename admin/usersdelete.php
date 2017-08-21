<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$users_delete = NULL; // Initialize page object first

class cusers_delete extends cusers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (employees)
		if (!isset($UserTable)) {
			$UserTable = new cemployees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("userslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("userslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in users class, usersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->password->DbValue = $row['password'];
		$this->companyname->DbValue = $row['companyname'];
		$this->servicetime->DbValue = $row['servicetime'];
		$this->country->DbValue = $row['country'];
		$this->phone->DbValue = $row['phone'];
		$this->skype->DbValue = $row['skype'];
		$this->website->DbValue = $row['website'];
		$this->linkedin->DbValue = $row['linkedin'];
		$this->facebook->DbValue = $row['facebook'];
		$this->twitter->DbValue = $row['twitter'];
		$this->active_code->DbValue = $row['active_code'];
		$this->identification->DbValue = $row['identification'];
		$this->link_expired->DbValue = $row['link_expired'];
		$this->isactive->DbValue = $row['isactive'];
		$this->pio->DbValue = $row['pio'];
		$this->google->DbValue = $row['google'];
		$this->instagram->DbValue = $row['instagram'];
		$this->account_type->DbValue = $row['account_type'];
		$this->logo->DbValue = $row['logo'];
		$this->profilepic->DbValue = $row['profilepic'];
		$this->mailref->DbValue = $row['mailref'];
		$this->deleted->DbValue = $row['deleted'];
		$this->deletefeedback->DbValue = $row['deletefeedback'];
		$this->account_id->DbValue = $row['account_id'];
		$this->start_date->DbValue = $row['start_date'];
		$this->end_date->DbValue = $row['end_date'];
		$this->year_moth->DbValue = $row['year_moth'];
		$this->registerdate->DbValue = $row['registerdate'];
		$this->login_type->DbValue = $row['login_type'];
		$this->accountstatus->DbValue = $row['accountstatus'];
		$this->ispay->DbValue = $row['ispay'];
		$this->profilelink->DbValue = $row['profilelink'];
		$this->source->DbValue = $row['source'];
		$this->agree->DbValue = $row['agree'];
		$this->balance->DbValue = $row['balance'];
		$this->job_title->DbValue = $row['job_title'];
		$this->projects->DbValue = $row['projects'];
		$this->opportunities->DbValue = $row['opportunities'];
		$this->isconsaltant->DbValue = $row['isconsaltant'];
		$this->isagent->DbValue = $row['isagent'];
		$this->isinvestor->DbValue = $row['isinvestor'];
		$this->isbusinessman->DbValue = $row['isbusinessman'];
		$this->isprovider->DbValue = $row['isprovider'];
		$this->isproductowner->DbValue = $row['isproductowner'];
		$this->states->DbValue = $row['states'];
		$this->cities->DbValue = $row['cities'];
		$this->offers->DbValue = $row['offers'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "userslist.php", "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($users_delete)) $users_delete = new cusers_delete();

// Page init
$users_delete->Page_Init();

// Page main
$users_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fusersdelete = new ew_Form("fusersdelete", "delete");

// Form_CustomValidate event
fusersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusersdelete.ValidateRequired = true;
<?php } else { ?>
fusersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($users_delete->Recordset = $users_delete->LoadRecordset())
	$users_deleteTotalRecs = $users_delete->Recordset->RecordCount(); // Get record count
if ($users_deleteTotalRecs <= 0) { // No record found, exit
	if ($users_delete->Recordset)
		$users_delete->Recordset->Close();
	$users_delete->Page_Terminate("userslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $users_delete->ShowPageHeader(); ?>
<?php
$users_delete->ShowMessage();
?>
<form name="fusersdelete" id="fusersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($users_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $users->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($users->id->Visible) { // id ?>
		<th><span id="elh_users_id" class="users_id"><?php echo $users->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
		<th><span id="elh_users_name" class="users_name"><?php echo $users->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
		<th><span id="elh_users__email" class="users__email"><?php echo $users->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->companyname->Visible) { // companyname ?>
		<th><span id="elh_users_companyname" class="users_companyname"><?php echo $users->companyname->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->servicetime->Visible) { // servicetime ?>
		<th><span id="elh_users_servicetime" class="users_servicetime"><?php echo $users->servicetime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->country->Visible) { // country ?>
		<th><span id="elh_users_country" class="users_country"><?php echo $users->country->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
		<th><span id="elh_users_phone" class="users_phone"><?php echo $users->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->skype->Visible) { // skype ?>
		<th><span id="elh_users_skype" class="users_skype"><?php echo $users->skype->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->website->Visible) { // website ?>
		<th><span id="elh_users_website" class="users_website"><?php echo $users->website->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->linkedin->Visible) { // linkedin ?>
		<th><span id="elh_users_linkedin" class="users_linkedin"><?php echo $users->linkedin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->facebook->Visible) { // facebook ?>
		<th><span id="elh_users_facebook" class="users_facebook"><?php echo $users->facebook->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->twitter->Visible) { // twitter ?>
		<th><span id="elh_users_twitter" class="users_twitter"><?php echo $users->twitter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->active_code->Visible) { // active_code ?>
		<th><span id="elh_users_active_code" class="users_active_code"><?php echo $users->active_code->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->identification->Visible) { // identification ?>
		<th><span id="elh_users_identification" class="users_identification"><?php echo $users->identification->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->link_expired->Visible) { // link_expired ?>
		<th><span id="elh_users_link_expired" class="users_link_expired"><?php echo $users->link_expired->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isactive->Visible) { // isactive ?>
		<th><span id="elh_users_isactive" class="users_isactive"><?php echo $users->isactive->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->google->Visible) { // google ?>
		<th><span id="elh_users_google" class="users_google"><?php echo $users->google->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->instagram->Visible) { // instagram ?>
		<th><span id="elh_users_instagram" class="users_instagram"><?php echo $users->instagram->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->account_type->Visible) { // account_type ?>
		<th><span id="elh_users_account_type" class="users_account_type"><?php echo $users->account_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->logo->Visible) { // logo ?>
		<th><span id="elh_users_logo" class="users_logo"><?php echo $users->logo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->profilepic->Visible) { // profilepic ?>
		<th><span id="elh_users_profilepic" class="users_profilepic"><?php echo $users->profilepic->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->mailref->Visible) { // mailref ?>
		<th><span id="elh_users_mailref" class="users_mailref"><?php echo $users->mailref->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->deleted->Visible) { // deleted ?>
		<th><span id="elh_users_deleted" class="users_deleted"><?php echo $users->deleted->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->deletefeedback->Visible) { // deletefeedback ?>
		<th><span id="elh_users_deletefeedback" class="users_deletefeedback"><?php echo $users->deletefeedback->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->account_id->Visible) { // account_id ?>
		<th><span id="elh_users_account_id" class="users_account_id"><?php echo $users->account_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->start_date->Visible) { // start_date ?>
		<th><span id="elh_users_start_date" class="users_start_date"><?php echo $users->start_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->end_date->Visible) { // end_date ?>
		<th><span id="elh_users_end_date" class="users_end_date"><?php echo $users->end_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->year_moth->Visible) { // year_moth ?>
		<th><span id="elh_users_year_moth" class="users_year_moth"><?php echo $users->year_moth->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->registerdate->Visible) { // registerdate ?>
		<th><span id="elh_users_registerdate" class="users_registerdate"><?php echo $users->registerdate->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->login_type->Visible) { // login_type ?>
		<th><span id="elh_users_login_type" class="users_login_type"><?php echo $users->login_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->accountstatus->Visible) { // accountstatus ?>
		<th><span id="elh_users_accountstatus" class="users_accountstatus"><?php echo $users->accountstatus->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->ispay->Visible) { // ispay ?>
		<th><span id="elh_users_ispay" class="users_ispay"><?php echo $users->ispay->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->profilelink->Visible) { // profilelink ?>
		<th><span id="elh_users_profilelink" class="users_profilelink"><?php echo $users->profilelink->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->source->Visible) { // source ?>
		<th><span id="elh_users_source" class="users_source"><?php echo $users->source->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->agree->Visible) { // agree ?>
		<th><span id="elh_users_agree" class="users_agree"><?php echo $users->agree->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->balance->Visible) { // balance ?>
		<th><span id="elh_users_balance" class="users_balance"><?php echo $users->balance->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->job_title->Visible) { // job_title ?>
		<th><span id="elh_users_job_title" class="users_job_title"><?php echo $users->job_title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->projects->Visible) { // projects ?>
		<th><span id="elh_users_projects" class="users_projects"><?php echo $users->projects->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->opportunities->Visible) { // opportunities ?>
		<th><span id="elh_users_opportunities" class="users_opportunities"><?php echo $users->opportunities->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isconsaltant->Visible) { // isconsaltant ?>
		<th><span id="elh_users_isconsaltant" class="users_isconsaltant"><?php echo $users->isconsaltant->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isagent->Visible) { // isagent ?>
		<th><span id="elh_users_isagent" class="users_isagent"><?php echo $users->isagent->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isinvestor->Visible) { // isinvestor ?>
		<th><span id="elh_users_isinvestor" class="users_isinvestor"><?php echo $users->isinvestor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isbusinessman->Visible) { // isbusinessman ?>
		<th><span id="elh_users_isbusinessman" class="users_isbusinessman"><?php echo $users->isbusinessman->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isprovider->Visible) { // isprovider ?>
		<th><span id="elh_users_isprovider" class="users_isprovider"><?php echo $users->isprovider->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->isproductowner->Visible) { // isproductowner ?>
		<th><span id="elh_users_isproductowner" class="users_isproductowner"><?php echo $users->isproductowner->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->states->Visible) { // states ?>
		<th><span id="elh_users_states" class="users_states"><?php echo $users->states->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->cities->Visible) { // cities ?>
		<th><span id="elh_users_cities" class="users_cities"><?php echo $users->cities->FldCaption() ?></span></th>
<?php } ?>
<?php if ($users->offers->Visible) { // offers ?>
		<th><span id="elh_users_offers" class="users_offers"><?php echo $users->offers->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$users_delete->RecCnt = 0;
$i = 0;
while (!$users_delete->Recordset->EOF) {
	$users_delete->RecCnt++;
	$users_delete->RowCnt++;

	// Set row properties
	$users->ResetAttrs();
	$users->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$users_delete->LoadRowValues($users_delete->Recordset);

	// Render row
	$users_delete->RenderRow();
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php if ($users->id->Visible) { // id ?>
		<td<?php echo $users->id->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
		<td<?php echo $users->name->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_name" class="users_name">
<span<?php echo $users->name->ViewAttributes() ?>>
<?php echo $users->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
		<td<?php echo $users->_email->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users__email" class="users__email">
<span<?php echo $users->_email->ViewAttributes() ?>>
<?php echo $users->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->companyname->Visible) { // companyname ?>
		<td<?php echo $users->companyname->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_companyname" class="users_companyname">
<span<?php echo $users->companyname->ViewAttributes() ?>>
<?php echo $users->companyname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->servicetime->Visible) { // servicetime ?>
		<td<?php echo $users->servicetime->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_servicetime" class="users_servicetime">
<span<?php echo $users->servicetime->ViewAttributes() ?>>
<?php echo $users->servicetime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->country->Visible) { // country ?>
		<td<?php echo $users->country->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_country" class="users_country">
<span<?php echo $users->country->ViewAttributes() ?>>
<?php echo $users->country->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
		<td<?php echo $users->phone->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_phone" class="users_phone">
<span<?php echo $users->phone->ViewAttributes() ?>>
<?php echo $users->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->skype->Visible) { // skype ?>
		<td<?php echo $users->skype->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_skype" class="users_skype">
<span<?php echo $users->skype->ViewAttributes() ?>>
<?php echo $users->skype->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->website->Visible) { // website ?>
		<td<?php echo $users->website->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_website" class="users_website">
<span<?php echo $users->website->ViewAttributes() ?>>
<?php echo $users->website->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->linkedin->Visible) { // linkedin ?>
		<td<?php echo $users->linkedin->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_linkedin" class="users_linkedin">
<span<?php echo $users->linkedin->ViewAttributes() ?>>
<?php echo $users->linkedin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->facebook->Visible) { // facebook ?>
		<td<?php echo $users->facebook->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_facebook" class="users_facebook">
<span<?php echo $users->facebook->ViewAttributes() ?>>
<?php echo $users->facebook->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->twitter->Visible) { // twitter ?>
		<td<?php echo $users->twitter->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_twitter" class="users_twitter">
<span<?php echo $users->twitter->ViewAttributes() ?>>
<?php echo $users->twitter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->active_code->Visible) { // active_code ?>
		<td<?php echo $users->active_code->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_active_code" class="users_active_code">
<span<?php echo $users->active_code->ViewAttributes() ?>>
<?php echo $users->active_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->identification->Visible) { // identification ?>
		<td<?php echo $users->identification->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_identification" class="users_identification">
<span<?php echo $users->identification->ViewAttributes() ?>>
<?php echo $users->identification->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->link_expired->Visible) { // link_expired ?>
		<td<?php echo $users->link_expired->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_link_expired" class="users_link_expired">
<span<?php echo $users->link_expired->ViewAttributes() ?>>
<?php echo $users->link_expired->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isactive->Visible) { // isactive ?>
		<td<?php echo $users->isactive->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isactive" class="users_isactive">
<span<?php echo $users->isactive->ViewAttributes() ?>>
<?php echo $users->isactive->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->google->Visible) { // google ?>
		<td<?php echo $users->google->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_google" class="users_google">
<span<?php echo $users->google->ViewAttributes() ?>>
<?php echo $users->google->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->instagram->Visible) { // instagram ?>
		<td<?php echo $users->instagram->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_instagram" class="users_instagram">
<span<?php echo $users->instagram->ViewAttributes() ?>>
<?php echo $users->instagram->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->account_type->Visible) { // account_type ?>
		<td<?php echo $users->account_type->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_account_type" class="users_account_type">
<span<?php echo $users->account_type->ViewAttributes() ?>>
<?php echo $users->account_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->logo->Visible) { // logo ?>
		<td<?php echo $users->logo->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_logo" class="users_logo">
<span<?php echo $users->logo->ViewAttributes() ?>>
<?php echo $users->logo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->profilepic->Visible) { // profilepic ?>
		<td<?php echo $users->profilepic->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_profilepic" class="users_profilepic">
<span<?php echo $users->profilepic->ViewAttributes() ?>>
<?php echo $users->profilepic->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->mailref->Visible) { // mailref ?>
		<td<?php echo $users->mailref->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_mailref" class="users_mailref">
<span<?php echo $users->mailref->ViewAttributes() ?>>
<?php echo $users->mailref->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->deleted->Visible) { // deleted ?>
		<td<?php echo $users->deleted->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_deleted" class="users_deleted">
<span<?php echo $users->deleted->ViewAttributes() ?>>
<?php echo $users->deleted->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->deletefeedback->Visible) { // deletefeedback ?>
		<td<?php echo $users->deletefeedback->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_deletefeedback" class="users_deletefeedback">
<span<?php echo $users->deletefeedback->ViewAttributes() ?>>
<?php echo $users->deletefeedback->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->account_id->Visible) { // account_id ?>
		<td<?php echo $users->account_id->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_account_id" class="users_account_id">
<span<?php echo $users->account_id->ViewAttributes() ?>>
<?php echo $users->account_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->start_date->Visible) { // start_date ?>
		<td<?php echo $users->start_date->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_start_date" class="users_start_date">
<span<?php echo $users->start_date->ViewAttributes() ?>>
<?php echo $users->start_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->end_date->Visible) { // end_date ?>
		<td<?php echo $users->end_date->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_end_date" class="users_end_date">
<span<?php echo $users->end_date->ViewAttributes() ?>>
<?php echo $users->end_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->year_moth->Visible) { // year_moth ?>
		<td<?php echo $users->year_moth->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_year_moth" class="users_year_moth">
<span<?php echo $users->year_moth->ViewAttributes() ?>>
<?php echo $users->year_moth->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->registerdate->Visible) { // registerdate ?>
		<td<?php echo $users->registerdate->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_registerdate" class="users_registerdate">
<span<?php echo $users->registerdate->ViewAttributes() ?>>
<?php echo $users->registerdate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->login_type->Visible) { // login_type ?>
		<td<?php echo $users->login_type->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_login_type" class="users_login_type">
<span<?php echo $users->login_type->ViewAttributes() ?>>
<?php echo $users->login_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->accountstatus->Visible) { // accountstatus ?>
		<td<?php echo $users->accountstatus->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_accountstatus" class="users_accountstatus">
<span<?php echo $users->accountstatus->ViewAttributes() ?>>
<?php echo $users->accountstatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->ispay->Visible) { // ispay ?>
		<td<?php echo $users->ispay->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_ispay" class="users_ispay">
<span<?php echo $users->ispay->ViewAttributes() ?>>
<?php echo $users->ispay->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->profilelink->Visible) { // profilelink ?>
		<td<?php echo $users->profilelink->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_profilelink" class="users_profilelink">
<span<?php echo $users->profilelink->ViewAttributes() ?>>
<?php echo $users->profilelink->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->source->Visible) { // source ?>
		<td<?php echo $users->source->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_source" class="users_source">
<span<?php echo $users->source->ViewAttributes() ?>>
<?php echo $users->source->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->agree->Visible) { // agree ?>
		<td<?php echo $users->agree->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_agree" class="users_agree">
<span<?php echo $users->agree->ViewAttributes() ?>>
<?php echo $users->agree->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->balance->Visible) { // balance ?>
		<td<?php echo $users->balance->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_balance" class="users_balance">
<span<?php echo $users->balance->ViewAttributes() ?>>
<?php echo $users->balance->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->job_title->Visible) { // job_title ?>
		<td<?php echo $users->job_title->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_job_title" class="users_job_title">
<span<?php echo $users->job_title->ViewAttributes() ?>>
<?php echo $users->job_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->projects->Visible) { // projects ?>
		<td<?php echo $users->projects->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_projects" class="users_projects">
<span<?php echo $users->projects->ViewAttributes() ?>>
<?php echo $users->projects->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->opportunities->Visible) { // opportunities ?>
		<td<?php echo $users->opportunities->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_opportunities" class="users_opportunities">
<span<?php echo $users->opportunities->ViewAttributes() ?>>
<?php echo $users->opportunities->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isconsaltant->Visible) { // isconsaltant ?>
		<td<?php echo $users->isconsaltant->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isconsaltant" class="users_isconsaltant">
<span<?php echo $users->isconsaltant->ViewAttributes() ?>>
<?php echo $users->isconsaltant->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isagent->Visible) { // isagent ?>
		<td<?php echo $users->isagent->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isagent" class="users_isagent">
<span<?php echo $users->isagent->ViewAttributes() ?>>
<?php echo $users->isagent->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isinvestor->Visible) { // isinvestor ?>
		<td<?php echo $users->isinvestor->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isinvestor" class="users_isinvestor">
<span<?php echo $users->isinvestor->ViewAttributes() ?>>
<?php echo $users->isinvestor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isbusinessman->Visible) { // isbusinessman ?>
		<td<?php echo $users->isbusinessman->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isbusinessman" class="users_isbusinessman">
<span<?php echo $users->isbusinessman->ViewAttributes() ?>>
<?php echo $users->isbusinessman->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isprovider->Visible) { // isprovider ?>
		<td<?php echo $users->isprovider->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isprovider" class="users_isprovider">
<span<?php echo $users->isprovider->ViewAttributes() ?>>
<?php echo $users->isprovider->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->isproductowner->Visible) { // isproductowner ?>
		<td<?php echo $users->isproductowner->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_isproductowner" class="users_isproductowner">
<span<?php echo $users->isproductowner->ViewAttributes() ?>>
<?php echo $users->isproductowner->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->states->Visible) { // states ?>
		<td<?php echo $users->states->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_states" class="users_states">
<span<?php echo $users->states->ViewAttributes() ?>>
<?php echo $users->states->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->cities->Visible) { // cities ?>
		<td<?php echo $users->cities->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_cities" class="users_cities">
<span<?php echo $users->cities->ViewAttributes() ?>>
<?php echo $users->cities->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($users->offers->Visible) { // offers ?>
		<td<?php echo $users->offers->CellAttributes() ?>>
<span id="el<?php echo $users_delete->RowCnt ?>_users_offers" class="users_offers">
<span<?php echo $users->offers->ViewAttributes() ?>>
<?php echo $users->offers->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$users_delete->Recordset->MoveNext();
}
$users_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fusersdelete.Init();
</script>
<?php
$users_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_delete->Page_Terminate();
?>
