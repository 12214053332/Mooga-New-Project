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

$users_view = NULL; // Initialize page object first

class cusers_view extends cusers {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header
		if (@$_GET["id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["id"]);
		}

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Setup export options
		$this->SetupExportOptions();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
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
		global $Language;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("userslist.php"); // Return to list page
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
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "userslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "userslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// name
		// email
		// password
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_users\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_users',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fusersview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED)
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, "userslist.php", "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($users_view)) $users_view = new cusers_view();

// Page init
$users_view->Page_Init();

// Page main
$users_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fusersview = new ew_Form("fusersview", "view");

// Form_CustomValidate event
fusersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusersview.ValidateRequired = true;
<?php } else { ?>
fusersview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($users->Export == "") { ?>
<div class="ewToolbar">
<?php if ($users->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $users_view->ExportOptions->Render("body") ?>
<?php
	foreach ($users_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($users->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $users_view->ShowPageHeader(); ?>
<?php
$users_view->ShowMessage();
?>
<?php if ($users->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_view->Pager)) $users_view->Pager = new cPrevNextPager($users_view->StartRec, $users_view->DisplayRecs, $users_view->TotalRecs) ?>
<?php if ($users_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fusersview" id="fusersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($users->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_users_id"><?php echo $users->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $users->id->CellAttributes() ?>>
<span id="el_users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_users_name"><?php echo $users->name->FldCaption() ?></span></td>
		<td data-name="name"<?php echo $users->name->CellAttributes() ?>>
<span id="el_users_name">
<span<?php echo $users->name->ViewAttributes() ?>>
<?php echo $users->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_users__email"><?php echo $users->_email->FldCaption() ?></span></td>
		<td data-name="_email"<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email">
<span<?php echo $users->_email->ViewAttributes() ?>>
<?php echo $users->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->companyname->Visible) { // companyname ?>
	<tr id="r_companyname">
		<td><span id="elh_users_companyname"><?php echo $users->companyname->FldCaption() ?></span></td>
		<td data-name="companyname"<?php echo $users->companyname->CellAttributes() ?>>
<span id="el_users_companyname">
<span<?php echo $users->companyname->ViewAttributes() ?>>
<?php echo $users->companyname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->servicetime->Visible) { // servicetime ?>
	<tr id="r_servicetime">
		<td><span id="elh_users_servicetime"><?php echo $users->servicetime->FldCaption() ?></span></td>
		<td data-name="servicetime"<?php echo $users->servicetime->CellAttributes() ?>>
<span id="el_users_servicetime">
<span<?php echo $users->servicetime->ViewAttributes() ?>>
<?php echo $users->servicetime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->country->Visible) { // country ?>
	<tr id="r_country">
		<td><span id="elh_users_country"><?php echo $users->country->FldCaption() ?></span></td>
		<td data-name="country"<?php echo $users->country->CellAttributes() ?>>
<span id="el_users_country">
<span<?php echo $users->country->ViewAttributes() ?>>
<?php echo $users->country->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->phone->Visible) { // phone ?>
	<tr id="r_phone">
		<td><span id="elh_users_phone"><?php echo $users->phone->FldCaption() ?></span></td>
		<td data-name="phone"<?php echo $users->phone->CellAttributes() ?>>
<span id="el_users_phone">
<span<?php echo $users->phone->ViewAttributes() ?>>
<?php echo $users->phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->skype->Visible) { // skype ?>
	<tr id="r_skype">
		<td><span id="elh_users_skype"><?php echo $users->skype->FldCaption() ?></span></td>
		<td data-name="skype"<?php echo $users->skype->CellAttributes() ?>>
<span id="el_users_skype">
<span<?php echo $users->skype->ViewAttributes() ?>>
<?php echo $users->skype->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->website->Visible) { // website ?>
	<tr id="r_website">
		<td><span id="elh_users_website"><?php echo $users->website->FldCaption() ?></span></td>
		<td data-name="website"<?php echo $users->website->CellAttributes() ?>>
<span id="el_users_website">
<span<?php echo $users->website->ViewAttributes() ?>>
<?php echo $users->website->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->linkedin->Visible) { // linkedin ?>
	<tr id="r_linkedin">
		<td><span id="elh_users_linkedin"><?php echo $users->linkedin->FldCaption() ?></span></td>
		<td data-name="linkedin"<?php echo $users->linkedin->CellAttributes() ?>>
<span id="el_users_linkedin">
<span<?php echo $users->linkedin->ViewAttributes() ?>>
<?php echo $users->linkedin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->facebook->Visible) { // facebook ?>
	<tr id="r_facebook">
		<td><span id="elh_users_facebook"><?php echo $users->facebook->FldCaption() ?></span></td>
		<td data-name="facebook"<?php echo $users->facebook->CellAttributes() ?>>
<span id="el_users_facebook">
<span<?php echo $users->facebook->ViewAttributes() ?>>
<?php echo $users->facebook->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->twitter->Visible) { // twitter ?>
	<tr id="r_twitter">
		<td><span id="elh_users_twitter"><?php echo $users->twitter->FldCaption() ?></span></td>
		<td data-name="twitter"<?php echo $users->twitter->CellAttributes() ?>>
<span id="el_users_twitter">
<span<?php echo $users->twitter->ViewAttributes() ?>>
<?php echo $users->twitter->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->active_code->Visible) { // active_code ?>
	<tr id="r_active_code">
		<td><span id="elh_users_active_code"><?php echo $users->active_code->FldCaption() ?></span></td>
		<td data-name="active_code"<?php echo $users->active_code->CellAttributes() ?>>
<span id="el_users_active_code">
<span<?php echo $users->active_code->ViewAttributes() ?>>
<?php echo $users->active_code->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->identification->Visible) { // identification ?>
	<tr id="r_identification">
		<td><span id="elh_users_identification"><?php echo $users->identification->FldCaption() ?></span></td>
		<td data-name="identification"<?php echo $users->identification->CellAttributes() ?>>
<span id="el_users_identification">
<span<?php echo $users->identification->ViewAttributes() ?>>
<?php echo $users->identification->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->link_expired->Visible) { // link_expired ?>
	<tr id="r_link_expired">
		<td><span id="elh_users_link_expired"><?php echo $users->link_expired->FldCaption() ?></span></td>
		<td data-name="link_expired"<?php echo $users->link_expired->CellAttributes() ?>>
<span id="el_users_link_expired">
<span<?php echo $users->link_expired->ViewAttributes() ?>>
<?php echo $users->link_expired->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isactive->Visible) { // isactive ?>
	<tr id="r_isactive">
		<td><span id="elh_users_isactive"><?php echo $users->isactive->FldCaption() ?></span></td>
		<td data-name="isactive"<?php echo $users->isactive->CellAttributes() ?>>
<span id="el_users_isactive">
<span<?php echo $users->isactive->ViewAttributes() ?>>
<?php echo $users->isactive->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->pio->Visible) { // pio ?>
	<tr id="r_pio">
		<td><span id="elh_users_pio"><?php echo $users->pio->FldCaption() ?></span></td>
		<td data-name="pio"<?php echo $users->pio->CellAttributes() ?>>
<span id="el_users_pio">
<span<?php echo $users->pio->ViewAttributes() ?>>
<?php echo $users->pio->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->google->Visible) { // google ?>
	<tr id="r_google">
		<td><span id="elh_users_google"><?php echo $users->google->FldCaption() ?></span></td>
		<td data-name="google"<?php echo $users->google->CellAttributes() ?>>
<span id="el_users_google">
<span<?php echo $users->google->ViewAttributes() ?>>
<?php echo $users->google->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->instagram->Visible) { // instagram ?>
	<tr id="r_instagram">
		<td><span id="elh_users_instagram"><?php echo $users->instagram->FldCaption() ?></span></td>
		<td data-name="instagram"<?php echo $users->instagram->CellAttributes() ?>>
<span id="el_users_instagram">
<span<?php echo $users->instagram->ViewAttributes() ?>>
<?php echo $users->instagram->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->account_type->Visible) { // account_type ?>
	<tr id="r_account_type">
		<td><span id="elh_users_account_type"><?php echo $users->account_type->FldCaption() ?></span></td>
		<td data-name="account_type"<?php echo $users->account_type->CellAttributes() ?>>
<span id="el_users_account_type">
<span<?php echo $users->account_type->ViewAttributes() ?>>
<?php echo $users->account_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->logo->Visible) { // logo ?>
	<tr id="r_logo">
		<td><span id="elh_users_logo"><?php echo $users->logo->FldCaption() ?></span></td>
		<td data-name="logo"<?php echo $users->logo->CellAttributes() ?>>
<span id="el_users_logo">
<span<?php echo $users->logo->ViewAttributes() ?>>
<?php echo $users->logo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->profilepic->Visible) { // profilepic ?>
	<tr id="r_profilepic">
		<td><span id="elh_users_profilepic"><?php echo $users->profilepic->FldCaption() ?></span></td>
		<td data-name="profilepic"<?php echo $users->profilepic->CellAttributes() ?>>
<span id="el_users_profilepic">
<span<?php echo $users->profilepic->ViewAttributes() ?>>
<?php echo $users->profilepic->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->mailref->Visible) { // mailref ?>
	<tr id="r_mailref">
		<td><span id="elh_users_mailref"><?php echo $users->mailref->FldCaption() ?></span></td>
		<td data-name="mailref"<?php echo $users->mailref->CellAttributes() ?>>
<span id="el_users_mailref">
<span<?php echo $users->mailref->ViewAttributes() ?>>
<?php echo $users->mailref->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->deleted->Visible) { // deleted ?>
	<tr id="r_deleted">
		<td><span id="elh_users_deleted"><?php echo $users->deleted->FldCaption() ?></span></td>
		<td data-name="deleted"<?php echo $users->deleted->CellAttributes() ?>>
<span id="el_users_deleted">
<span<?php echo $users->deleted->ViewAttributes() ?>>
<?php echo $users->deleted->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->deletefeedback->Visible) { // deletefeedback ?>
	<tr id="r_deletefeedback">
		<td><span id="elh_users_deletefeedback"><?php echo $users->deletefeedback->FldCaption() ?></span></td>
		<td data-name="deletefeedback"<?php echo $users->deletefeedback->CellAttributes() ?>>
<span id="el_users_deletefeedback">
<span<?php echo $users->deletefeedback->ViewAttributes() ?>>
<?php echo $users->deletefeedback->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->account_id->Visible) { // account_id ?>
	<tr id="r_account_id">
		<td><span id="elh_users_account_id"><?php echo $users->account_id->FldCaption() ?></span></td>
		<td data-name="account_id"<?php echo $users->account_id->CellAttributes() ?>>
<span id="el_users_account_id">
<span<?php echo $users->account_id->ViewAttributes() ?>>
<?php echo $users->account_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->start_date->Visible) { // start_date ?>
	<tr id="r_start_date">
		<td><span id="elh_users_start_date"><?php echo $users->start_date->FldCaption() ?></span></td>
		<td data-name="start_date"<?php echo $users->start_date->CellAttributes() ?>>
<span id="el_users_start_date">
<span<?php echo $users->start_date->ViewAttributes() ?>>
<?php echo $users->start_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->end_date->Visible) { // end_date ?>
	<tr id="r_end_date">
		<td><span id="elh_users_end_date"><?php echo $users->end_date->FldCaption() ?></span></td>
		<td data-name="end_date"<?php echo $users->end_date->CellAttributes() ?>>
<span id="el_users_end_date">
<span<?php echo $users->end_date->ViewAttributes() ?>>
<?php echo $users->end_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->year_moth->Visible) { // year_moth ?>
	<tr id="r_year_moth">
		<td><span id="elh_users_year_moth"><?php echo $users->year_moth->FldCaption() ?></span></td>
		<td data-name="year_moth"<?php echo $users->year_moth->CellAttributes() ?>>
<span id="el_users_year_moth">
<span<?php echo $users->year_moth->ViewAttributes() ?>>
<?php echo $users->year_moth->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->registerdate->Visible) { // registerdate ?>
	<tr id="r_registerdate">
		<td><span id="elh_users_registerdate"><?php echo $users->registerdate->FldCaption() ?></span></td>
		<td data-name="registerdate"<?php echo $users->registerdate->CellAttributes() ?>>
<span id="el_users_registerdate">
<span<?php echo $users->registerdate->ViewAttributes() ?>>
<?php echo $users->registerdate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->login_type->Visible) { // login_type ?>
	<tr id="r_login_type">
		<td><span id="elh_users_login_type"><?php echo $users->login_type->FldCaption() ?></span></td>
		<td data-name="login_type"<?php echo $users->login_type->CellAttributes() ?>>
<span id="el_users_login_type">
<span<?php echo $users->login_type->ViewAttributes() ?>>
<?php echo $users->login_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->accountstatus->Visible) { // accountstatus ?>
	<tr id="r_accountstatus">
		<td><span id="elh_users_accountstatus"><?php echo $users->accountstatus->FldCaption() ?></span></td>
		<td data-name="accountstatus"<?php echo $users->accountstatus->CellAttributes() ?>>
<span id="el_users_accountstatus">
<span<?php echo $users->accountstatus->ViewAttributes() ?>>
<?php echo $users->accountstatus->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->ispay->Visible) { // ispay ?>
	<tr id="r_ispay">
		<td><span id="elh_users_ispay"><?php echo $users->ispay->FldCaption() ?></span></td>
		<td data-name="ispay"<?php echo $users->ispay->CellAttributes() ?>>
<span id="el_users_ispay">
<span<?php echo $users->ispay->ViewAttributes() ?>>
<?php echo $users->ispay->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->profilelink->Visible) { // profilelink ?>
	<tr id="r_profilelink">
		<td><span id="elh_users_profilelink"><?php echo $users->profilelink->FldCaption() ?></span></td>
		<td data-name="profilelink"<?php echo $users->profilelink->CellAttributes() ?>>
<span id="el_users_profilelink">
<span<?php echo $users->profilelink->ViewAttributes() ?>>
<?php echo $users->profilelink->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->source->Visible) { // source ?>
	<tr id="r_source">
		<td><span id="elh_users_source"><?php echo $users->source->FldCaption() ?></span></td>
		<td data-name="source"<?php echo $users->source->CellAttributes() ?>>
<span id="el_users_source">
<span<?php echo $users->source->ViewAttributes() ?>>
<?php echo $users->source->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->agree->Visible) { // agree ?>
	<tr id="r_agree">
		<td><span id="elh_users_agree"><?php echo $users->agree->FldCaption() ?></span></td>
		<td data-name="agree"<?php echo $users->agree->CellAttributes() ?>>
<span id="el_users_agree">
<span<?php echo $users->agree->ViewAttributes() ?>>
<?php echo $users->agree->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->balance->Visible) { // balance ?>
	<tr id="r_balance">
		<td><span id="elh_users_balance"><?php echo $users->balance->FldCaption() ?></span></td>
		<td data-name="balance"<?php echo $users->balance->CellAttributes() ?>>
<span id="el_users_balance">
<span<?php echo $users->balance->ViewAttributes() ?>>
<?php echo $users->balance->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->job_title->Visible) { // job_title ?>
	<tr id="r_job_title">
		<td><span id="elh_users_job_title"><?php echo $users->job_title->FldCaption() ?></span></td>
		<td data-name="job_title"<?php echo $users->job_title->CellAttributes() ?>>
<span id="el_users_job_title">
<span<?php echo $users->job_title->ViewAttributes() ?>>
<?php echo $users->job_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->projects->Visible) { // projects ?>
	<tr id="r_projects">
		<td><span id="elh_users_projects"><?php echo $users->projects->FldCaption() ?></span></td>
		<td data-name="projects"<?php echo $users->projects->CellAttributes() ?>>
<span id="el_users_projects">
<span<?php echo $users->projects->ViewAttributes() ?>>
<?php echo $users->projects->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->opportunities->Visible) { // opportunities ?>
	<tr id="r_opportunities">
		<td><span id="elh_users_opportunities"><?php echo $users->opportunities->FldCaption() ?></span></td>
		<td data-name="opportunities"<?php echo $users->opportunities->CellAttributes() ?>>
<span id="el_users_opportunities">
<span<?php echo $users->opportunities->ViewAttributes() ?>>
<?php echo $users->opportunities->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isconsaltant->Visible) { // isconsaltant ?>
	<tr id="r_isconsaltant">
		<td><span id="elh_users_isconsaltant"><?php echo $users->isconsaltant->FldCaption() ?></span></td>
		<td data-name="isconsaltant"<?php echo $users->isconsaltant->CellAttributes() ?>>
<span id="el_users_isconsaltant">
<span<?php echo $users->isconsaltant->ViewAttributes() ?>>
<?php echo $users->isconsaltant->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isagent->Visible) { // isagent ?>
	<tr id="r_isagent">
		<td><span id="elh_users_isagent"><?php echo $users->isagent->FldCaption() ?></span></td>
		<td data-name="isagent"<?php echo $users->isagent->CellAttributes() ?>>
<span id="el_users_isagent">
<span<?php echo $users->isagent->ViewAttributes() ?>>
<?php echo $users->isagent->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isinvestor->Visible) { // isinvestor ?>
	<tr id="r_isinvestor">
		<td><span id="elh_users_isinvestor"><?php echo $users->isinvestor->FldCaption() ?></span></td>
		<td data-name="isinvestor"<?php echo $users->isinvestor->CellAttributes() ?>>
<span id="el_users_isinvestor">
<span<?php echo $users->isinvestor->ViewAttributes() ?>>
<?php echo $users->isinvestor->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isbusinessman->Visible) { // isbusinessman ?>
	<tr id="r_isbusinessman">
		<td><span id="elh_users_isbusinessman"><?php echo $users->isbusinessman->FldCaption() ?></span></td>
		<td data-name="isbusinessman"<?php echo $users->isbusinessman->CellAttributes() ?>>
<span id="el_users_isbusinessman">
<span<?php echo $users->isbusinessman->ViewAttributes() ?>>
<?php echo $users->isbusinessman->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isprovider->Visible) { // isprovider ?>
	<tr id="r_isprovider">
		<td><span id="elh_users_isprovider"><?php echo $users->isprovider->FldCaption() ?></span></td>
		<td data-name="isprovider"<?php echo $users->isprovider->CellAttributes() ?>>
<span id="el_users_isprovider">
<span<?php echo $users->isprovider->ViewAttributes() ?>>
<?php echo $users->isprovider->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->isproductowner->Visible) { // isproductowner ?>
	<tr id="r_isproductowner">
		<td><span id="elh_users_isproductowner"><?php echo $users->isproductowner->FldCaption() ?></span></td>
		<td data-name="isproductowner"<?php echo $users->isproductowner->CellAttributes() ?>>
<span id="el_users_isproductowner">
<span<?php echo $users->isproductowner->ViewAttributes() ?>>
<?php echo $users->isproductowner->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->states->Visible) { // states ?>
	<tr id="r_states">
		<td><span id="elh_users_states"><?php echo $users->states->FldCaption() ?></span></td>
		<td data-name="states"<?php echo $users->states->CellAttributes() ?>>
<span id="el_users_states">
<span<?php echo $users->states->ViewAttributes() ?>>
<?php echo $users->states->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->cities->Visible) { // cities ?>
	<tr id="r_cities">
		<td><span id="elh_users_cities"><?php echo $users->cities->FldCaption() ?></span></td>
		<td data-name="cities"<?php echo $users->cities->CellAttributes() ?>>
<span id="el_users_cities">
<span<?php echo $users->cities->ViewAttributes() ?>>
<?php echo $users->cities->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($users->offers->Visible) { // offers ?>
	<tr id="r_offers">
		<td><span id="elh_users_offers"><?php echo $users->offers->FldCaption() ?></span></td>
		<td data-name="offers"<?php echo $users->offers->CellAttributes() ?>>
<span id="el_users_offers">
<span<?php echo $users->offers->ViewAttributes() ?>>
<?php echo $users->offers->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($users->Export == "") { ?>
<?php if (!isset($users_view->Pager)) $users_view->Pager = new cPrevNextPager($users_view->StartRec, $users_view->DisplayRecs, $users_view->TotalRecs) ?>
<?php if ($users_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_view->PageUrl() ?>start=<?php echo $users_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fusersview.Init();
</script>
<?php
$users_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$users_view->Page_Terminate();
?>
