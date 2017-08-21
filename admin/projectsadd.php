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

$projects_add = NULL; // Initialize page object first

class cprojects_add extends cprojects {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
					$this->Page_Terminate("projectslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "projectsview.php")
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
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->project_type_list->CurrentValue = NULL;
		$this->project_type_list->OldValue = $this->project_type_list->CurrentValue;
		$this->project_field_list->CurrentValue = NULL;
		$this->project_field_list->OldValue = $this->project_field_list->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->country->CurrentValue = NULL;
		$this->country->OldValue = $this->country->CurrentValue;
		$this->stage_list->CurrentValue = NULL;
		$this->stage_list->OldValue = $this->stage_list->CurrentValue;
		$this->project_product_list->CurrentValue = NULL;
		$this->project_product_list->OldValue = $this->project_product_list->CurrentValue;
		$this->project_service_list->CurrentValue = NULL;
		$this->project_service_list->OldValue = $this->project_service_list->CurrentValue;
		$this->needagent->CurrentValue = 0;
		$this->needpartner->CurrentValue = 0;
		$this->needclose->CurrentValue = 0;
		$this->closedescription->CurrentValue = NULL;
		$this->closedescription->OldValue = $this->closedescription->CurrentValue;
		$this->views->CurrentValue = 0;
		$this->picpath->CurrentValue = NULL;
		$this->picpath->OldValue = $this->picpath->CurrentValue;
		$this->createdtime->CurrentValue = NULL;
		$this->createdtime->OldValue = $this->createdtime->CurrentValue;
		$this->modifiedtime->CurrentValue = NULL;
		$this->modifiedtime->OldValue = $this->modifiedtime->CurrentValue;
		$this->needfunder->CurrentValue = 0;
		$this->needdealer->CurrentValue = 0;
		$this->deleted->CurrentValue = 0;
		$this->states->CurrentValue = NULL;
		$this->states->OldValue = $this->states->CurrentValue;
		$this->cities->CurrentValue = NULL;
		$this->cities->OldValue = $this->cities->CurrentValue;
		$this->needbuyer->CurrentValue = NULL;
		$this->needbuyer->OldValue = $this->needbuyer->CurrentValue;
		$this->needdescription->CurrentValue = NULL;
		$this->needdescription->OldValue = $this->needdescription->CurrentValue;
		$this->contact_type->CurrentValue = NULL;
		$this->contact_type->OldValue = $this->contact_type->CurrentValue;
		$this->contact_email->CurrentValue = NULL;
		$this->contact_email->OldValue = $this->contact_email->CurrentValue;
		$this->contact_phone->CurrentValue = NULL;
		$this->contact_phone->OldValue = $this->contact_phone->CurrentValue;
		$this->contact_name->CurrentValue = NULL;
		$this->contact_name->OldValue = $this->contact_name->CurrentValue;
		$this->budget->CurrentValue = NULL;
		$this->budget->OldValue = $this->budget->CurrentValue;
		$this->pending->CurrentValue = 1;
		$this->verified_code->CurrentValue = NULL;
		$this->verified_code->OldValue = $this->verified_code->CurrentValue;
		$this->country_1->CurrentValue = NULL;
		$this->country_1->OldValue = $this->country_1->CurrentValue;
		$this->done->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->project_type_list->FldIsDetailKey) {
			$this->project_type_list->setFormValue($objForm->GetValue("x_project_type_list"));
		}
		if (!$this->project_field_list->FldIsDetailKey) {
			$this->project_field_list->setFormValue($objForm->GetValue("x_project_field_list"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue($objForm->GetValue("x_country"));
		}
		if (!$this->stage_list->FldIsDetailKey) {
			$this->stage_list->setFormValue($objForm->GetValue("x_stage_list"));
		}
		if (!$this->project_product_list->FldIsDetailKey) {
			$this->project_product_list->setFormValue($objForm->GetValue("x_project_product_list"));
		}
		if (!$this->project_service_list->FldIsDetailKey) {
			$this->project_service_list->setFormValue($objForm->GetValue("x_project_service_list"));
		}
		if (!$this->needagent->FldIsDetailKey) {
			$this->needagent->setFormValue($objForm->GetValue("x_needagent"));
		}
		if (!$this->needpartner->FldIsDetailKey) {
			$this->needpartner->setFormValue($objForm->GetValue("x_needpartner"));
		}
		if (!$this->needclose->FldIsDetailKey) {
			$this->needclose->setFormValue($objForm->GetValue("x_needclose"));
		}
		if (!$this->closedescription->FldIsDetailKey) {
			$this->closedescription->setFormValue($objForm->GetValue("x_closedescription"));
		}
		if (!$this->views->FldIsDetailKey) {
			$this->views->setFormValue($objForm->GetValue("x_views"));
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
		if (!$this->needfunder->FldIsDetailKey) {
			$this->needfunder->setFormValue($objForm->GetValue("x_needfunder"));
		}
		if (!$this->needdealer->FldIsDetailKey) {
			$this->needdealer->setFormValue($objForm->GetValue("x_needdealer"));
		}
		if (!$this->deleted->FldIsDetailKey) {
			$this->deleted->setFormValue($objForm->GetValue("x_deleted"));
		}
		if (!$this->states->FldIsDetailKey) {
			$this->states->setFormValue($objForm->GetValue("x_states"));
		}
		if (!$this->cities->FldIsDetailKey) {
			$this->cities->setFormValue($objForm->GetValue("x_cities"));
		}
		if (!$this->needbuyer->FldIsDetailKey) {
			$this->needbuyer->setFormValue($objForm->GetValue("x_needbuyer"));
		}
		if (!$this->needdescription->FldIsDetailKey) {
			$this->needdescription->setFormValue($objForm->GetValue("x_needdescription"));
		}
		if (!$this->contact_type->FldIsDetailKey) {
			$this->contact_type->setFormValue($objForm->GetValue("x_contact_type"));
		}
		if (!$this->contact_email->FldIsDetailKey) {
			$this->contact_email->setFormValue($objForm->GetValue("x_contact_email"));
		}
		if (!$this->contact_phone->FldIsDetailKey) {
			$this->contact_phone->setFormValue($objForm->GetValue("x_contact_phone"));
		}
		if (!$this->contact_name->FldIsDetailKey) {
			$this->contact_name->setFormValue($objForm->GetValue("x_contact_name"));
		}
		if (!$this->budget->FldIsDetailKey) {
			$this->budget->setFormValue($objForm->GetValue("x_budget"));
		}
		if (!$this->pending->FldIsDetailKey) {
			$this->pending->setFormValue($objForm->GetValue("x_pending"));
		}
		if (!$this->verified_code->FldIsDetailKey) {
			$this->verified_code->setFormValue($objForm->GetValue("x_verified_code"));
		}
		if (!$this->country_1->FldIsDetailKey) {
			$this->country_1->setFormValue($objForm->GetValue("x_country_1"));
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
		$this->name->CurrentValue = $this->name->FormValue;
		$this->project_type_list->CurrentValue = $this->project_type_list->FormValue;
		$this->project_field_list->CurrentValue = $this->project_field_list->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->country->CurrentValue = $this->country->FormValue;
		$this->stage_list->CurrentValue = $this->stage_list->FormValue;
		$this->project_product_list->CurrentValue = $this->project_product_list->FormValue;
		$this->project_service_list->CurrentValue = $this->project_service_list->FormValue;
		$this->needagent->CurrentValue = $this->needagent->FormValue;
		$this->needpartner->CurrentValue = $this->needpartner->FormValue;
		$this->needclose->CurrentValue = $this->needclose->FormValue;
		$this->closedescription->CurrentValue = $this->closedescription->FormValue;
		$this->views->CurrentValue = $this->views->FormValue;
		$this->picpath->CurrentValue = $this->picpath->FormValue;
		$this->createdtime->CurrentValue = $this->createdtime->FormValue;
		$this->createdtime->CurrentValue = ew_UnFormatDateTime($this->createdtime->CurrentValue, 5);
		$this->modifiedtime->CurrentValue = $this->modifiedtime->FormValue;
		$this->modifiedtime->CurrentValue = ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5);
		$this->needfunder->CurrentValue = $this->needfunder->FormValue;
		$this->needdealer->CurrentValue = $this->needdealer->FormValue;
		$this->deleted->CurrentValue = $this->deleted->FormValue;
		$this->states->CurrentValue = $this->states->FormValue;
		$this->cities->CurrentValue = $this->cities->FormValue;
		$this->needbuyer->CurrentValue = $this->needbuyer->FormValue;
		$this->needdescription->CurrentValue = $this->needdescription->FormValue;
		$this->contact_type->CurrentValue = $this->contact_type->FormValue;
		$this->contact_email->CurrentValue = $this->contact_email->FormValue;
		$this->contact_phone->CurrentValue = $this->contact_phone->FormValue;
		$this->contact_name->CurrentValue = $this->contact_name->FormValue;
		$this->budget->CurrentValue = $this->budget->FormValue;
		$this->pending->CurrentValue = $this->pending->FormValue;
		$this->verified_code->CurrentValue = $this->verified_code->FormValue;
		$this->country_1->CurrentValue = $this->country_1->FormValue;
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

		// project_type_list
		$this->project_type_list->ViewValue = $this->project_type_list->CurrentValue;
		$this->project_type_list->ViewCustomAttributes = "";

		// project_field_list
		$this->project_field_list->ViewValue = $this->project_field_list->CurrentValue;
		$this->project_field_list->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// stage_list
		$this->stage_list->ViewValue = $this->stage_list->CurrentValue;
		$this->stage_list->ViewCustomAttributes = "";

		// project_product_list
		$this->project_product_list->ViewValue = $this->project_product_list->CurrentValue;
		$this->project_product_list->ViewCustomAttributes = "";

		// project_service_list
		$this->project_service_list->ViewValue = $this->project_service_list->CurrentValue;
		$this->project_service_list->ViewCustomAttributes = "";

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

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// project_type_list
			$this->project_type_list->LinkCustomAttributes = "";
			$this->project_type_list->HrefValue = "";
			$this->project_type_list->TooltipValue = "";

			// project_field_list
			$this->project_field_list->LinkCustomAttributes = "";
			$this->project_field_list->HrefValue = "";
			$this->project_field_list->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";

			// stage_list
			$this->stage_list->LinkCustomAttributes = "";
			$this->stage_list->HrefValue = "";
			$this->stage_list->TooltipValue = "";

			// project_product_list
			$this->project_product_list->LinkCustomAttributes = "";
			$this->project_product_list->HrefValue = "";
			$this->project_product_list->TooltipValue = "";

			// project_service_list
			$this->project_service_list->LinkCustomAttributes = "";
			$this->project_service_list->HrefValue = "";
			$this->project_service_list->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// user_id
			$this->user_id->EditAttrs["class"] = "form-control";
			$this->user_id->EditCustomAttributes = "";
			$this->user_id->EditValue = ew_HtmlEncode($this->user_id->CurrentValue);
			$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// project_type_list
			$this->project_type_list->EditAttrs["class"] = "form-control";
			$this->project_type_list->EditCustomAttributes = "";
			$this->project_type_list->EditValue = ew_HtmlEncode($this->project_type_list->CurrentValue);
			$this->project_type_list->PlaceHolder = ew_RemoveHtml($this->project_type_list->FldCaption());

			// project_field_list
			$this->project_field_list->EditAttrs["class"] = "form-control";
			$this->project_field_list->EditCustomAttributes = "";
			$this->project_field_list->EditValue = ew_HtmlEncode($this->project_field_list->CurrentValue);
			$this->project_field_list->PlaceHolder = ew_RemoveHtml($this->project_field_list->FldCaption());

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

			// stage_list
			$this->stage_list->EditAttrs["class"] = "form-control";
			$this->stage_list->EditCustomAttributes = "";
			$this->stage_list->EditValue = ew_HtmlEncode($this->stage_list->CurrentValue);
			$this->stage_list->PlaceHolder = ew_RemoveHtml($this->stage_list->FldCaption());

			// project_product_list
			$this->project_product_list->EditAttrs["class"] = "form-control";
			$this->project_product_list->EditCustomAttributes = "";
			$this->project_product_list->EditValue = ew_HtmlEncode($this->project_product_list->CurrentValue);
			$this->project_product_list->PlaceHolder = ew_RemoveHtml($this->project_product_list->FldCaption());

			// project_service_list
			$this->project_service_list->EditAttrs["class"] = "form-control";
			$this->project_service_list->EditCustomAttributes = "";
			$this->project_service_list->EditValue = ew_HtmlEncode($this->project_service_list->CurrentValue);
			$this->project_service_list->PlaceHolder = ew_RemoveHtml($this->project_service_list->FldCaption());

			// needagent
			$this->needagent->EditAttrs["class"] = "form-control";
			$this->needagent->EditCustomAttributes = "";
			$this->needagent->EditValue = ew_HtmlEncode($this->needagent->CurrentValue);
			$this->needagent->PlaceHolder = ew_RemoveHtml($this->needagent->FldCaption());

			// needpartner
			$this->needpartner->EditAttrs["class"] = "form-control";
			$this->needpartner->EditCustomAttributes = "";
			$this->needpartner->EditValue = ew_HtmlEncode($this->needpartner->CurrentValue);
			$this->needpartner->PlaceHolder = ew_RemoveHtml($this->needpartner->FldCaption());

			// needclose
			$this->needclose->EditAttrs["class"] = "form-control";
			$this->needclose->EditCustomAttributes = "";
			$this->needclose->EditValue = ew_HtmlEncode($this->needclose->CurrentValue);
			$this->needclose->PlaceHolder = ew_RemoveHtml($this->needclose->FldCaption());

			// closedescription
			$this->closedescription->EditAttrs["class"] = "form-control";
			$this->closedescription->EditCustomAttributes = "";
			$this->closedescription->EditValue = ew_HtmlEncode($this->closedescription->CurrentValue);
			$this->closedescription->PlaceHolder = ew_RemoveHtml($this->closedescription->FldCaption());

			// views
			$this->views->EditAttrs["class"] = "form-control";
			$this->views->EditCustomAttributes = "";
			$this->views->EditValue = ew_HtmlEncode($this->views->CurrentValue);
			$this->views->PlaceHolder = ew_RemoveHtml($this->views->FldCaption());

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

			// needfunder
			$this->needfunder->EditAttrs["class"] = "form-control";
			$this->needfunder->EditCustomAttributes = "";
			$this->needfunder->EditValue = ew_HtmlEncode($this->needfunder->CurrentValue);
			$this->needfunder->PlaceHolder = ew_RemoveHtml($this->needfunder->FldCaption());

			// needdealer
			$this->needdealer->EditAttrs["class"] = "form-control";
			$this->needdealer->EditCustomAttributes = "";
			$this->needdealer->EditValue = ew_HtmlEncode($this->needdealer->CurrentValue);
			$this->needdealer->PlaceHolder = ew_RemoveHtml($this->needdealer->FldCaption());

			// deleted
			$this->deleted->EditAttrs["class"] = "form-control";
			$this->deleted->EditCustomAttributes = "";
			$this->deleted->EditValue = ew_HtmlEncode($this->deleted->CurrentValue);
			$this->deleted->PlaceHolder = ew_RemoveHtml($this->deleted->FldCaption());

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

			// needbuyer
			$this->needbuyer->EditAttrs["class"] = "form-control";
			$this->needbuyer->EditCustomAttributes = "";
			$this->needbuyer->EditValue = ew_HtmlEncode($this->needbuyer->CurrentValue);
			$this->needbuyer->PlaceHolder = ew_RemoveHtml($this->needbuyer->FldCaption());

			// needdescription
			$this->needdescription->EditAttrs["class"] = "form-control";
			$this->needdescription->EditCustomAttributes = "";
			$this->needdescription->EditValue = ew_HtmlEncode($this->needdescription->CurrentValue);
			$this->needdescription->PlaceHolder = ew_RemoveHtml($this->needdescription->FldCaption());

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

			// contact_phone
			$this->contact_phone->EditAttrs["class"] = "form-control";
			$this->contact_phone->EditCustomAttributes = "";
			$this->contact_phone->EditValue = ew_HtmlEncode($this->contact_phone->CurrentValue);
			$this->contact_phone->PlaceHolder = ew_RemoveHtml($this->contact_phone->FldCaption());

			// contact_name
			$this->contact_name->EditAttrs["class"] = "form-control";
			$this->contact_name->EditCustomAttributes = "";
			$this->contact_name->EditValue = ew_HtmlEncode($this->contact_name->CurrentValue);
			$this->contact_name->PlaceHolder = ew_RemoveHtml($this->contact_name->FldCaption());

			// budget
			$this->budget->EditAttrs["class"] = "form-control";
			$this->budget->EditCustomAttributes = "";
			$this->budget->EditValue = ew_HtmlEncode($this->budget->CurrentValue);
			$this->budget->PlaceHolder = ew_RemoveHtml($this->budget->FldCaption());
			if (strval($this->budget->EditValue) <> "" && is_numeric($this->budget->EditValue)) $this->budget->EditValue = ew_FormatNumber($this->budget->EditValue, -2, -1, -2, 0);

			// pending
			$this->pending->EditAttrs["class"] = "form-control";
			$this->pending->EditCustomAttributes = "";
			$this->pending->EditValue = ew_HtmlEncode($this->pending->CurrentValue);
			$this->pending->PlaceHolder = ew_RemoveHtml($this->pending->FldCaption());

			// verified_code
			$this->verified_code->EditAttrs["class"] = "form-control";
			$this->verified_code->EditCustomAttributes = "";
			$this->verified_code->EditValue = ew_HtmlEncode($this->verified_code->CurrentValue);
			$this->verified_code->PlaceHolder = ew_RemoveHtml($this->verified_code->FldCaption());

			// country_1
			$this->country_1->EditAttrs["class"] = "form-control";
			$this->country_1->EditCustomAttributes = "";
			$this->country_1->EditValue = ew_HtmlEncode($this->country_1->CurrentValue);
			$this->country_1->PlaceHolder = ew_RemoveHtml($this->country_1->FldCaption());

			// done
			$this->done->EditAttrs["class"] = "form-control";
			$this->done->EditCustomAttributes = "";
			$this->done->EditValue = ew_HtmlEncode($this->done->CurrentValue);
			$this->done->PlaceHolder = ew_RemoveHtml($this->done->FldCaption());

			// Edit refer script
			// user_id

			$this->user_id->HrefValue = "";

			// name
			$this->name->HrefValue = "";

			// project_type_list
			$this->project_type_list->HrefValue = "";

			// project_field_list
			$this->project_field_list->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// country
			$this->country->HrefValue = "";

			// stage_list
			$this->stage_list->HrefValue = "";

			// project_product_list
			$this->project_product_list->HrefValue = "";

			// project_service_list
			$this->project_service_list->HrefValue = "";

			// needagent
			$this->needagent->HrefValue = "";

			// needpartner
			$this->needpartner->HrefValue = "";

			// needclose
			$this->needclose->HrefValue = "";

			// closedescription
			$this->closedescription->HrefValue = "";

			// views
			$this->views->HrefValue = "";

			// picpath
			$this->picpath->HrefValue = "";

			// createdtime
			$this->createdtime->HrefValue = "";

			// modifiedtime
			$this->modifiedtime->HrefValue = "";

			// needfunder
			$this->needfunder->HrefValue = "";

			// needdealer
			$this->needdealer->HrefValue = "";

			// deleted
			$this->deleted->HrefValue = "";

			// states
			$this->states->HrefValue = "";

			// cities
			$this->cities->HrefValue = "";

			// needbuyer
			$this->needbuyer->HrefValue = "";

			// needdescription
			$this->needdescription->HrefValue = "";

			// contact_type
			$this->contact_type->HrefValue = "";

			// contact_email
			$this->contact_email->HrefValue = "";

			// contact_phone
			$this->contact_phone->HrefValue = "";

			// contact_name
			$this->contact_name->HrefValue = "";

			// budget
			$this->budget->HrefValue = "";

			// pending
			$this->pending->HrefValue = "";

			// verified_code
			$this->verified_code->HrefValue = "";

			// country_1
			$this->country_1->HrefValue = "";

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
		if (!ew_CheckInteger($this->country->FormValue)) {
			ew_AddMessage($gsFormError, $this->country->FldErrMsg());
		}
		if (!ew_CheckInteger($this->needagent->FormValue)) {
			ew_AddMessage($gsFormError, $this->needagent->FldErrMsg());
		}
		if (!ew_CheckInteger($this->needpartner->FormValue)) {
			ew_AddMessage($gsFormError, $this->needpartner->FldErrMsg());
		}
		if (!ew_CheckInteger($this->needclose->FormValue)) {
			ew_AddMessage($gsFormError, $this->needclose->FldErrMsg());
		}
		if (!ew_CheckInteger($this->views->FormValue)) {
			ew_AddMessage($gsFormError, $this->views->FldErrMsg());
		}
		if (!$this->createdtime->FldIsDetailKey && !is_null($this->createdtime->FormValue) && $this->createdtime->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->createdtime->FldCaption(), $this->createdtime->ReqErrMsg));
		}
		if (!ew_CheckDate($this->createdtime->FormValue)) {
			ew_AddMessage($gsFormError, $this->createdtime->FldErrMsg());
		}
		if (!ew_CheckDate($this->modifiedtime->FormValue)) {
			ew_AddMessage($gsFormError, $this->modifiedtime->FldErrMsg());
		}
		if (!$this->needfunder->FldIsDetailKey && !is_null($this->needfunder->FormValue) && $this->needfunder->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->needfunder->FldCaption(), $this->needfunder->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->needfunder->FormValue)) {
			ew_AddMessage($gsFormError, $this->needfunder->FldErrMsg());
		}
		if (!$this->needdealer->FldIsDetailKey && !is_null($this->needdealer->FormValue) && $this->needdealer->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->needdealer->FldCaption(), $this->needdealer->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->needdealer->FormValue)) {
			ew_AddMessage($gsFormError, $this->needdealer->FldErrMsg());
		}
		if (!$this->deleted->FldIsDetailKey && !is_null($this->deleted->FormValue) && $this->deleted->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->deleted->FldCaption(), $this->deleted->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->deleted->FormValue)) {
			ew_AddMessage($gsFormError, $this->deleted->FldErrMsg());
		}
		if (!$this->states->FldIsDetailKey && !is_null($this->states->FormValue) && $this->states->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->states->FldCaption(), $this->states->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->states->FormValue)) {
			ew_AddMessage($gsFormError, $this->states->FldErrMsg());
		}
		if (!$this->cities->FldIsDetailKey && !is_null($this->cities->FormValue) && $this->cities->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cities->FldCaption(), $this->cities->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->cities->FormValue)) {
			ew_AddMessage($gsFormError, $this->cities->FldErrMsg());
		}
		if (!$this->needbuyer->FldIsDetailKey && !is_null($this->needbuyer->FormValue) && $this->needbuyer->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->needbuyer->FldCaption(), $this->needbuyer->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->needbuyer->FormValue)) {
			ew_AddMessage($gsFormError, $this->needbuyer->FldErrMsg());
		}
		if (!$this->needdescription->FldIsDetailKey && !is_null($this->needdescription->FormValue) && $this->needdescription->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->needdescription->FldCaption(), $this->needdescription->ReqErrMsg));
		}
		if (!$this->contact_type->FldIsDetailKey && !is_null($this->contact_type->FormValue) && $this->contact_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->contact_type->FldCaption(), $this->contact_type->ReqErrMsg));
		}
		if (!$this->contact_email->FldIsDetailKey && !is_null($this->contact_email->FormValue) && $this->contact_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->contact_email->FldCaption(), $this->contact_email->ReqErrMsg));
		}
		if (!$this->contact_phone->FldIsDetailKey && !is_null($this->contact_phone->FormValue) && $this->contact_phone->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->contact_phone->FldCaption(), $this->contact_phone->ReqErrMsg));
		}
		if (!$this->contact_name->FldIsDetailKey && !is_null($this->contact_name->FormValue) && $this->contact_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->contact_name->FldCaption(), $this->contact_name->ReqErrMsg));
		}
		if (!$this->budget->FldIsDetailKey && !is_null($this->budget->FormValue) && $this->budget->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->budget->FldCaption(), $this->budget->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->budget->FormValue)) {
			ew_AddMessage($gsFormError, $this->budget->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pending->FormValue)) {
			ew_AddMessage($gsFormError, $this->pending->FldErrMsg());
		}
		if (!$this->verified_code->FldIsDetailKey && !is_null($this->verified_code->FormValue) && $this->verified_code->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->verified_code->FldCaption(), $this->verified_code->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->verified_code->FormValue)) {
			ew_AddMessage($gsFormError, $this->verified_code->FldErrMsg());
		}
		if (!$this->country_1->FldIsDetailKey && !is_null($this->country_1->FormValue) && $this->country_1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->country_1->FldCaption(), $this->country_1->ReqErrMsg));
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

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// project_type_list
		$this->project_type_list->SetDbValueDef($rsnew, $this->project_type_list->CurrentValue, NULL, FALSE);

		// project_field_list
		$this->project_field_list->SetDbValueDef($rsnew, $this->project_field_list->CurrentValue, NULL, FALSE);

		// description
		$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, FALSE);

		// country
		$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, FALSE);

		// stage_list
		$this->stage_list->SetDbValueDef($rsnew, $this->stage_list->CurrentValue, NULL, FALSE);

		// project_product_list
		$this->project_product_list->SetDbValueDef($rsnew, $this->project_product_list->CurrentValue, NULL, FALSE);

		// project_service_list
		$this->project_service_list->SetDbValueDef($rsnew, $this->project_service_list->CurrentValue, NULL, FALSE);

		// needagent
		$this->needagent->SetDbValueDef($rsnew, $this->needagent->CurrentValue, NULL, strval($this->needagent->CurrentValue) == "");

		// needpartner
		$this->needpartner->SetDbValueDef($rsnew, $this->needpartner->CurrentValue, NULL, strval($this->needpartner->CurrentValue) == "");

		// needclose
		$this->needclose->SetDbValueDef($rsnew, $this->needclose->CurrentValue, NULL, strval($this->needclose->CurrentValue) == "");

		// closedescription
		$this->closedescription->SetDbValueDef($rsnew, $this->closedescription->CurrentValue, NULL, FALSE);

		// views
		$this->views->SetDbValueDef($rsnew, $this->views->CurrentValue, NULL, strval($this->views->CurrentValue) == "");

		// picpath
		$this->picpath->SetDbValueDef($rsnew, $this->picpath->CurrentValue, NULL, FALSE);

		// createdtime
		$this->createdtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->createdtime->CurrentValue, 5), NULL, FALSE);

		// modifiedtime
		$this->modifiedtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5), NULL, FALSE);

		// needfunder
		$this->needfunder->SetDbValueDef($rsnew, $this->needfunder->CurrentValue, 0, strval($this->needfunder->CurrentValue) == "");

		// needdealer
		$this->needdealer->SetDbValueDef($rsnew, $this->needdealer->CurrentValue, 0, strval($this->needdealer->CurrentValue) == "");

		// deleted
		$this->deleted->SetDbValueDef($rsnew, $this->deleted->CurrentValue, 0, strval($this->deleted->CurrentValue) == "");

		// states
		$this->states->SetDbValueDef($rsnew, $this->states->CurrentValue, 0, FALSE);

		// cities
		$this->cities->SetDbValueDef($rsnew, $this->cities->CurrentValue, 0, FALSE);

		// needbuyer
		$this->needbuyer->SetDbValueDef($rsnew, $this->needbuyer->CurrentValue, 0, FALSE);

		// needdescription
		$this->needdescription->SetDbValueDef($rsnew, $this->needdescription->CurrentValue, "", FALSE);

		// contact_type
		$this->contact_type->SetDbValueDef($rsnew, $this->contact_type->CurrentValue, "", FALSE);

		// contact_email
		$this->contact_email->SetDbValueDef($rsnew, $this->contact_email->CurrentValue, "", FALSE);

		// contact_phone
		$this->contact_phone->SetDbValueDef($rsnew, $this->contact_phone->CurrentValue, "", FALSE);

		// contact_name
		$this->contact_name->SetDbValueDef($rsnew, $this->contact_name->CurrentValue, "", FALSE);

		// budget
		$this->budget->SetDbValueDef($rsnew, $this->budget->CurrentValue, 0, FALSE);

		// pending
		$this->pending->SetDbValueDef($rsnew, $this->pending->CurrentValue, 0, strval($this->pending->CurrentValue) == "");

		// verified_code
		$this->verified_code->SetDbValueDef($rsnew, $this->verified_code->CurrentValue, 0, FALSE);

		// country_1
		$this->country_1->SetDbValueDef($rsnew, $this->country_1->CurrentValue, "", FALSE);

		// done
		$this->done->SetDbValueDef($rsnew, $this->done->CurrentValue, 0, strval($this->done->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, "projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($projects_add)) $projects_add = new cprojects_add();

// Page init
$projects_add->Page_Init();

// Page main
$projects_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fprojectsadd = new ew_Form("fprojectsadd", "add");

// Validate form
fprojectsadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_country");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->country->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needagent");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needagent->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needpartner");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needpartner->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needclose");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needclose->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_views");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->views->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_createdtime");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->createdtime->FldCaption(), $projects->createdtime->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_createdtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->createdtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_modifiedtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->modifiedtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needfunder");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->needfunder->FldCaption(), $projects->needfunder->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_needfunder");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needfunder->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needdealer");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->needdealer->FldCaption(), $projects->needdealer->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_needdealer");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needdealer->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_deleted");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->deleted->FldCaption(), $projects->deleted->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_deleted");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->deleted->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_states");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->states->FldCaption(), $projects->states->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_states");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->states->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cities");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->cities->FldCaption(), $projects->cities->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cities");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->cities->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needbuyer");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->needbuyer->FldCaption(), $projects->needbuyer->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_needbuyer");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->needbuyer->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_needdescription");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->needdescription->FldCaption(), $projects->needdescription->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_contact_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->contact_type->FldCaption(), $projects->contact_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_contact_email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->contact_email->FldCaption(), $projects->contact_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_contact_phone");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->contact_phone->FldCaption(), $projects->contact_phone->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_contact_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->contact_name->FldCaption(), $projects->contact_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_budget");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->budget->FldCaption(), $projects->budget->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_budget");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->budget->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pending");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->pending->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_verified_code");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->verified_code->FldCaption(), $projects->verified_code->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_verified_code");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->verified_code->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_country_1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->country_1->FldCaption(), $projects->country_1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_done");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $projects->done->FldCaption(), $projects->done->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_done");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($projects->done->FldErrMsg()) ?>");

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
fprojectsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectsadd.ValidateRequired = true;
<?php } else { ?>
fprojectsadd.ValidateRequired = false; 
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
<?php $projects_add->ShowPageHeader(); ?>
<?php
$projects_add->ShowMessage();
?>
<form name="fprojectsadd" id="fprojectsadd" class="<?php echo $projects_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($projects->user_id->Visible) { // user_id ?>
	<div id="r_user_id" class="form-group">
		<label id="elh_projects_user_id" for="x_user_id" class="col-sm-2 control-label ewLabel"><?php echo $projects->user_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->user_id->CellAttributes() ?>>
<span id="el_projects_user_id">
<input type="text" data-table="projects" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($projects->user_id->getPlaceHolder()) ?>" value="<?php echo $projects->user_id->EditValue ?>"<?php echo $projects->user_id->EditAttributes() ?>>
</span>
<?php echo $projects->user_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_projects_name" for="x_name" class="col-sm-2 control-label ewLabel"><?php echo $projects->name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->name->CellAttributes() ?>>
<span id="el_projects_name">
<input type="text" data-table="projects" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->name->getPlaceHolder()) ?>" value="<?php echo $projects->name->EditValue ?>"<?php echo $projects->name->EditAttributes() ?>>
</span>
<?php echo $projects->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_type_list->Visible) { // project_type_list ?>
	<div id="r_project_type_list" class="form-group">
		<label id="elh_projects_project_type_list" for="x_project_type_list" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_type_list->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_type_list->CellAttributes() ?>>
<span id="el_projects_project_type_list">
<textarea data-table="projects" data-field="x_project_type_list" name="x_project_type_list" id="x_project_type_list" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->project_type_list->getPlaceHolder()) ?>"<?php echo $projects->project_type_list->EditAttributes() ?>><?php echo $projects->project_type_list->EditValue ?></textarea>
</span>
<?php echo $projects->project_type_list->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_field_list->Visible) { // project_field_list ?>
	<div id="r_project_field_list" class="form-group">
		<label id="elh_projects_project_field_list" for="x_project_field_list" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_field_list->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_field_list->CellAttributes() ?>>
<span id="el_projects_project_field_list">
<textarea data-table="projects" data-field="x_project_field_list" name="x_project_field_list" id="x_project_field_list" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->project_field_list->getPlaceHolder()) ?>"<?php echo $projects->project_field_list->EditAttributes() ?>><?php echo $projects->project_field_list->EditValue ?></textarea>
</span>
<?php echo $projects->project_field_list->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_projects_description" for="x_description" class="col-sm-2 control-label ewLabel"><?php echo $projects->description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->description->CellAttributes() ?>>
<span id="el_projects_description">
<textarea data-table="projects" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->description->getPlaceHolder()) ?>"<?php echo $projects->description->EditAttributes() ?>><?php echo $projects->description->EditValue ?></textarea>
</span>
<?php echo $projects->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->country->Visible) { // country ?>
	<div id="r_country" class="form-group">
		<label id="elh_projects_country" for="x_country" class="col-sm-2 control-label ewLabel"><?php echo $projects->country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->country->CellAttributes() ?>>
<span id="el_projects_country">
<input type="text" data-table="projects" data-field="x_country" name="x_country" id="x_country" size="30" placeholder="<?php echo ew_HtmlEncode($projects->country->getPlaceHolder()) ?>" value="<?php echo $projects->country->EditValue ?>"<?php echo $projects->country->EditAttributes() ?>>
</span>
<?php echo $projects->country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->stage_list->Visible) { // stage_list ?>
	<div id="r_stage_list" class="form-group">
		<label id="elh_projects_stage_list" for="x_stage_list" class="col-sm-2 control-label ewLabel"><?php echo $projects->stage_list->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->stage_list->CellAttributes() ?>>
<span id="el_projects_stage_list">
<input type="text" data-table="projects" data-field="x_stage_list" name="x_stage_list" id="x_stage_list" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->stage_list->getPlaceHolder()) ?>" value="<?php echo $projects->stage_list->EditValue ?>"<?php echo $projects->stage_list->EditAttributes() ?>>
</span>
<?php echo $projects->stage_list->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_product_list->Visible) { // project_product_list ?>
	<div id="r_project_product_list" class="form-group">
		<label id="elh_projects_project_product_list" for="x_project_product_list" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_product_list->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_product_list->CellAttributes() ?>>
<span id="el_projects_project_product_list">
<textarea data-table="projects" data-field="x_project_product_list" name="x_project_product_list" id="x_project_product_list" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->project_product_list->getPlaceHolder()) ?>"<?php echo $projects->project_product_list->EditAttributes() ?>><?php echo $projects->project_product_list->EditValue ?></textarea>
</span>
<?php echo $projects->project_product_list->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->project_service_list->Visible) { // project_service_list ?>
	<div id="r_project_service_list" class="form-group">
		<label id="elh_projects_project_service_list" for="x_project_service_list" class="col-sm-2 control-label ewLabel"><?php echo $projects->project_service_list->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->project_service_list->CellAttributes() ?>>
<span id="el_projects_project_service_list">
<textarea data-table="projects" data-field="x_project_service_list" name="x_project_service_list" id="x_project_service_list" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($projects->project_service_list->getPlaceHolder()) ?>"<?php echo $projects->project_service_list->EditAttributes() ?>><?php echo $projects->project_service_list->EditValue ?></textarea>
</span>
<?php echo $projects->project_service_list->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needagent->Visible) { // needagent ?>
	<div id="r_needagent" class="form-group">
		<label id="elh_projects_needagent" for="x_needagent" class="col-sm-2 control-label ewLabel"><?php echo $projects->needagent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needagent->CellAttributes() ?>>
<span id="el_projects_needagent">
<input type="text" data-table="projects" data-field="x_needagent" name="x_needagent" id="x_needagent" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needagent->getPlaceHolder()) ?>" value="<?php echo $projects->needagent->EditValue ?>"<?php echo $projects->needagent->EditAttributes() ?>>
</span>
<?php echo $projects->needagent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needpartner->Visible) { // needpartner ?>
	<div id="r_needpartner" class="form-group">
		<label id="elh_projects_needpartner" for="x_needpartner" class="col-sm-2 control-label ewLabel"><?php echo $projects->needpartner->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needpartner->CellAttributes() ?>>
<span id="el_projects_needpartner">
<input type="text" data-table="projects" data-field="x_needpartner" name="x_needpartner" id="x_needpartner" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needpartner->getPlaceHolder()) ?>" value="<?php echo $projects->needpartner->EditValue ?>"<?php echo $projects->needpartner->EditAttributes() ?>>
</span>
<?php echo $projects->needpartner->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needclose->Visible) { // needclose ?>
	<div id="r_needclose" class="form-group">
		<label id="elh_projects_needclose" for="x_needclose" class="col-sm-2 control-label ewLabel"><?php echo $projects->needclose->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needclose->CellAttributes() ?>>
<span id="el_projects_needclose">
<input type="text" data-table="projects" data-field="x_needclose" name="x_needclose" id="x_needclose" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needclose->getPlaceHolder()) ?>" value="<?php echo $projects->needclose->EditValue ?>"<?php echo $projects->needclose->EditAttributes() ?>>
</span>
<?php echo $projects->needclose->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->closedescription->Visible) { // closedescription ?>
	<div id="r_closedescription" class="form-group">
		<label id="elh_projects_closedescription" for="x_closedescription" class="col-sm-2 control-label ewLabel"><?php echo $projects->closedescription->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->closedescription->CellAttributes() ?>>
<span id="el_projects_closedescription">
<input type="text" data-table="projects" data-field="x_closedescription" name="x_closedescription" id="x_closedescription" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->closedescription->getPlaceHolder()) ?>" value="<?php echo $projects->closedescription->EditValue ?>"<?php echo $projects->closedescription->EditAttributes() ?>>
</span>
<?php echo $projects->closedescription->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->views->Visible) { // views ?>
	<div id="r_views" class="form-group">
		<label id="elh_projects_views" for="x_views" class="col-sm-2 control-label ewLabel"><?php echo $projects->views->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->views->CellAttributes() ?>>
<span id="el_projects_views">
<input type="text" data-table="projects" data-field="x_views" name="x_views" id="x_views" size="30" placeholder="<?php echo ew_HtmlEncode($projects->views->getPlaceHolder()) ?>" value="<?php echo $projects->views->EditValue ?>"<?php echo $projects->views->EditAttributes() ?>>
</span>
<?php echo $projects->views->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->picpath->Visible) { // picpath ?>
	<div id="r_picpath" class="form-group">
		<label id="elh_projects_picpath" for="x_picpath" class="col-sm-2 control-label ewLabel"><?php echo $projects->picpath->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->picpath->CellAttributes() ?>>
<span id="el_projects_picpath">
<input type="text" data-table="projects" data-field="x_picpath" name="x_picpath" id="x_picpath" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->picpath->getPlaceHolder()) ?>" value="<?php echo $projects->picpath->EditValue ?>"<?php echo $projects->picpath->EditAttributes() ?>>
</span>
<?php echo $projects->picpath->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->createdtime->Visible) { // createdtime ?>
	<div id="r_createdtime" class="form-group">
		<label id="elh_projects_createdtime" for="x_createdtime" class="col-sm-2 control-label ewLabel"><?php echo $projects->createdtime->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->createdtime->CellAttributes() ?>>
<span id="el_projects_createdtime">
<input type="text" data-table="projects" data-field="x_createdtime" data-format="5" name="x_createdtime" id="x_createdtime" placeholder="<?php echo ew_HtmlEncode($projects->createdtime->getPlaceHolder()) ?>" value="<?php echo $projects->createdtime->EditValue ?>"<?php echo $projects->createdtime->EditAttributes() ?>>
</span>
<?php echo $projects->createdtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
	<div id="r_modifiedtime" class="form-group">
		<label id="elh_projects_modifiedtime" for="x_modifiedtime" class="col-sm-2 control-label ewLabel"><?php echo $projects->modifiedtime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->modifiedtime->CellAttributes() ?>>
<span id="el_projects_modifiedtime">
<input type="text" data-table="projects" data-field="x_modifiedtime" data-format="5" name="x_modifiedtime" id="x_modifiedtime" placeholder="<?php echo ew_HtmlEncode($projects->modifiedtime->getPlaceHolder()) ?>" value="<?php echo $projects->modifiedtime->EditValue ?>"<?php echo $projects->modifiedtime->EditAttributes() ?>>
</span>
<?php echo $projects->modifiedtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needfunder->Visible) { // needfunder ?>
	<div id="r_needfunder" class="form-group">
		<label id="elh_projects_needfunder" for="x_needfunder" class="col-sm-2 control-label ewLabel"><?php echo $projects->needfunder->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needfunder->CellAttributes() ?>>
<span id="el_projects_needfunder">
<input type="text" data-table="projects" data-field="x_needfunder" name="x_needfunder" id="x_needfunder" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needfunder->getPlaceHolder()) ?>" value="<?php echo $projects->needfunder->EditValue ?>"<?php echo $projects->needfunder->EditAttributes() ?>>
</span>
<?php echo $projects->needfunder->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needdealer->Visible) { // needdealer ?>
	<div id="r_needdealer" class="form-group">
		<label id="elh_projects_needdealer" for="x_needdealer" class="col-sm-2 control-label ewLabel"><?php echo $projects->needdealer->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needdealer->CellAttributes() ?>>
<span id="el_projects_needdealer">
<input type="text" data-table="projects" data-field="x_needdealer" name="x_needdealer" id="x_needdealer" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needdealer->getPlaceHolder()) ?>" value="<?php echo $projects->needdealer->EditValue ?>"<?php echo $projects->needdealer->EditAttributes() ?>>
</span>
<?php echo $projects->needdealer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->deleted->Visible) { // deleted ?>
	<div id="r_deleted" class="form-group">
		<label id="elh_projects_deleted" for="x_deleted" class="col-sm-2 control-label ewLabel"><?php echo $projects->deleted->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->deleted->CellAttributes() ?>>
<span id="el_projects_deleted">
<input type="text" data-table="projects" data-field="x_deleted" name="x_deleted" id="x_deleted" size="30" placeholder="<?php echo ew_HtmlEncode($projects->deleted->getPlaceHolder()) ?>" value="<?php echo $projects->deleted->EditValue ?>"<?php echo $projects->deleted->EditAttributes() ?>>
</span>
<?php echo $projects->deleted->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->states->Visible) { // states ?>
	<div id="r_states" class="form-group">
		<label id="elh_projects_states" for="x_states" class="col-sm-2 control-label ewLabel"><?php echo $projects->states->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->states->CellAttributes() ?>>
<span id="el_projects_states">
<input type="text" data-table="projects" data-field="x_states" name="x_states" id="x_states" size="30" placeholder="<?php echo ew_HtmlEncode($projects->states->getPlaceHolder()) ?>" value="<?php echo $projects->states->EditValue ?>"<?php echo $projects->states->EditAttributes() ?>>
</span>
<?php echo $projects->states->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->cities->Visible) { // cities ?>
	<div id="r_cities" class="form-group">
		<label id="elh_projects_cities" for="x_cities" class="col-sm-2 control-label ewLabel"><?php echo $projects->cities->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->cities->CellAttributes() ?>>
<span id="el_projects_cities">
<input type="text" data-table="projects" data-field="x_cities" name="x_cities" id="x_cities" size="30" placeholder="<?php echo ew_HtmlEncode($projects->cities->getPlaceHolder()) ?>" value="<?php echo $projects->cities->EditValue ?>"<?php echo $projects->cities->EditAttributes() ?>>
</span>
<?php echo $projects->cities->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
	<div id="r_needbuyer" class="form-group">
		<label id="elh_projects_needbuyer" for="x_needbuyer" class="col-sm-2 control-label ewLabel"><?php echo $projects->needbuyer->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needbuyer->CellAttributes() ?>>
<span id="el_projects_needbuyer">
<input type="text" data-table="projects" data-field="x_needbuyer" name="x_needbuyer" id="x_needbuyer" size="30" placeholder="<?php echo ew_HtmlEncode($projects->needbuyer->getPlaceHolder()) ?>" value="<?php echo $projects->needbuyer->EditValue ?>"<?php echo $projects->needbuyer->EditAttributes() ?>>
</span>
<?php echo $projects->needbuyer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->needdescription->Visible) { // needdescription ?>
	<div id="r_needdescription" class="form-group">
		<label id="elh_projects_needdescription" for="x_needdescription" class="col-sm-2 control-label ewLabel"><?php echo $projects->needdescription->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->needdescription->CellAttributes() ?>>
<span id="el_projects_needdescription">
<input type="text" data-table="projects" data-field="x_needdescription" name="x_needdescription" id="x_needdescription" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($projects->needdescription->getPlaceHolder()) ?>" value="<?php echo $projects->needdescription->EditValue ?>"<?php echo $projects->needdescription->EditAttributes() ?>>
</span>
<?php echo $projects->needdescription->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->contact_type->Visible) { // contact_type ?>
	<div id="r_contact_type" class="form-group">
		<label id="elh_projects_contact_type" for="x_contact_type" class="col-sm-2 control-label ewLabel"><?php echo $projects->contact_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->contact_type->CellAttributes() ?>>
<span id="el_projects_contact_type">
<input type="text" data-table="projects" data-field="x_contact_type" name="x_contact_type" id="x_contact_type" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->contact_type->getPlaceHolder()) ?>" value="<?php echo $projects->contact_type->EditValue ?>"<?php echo $projects->contact_type->EditAttributes() ?>>
</span>
<?php echo $projects->contact_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->contact_email->Visible) { // contact_email ?>
	<div id="r_contact_email" class="form-group">
		<label id="elh_projects_contact_email" for="x_contact_email" class="col-sm-2 control-label ewLabel"><?php echo $projects->contact_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->contact_email->CellAttributes() ?>>
<span id="el_projects_contact_email">
<input type="text" data-table="projects" data-field="x_contact_email" name="x_contact_email" id="x_contact_email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->contact_email->getPlaceHolder()) ?>" value="<?php echo $projects->contact_email->EditValue ?>"<?php echo $projects->contact_email->EditAttributes() ?>>
</span>
<?php echo $projects->contact_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
	<div id="r_contact_phone" class="form-group">
		<label id="elh_projects_contact_phone" for="x_contact_phone" class="col-sm-2 control-label ewLabel"><?php echo $projects->contact_phone->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->contact_phone->CellAttributes() ?>>
<span id="el_projects_contact_phone">
<input type="text" data-table="projects" data-field="x_contact_phone" name="x_contact_phone" id="x_contact_phone" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->contact_phone->getPlaceHolder()) ?>" value="<?php echo $projects->contact_phone->EditValue ?>"<?php echo $projects->contact_phone->EditAttributes() ?>>
</span>
<?php echo $projects->contact_phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->contact_name->Visible) { // contact_name ?>
	<div id="r_contact_name" class="form-group">
		<label id="elh_projects_contact_name" for="x_contact_name" class="col-sm-2 control-label ewLabel"><?php echo $projects->contact_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->contact_name->CellAttributes() ?>>
<span id="el_projects_contact_name">
<input type="text" data-table="projects" data-field="x_contact_name" name="x_contact_name" id="x_contact_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($projects->contact_name->getPlaceHolder()) ?>" value="<?php echo $projects->contact_name->EditValue ?>"<?php echo $projects->contact_name->EditAttributes() ?>>
</span>
<?php echo $projects->contact_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->budget->Visible) { // budget ?>
	<div id="r_budget" class="form-group">
		<label id="elh_projects_budget" for="x_budget" class="col-sm-2 control-label ewLabel"><?php echo $projects->budget->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->budget->CellAttributes() ?>>
<span id="el_projects_budget">
<input type="text" data-table="projects" data-field="x_budget" name="x_budget" id="x_budget" size="30" placeholder="<?php echo ew_HtmlEncode($projects->budget->getPlaceHolder()) ?>" value="<?php echo $projects->budget->EditValue ?>"<?php echo $projects->budget->EditAttributes() ?>>
</span>
<?php echo $projects->budget->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->pending->Visible) { // pending ?>
	<div id="r_pending" class="form-group">
		<label id="elh_projects_pending" for="x_pending" class="col-sm-2 control-label ewLabel"><?php echo $projects->pending->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $projects->pending->CellAttributes() ?>>
<span id="el_projects_pending">
<input type="text" data-table="projects" data-field="x_pending" name="x_pending" id="x_pending" size="30" placeholder="<?php echo ew_HtmlEncode($projects->pending->getPlaceHolder()) ?>" value="<?php echo $projects->pending->EditValue ?>"<?php echo $projects->pending->EditAttributes() ?>>
</span>
<?php echo $projects->pending->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->verified_code->Visible) { // verified_code ?>
	<div id="r_verified_code" class="form-group">
		<label id="elh_projects_verified_code" for="x_verified_code" class="col-sm-2 control-label ewLabel"><?php echo $projects->verified_code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->verified_code->CellAttributes() ?>>
<span id="el_projects_verified_code">
<input type="text" data-table="projects" data-field="x_verified_code" name="x_verified_code" id="x_verified_code" size="30" placeholder="<?php echo ew_HtmlEncode($projects->verified_code->getPlaceHolder()) ?>" value="<?php echo $projects->verified_code->EditValue ?>"<?php echo $projects->verified_code->EditAttributes() ?>>
</span>
<?php echo $projects->verified_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->country_1->Visible) { // country_1 ?>
	<div id="r_country_1" class="form-group">
		<label id="elh_projects_country_1" for="x_country_1" class="col-sm-2 control-label ewLabel"><?php echo $projects->country_1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->country_1->CellAttributes() ?>>
<span id="el_projects_country_1">
<input type="text" data-table="projects" data-field="x_country_1" name="x_country_1" id="x_country_1" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($projects->country_1->getPlaceHolder()) ?>" value="<?php echo $projects->country_1->EditValue ?>"<?php echo $projects->country_1->EditAttributes() ?>>
</span>
<?php echo $projects->country_1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($projects->done->Visible) { // done ?>
	<div id="r_done" class="form-group">
		<label id="elh_projects_done" for="x_done" class="col-sm-2 control-label ewLabel"><?php echo $projects->done->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $projects->done->CellAttributes() ?>>
<span id="el_projects_done">
<input type="text" data-table="projects" data-field="x_done" name="x_done" id="x_done" size="30" placeholder="<?php echo ew_HtmlEncode($projects->done->getPlaceHolder()) ?>" value="<?php echo $projects->done->EditValue ?>"<?php echo $projects->done->EditAttributes() ?>>
</span>
<?php echo $projects->done->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $projects_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fprojectsadd.Init();
</script>
<?php
$projects_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$projects_add->Page_Terminate();
?>
