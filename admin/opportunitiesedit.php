<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "opportunitiesinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$opportunities_edit = NULL; // Initialize page object first

class copportunities_edit extends copportunities {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'opportunities';

	// Page object name
	var $PageObjName = 'opportunities_edit';

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

		// Table object (opportunities)
		if (!isset($GLOBALS["opportunities"]) || get_class($GLOBALS["opportunities"]) == "copportunities") {
			$GLOBALS["opportunities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["opportunities"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'opportunities', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("opportunitieslist.php"));
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
		global $EW_EXPORT, $opportunities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($opportunities);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
			$this->RecKey["id"] = $this->id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("opportunitieslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("opportunitieslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue($objForm->GetValue("x_country"));
		}
		if (!$this->expiredate->FldIsDetailKey) {
			$this->expiredate->setFormValue($objForm->GetValue("x_expiredate"));
			$this->expiredate->CurrentValue = ew_UnFormatDateTime($this->expiredate->CurrentValue, 5);
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
		if (!$this->deleted->FldIsDetailKey) {
			$this->deleted->setFormValue($objForm->GetValue("x_deleted"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->country->CurrentValue = $this->country->FormValue;
		$this->expiredate->CurrentValue = $this->expiredate->FormValue;
		$this->expiredate->CurrentValue = ew_UnFormatDateTime($this->expiredate->CurrentValue, 5);
		$this->views->CurrentValue = $this->views->FormValue;
		$this->picpath->CurrentValue = $this->picpath->FormValue;
		$this->createdtime->CurrentValue = $this->createdtime->FormValue;
		$this->createdtime->CurrentValue = ew_UnFormatDateTime($this->createdtime->CurrentValue, 5);
		$this->modifiedtime->CurrentValue = $this->modifiedtime->FormValue;
		$this->modifiedtime->CurrentValue = ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5);
		$this->deleted->CurrentValue = $this->deleted->FormValue;
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
		$this->description->setDbValue($rs->fields('description'));
		$this->country->setDbValue($rs->fields('country'));
		$this->expiredate->setDbValue($rs->fields('expiredate'));
		$this->views->setDbValue($rs->fields('views'));
		$this->picpath->setDbValue($rs->fields('picpath'));
		$this->createdtime->setDbValue($rs->fields('createdtime'));
		$this->modifiedtime->setDbValue($rs->fields('modifiedtime'));
		$this->deleted->setDbValue($rs->fields('deleted'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->name->DbValue = $row['name'];
		$this->description->DbValue = $row['description'];
		$this->country->DbValue = $row['country'];
		$this->expiredate->DbValue = $row['expiredate'];
		$this->views->DbValue = $row['views'];
		$this->picpath->DbValue = $row['picpath'];
		$this->createdtime->DbValue = $row['createdtime'];
		$this->modifiedtime->DbValue = $row['modifiedtime'];
		$this->deleted->DbValue = $row['deleted'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// user_id
		// name
		// description
		// country
		// expiredate
		// views
		// picpath
		// createdtime
		// modifiedtime
		// deleted

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

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// expiredate
		$this->expiredate->ViewValue = $this->expiredate->CurrentValue;
		$this->expiredate->ViewValue = ew_FormatDateTime($this->expiredate->ViewValue, 5);
		$this->expiredate->ViewCustomAttributes = "";

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

		// deleted
		$this->deleted->ViewValue = $this->deleted->CurrentValue;
		$this->deleted->ViewCustomAttributes = "";

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

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";

			// expiredate
			$this->expiredate->LinkCustomAttributes = "";
			$this->expiredate->HrefValue = "";
			$this->expiredate->TooltipValue = "";

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

			// deleted
			$this->deleted->LinkCustomAttributes = "";
			$this->deleted->HrefValue = "";
			$this->deleted->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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

			// expiredate
			$this->expiredate->EditAttrs["class"] = "form-control";
			$this->expiredate->EditCustomAttributes = "";
			$this->expiredate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->expiredate->CurrentValue, 5));
			$this->expiredate->PlaceHolder = ew_RemoveHtml($this->expiredate->FldCaption());

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

			// deleted
			$this->deleted->EditAttrs["class"] = "form-control";
			$this->deleted->EditCustomAttributes = "";
			$this->deleted->EditValue = ew_HtmlEncode($this->deleted->CurrentValue);
			$this->deleted->PlaceHolder = ew_RemoveHtml($this->deleted->FldCaption());

			// Edit refer script
			// id

			$this->id->HrefValue = "";

			// user_id
			$this->user_id->HrefValue = "";

			// name
			$this->name->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// country
			$this->country->HrefValue = "";

			// expiredate
			$this->expiredate->HrefValue = "";

			// views
			$this->views->HrefValue = "";

			// picpath
			$this->picpath->HrefValue = "";

			// createdtime
			$this->createdtime->HrefValue = "";

			// modifiedtime
			$this->modifiedtime->HrefValue = "";

			// deleted
			$this->deleted->HrefValue = "";
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
		if (!ew_CheckDate($this->expiredate->FormValue)) {
			ew_AddMessage($gsFormError, $this->expiredate->FldErrMsg());
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
		if (!$this->deleted->FldIsDetailKey && !is_null($this->deleted->FormValue) && $this->deleted->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->deleted->FldCaption(), $this->deleted->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->deleted->FormValue)) {
			ew_AddMessage($gsFormError, $this->deleted->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// user_id
			$this->user_id->SetDbValueDef($rsnew, $this->user_id->CurrentValue, NULL, $this->user_id->ReadOnly);

			// name
			$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, $this->name->ReadOnly);

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// country
			$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, $this->country->ReadOnly);

			// expiredate
			$this->expiredate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->expiredate->CurrentValue, 5), NULL, $this->expiredate->ReadOnly);

			// views
			$this->views->SetDbValueDef($rsnew, $this->views->CurrentValue, NULL, $this->views->ReadOnly);

			// picpath
			$this->picpath->SetDbValueDef($rsnew, $this->picpath->CurrentValue, NULL, $this->picpath->ReadOnly);

			// createdtime
			$this->createdtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->createdtime->CurrentValue, 5), NULL, $this->createdtime->ReadOnly);

			// modifiedtime
			$this->modifiedtime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->modifiedtime->CurrentValue, 5), NULL, $this->modifiedtime->ReadOnly);

