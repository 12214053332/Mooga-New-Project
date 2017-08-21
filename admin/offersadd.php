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

$offers_add = NULL; // Initialize page object first

class coffers_add extends coffers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'offers';

	// Page object name
	var $PageObjName = 'offers_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("offerslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "offersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
		$this->offer_type_filed->CurrentValue = NULL;
		$this->offer_type_filed->OldValue = $this->offer_type_filed->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->item_type->CurrentValue = NULL;
		$this->item_type->OldValue = $this->item_type->CurrentValue;
		$this->item_brand->CurrentValue = NULL;
		$this->item_brand->OldValue = $this->item_brand->CurrentValue;
		$this->min_qty->CurrentValue = NULL;
		$this->min_qty->OldValue = $this->min_qty->CurrentValue;
		$this->price->CurrentValue = NULL;
		$this->price->OldValue = $this->price->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->country->CurrentValue = NULL;
		$this->country->OldValue = $this->country->CurrentValue;
		$this->states->CurrentValue = NULL;
		$this->states->OldValue = $this->states->CurrentValue;
		$this->cities->CurrentValue = NULL;
		$this->cities->OldValue = $this->cities->CurrentValue;
		$this->contact_name->CurrentValue = NULL;
		$this->contact_name->OldValue = $this->contact_name->CurrentValue;
		$this->contact_phone->CurrentValue = NULL;
		$this->contact_phone->OldValue = $this->contact_phone->CurrentValue;
		$this->contact_type->CurrentValue = NULL;
		$this->contact_type->OldValue = $this->contact_type->CurrentValue;
		$this->contact_email->CurrentValue = NULL;
		$this->contact_email->OldValue = $this->contact_email->CurrentValue;
		$this->picpath->CurrentValue = NULL;
		$this->picpath->OldValue = $this->picpath->CurrentValue;
		$this->createdtime->CurrentValue = NULL;
		$this->createdtime->OldValue = $this->createdtime->CurrentValue;
		$this->modifiedtime->CurrentValue = NULL;
		$this->modifiedtime->OldValue = $this->modifiedtime->CurrentValue;
		$this->deleted->CurrentValue = 0;
		$this->views->CurrentValue = 0;
		$this->verified_code->CurrentValue = NULL;
		$this->verified_code->OldValue = $this->verified_code->CurrentValue;
		$this->pending->CurrentValue = 1;
		$this->country_1->CurrentValue = NULL;
		$this->country_1->OldValue = $this->country_1->CurrentValue;
		$this->num_send_sms->CurrentValue = 0;
		$this->num_send_email->CurrentValue = 0;
		$this->done->CurrentValue = NULL;
		$this->done->OldValue = $this->done->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->offer_type_filed->FldIsDetailKey) {
			$this->offer_type_filed->setFormValue($objForm->GetValue("x_offer_type_filed"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->item_type->FldIsDetailKey) {
			$this->item_type->setFormValue($objForm->GetValue("x_item_type"));
		}
		if (!$this->item_brand->FldIsDetailKey) {
			$this->item_brand->setFormValue($objForm->GetValue("x_item_brand"));
		}
		if (!$this->min_qty->FldIsDetailKey) {
			$this->min_qty->setFormValue($objForm->GetValue("x_min_qty"));
		}
		if (!$this->price->FldIsDetailKey) {
			$this->price->setFormValue($objForm->GetValue("x_price"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue($objForm->GetValue("x_country"));
		}
		if (!$this->states->FldIsDetailKey) {
			$this->states->setFormValue($objForm->GetValue("x_states"));
		}
		if (!$this->cities->FldIsDetailKey) {
			$this->cities->setFormValue($objForm->GetValue("x_cities"));
		}
		if (!$this->contact_name->FldIsDetailKey) {
			$this->contact_name->setFormValue($objForm->GetValue("x_contact_name"));
		}
		if (!$this->contact_phone->FldIsDetailKey) {
			$this->contact_phone->setFormValue($objForm->GetValue("x_contact_phone"));
		}
		if (!$this->contact_type->FldIsDetailKey) {
			$this->contact_type->setFormValue($objForm->GetValue("x_contact_type"));
		}
		if (!$this->contact_email->FldIsDetailKey) {
			$this->contact_email->setFormValue($objForm->GetValue("x_contact_email"));
		}
		if (!$this->picpath->FldIsDetailKey) {
			$this->picpath->setFormValue($objForm->GetValue("x_picpath"));
		}
		if (!$this->createdtime->FldIsDetailKey) {
			$this->createdtime->setFormValue($objForm->GetValue("x_createdtime"));
			$this->createdtime->CurrentValue = ew_UnFormatDateTime($this->createdtime->CurrentValue, 5);
		}
		if (!$this->modifiedtime->FldIsDetailKey) {
			$this->modifiedtime->setFormValue($objForm->GetValue("x_modifiedtime"));
			$this->modifiedtime->CurrentValue = ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5);
		}
		if (!$this->deleted->FldIsDetailKey) {
			$this->deleted->setFormValue($objForm->GetValue("x_deleted"));
		}
		if (!$this->views->FldIsDetailKey) {
			$this->views->setFormValue($objForm->GetValue("x_views"));
		}
		if (!$this->verified_code->FldIsDetailKey) {
			$this->verified_code->setFormValue($objForm->GetValue("x_verified_code"));
		}
		if (!$this->pending->FldIsDetailKey) {
			$this->pending->setFormValue($objForm->GetValue("x_pending"));
		}
		if (!$this->country_1->FldIsDetailKey) {
			$this->country_1->setFormValue($objForm->GetValue("x_country_1"));
		}
		if (!$this->num_send_sms->FldIsDetailKey) {
			$this->num_send_sms->setFormValue($objForm->GetValue("x_num_send_sms"));
		}
		if (!$this->num_send_email->FldIsDetailKey) {
			$this->num_send_email->setFormValue($objForm->GetValue("x_num_send_email"));
		}
		if (!$this->done->FldIsDetailKey) {
			$this->done->setFormValue($objForm->GetValue("x_done"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->offer_type_filed->CurrentValue = $this->offer_type_filed->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->item_type->CurrentValue = $this->item_type->FormValue;
		$this->item_brand->CurrentValue = $this->item_brand->FormValue;
		$this->min_qty->CurrentValue = $this->min_qty->FormValue;
		$this->price->CurrentValue = $this->price->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->country->CurrentValue = $this->country->FormValue;
		$this->states->CurrentValue = $this->states->FormValue;
		$this->cities->CurrentValue = $this->cities->FormValue;
		$this->contact_name->CurrentValue = $this->contact_name->FormValue;
		$this->contact_phone->CurrentValue = $this->contact_phone->FormValue;
		$this->contact_type->CurrentValue = $this->contact_type->FormValue;
		$this->contact_email->CurrentValue = $this->contact_email->FormValue;
		$this->picpath->CurrentValue = $this->picpath->FormValue;
		$this->createdtime->CurrentValue = $this->createdtime->FormValue;
		$this->createdtime->CurrentValue = ew_UnFormatDateTime($this->createdtime->CurrentValue, 5);
		$this->modifiedtime->CurrentValue = $this->modifiedtime->FormValue;
		$this->modifiedtime->CurrentValue = ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5);
		$this->deleted->CurrentValue = $this->deleted->FormValue;
		$this->views->CurrentValue = $this->views->FormValue;
		$this->verified_code->CurrentValue = $this->verified_code->FormValue;
		$this->pending->CurrentValue = $this->pending->FormValue;
		$this->country_1->CurrentValue = $this->country_1->FormValue;
		$this->num_send_sms->CurrentValue = $this->num_send_sms->FormValue;
		$this->num_send_email->CurrentValue = $this->num_send_email->FormValue;
		$this->done->CurrentValue = $this->done->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// user_id
			$this->user_id->EditAttrs["class"] = "form-control";
			$this->user_id->EditCustomAttributes = "";
			$this->user_id->EditValue = ew_HtmlEncode($this->user_id->CurrentValue);
			$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());

			// offer_type_filed
			$this->offer_type_filed->EditAttrs["class"] = "form-control";
			$this->offer_type_filed->EditCustomAttributes = "";
			$this->offer_type_filed->EditValue = ew_HtmlEncode($this->offer_type_filed->CurrentValue);
			$this->offer_type_filed->PlaceHolder = ew_RemoveHtml($this->offer_type_filed->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// item_type
			$this->item_type->EditAttrs["class"] = "form-control";
			$this->item_type->EditCustomAttributes = "";
			$this->item_type->EditValue = ew_HtmlEncode($this->item_type->CurrentValue);
			$this->item_type->PlaceHolder = ew_RemoveHtml($this->item_type->FldCaption());

			// item_brand
			$this->item_brand->EditAttrs["class"] = "form-control";
			$this->item_brand->EditCustomAttributes = "";
			$this->item_brand->EditValue = ew_HtmlEncode($this->item_brand->CurrentValue);
			$this->item_brand->PlaceHolder = ew_RemoveHtml($this->item_brand->FldCaption());

			// min_qty
			$this->min_qty->EditAttrs["class"] = "form-control";
			$this->min_qty->EditCustomAttributes = "";
			$this->min_qty->EditValue = ew_HtmlEncode($this->min_qty->CurrentValue);
			$this->min_qty->PlaceHolder = ew_RemoveHtml($this->min_qty->FldCaption());

			// price
			$this->price->EditAttrs["class"] = "form-control";
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);
			$this->price->PlaceHolder = ew_RemoveHtml($this->price->FldCaption());
			if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) $this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -1, -2, 0);

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

			// country
			$this->country->EditAttrs["class"] = "form-control";
			$this->country->EditCustomAttributes = "";
			$this->country->EditValue = ew_HtmlEncode($this->country->CurrentValue);
			$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

			// states
			$this->states->EditAttrs["class"] = "form-control";
			$this->states->EditCustomAttributes = "";
			$this->states->EditValue = ew_HtmlEncode($this->states->CurrentValue);
			$this->states->PlaceHolder = ew_RemoveHtml($this->states->FldCaption());

			// cities
			$this->cities->EditAttrs["class"] = "form-control";
			$this->cities->EditCustomAttributes = "";
			$this->cities->EditValue = ew_HtmlEncode($this->cities->CurrentValue);
			$this->cities->PlaceHolder = ew_RemoveHtml($this->cities->FldCaption());

			// contact_name
			$this->contact_name->EditAttrs["class"] = "form-control";
			$this->contact_name->EditCustomAttributes = "";
			$this->contact_name->EditValue = ew_HtmlEncode($this->contact_name->CurrentValue);
			$this->contact_name->PlaceHolder = ew_RemoveHtml($this->contact_name->FldCaption());

			// contact_phone
			$this->contact_phone->EditAttrs["class"] = "form-control";
			$this->contact_phone->EditCustomAttributes = "";
			$this->contact_phone->EditValue = ew_HtmlEncode($this->contact_phone->CurrentValue);
			$this->contact_phone->PlaceHolder = ew_RemoveHtml($this->contact_phone->FldCaption());

			// contact_type
			$this->contact_type->EditAttrs["class"] = "form-control";
			$this->contact_type->EditCustomAttributes = "";
			$this->contact_type->EditValue = ew_HtmlEncode($this->contact_type->CurrentValue);
			$this->contact_type->PlaceHolder = ew_RemoveHtml($this->contact_type->FldCaption());

			// contact_email
			$this->contact_email->EditAttrs["class"] = "form-control";
			$this->contact_email->EditCustomAttributes = "";
			$this->contact_email->EditValue = ew_HtmlEncode($this->contact_email->CurrentValue);
			$this->contact_email->PlaceHolder = ew_RemoveHtml($this->contact_email->FldCaption());

			// picpath
			$this->picpath->EditAttrs["class"] = "form-control";
			$this->picpath->EditCustomAttributes = "";
			$this->picpath->EditValue = ew_HtmlEncode($this->picpath->CurrentValue);
			$this->picpath->PlaceHolder = ew_RemoveHtml($this->picpath->FldCaption());

			// createdtime
			$this->createdtime->EditAttrs["class"] = "form-control";
			$this->createdtime->EditCustomAttributes = "";
			$this->createdtime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->createdtime->CurrentValue, 5));
			$this->createdtime->PlaceHolder = ew_RemoveHtml($this->createdtime->FldCaption());

			// modifiedtime
			$this->modifiedtime->EditAttrs["class"] = "form-control";
			$this->modifiedtime->EditCustomAttributes = "";
			$this->modifiedtime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->modifiedtime->CurrentValue, 5));
			$this->modifiedtime->PlaceHolder = ew_RemoveHtml($this->modifiedtime->FldCaption());

			// deleted
			$this->deleted->EditAttrs["class"] = "form-control";
			$this->deleted->EditCustomAttributes = "";
			$this->deleted->EditValue = ew_HtmlEncode($this->deleted->CurrentValue);
			$this->deleted->PlaceHolder = ew_RemoveHtml($this->deleted->FldCaption());

			// views
			$this->views->EditAttrs["class"] = "form-control";
			$this->views->EditCustomAttributes = "";
			$this->views->EditValue = ew_HtmlEncode($this->views->CurrentValue);
			$this->views->PlaceHolder = ew_RemoveHtml($this->views->FldCaption());

			// verified_code
			$this->verified_code->EditAttrs["class"] = "form-control";
			$this->verified_code->EditCustomAttributes = "";
			$this->verified_code->EditValue = ew_HtmlEncode($this->verified_code->CurrentValue);
			$this->verified_code->PlaceHolder = ew_RemoveHtml($this->verified_code->FldCaption());

			// pending
			$this->pending->EditAttrs["class"] = "form-control";
			$this->pending->EditCustomAttributes = "";
			$this->pending->EditValue = ew_HtmlEncode($this->pending->CurrentValue);
			$this->pending->PlaceHolder = ew_RemoveHtml($this->pending->FldCaption());

			// country_1
			$this->country_1->EditAttrs["class"] = "form-control";
			$this->country_1->EditCustomAttributes = "";
			$this->country_1->EditValue = ew_HtmlEncode($this->country_1->CurrentValue);
			$this->country_1->PlaceHolder = ew_RemoveHtml($this->country_1->FldCaption());

			// num_send_sms
			$this->num_send_sms->EditAttrs["class"] = "form-control";
			$this->num_send_sms->EditCustomAttributes = "";
			$this->num_send_sms->EditValue = ew_HtmlEncode($this->num_send_sms->CurrentValue);
			$this->num_send_sms->PlaceHolder = ew_RemoveHtml($this->num_send_sms->FldCaption());

			// num_send_email
			$this->num_send_email->EditAttrs["class"] = "form-control";
			$this->num_send_email->EditCustomAttributes = "";
			$this->num_send_email->EditValue = ew_HtmlEncode($this->num_send_email->CurrentValue);
			$this->num_send_email->PlaceHolder = ew_RemoveHtml($this->num_send_email->FldCaption());

			// done
			$this->done->EditAttrs["class"] = "form-control";
			$this->done->EditCustomAttributes = "";
			$this->done->EditValue = ew_HtmlEncode($this->done->CurrentValue);
			$this->done->PlaceHolder = ew_RemoveHtml($this->done->FldCaption());

			// Edit refer script
			// user_id

			$this->user_id->HrefValue = "";

			// offer_type_filed
			$this->offer_type_filed->HrefValue = "";

			// name
			$this->name->HrefValue = "";

			// item_type
			$this->item_type->HrefValue = "";

			// item_brand
			$this->item_brand->HrefValue = "";

			// min_qty
			$this->min_qty->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// country
			$this->country->HrefValue = "";

			// states
			$this->states->HrefValue = "";

			// cities
			$this->cities->HrefValue = "";

			// contact_name
			$this->contact_name->HrefValue = "";

			// contact_phone
			$this->contact_phone->HrefValue = "";

			// contact_type
			$this->contact_type->HrefValue = "";

			// contact_email
			$this->contact_email->HrefValue = "";

			// picpath
			$this->picpath->HrefValue = "";

			// createdtime
			$this->createdtime->HrefValue = "";

			// modifiedtime
			$this->modifiedtime->HrefValue = "";

			// deleted
			$this->deleted->HrefValue = "";

			// views
			$this->views->HrefValue = "";

			// verified_code
			$this->verified_code->HrefValue = "";

			// pending
			$this->pending->HrefValue = "";

			// country_1
			$this->country_1->HrefValue = "";

			// num_send_sms
			$this->num_send_sms->HrefValue = "";

			// num_send_email
			$this->num_send_email->HrefValue = "";

			// done
			$this->done->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->user_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->min_qty->FormValue)) {
			ew_AddMessage($gsFormError, $this->min_qty->FldErrMsg());
		}
		if (!ew_CheckNumber($this->price->FormValue)) {
			ew_AddMessage($gsFormError, $this->price->FldErrMsg());
		}
		if (!ew_CheckDate($this->createdtime->FormValue)) {
			ew_AddMessage($gsFormError, $this->createdtime->FldErrMsg());
		}
		if (!ew_CheckDate($this->modifiedtime->FormValue)) {
			ew_AddMessage($gsFormError, $this->modifiedtime->FldErrMsg());
		}
		if (!ew_CheckInteger($this->deleted->FormValue)) {
			ew_AddMessage($gsFormError, $this->deleted->FldErrMsg());
		}
		if (!ew_CheckInteger($this->views->FormValue)) {
			ew_AddMessage($gsFormError, $this->views->FldErrMsg());
		}
		if (!ew_CheckInteger($this->verified_code->FormValue)) {
			ew_AddMessage($gsFormError, $this->verified_code->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pending->FormValue)) {
			ew_AddMessage($gsFormError, $this->pending->FldErrMsg());
		}
		if (!ew_CheckInteger($this->num_send_sms->FormValue)) {
			ew_AddMessage($gsFormError, $this->num_send_sms->FldErrMsg());
		}
		if (!ew_CheckInteger($this->num_send_email->FormValue)) {
			ew_AddMessage($gsFormError, $this->num_send_email->FldErrMsg());
		}
		if (!$this->done->FldIsDetailKey && !is_null($this->done->FormValue) && $this->done->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->done->FldCaption(), $this->done->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->done->FormValue)) {
			ew_AddMessage($gsFormError, $this->done->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// user_id
		$this->user_id->SetDbValueDef($rsnew, $this->user_id->CurrentValue, NULL, FALSE);

		// offer_type_filed
		$this->offer_type_filed->SetDbValueDef($rsnew, $this->offer_type_filed->CurrentValue, NULL, FALSE);

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// item_type
		$this->item_type->SetDbValueDef($rsnew, $this->item_type->CurrentValue, NULL, FALSE);

		// item_brand
		$this->item_brand->SetDbValueDef($rsnew, $this->item_brand->CurrentValue, NULL, FALSE);

		// min_qty
		$this->min_qty->SetDbValueDef($rsnew, $this->min_qty->CurrentValue, NULL, FALSE);

		// price
		$this->price->SetDbValueDef($rsnew, $this->price->CurrentValue, NULL, FALSE);

		// description
		$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, FALSE);

		// country
		$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, FALSE);

		// states
		$this->states->SetDbValueDef($rsnew, $this->states->CurrentValue, NULL, FALSE);

		// cities
		$this->cities->SetDbValueDef($rsnew, $this->cities->CurrentValue, NULL, FALSE);

		// contact_name
		$this->contact_name->SetDbValueDef($rsnew, $this->contact_name->CurrentValue, NULL, FALSE);

		// contact_phone
		$this->contact_phone->SetDbValueDef($rsnew, $this->contact_phone->CurrentValue, NULL, FALSE);

		// contact_type
		$this->contact_type->SetDbValueDef($rsnew, $this->contact_type->CurrentValue, NULL, FALSE);

		// contact_email
		$this->contact_email->SetDbValueDef($rsnew, $this->contact_email->CurrentValue, NULL, FALSE);

		// picpath
		$this->picpath->SetDbValueDef($rsnew, $this->picpath->CurrentValue, NULL, FALSE);

		// createdtime
		$this->createdtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->createdtime->CurrentValue, 5), NULL, FALSE);

		// modifiedtime
		$this->modifiedtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5), NULL, FALSE);

		// deleted
		$this->deleted->SetDbValueDef($rsnew, $this->deleted->CurrentValue, NULL, strval($this->deleted->CurrentValue) == "");

		// views
		$this->views->SetDbValueDef($rsnew, $this->views->CurrentValue, NULL, strval($this->views->CurrentValue) == "");

		// verified_code
		$this->verified_code->SetDbValueDef($rsnew, $this->verified_code->CurrentValue, NULL, FALSE);

		// pending
		$this->pending->SetDbValueDef($rsnew, $this->pending->CurrentValue, NULL, strval($this->pending->CurrentValue) == "");

		// country_1
		$this->country_1->SetDbValueDef($rsnew, $this->country_1->CurrentValue, NULL, FALSE);

		// num_send_sms
		$this->num_send_sms->SetDbValueDef($rsnew, $this->num_send_sms->CurrentValue, NULL, strval($this->num_send_sms->CurrentValue) == "");

		// num_send_email
		$this->num_send_email->SetDbValueDef($rsnew, $this->num_send_email->CurrentValue, NULL, strval($this->num_send_email->CurrentValue) == "");

		// done
		$this->done->SetDbValueDef($rsnew, $this->done->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->id->setDbValue($conn->Insert_ID());
				$rsnew['id'] = $this->id->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "offerslist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($offers_add)) $offers_add = new coffers_add();

// Page init
$offers_add->Page_Init();

// Page main
$offers_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$offers_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = foffersadd = new ew_Form("foffersadd", "add");

// Validate form
foffersadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_min_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->min_qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_createdtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->createdtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_modifiedtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->modifiedtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_deleted");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->deleted->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_views");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->views->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_verified_code");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->verified_code->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pending");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->pending->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_num_send_sms");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->num_send_sms->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_num_send_email");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->num_send_email->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_done");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $offers->done->FldCaption(), $offers->done->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_done");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($offers->done->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
foffersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
foffersadd.ValidateRequired = true;
<?php } else { ?>
foffersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $offers_add->ShowPageHeader(); ?>
<?php
$offers_add->ShowMessage();
?>
<form name="foffersadd" id="foffersadd" class="<?php echo $offers_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($offers_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $offers_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="offers">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($offers->user_id->Visible) { // user_id ?>
	<div id="r_user_id" class="form-group">
		<label id="elh_offers_user_id" for="x_user_id" class="col-sm-2 control-label ewLabel"><?php echo $offers->user_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->user_id->CellAttributes() ?>>
<span id="el_offers_user_id">
<input type="text" data-table="offers" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($offers->user_id->getPlaceHolder()) ?>" value="<?php echo $offers->user_id->EditValue ?>"<?php echo $offers->user_id->EditAttributes() ?>>
</span>
<?php echo $offers->user_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->offer_type_filed->Visible) { // offer_type_filed ?>
	<div id="r_offer_type_filed" class="form-group">
		<label id="elh_offers_offer_type_filed" for="x_offer_type_filed" class="col-sm-2 control-label ewLabel"><?php echo $offers->offer_type_filed->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->offer_type_filed->CellAttributes() ?>>
<span id="el_offers_offer_type_filed">
<input type="text" data-table="offers" data-field="x_offer_type_filed" name="x_offer_type_filed" id="x_offer_type_filed" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->offer_type_filed->getPlaceHolder()) ?>" value="<?php echo $offers->offer_type_filed->EditValue ?>"<?php echo $offers->offer_type_filed->EditAttributes() ?>>
</span>
<?php echo $offers->offer_type_filed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_offers_name" for="x_name" class="col-sm-2 control-label ewLabel"><?php echo $offers->name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->name->CellAttributes() ?>>
<span id="el_offers_name">
<input type="text" data-table="offers" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->name->getPlaceHolder()) ?>" value="<?php echo $offers->name->EditValue ?>"<?php echo $offers->name->EditAttributes() ?>>
</span>
<?php echo $offers->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->item_type->Visible) { // item_type ?>
	<div id="r_item_type" class="form-group">
		<label id="elh_offers_item_type" for="x_item_type" class="col-sm-2 control-label ewLabel"><?php echo $offers->item_type->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->item_type->CellAttributes() ?>>
<span id="el_offers_item_type">
<input type="text" data-table="offers" data-field="x_item_type" name="x_item_type" id="x_item_type" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->item_type->getPlaceHolder()) ?>" value="<?php echo $offers->item_type->EditValue ?>"<?php echo $offers->item_type->EditAttributes() ?>>
</span>
<?php echo $offers->item_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->item_brand->Visible) { // item_brand ?>
	<div id="r_item_brand" class="form-group">
		<label id="elh_offers_item_brand" for="x_item_brand" class="col-sm-2 control-label ewLabel"><?php echo $offers->item_brand->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->item_brand->CellAttributes() ?>>
<span id="el_offers_item_brand">
<input type="text" data-table="offers" data-field="x_item_brand" name="x_item_brand" id="x_item_brand" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->item_brand->getPlaceHolder()) ?>" value="<?php echo $offers->item_brand->EditValue ?>"<?php echo $offers->item_brand->EditAttributes() ?>>
</span>
<?php echo $offers->item_brand->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->min_qty->Visible) { // min_qty ?>
	<div id="r_min_qty" class="form-group">
		<label id="elh_offers_min_qty" for="x_min_qty" class="col-sm-2 control-label ewLabel"><?php echo $offers->min_qty->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->min_qty->CellAttributes() ?>>
<span id="el_offers_min_qty">
<input type="text" data-table="offers" data-field="x_min_qty" name="x_min_qty" id="x_min_qty" size="30" placeholder="<?php echo ew_HtmlEncode($offers->min_qty->getPlaceHolder()) ?>" value="<?php echo $offers->min_qty->EditValue ?>"<?php echo $offers->min_qty->EditAttributes() ?>>
</span>
<?php echo $offers->min_qty->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->price->Visible) { // price ?>
	<div id="r_price" class="form-group">
		<label id="elh_offers_price" for="x_price" class="col-sm-2 control-label ewLabel"><?php echo $offers->price->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->price->CellAttributes() ?>>
<span id="el_offers_price">
<input type="text" data-table="offers" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?php echo ew_HtmlEncode($offers->price->getPlaceHolder()) ?>" value="<?php echo $offers->price->EditValue ?>"<?php echo $offers->price->EditAttributes() ?>>
</span>
<?php echo $offers->price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_offers_description" for="x_description" class="col-sm-2 control-label ewLabel"><?php echo $offers->description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->description->CellAttributes() ?>>
<span id="el_offers_description">
<input type="text" data-table="offers" data-field="x_description" name="x_description" id="x_description" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($offers->description->getPlaceHolder()) ?>" value="<?php echo $offers->description->EditValue ?>"<?php echo $offers->description->EditAttributes() ?>>
</span>
<?php echo $offers->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->country->Visible) { // country ?>
	<div id="r_country" class="form-group">
		<label id="elh_offers_country" for="x_country" class="col-sm-2 control-label ewLabel"><?php echo $offers->country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->country->CellAttributes() ?>>
<span id="el_offers_country">
<input type="text" data-table="offers" data-field="x_country" name="x_country" id="x_country" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->country->getPlaceHolder()) ?>" value="<?php echo $offers->country->EditValue ?>"<?php echo $offers->country->EditAttributes() ?>>
</span>
<?php echo $offers->country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->states->Visible) { // states ?>
	<div id="r_states" class="form-group">
		<label id="elh_offers_states" for="x_states" class="col-sm-2 control-label ewLabel"><?php echo $offers->states->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->states->CellAttributes() ?>>
<span id="el_offers_states">
<input type="text" data-table="offers" data-field="x_states" name="x_states" id="x_states" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->states->getPlaceHolder()) ?>" value="<?php echo $offers->states->EditValue ?>"<?php echo $offers->states->EditAttributes() ?>>
</span>
<?php echo $offers->states->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->cities->Visible) { // cities ?>
	<div id="r_cities" class="form-group">
		<label id="elh_offers_cities" for="x_cities" class="col-sm-2 control-label ewLabel"><?php echo $offers->cities->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->cities->CellAttributes() ?>>
<span id="el_offers_cities">
<input type="text" data-table="offers" data-field="x_cities" name="x_cities" id="x_cities" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->cities->getPlaceHolder()) ?>" value="<?php echo $offers->cities->EditValue ?>"<?php echo $offers->cities->EditAttributes() ?>>
</span>
<?php echo $offers->cities->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->contact_name->Visible) { // contact_name ?>
	<div id="r_contact_name" class="form-group">
		<label id="elh_offers_contact_name" for="x_contact_name" class="col-sm-2 control-label ewLabel"><?php echo $offers->contact_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->contact_name->CellAttributes() ?>>
<span id="el_offers_contact_name">
<input type="text" data-table="offers" data-field="x_contact_name" name="x_contact_name" id="x_contact_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->contact_name->getPlaceHolder()) ?>" value="<?php echo $offers->contact_name->EditValue ?>"<?php echo $offers->contact_name->EditAttributes() ?>>
</span>
<?php echo $offers->contact_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->contact_phone->Visible) { // contact_phone ?>
	<div id="r_contact_phone" class="form-group">
		<label id="elh_offers_contact_phone" for="x_contact_phone" class="col-sm-2 control-label ewLabel"><?php echo $offers->contact_phone->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->contact_phone->CellAttributes() ?>>
<span id="el_offers_contact_phone">
<input type="text" data-table="offers" data-field="x_contact_phone" name="x_contact_phone" id="x_contact_phone" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->contact_phone->getPlaceHolder()) ?>" value="<?php echo $offers->contact_phone->EditValue ?>"<?php echo $offers->contact_phone->EditAttributes() ?>>
</span>
<?php echo $offers->contact_phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->contact_type->Visible) { // contact_type ?>
	<div id="r_contact_type" class="form-group">
		<label id="elh_offers_contact_type" for="x_contact_type" class="col-sm-2 control-label ewLabel"><?php echo $offers->contact_type->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->contact_type->CellAttributes() ?>>
<span id="el_offers_contact_type">
<input type="text" data-table="offers" data-field="x_contact_type" name="x_contact_type" id="x_contact_type" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->contact_type->getPlaceHolder()) ?>" value="<?php echo $offers->contact_type->EditValue ?>"<?php echo $offers->contact_type->EditAttributes() ?>>
</span>
<?php echo $offers->contact_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->contact_email->Visible) { // contact_email ?>
	<div id="r_contact_email" class="form-group">
		<label id="elh_offers_contact_email" for="x_contact_email" class="col-sm-2 control-label ewLabel"><?php echo $offers->contact_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->contact_email->CellAttributes() ?>>
<span id="el_offers_contact_email">
<input type="text" data-table="offers" data-field="x_contact_email" name="x_contact_email" id="x_contact_email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($offers->contact_email->getPlaceHolder()) ?>" value="<?php echo $offers->contact_email->EditValue ?>"<?php echo $offers->contact_email->EditAttributes() ?>>
</span>
<?php echo $offers->contact_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->picpath->Visible) { // picpath ?>
	<div id="r_picpath" class="form-group">
		<label id="elh_offers_picpath" for="x_picpath" class="col-sm-2 control-label ewLabel"><?php echo $offers->picpath->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->picpath->CellAttributes() ?>>
<span id="el_offers_picpath">
<input type="text" data-table="offers" data-field="x_picpath" name="x_picpath" id="x_picpath" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($offers->picpath->getPlaceHolder()) ?>" value="<?php echo $offers->picpath->EditValue ?>"<?php echo $offers->picpath->EditAttributes() ?>>
</span>
<?php echo $offers->picpath->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->createdtime->Visible) { // createdtime ?>
	<div id="r_createdtime" class="form-group">
		<label id="elh_offers_createdtime" for="x_createdtime" class="col-sm-2 control-label ewLabel"><?php echo $offers->createdtime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->createdtime->CellAttributes() ?>>
<span id="el_offers_createdtime">
<input type="text" data-table="offers" data-field="x_createdtime" data-format="5" name="x_createdtime" id="x_createdtime" placeholder="<?php echo ew_HtmlEncode($offers->createdtime->getPlaceHolder()) ?>" value="<?php echo $offers->createdtime->EditValue ?>"<?php echo $offers->createdtime->EditAttributes() ?>>
</span>
<?php echo $offers->createdtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->modifiedtime->Visible) { // modifiedtime ?>
	<div id="r_modifiedtime" class="form-group">
		<label id="elh_offers_modifiedtime" for="x_modifiedtime" class="col-sm-2 control-label ewLabel"><?php echo $offers->modifiedtime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->modifiedtime->CellAttributes() ?>>
<span id="el_offers_modifiedtime">
<input type="text" data-table="offers" data-field="x_modifiedtime" data-format="5" name="x_modifiedtime" id="x_modifiedtime" placeholder="<?php echo ew_HtmlEncode($offers->modifiedtime->getPlaceHolder()) ?>" value="<?php echo $offers->modifiedtime->EditValue ?>"<?php echo $offers->modifiedtime->EditAttributes() ?>>
</span>
<?php echo $offers->modifiedtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->deleted->Visible) { // deleted ?>
	<div id="r_deleted" class="form-group">
		<label id="elh_offers_deleted" for="x_deleted" class="col-sm-2 control-label ewLabel"><?php echo $offers->deleted->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->deleted->CellAttributes() ?>>
<span id="el_offers_deleted">
<input type="text" data-table="offers" data-field="x_deleted" name="x_deleted" id="x_deleted" size="30" placeholder="<?php echo ew_HtmlEncode($offers->deleted->getPlaceHolder()) ?>" value="<?php echo $offers->deleted->EditValue ?>"<?php echo $offers->deleted->EditAttributes() ?>>
</span>
<?php echo $offers->deleted->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->views->Visible) { // views ?>
	<div id="r_views" class="form-group">
		<label id="elh_offers_views" for="x_views" class="col-sm-2 control-label ewLabel"><?php echo $offers->views->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->views->CellAttributes() ?>>
<span id="el_offers_views">
<input type="text" data-table="offers" data-field="x_views" name="x_views" id="x_views" size="30" placeholder="<?php echo ew_HtmlEncode($offers->views->getPlaceHolder()) ?>" value="<?php echo $offers->views->EditValue ?>"<?php echo $offers->views->EditAttributes() ?>>
</span>
<?php echo $offers->views->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->verified_code->Visible) { // verified_code ?>
	<div id="r_verified_code" class="form-group">
		<label id="elh_offers_verified_code" for="x_verified_code" class="col-sm-2 control-label ewLabel"><?php echo $offers->verified_code->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->verified_code->CellAttributes() ?>>
<span id="el_offers_verified_code">
<input type="text" data-table="offers" data-field="x_verified_code" name="x_verified_code" id="x_verified_code" size="30" placeholder="<?php echo ew_HtmlEncode($offers->verified_code->getPlaceHolder()) ?>" value="<?php echo $offers->verified_code->EditValue ?>"<?php echo $offers->verified_code->EditAttributes() ?>>
</span>
<?php echo $offers->verified_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->pending->Visible) { // pending ?>
	<div id="r_pending" class="form-group">
		<label id="elh_offers_pending" for="x_pending" class="col-sm-2 control-label ewLabel"><?php echo $offers->pending->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->pending->CellAttributes() ?>>
<span id="el_offers_pending">
<input type="text" data-table="offers" data-field="x_pending" name="x_pending" id="x_pending" size="30" placeholder="<?php echo ew_HtmlEncode($offers->pending->getPlaceHolder()) ?>" value="<?php echo $offers->pending->EditValue ?>"<?php echo $offers->pending->EditAttributes() ?>>
</span>
<?php echo $offers->pending->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->country_1->Visible) { // country_1 ?>
	<div id="r_country_1" class="form-group">
		<label id="elh_offers_country_1" for="x_country_1" class="col-sm-2 control-label ewLabel"><?php echo $offers->country_1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->country_1->CellAttributes() ?>>
<span id="el_offers_country_1">
<input type="text" data-table="offers" data-field="x_country_1" name="x_country_1" id="x_country_1" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($offers->country_1->getPlaceHolder()) ?>" value="<?php echo $offers->country_1->EditValue ?>"<?php echo $offers->country_1->EditAttributes() ?>>
</span>
<?php echo $offers->country_1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->num_send_sms->Visible) { // num_send_sms ?>
	<div id="r_num_send_sms" class="form-group">
		<label id="elh_offers_num_send_sms" for="x_num_send_sms" class="col-sm-2 control-label ewLabel"><?php echo $offers->num_send_sms->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->num_send_sms->CellAttributes() ?>>
<span id="el_offers_num_send_sms">
<input type="text" data-table="offers" data-field="x_num_send_sms" name="x_num_send_sms" id="x_num_send_sms" size="30" placeholder="<?php echo ew_HtmlEncode($offers->num_send_sms->getPlaceHolder()) ?>" value="<?php echo $offers->num_send_sms->EditValue ?>"<?php echo $offers->num_send_sms->EditAttributes() ?>>
</span>
<?php echo $offers->num_send_sms->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->num_send_email->Visible) { // num_send_email ?>
	<div id="r_num_send_email" class="form-group">
		<label id="elh_offers_num_send_email" for="x_num_send_email" class="col-sm-2 control-label ewLabel"><?php echo $offers->num_send_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $offers->num_send_email->CellAttributes() ?>>
<span id="el_offers_num_send_email">
<input type="text" data-table="offers" data-field="x_num_send_email" name="x_num_send_email" id="x_num_send_email" size="30" placeholder="<?php echo ew_HtmlEncode($offers->num_send_email->getPlaceHolder()) ?>" value="<?php echo $offers->num_send_email->EditValue ?>"<?php echo $offers->num_send_email->EditAttributes() ?>>
</span>
<?php echo $offers->num_send_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($offers->done->Visible) { // done ?>
	<div id="r_done" class="form-group">
		<label id="elh_offers_done" for="x_done" class="col-sm-2 control-label ewLabel"><?php echo $offers->done->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $offers->done->CellAttributes() ?>>
<span id="el_offers_done">
<input type="text" data-table="offers" data-field="x_done" name="x_done" id="x_done" size="30" placeholder="<?php echo ew_HtmlEncode($offers->done->getPlaceHolder()) ?>" value="<?php echo $offers->done->EditValue ?>"<?php echo $offers->done->EditAttributes() ?>>
</span>
<?php echo $offers->done->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $offers_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
foffersadd.Init();
</script>
<?php
$offers_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$offers_add->Page_Terminate();
?>
