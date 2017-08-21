<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "offersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$offers_delete = NULL; // Initialize page object first

class coffers_delete extends coffers {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'offers';

	// Page object name
	var $PageObjName = 'offers_delete';

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

		// Table object (offers)
		if (!isset($GLOBALS["offers"]) || get_class($GLOBALS["offers"]) == "coffers") {
			$GLOBALS["offers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["offers"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'offers', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("offerslist.php"));
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
		global $EW_EXPORT, $offers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($offers);
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
			$this->Page_Terminate("offerslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in offers class, offersinfo.php

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
		$this->offer_type_filed->setDbValue($rs->fields('offer_type_filed'));
		$this->name->setDbValue($rs->fields('name'));
		$this->item_type->setDbValue($rs->fields('item_type'));
		$this->item_brand->setDbValue($rs->fields('item_brand'));
		$this->min_qty->setDbValue($rs->fields('min_qty'));
		$this->price->setDbValue($rs->fields('price'));
		$this->description->setDbValue($rs->fields('description'));
		$this->country->setDbValue($rs->fields('country'));
		$this->states->setDbValue($rs->fields('states'));
		$this->cities->setDbValue($rs->fields('cities'));
		$this->contact_name->setDbValue($rs->fields('contact_name'));
		$this->contact_phone->setDbValue($rs->fields('contact_phone'));
		$this->contact_type->setDbValue($rs->fields('contact_type'));
		$this->contact_email->setDbValue($rs->fields('contact_email'));
		$this->picpath->setDbValue($rs->fields('picpath'));
		$this->createdtime->setDbValue($rs->fields('createdtime'));
		$this->modifiedtime->setDbValue($rs->fields('modifiedtime'));
		$this->deleted->setDbValue($rs->fields('deleted'));
		$this->views->setDbValue($rs->fields('views'));
		$this->verified_code->setDbValue($rs->fields('verified_code'));
		$this->pending->setDbValue($rs->fields('pending'));
		$this->country_1->setDbValue($rs->fields('country_1'));
		$this->num_send_sms->setDbValue($rs->fields('num_send_sms'));
		$this->num_send_email->setDbValue($rs->fields('num_send_email'));
		$this->done->setDbValue($rs->fields('done'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->offer_type_filed->DbValue = $row['offer_type_filed'];
		$this->name->DbValue = $row['name'];
		$this->item_type->DbValue = $row['item_type'];
		$this->item_brand->DbValue = $row['item_brand'];
		$this->min_qty->DbValue = $row['min_qty'];
		$this->price->DbValue = $row['price'];
		$this->description->DbValue = $row['description'];
		$this->country->DbValue = $row['country'];
		$this->states->DbValue = $row['states'];
		$this->cities->DbValue = $row['cities'];
		$this->contact_name->DbValue = $row['contact_name'];
		$this->contact_phone->DbValue = $row['contact_phone'];
		$this->contact_type->DbValue = $row['contact_type'];
		$this->contact_email->DbValue = $row['contact_email'];
		$this->picpath->DbValue = $row['picpath'];
		$this->createdtime->DbValue = $row['createdtime'];
		$this->modifiedtime->DbValue = $row['modifiedtime'];
		$this->deleted->DbValue = $row['deleted'];
		$this->views->DbValue = $row['views'];
		$this->verified_code->DbValue = $row['verified_code'];
		$this->pending->DbValue = $row['pending'];
		$this->country_1->DbValue = $row['country_1'];
		$this->num_send_sms->DbValue = $row['num_send_sms'];
		$this->num_send_email->DbValue = $row['num_send_email'];
		$this->done->DbValue = $row['done'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->price->FormValue == $this->price->CurrentValue && is_numeric(ew_StrToFloat($this->price->CurrentValue)))
			$this->price->CurrentValue = ew_StrToFloat($this->price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// user_id
		// offer_type_filed
		// name
		// item_type
		// item_brand
		// min_qty
		// price
		// description
		// country
		// states
		// cities
		// contact_name
		// contact_phone
		// contact_type
		// contact_email
		// picpath
		// createdtime
		// modifiedtime
		// deleted
		// views
		// verified_code
		// pending
		// country_1
		// num_send_sms
		// num_send_email
		// done

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// offer_type_filed
		$this->offer_type_filed->ViewValue = $this->offer_type_filed->CurrentValue;
		$this->offer_type_filed->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// item_type
		$this->item_type->ViewValue = $this->item_type->CurrentValue;
		$this->item_type->ViewCustomAttributes = "";

		// item_brand
		$this->item_brand->ViewValue = $this->item_brand->CurrentValue;
		$this->item_brand->ViewCustomAttributes = "";

		// min_qty
		$this->min_qty->ViewValue = $this->min_qty->CurrentValue;
		$this->min_qty->ViewCustomAttributes = "";

		// price
		$this->price->ViewValue = $this->price->CurrentValue;
		$this->price->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// states
		$this->states->ViewValue = $this->states->CurrentValue;
		$this->states->ViewCustomAttributes = "";

		// cities
		$this->cities->ViewValue = $this->cities->CurrentValue;
		$this->cities->ViewCustomAttributes = "";

		// contact_name
		$this->contact_name->ViewValue = $this->contact_name->CurrentValue;
		$this->contact_name->ViewCustomAttributes = "";

		// contact_phone
		$this->contact_phone->ViewValue = $this->contact_phone->CurrentValue;
		$this->contact_phone->ViewCustomAttributes = "";

		// contact_type
		$this->contact_type->ViewValue = $this->contact_type->CurrentValue;
		$this->contact_type->ViewCustomAttributes = "";

		// contact_email
		$this->contact_email->ViewValue = $this->contact_email->CurrentValue;
		$this->contact_email->ViewCustomAttributes = "";

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

		// deleted
		$this->deleted->ViewValue = $this->deleted->CurrentValue;
		$this->deleted->ViewCustomAttributes = "";

		// views
		$this->views->ViewValue = $this->views->CurrentValue;
		$this->views->ViewCustomAttributes = "";

		// verified_code
		$this->verified_code->ViewValue = $this->verified_code->CurrentValue;
		$this->verified_code->ViewCustomAttributes = "";

		// pending
		$this->pending->ViewValue = $this->pending->CurrentValue;
		$this->pending->ViewCustomAttributes = "";

		// country_1
		$this->country_1->ViewValue = $this->country_1->CurrentValue;
		$this->country_1->ViewCustomAttributes = "";

		// num_send_sms
		$this->num_send_sms->ViewValue = $this->num_send_sms->CurrentValue;
		$this->num_send_sms->ViewCustomAttributes = "";

		// num_send_email
		$this->num_send_email->ViewValue = $this->num_send_email->CurrentValue;
		$this->num_send_email->ViewCustomAttributes = "";

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

			// offer_type_filed
			$this->offer_type_filed->LinkCustomAttributes = "";
			$this->offer_type_filed->HrefValue = "";
			$this->offer_type_filed->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// item_type
			$this->item_type->LinkCustomAttributes = "";
			$this->item_type->HrefValue = "";
			$this->item_type->TooltipValue = "";

			// item_brand
			$this->item_brand->LinkCustomAttributes = "";
			$this->item_brand->HrefValue = "";
			$this->item_brand->TooltipValue = "";

			// min_qty
			$this->min_qty->LinkCustomAttributes = "";
			$this->min_qty->HrefValue = "";
			$this->min_qty->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";

			// states
			$this->states->LinkCustomAttributes = "";
			$this->states->HrefValue = "";
			$this->states->TooltipValue = "";

			// cities
			$this->cities->LinkCustomAttributes = "";
			$this->cities->HrefValue = "";
			$this->cities->TooltipValue = "";

			// contact_name
			$this->contact_name->LinkCustomAttributes = "";
			$this->contact_name->HrefValue = "";
			$this->contact_name->TooltipValue = "";

			// contact_phone
			$this->contact_phone->LinkCustomAttributes = "";
			$this->contact_phone->HrefValue = "";
			$this->contact_phone->TooltipValue = "";

			// contact_type
			$this->contact_type->LinkCustomAttributes = "";
			$this->contact_type->HrefValue = "";
			$this->contact_type->TooltipValue = "";

			// contact_email
			$this->contact_email->LinkCustomAttributes = "";
			$this->contact_email->HrefValue = "";
			$this->contact_email->TooltipValue = "";

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

			// deleted
			$this->deleted->LinkCustomAttributes = "";
			$this->deleted->HrefValue = "";
			$this->deleted->TooltipValue = "";

			// views
			$this->views->LinkCustomAttributes = "";
			$this->views->HrefValue = "";
			$this->views->TooltipValue = "";

			// verified_code
			$this->verified_code->LinkCustomAttributes = "";
			$this->verified_code->HrefValue = "";
			$this->verified_code->TooltipValue = "";

			// pending
			$this->pending->LinkCustomAttributes = "";
			$this->pending->HrefValue = "";
			$this->pending->TooltipValue = "";

			// country_1
			$this->country_1->LinkCustomAttributes = "";
			$this->country_1->HrefValue = "";
			$this->country_1->TooltipValue = "";

			// num_send_sms
			$this->num_send_sms->LinkCustomAttributes = "";
			$this->num_send_sms->HrefValue = "";
			$this->num_send_sms->TooltipValue = "";

			// num_send_email
			$this->num_send_email->LinkCustomAttributes = "";
			$this->num_send_email->HrefValue = "";
			$this->num_send_email->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, "offerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($offers_delete)) $offers_delete = new coffers_delete();

// Page init
$offers_delete->Page_Init();

// Page main
$offers_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$offers_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = foffersdelete = new ew_Form("foffersdelete", "delete");

// Form_CustomValidate event
foffersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
foffersdelete.ValidateRequired = true;
<?php } else { ?>
foffersdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($offers_delete->Recordset = $offers_delete->LoadRecordset())
	$offers_deleteTotalRecs = $offers_delete->Recordset->RecordCount(); // Get record count
if ($offers_deleteTotalRecs <= 0) { // No record found, exit
	if ($offers_delete->Recordset)
		$offers_delete->Recordset->Close();
	$offers_delete->Page_Terminate("offerslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $offers_delete->ShowPageHeader(); ?>
<?php
$offers_delete->ShowMessage();
?>
<form name="foffersdelete" id="foffersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($offers_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $offers_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="offers">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($offers_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $offers->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($offers->id->Visible) { // id ?>
		<th><span id="elh_offers_id" class="offers_id"><?php echo $offers->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->user_id->Visible) { // user_id ?>
		<th><span id="elh_offers_user_id" class="offers_user_id"><?php echo $offers->user_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->offer_type_filed->Visible) { // offer_type_filed ?>
		<th><span id="elh_offers_offer_type_filed" class="offers_offer_type_filed"><?php echo $offers->offer_type_filed->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->name->Visible) { // name ?>
		<th><span id="elh_offers_name" class="offers_name"><?php echo $offers->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->item_type->Visible) { // item_type ?>
		<th><span id="elh_offers_item_type" class="offers_item_type"><?php echo $offers->item_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->item_brand->Visible) { // item_brand ?>
		<th><span id="elh_offers_item_brand" class="offers_item_brand"><?php echo $offers->item_brand->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->min_qty->Visible) { // min_qty ?>
		<th><span id="elh_offers_min_qty" class="offers_min_qty"><?php echo $offers->min_qty->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->price->Visible) { // price ?>
		<th><span id="elh_offers_price" class="offers_price"><?php echo $offers->price->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->description->Visible) { // description ?>
		<th><span id="elh_offers_description" class="offers_description"><?php echo $offers->description->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->country->Visible) { // country ?>
		<th><span id="elh_offers_country" class="offers_country"><?php echo $offers->country->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->states->Visible) { // states ?>
		<th><span id="elh_offers_states" class="offers_states"><?php echo $offers->states->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->cities->Visible) { // cities ?>
		<th><span id="elh_offers_cities" class="offers_cities"><?php echo $offers->cities->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->contact_name->Visible) { // contact_name ?>
		<th><span id="elh_offers_contact_name" class="offers_contact_name"><?php echo $offers->contact_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->contact_phone->Visible) { // contact_phone ?>
		<th><span id="elh_offers_contact_phone" class="offers_contact_phone"><?php echo $offers->contact_phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->contact_type->Visible) { // contact_type ?>
		<th><span id="elh_offers_contact_type" class="offers_contact_type"><?php echo $offers->contact_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->contact_email->Visible) { // contact_email ?>
		<th><span id="elh_offers_contact_email" class="offers_contact_email"><?php echo $offers->contact_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->picpath->Visible) { // picpath ?>
		<th><span id="elh_offers_picpath" class="offers_picpath"><?php echo $offers->picpath->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->createdtime->Visible) { // createdtime ?>
		<th><span id="elh_offers_createdtime" class="offers_createdtime"><?php echo $offers->createdtime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->modifiedtime->Visible) { // modifiedtime ?>
		<th><span id="elh_offers_modifiedtime" class="offers_modifiedtime"><?php echo $offers->modifiedtime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->deleted->Visible) { // deleted ?>
		<th><span id="elh_offers_deleted" class="offers_deleted"><?php echo $offers->deleted->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->views->Visible) { // views ?>
		<th><span id="elh_offers_views" class="offers_views"><?php echo $offers->views->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->verified_code->Visible) { // verified_code ?>
		<th><span id="elh_offers_verified_code" class="offers_verified_code"><?php echo $offers->verified_code->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->pending->Visible) { // pending ?>
		<th><span id="elh_offers_pending" class="offers_pending"><?php echo $offers->pending->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->country_1->Visible) { // country_1 ?>
		<th><span id="elh_offers_country_1" class="offers_country_1"><?php echo $offers->country_1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->num_send_sms->Visible) { // num_send_sms ?>
		<th><span id="elh_offers_num_send_sms" class="offers_num_send_sms"><?php echo $offers->num_send_sms->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->num_send_email->Visible) { // num_send_email ?>
		<th><span id="elh_offers_num_send_email" class="offers_num_send_email"><?php echo $offers->num_send_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($offers->done->Visible) { // done ?>
		<th><span id="elh_offers_done" class="offers_done"><?php echo $offers->done->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$offers_delete->RecCnt = 0;
$i = 0;
while (!$offers_delete->Recordset->EOF) {
	$offers_delete->RecCnt++;
	$offers_delete->RowCnt++;

	// Set row properties
	$offers->ResetAttrs();
	$offers->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$offers_delete->LoadRowValues($offers_delete->Recordset);

	// Render row
	$offers_delete->RenderRow();
?>
	<tr<?php echo $offers->RowAttributes() ?>>
<?php if ($offers->id->Visible) { // id ?>
		<td<?php echo $offers->id->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_id" class="offers_id">
<span<?php echo $offers->id->ViewAttributes() ?>>
<?php echo $offers->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->user_id->Visible) { // user_id ?>
		<td<?php echo $offers->user_id->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_user_id" class="offers_user_id">
<span<?php echo $offers->user_id->ViewAttributes() ?>>
<?php echo $offers->user_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->offer_type_filed->Visible) { // offer_type_filed ?>
		<td<?php echo $offers->offer_type_filed->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_offer_type_filed" class="offers_offer_type_filed">
<span<?php echo $offers->offer_type_filed->ViewAttributes() ?>>
<?php echo $offers->offer_type_filed->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->name->Visible) { // name ?>
		<td<?php echo $offers->name->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_name" class="offers_name">
<span<?php echo $offers->name->ViewAttributes() ?>>
<?php echo $offers->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->item_type->Visible) { // item_type ?>
		<td<?php echo $offers->item_type->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_item_type" class="offers_item_type">
<span<?php echo $offers->item_type->ViewAttributes() ?>>
<?php echo $offers->item_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->item_brand->Visible) { // item_brand ?>
		<td<?php echo $offers->item_brand->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_item_brand" class="offers_item_brand">
<span<?php echo $offers->item_brand->ViewAttributes() ?>>
<?php echo $offers->item_brand->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->min_qty->Visible) { // min_qty ?>
		<td<?php echo $offers->min_qty->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_min_qty" class="offers_min_qty">
<span<?php echo $offers->min_qty->ViewAttributes() ?>>
<?php echo $offers->min_qty->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->price->Visible) { // price ?>
		<td<?php echo $offers->price->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_price" class="offers_price">
<span<?php echo $offers->price->ViewAttributes() ?>>
<?php echo $offers->price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->description->Visible) { // description ?>
		<td<?php echo $offers->description->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_description" class="offers_description">
<span<?php echo $offers->description->ViewAttributes() ?>>
<?php echo $offers->description->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->country->Visible) { // country ?>
		<td<?php echo $offers->country->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_country" class="offers_country">
<span<?php echo $offers->country->ViewAttributes() ?>>
<?php echo $offers->country->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->states->Visible) { // states ?>
		<td<?php echo $offers->states->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_states" class="offers_states">
<span<?php echo $offers->states->ViewAttributes() ?>>
<?php echo $offers->states->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->cities->Visible) { // cities ?>
		<td<?php echo $offers->cities->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_cities" class="offers_cities">
<span<?php echo $offers->cities->ViewAttributes() ?>>
<?php echo $offers->cities->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->contact_name->Visible) { // contact_name ?>
		<td<?php echo $offers->contact_name->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_contact_name" class="offers_contact_name">
<span<?php echo $offers->contact_name->ViewAttributes() ?>>
<?php echo $offers->contact_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->contact_phone->Visible) { // contact_phone ?>
		<td<?php echo $offers->contact_phone->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_contact_phone" class="offers_contact_phone">
<span<?php echo $offers->contact_phone->ViewAttributes() ?>>
<?php echo $offers->contact_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->contact_type->Visible) { // contact_type ?>
		<td<?php echo $offers->contact_type->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_contact_type" class="offers_contact_type">
<span<?php echo $offers->contact_type->ViewAttributes() ?>>
<?php echo $offers->contact_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->contact_email->Visible) { // contact_email ?>
		<td<?php echo $offers->contact_email->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_contact_email" class="offers_contact_email">
<span<?php echo $offers->contact_email->ViewAttributes() ?>>
<?php echo $offers->contact_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->picpath->Visible) { // picpath ?>
		<td<?php echo $offers->picpath->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_picpath" class="offers_picpath">
<span<?php echo $offers->picpath->ViewAttributes() ?>>
<?php echo $offers->picpath->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->createdtime->Visible) { // createdtime ?>
		<td<?php echo $offers->createdtime->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_createdtime" class="offers_createdtime">
<span<?php echo $offers->createdtime->ViewAttributes() ?>>
<?php echo $offers->createdtime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->modifiedtime->Visible) { // modifiedtime ?>
		<td<?php echo $offers->modifiedtime->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_modifiedtime" class="offers_modifiedtime">
<span<?php echo $offers->modifiedtime->ViewAttributes() ?>>
<?php echo $offers->modifiedtime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->deleted->Visible) { // deleted ?>
		<td<?php echo $offers->deleted->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_deleted" class="offers_deleted">
<span<?php echo $offers->deleted->ViewAttributes() ?>>
<?php echo $offers->deleted->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->views->Visible) { // views ?>
		<td<?php echo $offers->views->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_views" class="offers_views">
<span<?php echo $offers->views->ViewAttributes() ?>>
<?php echo $offers->views->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->verified_code->Visible) { // verified_code ?>
		<td<?php echo $offers->verified_code->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_verified_code" class="offers_verified_code">
<span<?php echo $offers->verified_code->ViewAttributes() ?>>
<?php echo $offers->verified_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->pending->Visible) { // pending ?>
		<td<?php echo $offers->pending->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_pending" class="offers_pending">
<span<?php echo $offers->pending->ViewAttributes() ?>>
<?php echo $offers->pending->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->country_1->Visible) { // country_1 ?>
		<td<?php echo $offers->country_1->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_country_1" class="offers_country_1">
<span<?php echo $offers->country_1->ViewAttributes() ?>>
<?php echo $offers->country_1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->num_send_sms->Visible) { // num_send_sms ?>
		<td<?php echo $offers->num_send_sms->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_num_send_sms" class="offers_num_send_sms">
<span<?php echo $offers->num_send_sms->ViewAttributes() ?>>
<?php echo $offers->num_send_sms->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->num_send_email->Visible) { // num_send_email ?>
		<td<?php echo $offers->num_send_email->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_num_send_email" class="offers_num_send_email">
<span<?php echo $offers->num_send_email->ViewAttributes() ?>>
<?php echo $offers->num_send_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($offers->done->Visible) { // done ?>
		<td<?php echo $offers->done->CellAttributes() ?>>
<span id="el<?php echo $offers_delete->RowCnt ?>_offers_done" class="offers_done">
<span<?php echo $offers->done->ViewAttributes() ?>>
<?php echo $offers->done->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$offers_delete->Recordset->MoveNext();
}
$offers_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $offers_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
foffersdelete.Init();
</script>
<?php
$offers_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$offers_delete->Page_Terminate();
?>