			// deleted
			$this->deleted->SetDbValueDef($rsnew, $this->deleted->CurrentValue, 0, $this->deleted->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "opportunitieslist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($opportunities_edit)) $opportunities_edit = new copportunities_edit();

// Page init
$opportunities_edit->Page_Init();

// Page main
$opportunities_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$opportunities_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fopportunitiesedit = new ew_Form("fopportunitiesedit", "edit");

// Validate form
fopportunitiesedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_country");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->country->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_expiredate");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->expiredate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_views");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->views->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_createdtime");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $opportunities->createdtime->FldCaption(), $opportunities->createdtime->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_createdtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->createdtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_modifiedtime");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->modifiedtime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_deleted");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $opportunities->deleted->FldCaption(), $opportunities->deleted->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_deleted");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($opportunities->deleted->FldErrMsg()) ?>");

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
fopportunitiesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fopportunitiesedit.ValidateRequired = true;
<?php } else { ?>
fopportunitiesedit.ValidateRequired = false; 
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
<?php $opportunities_edit->ShowPageHeader(); ?>
<?php
$opportunities_edit->ShowMessage();
?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($opportunities_edit->Pager)) $opportunities_edit->Pager = new cPrevNextPager($opportunities_edit->StartRec, $opportunities_edit->DisplayRecs, $opportunities_edit->TotalRecs) ?>
<?php if ($opportunities_edit->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($opportunities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($opportunities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $opportunities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($opportunities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($opportunities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $opportunities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<form name="fopportunitiesedit" id="fopportunitiesedit" class="<?php echo $opportunities_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($opportunities_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $opportunities_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="opportunities">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($opportunities->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_opportunities_id" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->id->CellAttributes() ?>>
<span id="el_opportunities_id">
<span<?php echo $opportunities->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $opportunities->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="opportunities" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($opportunities->id->CurrentValue) ?>">
<?php echo $opportunities->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->user_id->Visible) { // user_id ?>
	<div id="r_user_id" class="form-group">
		<label id="elh_opportunities_user_id" for="x_user_id" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->user_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->user_id->CellAttributes() ?>>
<span id="el_opportunities_user_id">
<input type="text" data-table="opportunities" data-field="x_user_id" name="x_user_id" id="x_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($opportunities->user_id->getPlaceHolder()) ?>" value="<?php echo $opportunities->user_id->EditValue ?>"<?php echo $opportunities->user_id->EditAttributes() ?>>
</span>
<?php echo $opportunities->user_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_opportunities_name" for="x_name" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->name->CellAttributes() ?>>
<span id="el_opportunities_name">
<input type="text" data-table="opportunities" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($opportunities->name->getPlaceHolder()) ?>" value="<?php echo $opportunities->name->EditValue ?>"<?php echo $opportunities->name->EditAttributes() ?>>
</span>
<?php echo $opportunities->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_opportunities_description" for="x_description" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->description->CellAttributes() ?>>
<span id="el_opportunities_description">
<textarea data-table="opportunities" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($opportunities->description->getPlaceHolder()) ?>"<?php echo $opportunities->description->EditAttributes() ?>><?php echo $opportunities->description->EditValue ?></textarea>
</span>
<?php echo $opportunities->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->country->Visible) { // country ?>
	<div id="r_country" class="form-group">
		<label id="elh_opportunities_country" for="x_country" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->country->CellAttributes() ?>>
<span id="el_opportunities_country">
<input type="text" data-table="opportunities" data-field="x_country" name="x_country" id="x_country" size="30" placeholder="<?php echo ew_HtmlEncode($opportunities->country->getPlaceHolder()) ?>" value="<?php echo $opportunities->country->EditValue ?>"<?php echo $opportunities->country->EditAttributes() ?>>
</span>
<?php echo $opportunities->country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->expiredate->Visible) { // expiredate ?>
	<div id="r_expiredate" class="form-group">
		<label id="elh_opportunities_expiredate" for="x_expiredate" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->expiredate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->expiredate->CellAttributes() ?>>
<span id="el_opportunities_expiredate">
<input type="text" data-table="opportunities" data-field="x_expiredate" data-format="5" name="x_expiredate" id="x_expiredate" placeholder="<?php echo ew_HtmlEncode($opportunities->expiredate->getPlaceHolder()) ?>" value="<?php echo $opportunities->expiredate->EditValue ?>"<?php echo $opportunities->expiredate->EditAttributes() ?>>
</span>
<?php echo $opportunities->expiredate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->views->Visible) { // views ?>
	<div id="r_views" class="form-group">
		<label id="elh_opportunities_views" for="x_views" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->views->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->views->CellAttributes() ?>>
<span id="el_opportunities_views">
<input type="text" data-table="opportunities" data-field="x_views" name="x_views" id="x_views" size="30" placeholder="<?php echo ew_HtmlEncode($opportunities->views->getPlaceHolder()) ?>" value="<?php echo $opportunities->views->EditValue ?>"<?php echo $opportunities->views->EditAttributes() ?>>
</span>
<?php echo $opportunities->views->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->picpath->Visible) { // picpath ?>
	<div id="r_picpath" class="form-group">
		<label id="elh_opportunities_picpath" for="x_picpath" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->picpath->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->picpath->CellAttributes() ?>>
<span id="el_opportunities_picpath">
<input type="text" data-table="opportunities" data-field="x_picpath" name="x_picpath" id="x_picpath" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($opportunities->picpath->getPlaceHolder()) ?>" value="<?php echo $opportunities->picpath->EditValue ?>"<?php echo $opportunities->picpath->EditAttributes() ?>>
</span>
<?php echo $opportunities->picpath->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->createdtime->Visible) { // createdtime ?>
	<div id="r_createdtime" class="form-group">
		<label id="elh_opportunities_createdtime" for="x_createdtime" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->createdtime->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->createdtime->CellAttributes() ?>>
<span id="el_opportunities_createdtime">
<input type="text" data-table="opportunities" data-field="x_createdtime" data-format="5" name="x_createdtime" id="x_createdtime" placeholder="<?php echo ew_HtmlEncode($opportunities->createdtime->getPlaceHolder()) ?>" value="<?php echo $opportunities->createdtime->EditValue ?>"<?php echo $opportunities->createdtime->EditAttributes() ?>>
</span>
<?php echo $opportunities->createdtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->modifiedtime->Visible) { // modifiedtime ?>
	<div id="r_modifiedtime" class="form-group">
		<label id="elh_opportunities_modifiedtime" for="x_modifiedtime" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->modifiedtime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->modifiedtime->CellAttributes() ?>>
<span id="el_opportunities_modifiedtime">
<input type="text" data-table="opportunities" data-field="x_modifiedtime" data-format="5" name="x_modifiedtime" id="x_modifiedtime" placeholder="<?php echo ew_HtmlEncode($opportunities->modifiedtime->getPlaceHolder()) ?>" value="<?php echo $opportunities->modifiedtime->EditValue ?>"<?php echo $opportunities->modifiedtime->EditAttributes() ?>>
</span>
<?php echo $opportunities->modifiedtime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($opportunities->deleted->Visible) { // deleted ?>
	<div id="r_deleted" class="form-group">
		<label id="elh_opportunities_deleted" for="x_deleted" class="col-sm-2 control-label ewLabel"><?php echo $opportunities->deleted->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $opportunities->deleted->CellAttributes() ?>>
<span id="el_opportunities_deleted">
<input type="text" data-table="opportunities" data-field="x_deleted" name="x_deleted" id="x_deleted" size="30" placeholder="<?php echo ew_HtmlEncode($opportunities->deleted->getPlaceHolder()) ?>" value="<?php echo $opportunities->deleted->EditValue ?>"<?php echo $opportunities->deleted->EditAttributes() ?>>
</span>
<?php echo $opportunities->deleted->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $opportunities_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($opportunities_edit->Pager)) $opportunities_edit->Pager = new cPrevNextPager($opportunities_edit->StartRec, $opportunities_edit->DisplayRecs, $opportunities_edit->TotalRecs) ?>
<?php if ($opportunities_edit->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($opportunities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($opportunities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $opportunities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($opportunities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($opportunities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $opportunities_edit->PageUrl() ?>start=<?php echo $opportunities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $opportunities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<script type="text/javascript">
fopportunitiesedit.Init();
</script>
<?php
$opportunities_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$opportunities_edit->Page_Terminate();
?>
