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

$projects_list = NULL; // Initialize page object first

class cprojects_list extends cprojects {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'projects';

	// Page object name
	var $PageObjName = 'projects_list';

	// Grid form hidden field names
	var $FormName = 'fprojectslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "projectsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "projectsdelete.php";
		$this->MultiUpdateUrl = "projectsupdate.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fprojectslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->user_id->AdvancedSearch->ToJSON(), ","); // Field user_id
		$sFilterList = ew_Concat($sFilterList, $this->name->AdvancedSearch->ToJSON(), ","); // Field name
		$sFilterList = ew_Concat($sFilterList, $this->project_type_list->AdvancedSearch->ToJSON(), ","); // Field project_type_list
		$sFilterList = ew_Concat($sFilterList, $this->project_field_list->AdvancedSearch->ToJSON(), ","); // Field project_field_list
		$sFilterList = ew_Concat($sFilterList, $this->description->AdvancedSearch->ToJSON(), ","); // Field description
		$sFilterList = ew_Concat($sFilterList, $this->country->AdvancedSearch->ToJSON(), ","); // Field country
		$sFilterList = ew_Concat($sFilterList, $this->stage_list->AdvancedSearch->ToJSON(), ","); // Field stage_list
		$sFilterList = ew_Concat($sFilterList, $this->project_product_list->AdvancedSearch->ToJSON(), ","); // Field project_product_list
		$sFilterList = ew_Concat($sFilterList, $this->project_service_list->AdvancedSearch->ToJSON(), ","); // Field project_service_list
		$sFilterList = ew_Concat($sFilterList, $this->needagent->AdvancedSearch->ToJSON(), ","); // Field needagent
		$sFilterList = ew_Concat($sFilterList, $this->needpartner->AdvancedSearch->ToJSON(), ","); // Field needpartner
		$sFilterList = ew_Concat($sFilterList, $this->needclose->AdvancedSearch->ToJSON(), ","); // Field needclose
		$sFilterList = ew_Concat($sFilterList, $this->closedescription->AdvancedSearch->ToJSON(), ","); // Field closedescription
		$sFilterList = ew_Concat($sFilterList, $this->views->AdvancedSearch->ToJSON(), ","); // Field views
		$sFilterList = ew_Concat($sFilterList, $this->picpath->AdvancedSearch->ToJSON(), ","); // Field picpath
		$sFilterList = ew_Concat($sFilterList, $this->createdtime->AdvancedSearch->ToJSON(), ","); // Field createdtime
		$sFilterList = ew_Concat($sFilterList, $this->modifiedtime->AdvancedSearch->ToJSON(), ","); // Field modifiedtime
		$sFilterList = ew_Concat($sFilterList, $this->needfunder->AdvancedSearch->ToJSON(), ","); // Field needfunder
		$sFilterList = ew_Concat($sFilterList, $this->needdealer->AdvancedSearch->ToJSON(), ","); // Field needdealer
		$sFilterList = ew_Concat($sFilterList, $this->deleted->AdvancedSearch->ToJSON(), ","); // Field deleted
		$sFilterList = ew_Concat($sFilterList, $this->states->AdvancedSearch->ToJSON(), ","); // Field states
		$sFilterList = ew_Concat($sFilterList, $this->cities->AdvancedSearch->ToJSON(), ","); // Field cities
		$sFilterList = ew_Concat($sFilterList, $this->needbuyer->AdvancedSearch->ToJSON(), ","); // Field needbuyer
		$sFilterList = ew_Concat($sFilterList, $this->needdescription->AdvancedSearch->ToJSON(), ","); // Field needdescription
		$sFilterList = ew_Concat($sFilterList, $this->contact_type->AdvancedSearch->ToJSON(), ","); // Field contact_type
		$sFilterList = ew_Concat($sFilterList, $this->contact_email->AdvancedSearch->ToJSON(), ","); // Field contact_email
		$sFilterList = ew_Concat($sFilterList, $this->contact_phone->AdvancedSearch->ToJSON(), ","); // Field contact_phone
		$sFilterList = ew_Concat($sFilterList, $this->contact_name->AdvancedSearch->ToJSON(), ","); // Field contact_name
		$sFilterList = ew_Concat($sFilterList, $this->budget->AdvancedSearch->ToJSON(), ","); // Field budget
		$sFilterList = ew_Concat($sFilterList, $this->pending->AdvancedSearch->ToJSON(), ","); // Field pending
		$sFilterList = ew_Concat($sFilterList, $this->verified_code->AdvancedSearch->ToJSON(), ","); // Field verified_code
		$sFilterList = ew_Concat($sFilterList, $this->country_1->AdvancedSearch->ToJSON(), ","); // Field country_1
		$sFilterList = ew_Concat($sFilterList, $this->done->AdvancedSearch->ToJSON(), ","); // Field done
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field user_id
		$this->user_id->AdvancedSearch->SearchValue = @$filter["x_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator = @$filter["z_user_id"];
		$this->user_id->AdvancedSearch->SearchCondition = @$filter["v_user_id"];
		$this->user_id->AdvancedSearch->SearchValue2 = @$filter["y_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator2 = @$filter["w_user_id"];
		$this->user_id->AdvancedSearch->Save();

		// Field name
		$this->name->AdvancedSearch->SearchValue = @$filter["x_name"];
		$this->name->AdvancedSearch->SearchOperator = @$filter["z_name"];
		$this->name->AdvancedSearch->SearchCondition = @$filter["v_name"];
		$this->name->AdvancedSearch->SearchValue2 = @$filter["y_name"];
		$this->name->AdvancedSearch->SearchOperator2 = @$filter["w_name"];
		$this->name->AdvancedSearch->Save();

		// Field project_type_list
		$this->project_type_list->AdvancedSearch->SearchValue = @$filter["x_project_type_list"];
		$this->project_type_list->AdvancedSearch->SearchOperator = @$filter["z_project_type_list"];
		$this->project_type_list->AdvancedSearch->SearchCondition = @$filter["v_project_type_list"];
		$this->project_type_list->AdvancedSearch->SearchValue2 = @$filter["y_project_type_list"];
		$this->project_type_list->AdvancedSearch->SearchOperator2 = @$filter["w_project_type_list"];
		$this->project_type_list->AdvancedSearch->Save();

		// Field project_field_list
		$this->project_field_list->AdvancedSearch->SearchValue = @$filter["x_project_field_list"];
		$this->project_field_list->AdvancedSearch->SearchOperator = @$filter["z_project_field_list"];
		$this->project_field_list->AdvancedSearch->SearchCondition = @$filter["v_project_field_list"];
		$this->project_field_list->AdvancedSearch->SearchValue2 = @$filter["y_project_field_list"];
		$this->project_field_list->AdvancedSearch->SearchOperator2 = @$filter["w_project_field_list"];
		$this->project_field_list->AdvancedSearch->Save();

		// Field description
		$this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
		$this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
		$this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
		$this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
		$this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
		$this->description->AdvancedSearch->Save();

		// Field country
		$this->country->AdvancedSearch->SearchValue = @$filter["x_country"];
		$this->country->AdvancedSearch->SearchOperator = @$filter["z_country"];
		$this->country->AdvancedSearch->SearchCondition = @$filter["v_country"];
		$this->country->AdvancedSearch->SearchValue2 = @$filter["y_country"];
		$this->country->AdvancedSearch->SearchOperator2 = @$filter["w_country"];
		$this->country->AdvancedSearch->Save();

		// Field stage_list
		$this->stage_list->AdvancedSearch->SearchValue = @$filter["x_stage_list"];
		$this->stage_list->AdvancedSearch->SearchOperator = @$filter["z_stage_list"];
		$this->stage_list->AdvancedSearch->SearchCondition = @$filter["v_stage_list"];
		$this->stage_list->AdvancedSearch->SearchValue2 = @$filter["y_stage_list"];
		$this->stage_list->AdvancedSearch->SearchOperator2 = @$filter["w_stage_list"];
		$this->stage_list->AdvancedSearch->Save();

		// Field project_product_list
		$this->project_product_list->AdvancedSearch->SearchValue = @$filter["x_project_product_list"];
		$this->project_product_list->AdvancedSearch->SearchOperator = @$filter["z_project_product_list"];
		$this->project_product_list->AdvancedSearch->SearchCondition = @$filter["v_project_product_list"];
		$this->project_product_list->AdvancedSearch->SearchValue2 = @$filter["y_project_product_list"];
		$this->project_product_list->AdvancedSearch->SearchOperator2 = @$filter["w_project_product_list"];
		$this->project_product_list->AdvancedSearch->Save();

		// Field project_service_list
		$this->project_service_list->AdvancedSearch->SearchValue = @$filter["x_project_service_list"];
		$this->project_service_list->AdvancedSearch->SearchOperator = @$filter["z_project_service_list"];
		$this->project_service_list->AdvancedSearch->SearchCondition = @$filter["v_project_service_list"];
		$this->project_service_list->AdvancedSearch->SearchValue2 = @$filter["y_project_service_list"];
		$this->project_service_list->AdvancedSearch->SearchOperator2 = @$filter["w_project_service_list"];
		$this->project_service_list->AdvancedSearch->Save();

		// Field needagent
		$this->needagent->AdvancedSearch->SearchValue = @$filter["x_needagent"];
		$this->needagent->AdvancedSearch->SearchOperator = @$filter["z_needagent"];
		$this->needagent->AdvancedSearch->SearchCondition = @$filter["v_needagent"];
		$this->needagent->AdvancedSearch->SearchValue2 = @$filter["y_needagent"];
		$this->needagent->AdvancedSearch->SearchOperator2 = @$filter["w_needagent"];
		$this->needagent->AdvancedSearch->Save();

		// Field needpartner
		$this->needpartner->AdvancedSearch->SearchValue = @$filter["x_needpartner"];
		$this->needpartner->AdvancedSearch->SearchOperator = @$filter["z_needpartner"];
		$this->needpartner->AdvancedSearch->SearchCondition = @$filter["v_needpartner"];
		$this->needpartner->AdvancedSearch->SearchValue2 = @$filter["y_needpartner"];
		$this->needpartner->AdvancedSearch->SearchOperator2 = @$filter["w_needpartner"];
		$this->needpartner->AdvancedSearch->Save();

		// Field needclose
		$this->needclose->AdvancedSearch->SearchValue = @$filter["x_needclose"];
		$this->needclose->AdvancedSearch->SearchOperator = @$filter["z_needclose"];
		$this->needclose->AdvancedSearch->SearchCondition = @$filter["v_needclose"];
		$this->needclose->AdvancedSearch->SearchValue2 = @$filter["y_needclose"];
		$this->needclose->AdvancedSearch->SearchOperator2 = @$filter["w_needclose"];
		$this->needclose->AdvancedSearch->Save();

		// Field closedescription
		$this->closedescription->AdvancedSearch->SearchValue = @$filter["x_closedescription"];
		$this->closedescription->AdvancedSearch->SearchOperator = @$filter["z_closedescription"];
		$this->closedescription->AdvancedSearch->SearchCondition = @$filter["v_closedescription"];
		$this->closedescription->AdvancedSearch->SearchValue2 = @$filter["y_closedescription"];
		$this->closedescription->AdvancedSearch->SearchOperator2 = @$filter["w_closedescription"];
		$this->closedescription->AdvancedSearch->Save();

		// Field views
		$this->views->AdvancedSearch->SearchValue = @$filter["x_views"];
		$this->views->AdvancedSearch->SearchOperator = @$filter["z_views"];
		$this->views->AdvancedSearch->SearchCondition = @$filter["v_views"];
		$this->views->AdvancedSearch->SearchValue2 = @$filter["y_views"];
		$this->views->AdvancedSearch->SearchOperator2 = @$filter["w_views"];
		$this->views->AdvancedSearch->Save();

		// Field picpath
		$this->picpath->AdvancedSearch->SearchValue = @$filter["x_picpath"];
		$this->picpath->AdvancedSearch->SearchOperator = @$filter["z_picpath"];
		$this->picpath->AdvancedSearch->SearchCondition = @$filter["v_picpath"];
		$this->picpath->AdvancedSearch->SearchValue2 = @$filter["y_picpath"];
		$this->picpath->AdvancedSearch->SearchOperator2 = @$filter["w_picpath"];
		$this->picpath->AdvancedSearch->Save();

		// Field createdtime
		$this->createdtime->AdvancedSearch->SearchValue = @$filter["x_createdtime"];
		$this->createdtime->AdvancedSearch->SearchOperator = @$filter["z_createdtime"];
		$this->createdtime->AdvancedSearch->SearchCondition = @$filter["v_createdtime"];
		$this->createdtime->AdvancedSearch->SearchValue2 = @$filter["y_createdtime"];
		$this->createdtime->AdvancedSearch->SearchOperator2 = @$filter["w_createdtime"];
		$this->createdtime->AdvancedSearch->Save();

		// Field modifiedtime
		$this->modifiedtime->AdvancedSearch->SearchValue = @$filter["x_modifiedtime"];
		$this->modifiedtime->AdvancedSearch->SearchOperator = @$filter["z_modifiedtime"];
		$this->modifiedtime->AdvancedSearch->SearchCondition = @$filter["v_modifiedtime"];
		$this->modifiedtime->AdvancedSearch->SearchValue2 = @$filter["y_modifiedtime"];
		$this->modifiedtime->AdvancedSearch->SearchOperator2 = @$filter["w_modifiedtime"];
		$this->modifiedtime->AdvancedSearch->Save();

		// Field needfunder
		$this->needfunder->AdvancedSearch->SearchValue = @$filter["x_needfunder"];
		$this->needfunder->AdvancedSearch->SearchOperator = @$filter["z_needfunder"];
		$this->needfunder->AdvancedSearch->SearchCondition = @$filter["v_needfunder"];
		$this->needfunder->AdvancedSearch->SearchValue2 = @$filter["y_needfunder"];
		$this->needfunder->AdvancedSearch->SearchOperator2 = @$filter["w_needfunder"];
		$this->needfunder->AdvancedSearch->Save();

		// Field needdealer
		$this->needdealer->AdvancedSearch->SearchValue = @$filter["x_needdealer"];
		$this->needdealer->AdvancedSearch->SearchOperator = @$filter["z_needdealer"];
		$this->needdealer->AdvancedSearch->SearchCondition = @$filter["v_needdealer"];
		$this->needdealer->AdvancedSearch->SearchValue2 = @$filter["y_needdealer"];
		$this->needdealer->AdvancedSearch->SearchOperator2 = @$filter["w_needdealer"];
		$this->needdealer->AdvancedSearch->Save();

		// Field deleted
		$this->deleted->AdvancedSearch->SearchValue = @$filter["x_deleted"];
		$this->deleted->AdvancedSearch->SearchOperator = @$filter["z_deleted"];
		$this->deleted->AdvancedSearch->SearchCondition = @$filter["v_deleted"];
		$this->deleted->AdvancedSearch->SearchValue2 = @$filter["y_deleted"];
		$this->deleted->AdvancedSearch->SearchOperator2 = @$filter["w_deleted"];
		$this->deleted->AdvancedSearch->Save();

		// Field states
		$this->states->AdvancedSearch->SearchValue = @$filter["x_states"];
		$this->states->AdvancedSearch->SearchOperator = @$filter["z_states"];
		$this->states->AdvancedSearch->SearchCondition = @$filter["v_states"];
		$this->states->AdvancedSearch->SearchValue2 = @$filter["y_states"];
		$this->states->AdvancedSearch->SearchOperator2 = @$filter["w_states"];
		$this->states->AdvancedSearch->Save();

		// Field cities
		$this->cities->AdvancedSearch->SearchValue = @$filter["x_cities"];
		$this->cities->AdvancedSearch->SearchOperator = @$filter["z_cities"];
		$this->cities->AdvancedSearch->SearchCondition = @$filter["v_cities"];
		$this->cities->AdvancedSearch->SearchValue2 = @$filter["y_cities"];
		$this->cities->AdvancedSearch->SearchOperator2 = @$filter["w_cities"];
		$this->cities->AdvancedSearch->Save();

		// Field needbuyer
		$this->needbuyer->AdvancedSearch->SearchValue = @$filter["x_needbuyer"];
		$this->needbuyer->AdvancedSearch->SearchOperator = @$filter["z_needbuyer"];
		$this->needbuyer->AdvancedSearch->SearchCondition = @$filter["v_needbuyer"];
		$this->needbuyer->AdvancedSearch->SearchValue2 = @$filter["y_needbuyer"];
		$this->needbuyer->AdvancedSearch->SearchOperator2 = @$filter["w_needbuyer"];
		$this->needbuyer->AdvancedSearch->Save();

		// Field needdescription
		$this->needdescription->AdvancedSearch->SearchValue = @$filter["x_needdescription"];
		$this->needdescription->AdvancedSearch->SearchOperator = @$filter["z_needdescription"];
		$this->needdescription->AdvancedSearch->SearchCondition = @$filter["v_needdescription"];
		$this->needdescription->AdvancedSearch->SearchValue2 = @$filter["y_needdescription"];
		$this->needdescription->AdvancedSearch->SearchOperator2 = @$filter["w_needdescription"];
		$this->needdescription->AdvancedSearch->Save();

		// Field contact_type
		$this->contact_type->AdvancedSearch->SearchValue = @$filter["x_contact_type"];
		$this->contact_type->AdvancedSearch->SearchOperator = @$filter["z_contact_type"];
		$this->contact_type->AdvancedSearch->SearchCondition = @$filter["v_contact_type"];
		$this->contact_type->AdvancedSearch->SearchValue2 = @$filter["y_contact_type"];
		$this->contact_type->AdvancedSearch->SearchOperator2 = @$filter["w_contact_type"];
		$this->contact_type->AdvancedSearch->Save();

		// Field contact_email
		$this->contact_email->AdvancedSearch->SearchValue = @$filter["x_contact_email"];
		$this->contact_email->AdvancedSearch->SearchOperator = @$filter["z_contact_email"];
		$this->contact_email->AdvancedSearch->SearchCondition = @$filter["v_contact_email"];
		$this->contact_email->AdvancedSearch->SearchValue2 = @$filter["y_contact_email"];
		$this->contact_email->AdvancedSearch->SearchOperator2 = @$filter["w_contact_email"];
		$this->contact_email->AdvancedSearch->Save();

		// Field contact_phone
		$this->contact_phone->AdvancedSearch->SearchValue = @$filter["x_contact_phone"];
		$this->contact_phone->AdvancedSearch->SearchOperator = @$filter["z_contact_phone"];
		$this->contact_phone->AdvancedSearch->SearchCondition = @$filter["v_contact_phone"];
		$this->contact_phone->AdvancedSearch->SearchValue2 = @$filter["y_contact_phone"];
		$this->contact_phone->AdvancedSearch->SearchOperator2 = @$filter["w_contact_phone"];
		$this->contact_phone->AdvancedSearch->Save();

		// Field contact_name
		$this->contact_name->AdvancedSearch->SearchValue = @$filter["x_contact_name"];
		$this->contact_name->AdvancedSearch->SearchOperator = @$filter["z_contact_name"];
		$this->contact_name->AdvancedSearch->SearchCondition = @$filter["v_contact_name"];
		$this->contact_name->AdvancedSearch->SearchValue2 = @$filter["y_contact_name"];
		$this->contact_name->AdvancedSearch->SearchOperator2 = @$filter["w_contact_name"];
		$this->contact_name->AdvancedSearch->Save();

		// Field budget
		$this->budget->AdvancedSearch->SearchValue = @$filter["x_budget"];
		$this->budget->AdvancedSearch->SearchOperator = @$filter["z_budget"];
		$this->budget->AdvancedSearch->SearchCondition = @$filter["v_budget"];
		$this->budget->AdvancedSearch->SearchValue2 = @$filter["y_budget"];
		$this->budget->AdvancedSearch->SearchOperator2 = @$filter["w_budget"];
		$this->budget->AdvancedSearch->Save();

		// Field pending
		$this->pending->AdvancedSearch->SearchValue = @$filter["x_pending"];
		$this->pending->AdvancedSearch->SearchOperator = @$filter["z_pending"];
		$this->pending->AdvancedSearch->SearchCondition = @$filter["v_pending"];
		$this->pending->AdvancedSearch->SearchValue2 = @$filter["y_pending"];
		$this->pending->AdvancedSearch->SearchOperator2 = @$filter["w_pending"];
		$this->pending->AdvancedSearch->Save();

		// Field verified_code
		$this->verified_code->AdvancedSearch->SearchValue = @$filter["x_verified_code"];
		$this->verified_code->AdvancedSearch->SearchOperator = @$filter["z_verified_code"];
		$this->verified_code->AdvancedSearch->SearchCondition = @$filter["v_verified_code"];
		$this->verified_code->AdvancedSearch->SearchValue2 = @$filter["y_verified_code"];
		$this->verified_code->AdvancedSearch->SearchOperator2 = @$filter["w_verified_code"];
		$this->verified_code->AdvancedSearch->Save();

		// Field country_1
		$this->country_1->AdvancedSearch->SearchValue = @$filter["x_country_1"];
		$this->country_1->AdvancedSearch->SearchOperator = @$filter["z_country_1"];
		$this->country_1->AdvancedSearch->SearchCondition = @$filter["v_country_1"];
		$this->country_1->AdvancedSearch->SearchValue2 = @$filter["y_country_1"];
		$this->country_1->AdvancedSearch->SearchOperator2 = @$filter["w_country_1"];
		$this->country_1->AdvancedSearch->Save();

		// Field done
		$this->done->AdvancedSearch->SearchValue = @$filter["x_done"];
		$this->done->AdvancedSearch->SearchOperator = @$filter["z_done"];
		$this->done->AdvancedSearch->SearchCondition = @$filter["v_done"];
		$this->done->AdvancedSearch->SearchValue2 = @$filter["y_done"];
		$this->done->AdvancedSearch->SearchOperator2 = @$filter["w_done"];
		$this->done->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_type_list, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_field_list, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->stage_list, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_product_list, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->project_service_list, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->closedescription, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->picpath, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->needdescription, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->contact_type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->contact_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->contact_phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->contact_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->country_1, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->user_id); // user_id
			$this->UpdateSort($this->name); // name
			$this->UpdateSort($this->country); // country
			$this->UpdateSort($this->stage_list); // stage_list
			$this->UpdateSort($this->needagent); // needagent
			$this->UpdateSort($this->needpartner); // needpartner
			$this->UpdateSort($this->needclose); // needclose
			$this->UpdateSort($this->closedescription); // closedescription
			$this->UpdateSort($this->views); // views
			$this->UpdateSort($this->picpath); // picpath
			$this->UpdateSort($this->createdtime); // createdtime
			$this->UpdateSort($this->modifiedtime); // modifiedtime
			$this->UpdateSort($this->needfunder); // needfunder
			$this->UpdateSort($this->needdealer); // needdealer
			$this->UpdateSort($this->deleted); // deleted
			$this->UpdateSort($this->states); // states
			$this->UpdateSort($this->cities); // cities
			$this->UpdateSort($this->needbuyer); // needbuyer
			$this->UpdateSort($this->needdescription); // needdescription
			$this->UpdateSort($this->contact_type); // contact_type
			$this->UpdateSort($this->contact_email); // contact_email
			$this->UpdateSort($this->contact_phone); // contact_phone
			$this->UpdateSort($this->contact_name); // contact_name
			$this->UpdateSort($this->budget); // budget
			$this->UpdateSort($this->pending); // pending
			$this->UpdateSort($this->verified_code); // verified_code
			$this->UpdateSort($this->country_1); // country_1
			$this->UpdateSort($this->done); // done
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->user_id->setSort("");
				$this->name->setSort("");
				$this->country->setSort("");
				$this->stage_list->setSort("");
				$this->needagent->setSort("");
				$this->needpartner->setSort("");
				$this->needclose->setSort("");
				$this->closedescription->setSort("");
				$this->views->setSort("");
				$this->picpath->setSort("");
				$this->createdtime->setSort("");
				$this->modifiedtime->setSort("");
				$this->needfunder->setSort("");
				$this->needdealer->setSort("");
				$this->deleted->setSort("");
				$this->states->setSort("");
				$this->cities->setSort("");
				$this->needbuyer->setSort("");
				$this->needdescription->setSort("");
				$this->contact_type->setSort("");
				$this->contact_email->setSort("");
				$this->contact_phone->setSort("");
				$this->contact_name->setSort("");
				$this->budget->setSort("");
				$this->pending->setSort("");
				$this->verified_code->setSort("");
				$this->country_1->setSort("");
				$this->done->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . " onclick=\"return ew_ConfirmDelete(this);\"" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fprojectslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fprojectslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fprojectslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fprojectslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_projects\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_projects',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fprojectslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

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

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($projects_list)) $projects_list = new cprojects_list();

// Page init
$projects_list->Page_Init();

// Page main
$projects_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$projects_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($projects->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fprojectslist = new ew_Form("fprojectslist", "list");
fprojectslist.FormKeyCountName = '<?php echo $projects_list->FormKeyCountName ?>';

// Form_CustomValidate event
fprojectslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fprojectslist.ValidateRequired = true;
<?php } else { ?>
fprojectslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fprojectslistsrch = new ew_Form("fprojectslistsrch");
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
<?php if ($projects_list->TotalRecs > 0 && $projects_list->ExportOptions->Visible()) { ?>
<?php $projects_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($projects_list->SearchOptions->Visible()) { ?>
<?php $projects_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($projects_list->FilterOptions->Visible()) { ?>
<?php $projects_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($projects->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $projects_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($projects_list->TotalRecs <= 0)
			$projects_list->TotalRecs = $projects->SelectRecordCount();
	} else {
		if (!$projects_list->Recordset && ($projects_list->Recordset = $projects_list->LoadRecordset()))
			$projects_list->TotalRecs = $projects_list->Recordset->RecordCount();
	}
	$projects_list->StartRec = 1;
	if ($projects_list->DisplayRecs <= 0 || ($projects->Export <> "" && $projects->ExportAll)) // Display all records
		$projects_list->DisplayRecs = $projects_list->TotalRecs;
	if (!($projects->Export <> "" && $projects->ExportAll))
		$projects_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$projects_list->Recordset = $projects_list->LoadRecordset($projects_list->StartRec-1, $projects_list->DisplayRecs);

	// Set no record found message
	if ($projects->CurrentAction == "" && $projects_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$projects_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($projects_list->SearchWhere == "0=101")
			$projects_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$projects_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$projects_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($projects->Export == "" && $projects->CurrentAction == "") { ?>
<form name="fprojectslistsrch" id="fprojectslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($projects_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fprojectslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="projects">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($projects_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($projects_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $projects_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($projects_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($projects_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $projects_list->ShowPageHeader(); ?>
<?php
$projects_list->ShowMessage();
?>
<?php if ($projects_list->TotalRecs > 0 || $projects->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($projects->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($projects->CurrentAction <> "gridadd" && $projects->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($projects_list->Pager)) $projects_list->Pager = new cPrevNextPager($projects_list->StartRec, $projects_list->DisplayRecs, $projects_list->TotalRecs) ?>
<?php if ($projects_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($projects_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($projects_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $projects_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($projects_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($projects_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $projects_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $projects_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $projects_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $projects_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($projects_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fprojectslist" id="fprojectslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($projects_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $projects_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="projects">
<div id="gmp_projects" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($projects_list->TotalRecs > 0) { ?>
<table id="tbl_projectslist" class="table ewTable">
<?php echo $projects->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$projects_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$projects_list->RenderListOptions();

// Render list options (header, left)
$projects_list->ListOptions->Render("header", "left");
?>
<?php if ($projects->id->Visible) { // id ?>
	<?php if ($projects->SortUrl($projects->id) == "") { ?>
		<th data-name="id"><div id="elh_projects_id" class="projects_id"><div class="ewTableHeaderCaption"><?php echo $projects->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->id) ?>',1);"><div id="elh_projects_id" class="projects_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->user_id->Visible) { // user_id ?>
	<?php if ($projects->SortUrl($projects->user_id) == "") { ?>
		<th data-name="user_id"><div id="elh_projects_user_id" class="projects_user_id"><div class="ewTableHeaderCaption"><?php echo $projects->user_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->user_id) ?>',1);"><div id="elh_projects_user_id" class="projects_user_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->user_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->user_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->user_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->name->Visible) { // name ?>
	<?php if ($projects->SortUrl($projects->name) == "") { ?>
		<th data-name="name"><div id="elh_projects_name" class="projects_name"><div class="ewTableHeaderCaption"><?php echo $projects->name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->name) ?>',1);"><div id="elh_projects_name" class="projects_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->country->Visible) { // country ?>
	<?php if ($projects->SortUrl($projects->country) == "") { ?>
		<th data-name="country"><div id="elh_projects_country" class="projects_country"><div class="ewTableHeaderCaption"><?php echo $projects->country->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->country) ?>',1);"><div id="elh_projects_country" class="projects_country">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->country->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->country->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->country->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->stage_list->Visible) { // stage_list ?>
	<?php if ($projects->SortUrl($projects->stage_list) == "") { ?>
		<th data-name="stage_list"><div id="elh_projects_stage_list" class="projects_stage_list"><div class="ewTableHeaderCaption"><?php echo $projects->stage_list->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="stage_list"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->stage_list) ?>',1);"><div id="elh_projects_stage_list" class="projects_stage_list">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->stage_list->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->stage_list->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->stage_list->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needagent->Visible) { // needagent ?>
	<?php if ($projects->SortUrl($projects->needagent) == "") { ?>
		<th data-name="needagent"><div id="elh_projects_needagent" class="projects_needagent"><div class="ewTableHeaderCaption"><?php echo $projects->needagent->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needagent"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needagent) ?>',1);"><div id="elh_projects_needagent" class="projects_needagent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needagent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needagent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needagent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needpartner->Visible) { // needpartner ?>
	<?php if ($projects->SortUrl($projects->needpartner) == "") { ?>
		<th data-name="needpartner"><div id="elh_projects_needpartner" class="projects_needpartner"><div class="ewTableHeaderCaption"><?php echo $projects->needpartner->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needpartner"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needpartner) ?>',1);"><div id="elh_projects_needpartner" class="projects_needpartner">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needpartner->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needpartner->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needpartner->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needclose->Visible) { // needclose ?>
	<?php if ($projects->SortUrl($projects->needclose) == "") { ?>
		<th data-name="needclose"><div id="elh_projects_needclose" class="projects_needclose"><div class="ewTableHeaderCaption"><?php echo $projects->needclose->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needclose"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needclose) ?>',1);"><div id="elh_projects_needclose" class="projects_needclose">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needclose->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needclose->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needclose->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->closedescription->Visible) { // closedescription ?>
	<?php if ($projects->SortUrl($projects->closedescription) == "") { ?>
		<th data-name="closedescription"><div id="elh_projects_closedescription" class="projects_closedescription"><div class="ewTableHeaderCaption"><?php echo $projects->closedescription->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="closedescription"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->closedescription) ?>',1);"><div id="elh_projects_closedescription" class="projects_closedescription">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->closedescription->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->closedescription->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->closedescription->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->views->Visible) { // views ?>
	<?php if ($projects->SortUrl($projects->views) == "") { ?>
		<th data-name="views"><div id="elh_projects_views" class="projects_views"><div class="ewTableHeaderCaption"><?php echo $projects->views->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="views"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->views) ?>',1);"><div id="elh_projects_views" class="projects_views">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->views->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->views->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->views->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->picpath->Visible) { // picpath ?>
	<?php if ($projects->SortUrl($projects->picpath) == "") { ?>
		<th data-name="picpath"><div id="elh_projects_picpath" class="projects_picpath"><div class="ewTableHeaderCaption"><?php echo $projects->picpath->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="picpath"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->picpath) ?>',1);"><div id="elh_projects_picpath" class="projects_picpath">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->picpath->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->picpath->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->picpath->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->createdtime->Visible) { // createdtime ?>
	<?php if ($projects->SortUrl($projects->createdtime) == "") { ?>
		<th data-name="createdtime"><div id="elh_projects_createdtime" class="projects_createdtime"><div class="ewTableHeaderCaption"><?php echo $projects->createdtime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="createdtime"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->createdtime) ?>',1);"><div id="elh_projects_createdtime" class="projects_createdtime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->createdtime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->createdtime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->createdtime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
	<?php if ($projects->SortUrl($projects->modifiedtime) == "") { ?>
		<th data-name="modifiedtime"><div id="elh_projects_modifiedtime" class="projects_modifiedtime"><div class="ewTableHeaderCaption"><?php echo $projects->modifiedtime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="modifiedtime"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->modifiedtime) ?>',1);"><div id="elh_projects_modifiedtime" class="projects_modifiedtime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->modifiedtime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->modifiedtime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->modifiedtime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needfunder->Visible) { // needfunder ?>
	<?php if ($projects->SortUrl($projects->needfunder) == "") { ?>
		<th data-name="needfunder"><div id="elh_projects_needfunder" class="projects_needfunder"><div class="ewTableHeaderCaption"><?php echo $projects->needfunder->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needfunder"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needfunder) ?>',1);"><div id="elh_projects_needfunder" class="projects_needfunder">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needfunder->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needfunder->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needfunder->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needdealer->Visible) { // needdealer ?>
	<?php if ($projects->SortUrl($projects->needdealer) == "") { ?>
		<th data-name="needdealer"><div id="elh_projects_needdealer" class="projects_needdealer"><div class="ewTableHeaderCaption"><?php echo $projects->needdealer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needdealer"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needdealer) ?>',1);"><div id="elh_projects_needdealer" class="projects_needdealer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needdealer->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needdealer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needdealer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->deleted->Visible) { // deleted ?>
	<?php if ($projects->SortUrl($projects->deleted) == "") { ?>
		<th data-name="deleted"><div id="elh_projects_deleted" class="projects_deleted"><div class="ewTableHeaderCaption"><?php echo $projects->deleted->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="deleted"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->deleted) ?>',1);"><div id="elh_projects_deleted" class="projects_deleted">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->deleted->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->deleted->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->deleted->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->states->Visible) { // states ?>
	<?php if ($projects->SortUrl($projects->states) == "") { ?>
		<th data-name="states"><div id="elh_projects_states" class="projects_states"><div class="ewTableHeaderCaption"><?php echo $projects->states->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="states"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->states) ?>',1);"><div id="elh_projects_states" class="projects_states">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->states->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->states->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->states->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->cities->Visible) { // cities ?>
	<?php if ($projects->SortUrl($projects->cities) == "") { ?>
		<th data-name="cities"><div id="elh_projects_cities" class="projects_cities"><div class="ewTableHeaderCaption"><?php echo $projects->cities->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cities"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->cities) ?>',1);"><div id="elh_projects_cities" class="projects_cities">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->cities->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->cities->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->cities->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
	<?php if ($projects->SortUrl($projects->needbuyer) == "") { ?>
		<th data-name="needbuyer"><div id="elh_projects_needbuyer" class="projects_needbuyer"><div class="ewTableHeaderCaption"><?php echo $projects->needbuyer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needbuyer"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needbuyer) ?>',1);"><div id="elh_projects_needbuyer" class="projects_needbuyer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needbuyer->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->needbuyer->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needbuyer->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->needdescription->Visible) { // needdescription ?>
	<?php if ($projects->SortUrl($projects->needdescription) == "") { ?>
		<th data-name="needdescription"><div id="elh_projects_needdescription" class="projects_needdescription"><div class="ewTableHeaderCaption"><?php echo $projects->needdescription->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="needdescription"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->needdescription) ?>',1);"><div id="elh_projects_needdescription" class="projects_needdescription">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->needdescription->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->needdescription->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->needdescription->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->contact_type->Visible) { // contact_type ?>
	<?php if ($projects->SortUrl($projects->contact_type) == "") { ?>
		<th data-name="contact_type"><div id="elh_projects_contact_type" class="projects_contact_type"><div class="ewTableHeaderCaption"><?php echo $projects->contact_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="contact_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->contact_type) ?>',1);"><div id="elh_projects_contact_type" class="projects_contact_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->contact_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->contact_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->contact_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->contact_email->Visible) { // contact_email ?>
	<?php if ($projects->SortUrl($projects->contact_email) == "") { ?>
		<th data-name="contact_email"><div id="elh_projects_contact_email" class="projects_contact_email"><div class="ewTableHeaderCaption"><?php echo $projects->contact_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="contact_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->contact_email) ?>',1);"><div id="elh_projects_contact_email" class="projects_contact_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->contact_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->contact_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->contact_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
	<?php if ($projects->SortUrl($projects->contact_phone) == "") { ?>
		<th data-name="contact_phone"><div id="elh_projects_contact_phone" class="projects_contact_phone"><div class="ewTableHeaderCaption"><?php echo $projects->contact_phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="contact_phone"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->contact_phone) ?>',1);"><div id="elh_projects_contact_phone" class="projects_contact_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->contact_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->contact_phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->contact_phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->contact_name->Visible) { // contact_name ?>
	<?php if ($projects->SortUrl($projects->contact_name) == "") { ?>
		<th data-name="contact_name"><div id="elh_projects_contact_name" class="projects_contact_name"><div class="ewTableHeaderCaption"><?php echo $projects->contact_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="contact_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->contact_name) ?>',1);"><div id="elh_projects_contact_name" class="projects_contact_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->contact_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->contact_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->contact_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->budget->Visible) { // budget ?>
	<?php if ($projects->SortUrl($projects->budget) == "") { ?>
		<th data-name="budget"><div id="elh_projects_budget" class="projects_budget"><div class="ewTableHeaderCaption"><?php echo $projects->budget->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="budget"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->budget) ?>',1);"><div id="elh_projects_budget" class="projects_budget">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->budget->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->budget->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->budget->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->pending->Visible) { // pending ?>
	<?php if ($projects->SortUrl($projects->pending) == "") { ?>
		<th data-name="pending"><div id="elh_projects_pending" class="projects_pending"><div class="ewTableHeaderCaption"><?php echo $projects->pending->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pending"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->pending) ?>',1);"><div id="elh_projects_pending" class="projects_pending">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->pending->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->pending->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->pending->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->verified_code->Visible) { // verified_code ?>
	<?php if ($projects->SortUrl($projects->verified_code) == "") { ?>
		<th data-name="verified_code"><div id="elh_projects_verified_code" class="projects_verified_code"><div class="ewTableHeaderCaption"><?php echo $projects->verified_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="verified_code"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->verified_code) ?>',1);"><div id="elh_projects_verified_code" class="projects_verified_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->verified_code->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->verified_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->verified_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->country_1->Visible) { // country_1 ?>
	<?php if ($projects->SortUrl($projects->country_1) == "") { ?>
		<th data-name="country_1"><div id="elh_projects_country_1" class="projects_country_1"><div class="ewTableHeaderCaption"><?php echo $projects->country_1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country_1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->country_1) ?>',1);"><div id="elh_projects_country_1" class="projects_country_1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->country_1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($projects->country_1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->country_1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($projects->done->Visible) { // done ?>
	<?php if ($projects->SortUrl($projects->done) == "") { ?>
		<th data-name="done"><div id="elh_projects_done" class="projects_done"><div class="ewTableHeaderCaption"><?php echo $projects->done->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="done"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $projects->SortUrl($projects->done) ?>',1);"><div id="elh_projects_done" class="projects_done">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $projects->done->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($projects->done->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($projects->done->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$projects_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($projects->ExportAll && $projects->Export <> "") {
	$projects_list->StopRec = $projects_list->TotalRecs;
} else {

	// Set the last record to display
	if ($projects_list->TotalRecs > $projects_list->StartRec + $projects_list->DisplayRecs - 1)
		$projects_list->StopRec = $projects_list->StartRec + $projects_list->DisplayRecs - 1;
	else
		$projects_list->StopRec = $projects_list->TotalRecs;
}
$projects_list->RecCnt = $projects_list->StartRec - 1;
if ($projects_list->Recordset && !$projects_list->Recordset->EOF) {
	$projects_list->Recordset->MoveFirst();
	$bSelectLimit = $projects_list->UseSelectLimit;
	if (!$bSelectLimit && $projects_list->StartRec > 1)
		$projects_list->Recordset->Move($projects_list->StartRec - 1);
} elseif (!$projects->AllowAddDeleteRow && $projects_list->StopRec == 0) {
	$projects_list->StopRec = $projects->GridAddRowCount;
}

// Initialize aggregate
$projects->RowType = EW_ROWTYPE_AGGREGATEINIT;
$projects->ResetAttrs();
$projects_list->RenderRow();
while ($projects_list->RecCnt < $projects_list->StopRec) {
	$projects_list->RecCnt++;
	if (intval($projects_list->RecCnt) >= intval($projects_list->StartRec)) {
		$projects_list->RowCnt++;

		// Set up key count
		$projects_list->KeyCount = $projects_list->RowIndex;

		// Init row class and style
		$projects->ResetAttrs();
		$projects->CssClass = "";
		if ($projects->CurrentAction == "gridadd") {
		} else {
			$projects_list->LoadRowValues($projects_list->Recordset); // Load row values
		}
		$projects->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$projects->RowAttrs = array_merge($projects->RowAttrs, array('data-rowindex'=>$projects_list->RowCnt, 'id'=>'r' . $projects_list->RowCnt . '_projects', 'data-rowtype'=>$projects->RowType));

		// Render row
		$projects_list->RenderRow();

		// Render list options
		$projects_list->RenderListOptions();
?>
	<tr<?php echo $projects->RowAttributes() ?>>
<?php

// Render list options (body, left)
$projects_list->ListOptions->Render("body", "left", $projects_list->RowCnt);
?>
	<?php if ($projects->id->Visible) { // id ?>
		<td data-name="id"<?php echo $projects->id->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_id" class="projects_id">
<span<?php echo $projects->id->ViewAttributes() ?>>
<?php echo $projects->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $projects_list->PageObjName . "_row_" . $projects_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($projects->user_id->Visible) { // user_id ?>
		<td data-name="user_id"<?php echo $projects->user_id->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_user_id" class="projects_user_id">
<span<?php echo $projects->user_id->ViewAttributes() ?>>
<?php echo $projects->user_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->name->Visible) { // name ?>
		<td data-name="name"<?php echo $projects->name->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_name" class="projects_name">
<span<?php echo $projects->name->ViewAttributes() ?>>
<?php echo $projects->name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->country->Visible) { // country ?>
		<td data-name="country"<?php echo $projects->country->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_country" class="projects_country">
<span<?php echo $projects->country->ViewAttributes() ?>>
<?php echo $projects->country->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->stage_list->Visible) { // stage_list ?>
		<td data-name="stage_list"<?php echo $projects->stage_list->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_stage_list" class="projects_stage_list">
<span<?php echo $projects->stage_list->ViewAttributes() ?>>
<?php echo $projects->stage_list->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needagent->Visible) { // needagent ?>
		<td data-name="needagent"<?php echo $projects->needagent->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needagent" class="projects_needagent">
<span<?php echo $projects->needagent->ViewAttributes() ?>>
<?php echo $projects->needagent->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needpartner->Visible) { // needpartner ?>
		<td data-name="needpartner"<?php echo $projects->needpartner->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needpartner" class="projects_needpartner">
<span<?php echo $projects->needpartner->ViewAttributes() ?>>
<?php echo $projects->needpartner->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needclose->Visible) { // needclose ?>
		<td data-name="needclose"<?php echo $projects->needclose->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needclose" class="projects_needclose">
<span<?php echo $projects->needclose->ViewAttributes() ?>>
<?php echo $projects->needclose->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->closedescription->Visible) { // closedescription ?>
		<td data-name="closedescription"<?php echo $projects->closedescription->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_closedescription" class="projects_closedescription">
<span<?php echo $projects->closedescription->ViewAttributes() ?>>
<?php echo $projects->closedescription->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->views->Visible) { // views ?>
		<td data-name="views"<?php echo $projects->views->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_views" class="projects_views">
<span<?php echo $projects->views->ViewAttributes() ?>>
<?php echo $projects->views->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->picpath->Visible) { // picpath ?>
		<td data-name="picpath"<?php echo $projects->picpath->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_picpath" class="projects_picpath">
<span<?php echo $projects->picpath->ViewAttributes() ?>>
<?php echo $projects->picpath->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->createdtime->Visible) { // createdtime ?>
		<td data-name="createdtime"<?php echo $projects->createdtime->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_createdtime" class="projects_createdtime">
<span<?php echo $projects->createdtime->ViewAttributes() ?>>
<?php echo $projects->createdtime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->modifiedtime->Visible) { // modifiedtime ?>
		<td data-name="modifiedtime"<?php echo $projects->modifiedtime->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_modifiedtime" class="projects_modifiedtime">
<span<?php echo $projects->modifiedtime->ViewAttributes() ?>>
<?php echo $projects->modifiedtime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needfunder->Visible) { // needfunder ?>
		<td data-name="needfunder"<?php echo $projects->needfunder->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needfunder" class="projects_needfunder">
<span<?php echo $projects->needfunder->ViewAttributes() ?>>
<?php echo $projects->needfunder->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needdealer->Visible) { // needdealer ?>
		<td data-name="needdealer"<?php echo $projects->needdealer->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needdealer" class="projects_needdealer">
<span<?php echo $projects->needdealer->ViewAttributes() ?>>
<?php echo $projects->needdealer->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->deleted->Visible) { // deleted ?>
		<td data-name="deleted"<?php echo $projects->deleted->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_deleted" class="projects_deleted">
<span<?php echo $projects->deleted->ViewAttributes() ?>>
<?php echo $projects->deleted->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->states->Visible) { // states ?>
		<td data-name="states"<?php echo $projects->states->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_states" class="projects_states">
<span<?php echo $projects->states->ViewAttributes() ?>>
<?php echo $projects->states->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->cities->Visible) { // cities ?>
		<td data-name="cities"<?php echo $projects->cities->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_cities" class="projects_cities">
<span<?php echo $projects->cities->ViewAttributes() ?>>
<?php echo $projects->cities->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needbuyer->Visible) { // needbuyer ?>
		<td data-name="needbuyer"<?php echo $projects->needbuyer->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needbuyer" class="projects_needbuyer">
<span<?php echo $projects->needbuyer->ViewAttributes() ?>>
<?php echo $projects->needbuyer->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->needdescription->Visible) { // needdescription ?>
		<td data-name="needdescription"<?php echo $projects->needdescription->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_needdescription" class="projects_needdescription">
<span<?php echo $projects->needdescription->ViewAttributes() ?>>
<?php echo $projects->needdescription->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->contact_type->Visible) { // contact_type ?>
		<td data-name="contact_type"<?php echo $projects->contact_type->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_contact_type" class="projects_contact_type">
<span<?php echo $projects->contact_type->ViewAttributes() ?>>
<?php echo $projects->contact_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->contact_email->Visible) { // contact_email ?>
		<td data-name="contact_email"<?php echo $projects->contact_email->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_contact_email" class="projects_contact_email">
<span<?php echo $projects->contact_email->ViewAttributes() ?>>
<?php echo $projects->contact_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->contact_phone->Visible) { // contact_phone ?>
		<td data-name="contact_phone"<?php echo $projects->contact_phone->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_contact_phone" class="projects_contact_phone">
<span<?php echo $projects->contact_phone->ViewAttributes() ?>>
<?php echo $projects->contact_phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->contact_name->Visible) { // contact_name ?>
		<td data-name="contact_name"<?php echo $projects->contact_name->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_contact_name" class="projects_contact_name">
<span<?php echo $projects->contact_name->ViewAttributes() ?>>
<?php echo $projects->contact_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->budget->Visible) { // budget ?>
		<td data-name="budget"<?php echo $projects->budget->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_budget" class="projects_budget">
<span<?php echo $projects->budget->ViewAttributes() ?>>
<?php echo $projects->budget->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->pending->Visible) { // pending ?>
		<td data-name="pending"<?php echo $projects->pending->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_pending" class="projects_pending">
<span<?php echo $projects->pending->ViewAttributes() ?>>
<?php echo $projects->pending->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->verified_code->Visible) { // verified_code ?>
		<td data-name="verified_code"<?php echo $projects->verified_code->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_verified_code" class="projects_verified_code">
<span<?php echo $projects->verified_code->ViewAttributes() ?>>
<?php echo $projects->verified_code->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->country_1->Visible) { // country_1 ?>
		<td data-name="country_1"<?php echo $projects->country_1->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_country_1" class="projects_country_1">
<span<?php echo $projects->country_1->ViewAttributes() ?>>
<?php echo $projects->country_1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($projects->done->Visible) { // done ?>
		<td data-name="done"<?php echo $projects->done->CellAttributes() ?>>
<span id="el<?php echo $projects_list->RowCnt ?>_projects_done" class="projects_done">
<span<?php echo $projects->done->ViewAttributes() ?>>
<?php echo $projects->done->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$projects_list->ListOptions->Render("body", "right", $projects_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($projects->CurrentAction <> "gridadd")
		$projects_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($projects->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($projects_list->Recordset)
	$projects_list->Recordset->Close();
?>
<?php if ($projects->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($projects->CurrentAction <> "gridadd" && $projects->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($projects_list->Pager)) $projects_list->Pager = new cPrevNextPager($projects_list->StartRec, $projects_list->DisplayRecs, $projects_list->TotalRecs) ?>
<?php if ($projects_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($projects_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($projects_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $projects_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($projects_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($projects_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $projects_list->PageUrl() ?>start=<?php echo $projects_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $projects_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $projects_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $projects_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $projects_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($projects_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($projects_list->TotalRecs == 0 && $projects->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($projects_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($projects->Export == "") { ?>
<script type="text/javascript">
fprojectslistsrch.Init();
fprojectslistsrch.FilterList = <?php echo $projects_list->GetFilterList() ?>;
fprojectslist.Init();
</script>
<?php } ?>
<?php
$projects_list->ShowPageFooter();
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
$projects_list->Page_Terminate();
?>
