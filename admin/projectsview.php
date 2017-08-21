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

$projects_view = NULL; // Initialize page object first

class cprojects_view extends cprojects {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_view';

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

		// Table object (projects)
		if (!isset($GLOBALS["projects"]) || get_class($GLOBALS["projects"]) == "cprojects") {
			$GLOBALS["projects"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["projects"];
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
				$this->Page_Terminate(ew_GetUrl("projectslist.php"));
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
						$this->Page_Terminate("projectslist.php"); // Return to list page
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
						$sReturnUrl = "projectslist.php"; // No matching record, return to list
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
			$sReturnUrl = "projectslist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$item->Body = "<button id=\"emf_projects\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_projects',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fprojectsview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, "projectslist.php", "", $this->TableVar, TRUE);
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
if (!isset($projects_view)) $projects_view = new cprojects_view();

// Page init
$projects_view->Page_Init();

// Page main
$projects_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($projects->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fprojectsview = new ew_Form("fprojectsview", "view");

// Form_CustomValidate event
fprojectsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectsview.ValidateRequired = true;
<?php } else { ?>
fprojectsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($projects->Export == "") { ?>
<div class="ewToolbar">
<?php if ($projects->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $projects_view->ExportOptions->Render("body") ?>
<?php
	foreach ($projects_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($projects->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $projects_view->ShowPageHeader(); ?>
<?php
$projects_view->ShowMessage();
?>
<?php if ($projects->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($projects_view->Pager)) $projects_view->Pager = new cPrevNextPager($projects_view->StartRec, $projects_view->DisplayRecs, $projects_view->TotalRecs) ?>
<?php if ($projects_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($projects_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($projects_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $projects_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($projects_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($projects_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $projects_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fprojectsview" id="fprojectsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($projects->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_projects_id"><?php echo $projects->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $projects->id->CellAttributes() ?>>
<span id="el_projects_id">
<span<?php echo $projects->id->ViewAttributes() ?>>
<?php echo $projects->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->user_id->Visible) { // user_id ?>
	<tr id="r_user_id">
		<td><span id="elh_projects_user_id"><?php echo $projects->user_id->FldCaption() ?></span></td>
		<td data-name="user_id"<?php echo $projects->user_id->CellAttributes() ?>>
<span id="el_projects_user_id">
<span<?php echo $projects->user_id->ViewAttributes() ?>>
<?php echo $projects->user_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_projects_name"><?php echo $projects->name->FldCaption() ?></span></td>
		<td data-name="name"<?php echo $projects->name->CellAttributes() ?>>
<span id="el_projects_name">
<span<?php echo $projects->name->ViewAttributes() ?>>
<?php echo $projects->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->project_type_list->Visible) { // project_type_list ?>
	<tr id="r_project_type_list">
		<td><span id="elh_projects_project_type_list"><?php echo $projects->project_type_list->FldCaption() ?></span></td>
		<td data-name="project_type_list"<?php echo $projects->project_type_list->CellAttributes() ?>>
<span id="el_projects_project_type_list">
<span<?php echo $projects->project_type_list->ViewAttributes() ?>>
<?php echo $projects->project_type_list->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->project_field_list->Visible) { // project_field_list ?>
	<tr id="r_project_field_list">
		<td><span id="elh_projects_project_field_list"><?php echo $projects->project_field_list->FldCaption() ?></span></td>
		<td data-name="project_field_list"<?php echo $projects->project_field_list->CellAttributes() ?>>
<span id="el_projects_project_field_list">
<span<?php echo $projects->project_field_list->ViewAttributes() ?>>
<?php echo $projects->project_field_list->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->description->Visible) { // description ?>
	<tr id="r_description">
		<td><span id="elh_projects_description"><?php echo $projects->description->FldCaption() ?></span></td>
		<td data-name="description"<?php echo $projects->description->CellAttributes() ?>>
<span id="el_projects_description">
<span<?php echo $projects->description->ViewAttributes() ?>>
<?php echo $projects->description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->country->Visible) { // country ?>
	<tr id="r_country">
		<td><span id="elh_projects_country"><?php echo $projects->country->FldCaption() ?></span></td>
		<td data-name="country"<?php echo $projects->country->CellAttributes() ?>>
<span id="el_projects_country">
<span<?php echo $projects->country->ViewAttributes() ?>>
<?php echo $projects->country->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->stage_list->Visible) { // stage_list ?>
	<tr id="r_stage_list">
		<td><span id="elh_projects_stage_list"><?php echo $projects->stage_list->FldCaption() ?></span></td>
		<td data-name="stage_list"<?php echo $projects->stage_list->CellAttributes() ?>>
<span id="el_projects_stage_list">
<span<?php echo $projects->stage_list->ViewAttributes() ?>>
<?php echo $projects->stage_list->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->project_product_list->Visible) { // project_product_list ?>
	<tr id="r_project_product_list">
		<td><span id="elh_projects_project_product_list"><?php echo $projects->project_product_list->FldCaption() ?></span></td>
		<td data-name="project_product_list"<?php echo $projects->project_product_list->CellAttributes() ?>>
<span id="el_projects_project_product_list">
<span<?php echo $projects->project_product_list->ViewAttributes() ?>>
<?php echo $projects->project_product_list->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->project_service_list->Visible) { // project_service_list ?>
	<tr id="r_project_service_list">
		<td><span id="elh_projects_project_service_list"><?php echo $projects->project_service_list->FldCaption() ?></span></td>
		<td data-name="project_service_list"<?php echo $projects->project_service_list->CellAttributes() ?>>
<span id="el_projects_project_service_list">
<span<?php echo $projects->project_service_list->ViewAttributes() ?>>
<?php echo $projects->project_service_list->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needagent->Visible) { // needagent ?>
	<tr id="r_needagent">
		<td><span id="elh_projects_needagent"><?php echo $projects->needagent->FldCaption() ?></span></td>
		<td data-name="needagent"<?php echo $projects->needagent->CellAttributes() ?>>
<span id="el_projects_needagent">
<span<?php echo $projects->needagent->ViewAttributes() ?>>
<?php echo $projects->needagent->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needpartner->Visible) { // needpartner ?>
	<tr id="r_needpartner">
		<td><span id="elh_projects_needpartner"><?php echo $projects->needpartner->FldCaption() ?></span></td>
		<td data-name="needpartner"<?php echo $projects->needpartner->CellAttributes() ?>>
<span id="el_projects_needpartner">
<span<?php echo $projects->needpartner->ViewAttributes() ?>>
<?php echo $projects->needpartner->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needclose->Visible) { // needclose ?>
	<tr id="r_needclose">
		<td><span id="elh_projects_needclose"><?php echo $projects->needclose->FldCaption() ?></span></td>
		<td data-name="needclose"<?php echo $projects->needclose->CellAttributes() ?>>
<span id="el_projects_needclose">
<span<?php echo $projects->needclose->ViewAttributes() ?>>
<?php echo $projects->needclose->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->closedescription->Visible) { // closedescription ?>
	<tr id="r_closedescription">
		<td><span id="elh_projects_closedescription"><?php echo $projects->closedescription->FldCaption() ?></span></td>
		<td data-name="closedescription"<?php echo $projects->closedescription->CellAttributes() ?>>
<span id="el_projects_closedescription">
<span<?php echo $projects->closedescription->ViewAttributes() ?>>
<?php echo $projects->closedescription->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->views->Visible) { // views ?>
	<tr id="r_views">
		<td><span id="elh_projects_views"><?php echo $projects->views->FldCaption() ?></span></td>
		<td data-name="views"<?php echo $projects->views->CellAttributes() ?>>
<span id="el_projects_views">
<span<?php echo $projects->views->ViewAttributes() ?>>
<?php echo $projects->views->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->picpath->Visible) { // picpath ?>
	<tr id="r_picpath">
		<td><span id="elh_projects_picpath"><?php echo $projects->picpath->FldCaption() ?></span></td>
		<td data-name="picpath"<?php echo $projects->picpath->CellAttributes() ?>>
<span id="el_projects_picpath">
<span<?php echo $projects->picpath->ViewAttributes() ?>>
<?php echo $projects->picpath->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->createdtime->Visible) { // createdtime ?>
	<tr id="r_createdtime">
		<td><span id="elh_projects_createdtime"><?php echo $projects->createdtime->FldCaption() ?></span></td>
		<td data-name="createdtime"<?php echo $projects->createdtime->CellAttributes() ?>>
<span id="el_projects_createdtime">
<span<?php echo $projects->createdtime->ViewAttributes() ?>>
<?php echo $projects->createdtime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
	<tr id="r_modifiedtime">
		<td><span id="elh_projects_modifiedtime"><?php echo $projects->modifiedtime->FldCaption() ?></span></td>
		<td data-name="modifiedtime"<?php echo $projects->modifiedtime->CellAttributes() ?>>
<span id="el_projects_modifiedtime">
<span<?php echo $projects->modifiedtime->ViewAttributes() ?>>
<?php echo $projects->modifiedtime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needfunder->Visible) { // needfunder ?>
	<tr id="r_needfunder">
		<td><span id="elh_projects_needfunder"><?php echo $projects->needfunder->FldCaption() ?></span></td>
		<td data-name="needfunder"<?php echo $projects->needfunder->CellAttributes() ?>>
<span id="el_projects_needfunder">
<span<?php echo $projects->needfunder->ViewAttributes() ?>>
<?php echo $projects->needfunder->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needdealer->Visible) { // needdealer ?>
	<tr id="r_needdealer">
		<td><span id="elh_projects_needdealer"><?php echo $projects->needdealer->FldCaption() ?></span></td>
		<td data-name="needdealer"<?php echo $projects->needdealer->CellAttributes() ?>>
<span id="el_projects_needdealer">
<span<?php echo $projects->needdealer->ViewAttributes() ?>>
<?php echo $projects->needdealer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->deleted->Visible) { // deleted ?>
	<tr id="r_deleted">
		<td><span id="elh_projects_deleted"><?php echo $projects->deleted->FldCaption() ?></span></td>
		<td data-name="deleted"<?php echo $projects->deleted->CellAttributes() ?>>
<span id="el_projects_deleted">
<span<?php echo $projects->deleted->ViewAttributes() ?>>
<?php echo $projects->deleted->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->states->Visible) { // states ?>
	<tr id="r_states">
		<td><span id="elh_projects_states"><?php echo $projects->states->FldCaption() ?></span></td>
		<td data-name="states"<?php echo $projects->states->CellAttributes() ?>>
<span id="el_projects_states">
<span<?php echo $projects->states->ViewAttributes() ?>>
<?php echo $projects->states->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->cities->Visible) { // cities ?>
	<tr id="r_cities">
		<td><span id="elh_projects_cities"><?php echo $projects->cities->FldCaption() ?></span></td>
		<td data-name="cities"<?php echo $projects->cities->CellAttributes() ?>>
<span id="el_projects_cities">
<span<?php echo $projects->cities->ViewAttributes() ?>>
<?php echo $projects->cities->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
	<tr id="r_needbuyer">
		<td><span id="elh_projects_needbuyer"><?php echo $projects->needbuyer->FldCaption() ?></span></td>
		<td data-name="needbuyer"<?php echo $projects->needbuyer->CellAttributes() ?>>
<span id="el_projects_needbuyer">
<span<?php echo $projects->needbuyer->ViewAttributes() ?>>
<?php echo $projects->needbuyer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->needdescription->Visible) { // needdescription ?>
	<tr id="r_needdescription">
		<td><span id="elh_projects_needdescription"><?php echo $projects->needdescription->FldCaption() ?></span></td>
		<td data-name="needdescription"<?php echo $projects->needdescription->CellAttributes() ?>>
<span id="el_projects_needdescription">
<span<?php echo $projects->needdescription->ViewAttributes() ?>>
<?php echo $projects->needdescription->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->contact_type->Visible) { // contact_type ?>
	<tr id="r_contact_type">
		<td><span id="elh_projects_contact_type"><?php echo $projects->contact_type->FldCaption() ?></span></td>
		<td data-name="contact_type"<?php echo $projects->contact_type->CellAttributes() ?>>
<span id="el_projects_contact_type">
<span<?php echo $projects->contact_type->ViewAttributes() ?>>
<?php echo $projects->contact_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->contact_email->Visible) { // contact_email ?>
	<tr id="r_contact_email">
		<td><span id="elh_projects_contact_email"><?php echo $projects->contact_email->FldCaption() ?></span></td>
		<td data-name="contact_email"<?php echo $projects->contact_email->CellAttributes() ?>>
<span id="el_projects_contact_email">
<span<?php echo $projects->contact_email->ViewAttributes() ?>>
<?php echo $projects->contact_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
	<tr id="r_contact_phone">
		<td><span id="elh_projects_contact_phone"><?php echo $projects->contact_phone->FldCaption() ?></span></td>
		<td data-name="contact_phone"<?php echo $projects->contact_phone->CellAttributes() ?>>
<span id="el_projects_contact_phone">
<span<?php echo $projects->contact_phone->ViewAttributes() ?>>
<?php echo $projects->contact_phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->contact_name->Visible) { // contact_name ?>
	<tr id="r_contact_name">
		<td><span id="elh_projects_contact_name"><?php echo $projects->contact_name->FldCaption() ?></span></td>
		<td data-name="contact_name"<?php echo $projects->contact_name->CellAttributes() ?>>
<span id="el_projects_contact_name">
<span<?php echo $projects->contact_name->ViewAttributes() ?>>
<?php echo $projects->contact_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->budget->Visible) { // budget ?>
	<tr id="r_budget">
		<td><span id="elh_projects_budget"><?php echo $projects->budget->FldCaption() ?></span></td>
		<td data-name="budget"<?php echo $projects->budget->CellAttributes() ?>>
<span id="el_projects_budget">
<span<?php echo $projects->budget->ViewAttributes() ?>>
<?php echo $projects->budget->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->pending->Visible) { // pending ?>
	<tr id="r_pending">
		<td><span id="elh_projects_pending"><?php echo $projects->pending->FldCaption() ?></span></td>
		<td data-name="pending"<?php echo $projects->pending->CellAttributes() ?>>
<span id="el_projects_pending">
<span<?php echo $projects->pending->ViewAttributes() ?>>
<?php echo $projects->pending->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->verified_code->Visible) { // verified_code ?>
	<tr id="r_verified_code">
		<td><span id="elh_projects_verified_code"><?php echo $projects->verified_code->FldCaption() ?></span></td>
		<td data-name="verified_code"<?php echo $projects->verified_code->CellAttributes() ?>>
<span id="el_projects_verified_code">
<span<?php echo $projects->verified_code->ViewAttributes() ?>>
<?php echo $projects->verified_code->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->country_1->Visible) { // country_1 ?>
	<tr id="r_country_1">
		<td><span id="elh_projects_country_1"><?php echo $projects->country_1->FldCaption() ?></span></td>
		<td data-name="country_1"<?php echo $projects->country_1->CellAttributes() ?>>
<span id="el_projects_country_1">
<span<?php echo $projects->country_1->ViewAttributes() ?>>
<?php echo $projects->country_1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($projects->done->Visible) { // done ?>
	<tr id="r_done">
		<td><span id="elh_projects_done"><?php echo $projects->done->FldCaption() ?></span></td>
		<td data-name="done"<?php echo $projects->done->CellAttributes() ?>>
<span id="el_projects_done">
<span<?php echo $projects->done->ViewAttributes() ?>>
<?php echo $projects->done->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($projects->Export == "") { ?>
<?php if (!isset($projects_view->Pager)) $projects_view->Pager = new cPrevNextPager($projects_view->StartRec, $projects_view->DisplayRecs, $projects_view->TotalRecs) ?>
<?php if ($projects_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($projects_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($projects_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $projects_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($projects_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($projects_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $projects_view->PageUrl() ?>start=<?php echo $projects_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $projects_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fprojectsview.Init();
</script>
<?php
$projects_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($projects->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$projects_view->Page_Terminate();
?>
