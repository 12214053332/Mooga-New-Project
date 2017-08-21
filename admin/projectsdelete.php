<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "projectsinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$projects_delete = NULL; // Initialize page object first

class cprojects_delete extends cprojects {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_delete';

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

		// Table object (projects)
		if (!isset($GLOBALS["projects"]) || get_class($GLOBALS["projects"]) == "cprojects") {
			$GLOBALS["projects"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["projects"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'projects', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("projectslist.php"));
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
		global $EW_EXPORT, $projects;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($projects);
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
			$this->Page_Terminate("projectslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in projects class, projectsinfo.php

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
		$this->user_id->setDbValue($rs->fields('user_id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->project_type_list->setDbValue($rs->fields('project_type_list'));
		$this->project_field_list->setDbValue($rs->fields('project_field_list'));
		$this->description->setDbValue($rs->fields('description'));
		$this->country->setDbValue($rs->fields('country'));
		$this->stage_list->setDbValue($rs->fields('stage_list'));
		$this->project_product_list->setDbValue($rs->fields('project_product_list'));
		$this->project_service_list->setDbValue($rs->fields('project_service_list'));
		$this->needagent->setDbValue($rs->fields('needagent'));
		$this->needpartner->setDbValue($rs->fields('needpartner'));
		$this->needclose->setDbValue($rs->fields('needclose'));
		$this->closedescription->setDbValue($rs->fields('closedescription'));
		$this->views->setDbValue($rs->fields('views'));
		$this->picpath->setDbValue($rs->fields('picpath'));
		$this->createdtime->setDbValue($rs->fields('createdtime'));
		$this->modifiedtime->setDbValue($rs->fields('modifiedtime'));
		$this->needfunder->setDbValue($rs->fields('needfunder'));
		$this->needdealer->setDbValue($rs->fields('needdealer'));
		$this->deleted->setDbValue($rs->fields('deleted'));
		$this->states->setDbValue($rs->fields('states'));
		$this->cities->setDbValue($rs->fields('cities'));
		$this->needbuyer->setDbValue($rs->fields('needbuyer'));
		$this->needdescription->setDbValue($rs->fields('needdescription'));
		$this->contact_type->setDbValue($rs->fields('contact_type'));
		$this->contact_email->setDbValue($rs->fields('contact_email'));
		$this->contact_phone->setDbValue($rs->fields('contact_phone'));
		$this->contact_name->setDbValue($rs->fields('contact_name'));
		$this->budget->setDbValue($rs->fields('budget'));
		$this->pending->setDbValue($rs->fields('pending'));
		$this->verified_code->setDbValue($rs->fields('verified_code'));
		$this->country_1->setDbValue($rs->fields('country_1'));
		$this->done->setDbValue($rs->fields('done'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->name->DbValue = $row['name'];
		$this->project_type_list->DbValue = $row['project_type_list'];
		$this->project_field_list->DbValue = $row['project_field_list'];
		$this->description->DbValue = $row['description'];
		$this->country->DbValue = $row['country'];
		$this->stage_list->DbValue = $row['stage_list'];
		$this->project_product_list->DbValue = $row['project_product_list'];
		$this->project_service_list->DbValue = $row['project_service_list'];
		$this->needagent->DbValue = $row['needagent'];
		$this->needpartner->DbValue = $row['needpartner'];
		$this->needclose->DbValue = $row['needclose'];
		$this->closedescription->DbValue = $row['closedescription'];
		$this->views->DbValue = $row['views'];
		$this->picpath->DbValue = $row['picpath'];
		$this->createdtime->DbValue = $row['createdtime'];
		$this->modifiedtime->DbValue = $row['modifiedtime'];
		$this->needfunder->DbValue = $row['needfunder'];
		$this->needdealer->DbValue = $row['needdealer'];
		$this->deleted->DbValue = $row['deleted'];
		$this->states->DbValue = $row['states'];
		$this->cities->DbValue = $row['cities'];
		$this->needbuyer->DbValue = $row['needbuyer'];
		$this->needdescription->DbValue = $row['needdescription'];
		$this->contact_type->DbValue = $row['contact_type'];
		$this->contact_email->DbValue = $row['contact_email'];
		$this->contact_phone->DbValue = $row['contact_phone'];
		$this->contact_name->DbValue = $row['contact_name'];
		$this->budget->DbValue = $row['budget'];
		$this->pending->DbValue = $row['pending'];
		$this->verified_code->DbValue = $row['verified_code'];
		$this->country_1->DbValue = $row['country_1'];
		$this->done->DbValue = $row['done'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->budget->FormValue == $this->budget->CurrentValue && is_numeric(ew_StrToFloat($this->budget->CurrentValue)))
			$this->budget->CurrentValue = ew_StrToFloat($this->budget->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// user_id
		// name
		// project_type_list
		// project_field_list
		// description
		// country
		// stage_list
		// project_product_list
		// project_service_list
		// needagent
		// needpartner
		// needclose
		// closedescription
		// views
		// picpath
		// createdtime
		// modifiedtime
		// needfunder
		// needdealer
		// deleted
		// states
		// cities
		// needbuyer
		// needdescription
		// contact_type
		// contact_email
		// contact_phone
		// contact_name
		// budget
		// pending
		// verified_code
		// country_1
		// done

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// stage_list
		$this->stage_list->ViewValue = $this->stage_list->CurrentValue;
		$this->stage_list->ViewCustomAttributes = "";

		// needagent
		$this->needagent->ViewValue = $this->needagent->CurrentValue;
		$this->needagent->ViewCustomAttributes = "";

		// needpartner
		$this->needpartner->ViewValue = $this->needpartner->CurrentValue;
		$this->needpartner->ViewCustomAttributes = "";

		// needclose
		$this->needclose->ViewValue = $this->needclose->CurrentValue;
		$this->needclose->ViewCustomAttributes = "";

		// closedescription
		$this->closedescription->ViewValue = $this->closedescription->CurrentValue;
		$this->closedescription->ViewCustomAttributes = "";

		// views
		$this->views->ViewValue = $this->views->CurrentValue;
		$this->views->ViewCustomAttributes = "";

		// picpath
		$this->picpath->ViewValue = $this->picpath->CurrentValue;
		$this->picpath->ViewCustomAttributes = "";

		// createdtime
		$this->createdtime->ViewValue = $this->createdtime->CurrentValue;
		$this->createdtime->ViewValue = ew_FormatDateTime($this->createdtime->ViewValue, 5);
		$this->createdtime->ViewCustomAttributes = "";

		// modifiedtime
		$this->modifiedtime->ViewValue = $this->modifiedtime->CurrentValue;
		$this->modifiedtime->ViewValue = ew_FormatDateTime($this->modifiedtime->ViewValue, 5);
		$this->modifiedtime->ViewCustomAttributes = "";

		// needfunder
		$this->needfunder->ViewValue = $this->needfunder->CurrentValue;
		$this->needfunder->ViewCustomAttributes = "";

		// needdealer
		$this->needdealer->ViewValue = $this->needdealer->CurrentValue;
		$this->needdealer->ViewCustomAttributes = "";

		// deleted
		$this->deleted->ViewValue = $this->deleted->CurrentValue;
		$this->deleted->ViewCustomAttributes = "";

		// states
		$this->states->ViewValue = $this->states->CurrentValue;
		$this->states->ViewCustomAttributes = "";

		// cities
		$this->cities->ViewValue = $this->cities->CurrentValue;
		$this->cities->ViewCustomAttributes = "";

		// needbuyer
		$this->needbuyer->ViewValue = $this->needbuyer->CurrentValue;
		$this->needbuyer->ViewCustomAttributes = "";

		// needdescription
		$this->needdescription->ViewValue = $this->needdescription->CurrentValue;
		$this->needdescription->ViewCustomAttributes = "";

		// contact_type
		$this->contact_type->ViewValue = $this->contact_type->CurrentValue;
		$this->contact_type->ViewCustomAttributes = "";

		// contact_email
		$this->contact_email->ViewValue = $this->contact_email->CurrentValue;
		$this->contact_email->ViewCustomAttributes = "";

		// contact_phone
		$this->contact_phone->ViewValue = $this->contact_phone->CurrentValue;
		$this->contact_phone->ViewCustomAttributes = "";

		// contact_name
		$this->contact_name->ViewValue = $this->contact_name->CurrentValue;
		$this->contact_name->ViewCustomAttributes = "";

		// budget
		$this->budget->ViewValue = $this->budget->CurrentValue;
		$this->budget->ViewCustomAttributes = "";

		// pending
		$this->pending->ViewValue = $this->pending->CurrentValue;
		$this->pending->ViewCustomAttributes = "";

		// verified_code
		$this->verified_code->ViewValue = $this->verified_code->CurrentValue;
		$this->verified_code->ViewCustomAttributes = "";

		// country_1
		$this->country_1->ViewValue = $this->country_1->CurrentValue;
		$this->country_1->ViewCustomAttributes = "";

		// done
		$this->done->ViewValue = $this->done->CurrentValue;
		$this->done->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";

			// stage_list
			$this->stage_list->LinkCustomAttributes = "";
			$this->stage_list->HrefValue = "";
			$this->stage_list->TooltipValue = "";

			// needagent
			$this->needagent->LinkCustomAttributes = "";
			$this->needagent->HrefValue = "";
			$this->needagent->TooltipValue = "";

			// needpartner
			$this->needpartner->LinkCustomAttributes = "";
			$this->needpartner->HrefValue = "";
			$this->needpartner->TooltipValue = "";

			// needclose
			$this->needclose->LinkCustomAttributes = "";
			$this->needclose->HrefValue = "";
			$this->needclose->TooltipValue = "";

			// closedescription
			$this->closedescription->LinkCustomAttributes = "";
			$this->closedescription->HrefValue = "";
			$this->closedescription->TooltipValue = "";

			// views
			$this->views->LinkCustomAttributes = "";
			$this->views->HrefValue = "";
			$this->views->TooltipValue = "";

			// picpath
			$this->picpath->LinkCustomAttributes = "";
			$this->picpath->HrefValue = "";
			$this->picpath->TooltipValue = "";

			// createdtime
			$this->createdtime->LinkCustomAttributes = "";
			$this->createdtime->HrefValue = "";
			$this->createdtime->TooltipValue = "";

			// modifiedtime
			$this->modifiedtime->LinkCustomAttributes = "";
			$this->modifiedtime->HrefValue = "";
			$this->modifiedtime->TooltipValue = "";

			// needfunder
			$this->needfunder->LinkCustomAttributes = "";
			$this->needfunder->HrefValue = "";
			$this->needfunder->TooltipValue = "";

			// needdealer
			$this->needdealer->LinkCustomAttributes = "";
			$this->needdealer->HrefValue = "";
			$this->needdealer->TooltipValue = "";

			// deleted
			$this->deleted->LinkCustomAttributes = "";
			$this->deleted->HrefValue = "";
			$this->deleted->TooltipValue = "";

			// states
			$this->states->LinkCustomAttributes = "";
			$this->states->HrefValue = "";
			$this->states->TooltipValue = "";

			// cities
			$this->cities->LinkCustomAttributes = "";
			$this->cities->HrefValue = "";
			$this->cities->TooltipValue = "";

			// needbuyer
			$this->needbuyer->LinkCustomAttributes = "";
			$this->needbuyer->HrefValue = "";
			$this->needbuyer->TooltipValue = "";

			// needdescription
			$this->needdescription->LinkCustomAttributes = "";
			$this->needdescription->HrefValue = "";
			$this->needdescription->TooltipValue = "";

			// contact_type
			$this->contact_type->LinkCustomAttributes = "";
			$this->contact_type->HrefValue = "";
			$this->contact_type->TooltipValue = "";

			// contact_email
			$this->contact_email->LinkCustomAttributes = "";
			$this->contact_email->HrefValue = "";
			$this->contact_email->TooltipValue = "";

			// contact_phone
			$this->contact_phone->LinkCustomAttributes = "";
			$this->contact_phone->HrefValue = "";
			$this->contact_phone->TooltipValue = "";

			// contact_name
			$this->contact_name->LinkCustomAttributes = "";
			$this->contact_name->HrefValue = "";
			$this->contact_name->TooltipValue = "";

			// budget
			$this->budget->LinkCustomAttributes = "";
			$this->budget->HrefValue = "";
			$this->budget->TooltipValue = "";

			// pending
			$this->pending->LinkCustomAttributes = "";
			$this->pending->HrefValue = "";
			$this->pending->TooltipValue = "";

			// verified_code
			$this->verified_code->LinkCustomAttributes = "";
			$this->verified_code->HrefValue = "";
			$this->verified_code->TooltipValue = "";

			// country_1
			$this->country_1->LinkCustomAttributes = "";
			$this->country_1->HrefValue = "";
			$this->country_1->TooltipValue = "";

			// done
			$this->done->LinkCustomAttributes = "";
			$this->done->HrefValue = "";
			$this->done->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, "projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($projects_delete)) $projects_delete = new cprojects_delete();

// Page init
$projects_delete->Page_Init();

// Page main
$projects_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fprojectsdelete = new ew_Form("fprojectsdelete", "delete");

// Form_CustomValidate event
fprojectsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectsdelete.ValidateRequired = true;
<?php } else { ?>
fprojectsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($projects_delete->Recordset = $projects_delete->LoadRecordset())
	$projects_deleteTotalRecs = $projects_delete->Recordset->RecordCount(); // Get record count
if ($projects_deleteTotalRecs <= 0) { // No record found, exit
	if ($projects_delete->Recordset)
		$projects_delete->Recordset->Close();
	$projects_delete->Page_Terminate("projectslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $projects_delete->ShowPageHeader(); ?>
<?php
$projects_delete->ShowMessage();
?>
<form name="fprojectsdelete" id="fprojectsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($projects_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $projects->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($projects->id->Visible) { // id ?>
		<th><span id="elh_projects_id" class="projects_id"><?php echo $projects->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->user_id->Visible) { // user_id ?>
		<th><span id="elh_projects_user_id" class="projects_user_id"><?php echo $projects->user_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->name->Visible) { // name ?>
		<th><span id="elh_projects_name" class="projects_name"><?php echo $projects->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->country->Visible) { // country ?>
		<th><span id="elh_projects_country" class="projects_country"><?php echo $projects->country->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->stage_list->Visible) { // stage_list ?>
		<th><span id="elh_projects_stage_list" class="projects_stage_list"><?php echo $projects->stage_list->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needagent->Visible) { // needagent ?>
		<th><span id="elh_projects_needagent" class="projects_needagent"><?php echo $projects->needagent->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needpartner->Visible) { // needpartner ?>
		<th><span id="elh_projects_needpartner" class="projects_needpartner"><?php echo $projects->needpartner->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needclose->Visible) { // needclose ?>
		<th><span id="elh_projects_needclose" class="projects_needclose"><?php echo $projects->needclose->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->closedescription->Visible) { // closedescription ?>
		<th><span id="elh_projects_closedescription" class="projects_closedescription"><?php echo $projects->closedescription->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->views->Visible) { // views ?>
		<th><span id="elh_projects_views" class="projects_views"><?php echo $projects->views->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->picpath->Visible) { // picpath ?>
		<th><span id="elh_projects_picpath" class="projects_picpath"><?php echo $projects->picpath->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->createdtime->Visible) { // createdtime ?>
		<th><span id="elh_projects_createdtime" class="projects_createdtime"><?php echo $projects->createdtime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
		<th><span id="elh_projects_modifiedtime" class="projects_modifiedtime"><?php echo $projects->modifiedtime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needfunder->Visible) { // needfunder ?>
		<th><span id="elh_projects_needfunder" class="projects_needfunder"><?php echo $projects->needfunder->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needdealer->Visible) { // needdealer ?>
		<th><span id="elh_projects_needdealer" class="projects_needdealer"><?php echo $projects->needdealer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->deleted->Visible) { // deleted ?>
		<th><span id="elh_projects_deleted" class="projects_deleted"><?php echo $projects->deleted->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->states->Visible) { // states ?>
		<th><span id="elh_projects_states" class="projects_states"><?php echo $projects->states->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->cities->Visible) { // cities ?>
		<th><span id="elh_projects_cities" class="projects_cities"><?php echo $projects->cities->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
		<th><span id="elh_projects_needbuyer" class="projects_needbuyer"><?php echo $projects->needbuyer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->needdescription->Visible) { // needdescription ?>
		<th><span id="elh_projects_needdescription" class="projects_needdescription"><?php echo $projects->needdescription->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->contact_type->Visible) { // contact_type ?>
		<th><span id="elh_projects_contact_type" class="projects_contact_type"><?php echo $projects->contact_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->contact_email->Visible) { // contact_email ?>
		<th><span id="elh_projects_contact_email" class="projects_contact_email"><?php echo $projects->contact_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
		<th><span id="elh_projects_contact_phone" class="projects_contact_phone"><?php echo $projects->contact_phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->contact_name->Visible) { // contact_name ?>
		<th><span id="elh_projects_contact_name" class="projects_contact_name"><?php echo $projects->contact_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->budget->Visible) { // budget ?>
		<th><span id="elh_projects_budget" class="projects_budget"><?php echo $projects->budget->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->pending->Visible) { // pending ?>
		<th><span id="elh_projects_pending" class="projects_pending"><?php echo $projects->pending->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->verified_code->Visible) { // verified_code ?>
		<th><span id="elh_projects_verified_code" class="projects_verified_code"><?php echo $projects->verified_code->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->country_1->Visible) { // country_1 ?>
		<th><span id="elh_projects_country_1" class="projects_country_1"><?php echo $projects->country_1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($projects->done->Visible) { // done ?>
		<th><span id="elh_projects_done" class="projects_done"><?php echo $projects->done->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$projects_delete->RecCnt = 0;
$i = 0;
while (!$projects_delete->Recordset->EOF) {
	$projects_delete->RecCnt++;
	$projects_delete->RowCnt++;

	// Set row properties
	$projects->ResetAttrs();
	$projects->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$projects_delete->LoadRowValues($projects_delete->Recordset);

	// Render row
	$projects_delete->RenderRow();
?>
	<tr<?php echo $projects->RowAttributes() ?>>
<?php if ($projects->id->Visible) { // id ?>
		<td<?php echo $projects->id->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_id" class="projects_id">
<span<?php echo $projects->id->ViewAttributes() ?>>
<?php echo $projects->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->user_id->Visible) { // user_id ?>
		<td<?php echo $projects->user_id->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_user_id" class="projects_user_id">
<span<?php echo $projects->user_id->ViewAttributes() ?>>
<?php echo $projects->user_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->name->Visible) { // name ?>
		<td<?php echo $projects->name->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_name" class="projects_name">
<span<?php echo $projects->name->ViewAttributes() ?>>
<?php echo $projects->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->country->Visible) { // country ?>
		<td<?php echo $projects->country->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_country" class="projects_country">
<span<?php echo $projects->country->ViewAttributes() ?>>
<?php echo $projects->country->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->stage_list->Visible) { // stage_list ?>
		<td<?php echo $projects->stage_list->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_stage_list" class="projects_stage_list">
<span<?php echo $projects->stage_list->ViewAttributes() ?>>
<?php echo $projects->stage_list->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needagent->Visible) { // needagent ?>
		<td<?php echo $projects->needagent->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needagent" class="projects_needagent">
<span<?php echo $projects->needagent->ViewAttributes() ?>>
<?php echo $projects->needagent->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needpartner->Visible) { // needpartner ?>
		<td<?php echo $projects->needpartner->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needpartner" class="projects_needpartner">
<span<?php echo $projects->needpartner->ViewAttributes() ?>>
<?php echo $projects->needpartner->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needclose->Visible) { // needclose ?>
		<td<?php echo $projects->needclose->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needclose" class="projects_needclose">
<span<?php echo $projects->needclose->ViewAttributes() ?>>
<?php echo $projects->needclose->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->closedescription->Visible) { // closedescription ?>
		<td<?php echo $projects->closedescription->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_closedescription" class="projects_closedescription">
<span<?php echo $projects->closedescription->ViewAttributes() ?>>
<?php echo $projects->closedescription->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->views->Visible) { // views ?>
		<td<?php echo $projects->views->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_views" class="projects_views">
<span<?php echo $projects->views->ViewAttributes() ?>>
<?php echo $projects->views->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->picpath->Visible) { // picpath ?>
		<td<?php echo $projects->picpath->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_picpath" class="projects_picpath">
<span<?php echo $projects->picpath->ViewAttributes() ?>>
<?php echo $projects->picpath->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->createdtime->Visible) { // createdtime ?>
		<td<?php echo $projects->createdtime->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_createdtime" class="projects_createdtime">
<span<?php echo $projects->createdtime->ViewAttributes() ?>>
<?php echo $projects->createdtime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
		<td<?php echo $projects->modifiedtime->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_modifiedtime" class="projects_modifiedtime">
<span<?php echo $projects->modifiedtime->ViewAttributes() ?>>
<?php echo $projects->modifiedtime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needfunder->Visible) { // needfunder ?>
		<td<?php echo $projects->needfunder->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needfunder" class="projects_needfunder">
<span<?php echo $projects->needfunder->ViewAttributes() ?>>
<?php echo $projects->needfunder->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needdealer->Visible) { // needdealer ?>
		<td<?php echo $projects->needdealer->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needdealer" class="projects_needdealer">
<span<?php echo $projects->needdealer->ViewAttributes() ?>>
<?php echo $projects->needdealer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->deleted->Visible) { // deleted ?>
		<td<?php echo $projects->deleted->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_deleted" class="projects_deleted">
<span<?php echo $projects->deleted->ViewAttributes() ?>>
<?php echo $projects->deleted->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->states->Visible) { // states ?>
		<td<?php echo $projects->states->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_states" class="projects_states">
<span<?php echo $projects->states->ViewAttributes() ?>>
<?php echo $projects->states->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->cities->Visible) { // cities ?>
		<td<?php echo $projects->cities->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_cities" class="projects_cities">
<span<?php echo $projects->cities->ViewAttributes() ?>>
<?php echo $projects->cities->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
		<td<?php echo $projects->needbuyer->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needbuyer" class="projects_needbuyer">
<span<?php echo $projects->needbuyer->ViewAttributes() ?>>
<?php echo $projects->needbuyer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->needdescription->Visible) { // needdescription ?>
		<td<?php echo $projects->needdescription->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_needdescription" class="projects_needdescription">
<span<?php echo $projects->needdescription->ViewAttributes() ?>>
<?php echo $projects->needdescription->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->contact_type->Visible) { // contact_type ?>
		<td<?php echo $projects->contact_type->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_contact_type" class="projects_contact_type">
<span<?php echo $projects->contact_type->ViewAttributes() ?>>
<?php echo $projects->contact_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->contact_email->Visible) { // contact_email ?>
		<td<?php echo $projects->contact_email->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_contact_email" class="projects_contact_email">
<span<?php echo $projects->contact_email->ViewAttributes() ?>>
<?php echo $projects->contact_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
		<td<?php echo $projects->contact_phone->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_contact_phone" class="projects_contact_phone">
<span<?php echo $projects->contact_phone->ViewAttributes() ?>>
<?php echo $projects->contact_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->contact_name->Visible) { // contact_name ?>
		<td<?php echo $projects->contact_name->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_contact_name" class="projects_contact_name">
<span<?php echo $projects->contact_name->ViewAttributes() ?>>
<?php echo $projects->contact_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->budget->Visible) { // budget ?>
		<td<?php echo $projects->budget->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_budget" class="projects_budget">
<span<?php echo $projects->budget->ViewAttributes() ?>>
<?php echo $projects->budget->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->pending->Visible) { // pending ?>
		<td<?php echo $projects->pending->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_pending" class="projects_pending">
<span<?php echo $projects->pending->ViewAttributes() ?>>
<?php echo $projects->pending->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->verified_code->Visible) { // verified_code ?>
		<td<?php echo $projects->verified_code->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_verified_code" class="projects_verified_code">
<span<?php echo $projects->verified_code->ViewAttributes() ?>>
<?php echo $projects->verified_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->country_1->Visible) { // country_1 ?>
		<td<?php echo $projects->country_1->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_country_1" class="projects_country_1">
<span<?php echo $projects->country_1->ViewAttributes() ?>>
<?php echo $projects->country_1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($projects->done->Visible) { // done ?>
		<td<?php echo $projects->done->CellAttributes() ?>>
<span id="el<?php echo $projects_delete->RowCnt ?>_projects_done" class="projects_done">
<span<?php echo $projects->done->ViewAttributes() ?>>
<?php echo $projects->done->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$projects_delete->Recordset->MoveNext();
}
$projects_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $projects_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fprojectsdelete.Init();
</script>
<?php
$projects_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$projects_delete->Page_Terminate();
?>
