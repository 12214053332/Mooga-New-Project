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

$users_list = NULL; // Initialize page object first

class cusers_list extends cusers {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_list';

	// Grid form hidden field names
	var $FormName = 'fuserslist';
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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "usersadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "usersdelete.php";
		$this->MultiUpdateUrl = "usersupdate.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fuserslistsrch";

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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		$sFilterList = ew_Concat($sFilterList, $this->name->AdvancedSearch->ToJSON(), ","); // Field name
		$sFilterList = ew_Concat($sFilterList, $this->_email->AdvancedSearch->ToJSON(), ","); // Field email
		$sFilterList = ew_Concat($sFilterList, $this->companyname->AdvancedSearch->ToJSON(), ","); // Field companyname
		$sFilterList = ew_Concat($sFilterList, $this->servicetime->AdvancedSearch->ToJSON(), ","); // Field servicetime
		$sFilterList = ew_Concat($sFilterList, $this->country->AdvancedSearch->ToJSON(), ","); // Field country
		$sFilterList = ew_Concat($sFilterList, $this->phone->AdvancedSearch->ToJSON(), ","); // Field phone
		$sFilterList = ew_Concat($sFilterList, $this->skype->AdvancedSearch->ToJSON(), ","); // Field skype
		$sFilterList = ew_Concat($sFilterList, $this->website->AdvancedSearch->ToJSON(), ","); // Field website
		$sFilterList = ew_Concat($sFilterList, $this->linkedin->AdvancedSearch->ToJSON(), ","); // Field linkedin
		$sFilterList = ew_Concat($sFilterList, $this->facebook->AdvancedSearch->ToJSON(), ","); // Field facebook
		$sFilterList = ew_Concat($sFilterList, $this->twitter->AdvancedSearch->ToJSON(), ","); // Field twitter
		$sFilterList = ew_Concat($sFilterList, $this->active_code->AdvancedSearch->ToJSON(), ","); // Field active_code
		$sFilterList = ew_Concat($sFilterList, $this->identification->AdvancedSearch->ToJSON(), ","); // Field identification
		$sFilterList = ew_Concat($sFilterList, $this->link_expired->AdvancedSearch->ToJSON(), ","); // Field link_expired
		$sFilterList = ew_Concat($sFilterList, $this->isactive->AdvancedSearch->ToJSON(), ","); // Field isactive
		$sFilterList = ew_Concat($sFilterList, $this->pio->AdvancedSearch->ToJSON(), ","); // Field pio
		$sFilterList = ew_Concat($sFilterList, $this->google->AdvancedSearch->ToJSON(), ","); // Field google
		$sFilterList = ew_Concat($sFilterList, $this->instagram->AdvancedSearch->ToJSON(), ","); // Field instagram
		$sFilterList = ew_Concat($sFilterList, $this->account_type->AdvancedSearch->ToJSON(), ","); // Field account_type
		$sFilterList = ew_Concat($sFilterList, $this->logo->AdvancedSearch->ToJSON(), ","); // Field logo
		$sFilterList = ew_Concat($sFilterList, $this->profilepic->AdvancedSearch->ToJSON(), ","); // Field profilepic
		$sFilterList = ew_Concat($sFilterList, $this->mailref->AdvancedSearch->ToJSON(), ","); // Field mailref
		$sFilterList = ew_Concat($sFilterList, $this->deleted->AdvancedSearch->ToJSON(), ","); // Field deleted
		$sFilterList = ew_Concat($sFilterList, $this->deletefeedback->AdvancedSearch->ToJSON(), ","); // Field deletefeedback
		$sFilterList = ew_Concat($sFilterList, $this->account_id->AdvancedSearch->ToJSON(), ","); // Field account_id
		$sFilterList = ew_Concat($sFilterList, $this->start_date->AdvancedSearch->ToJSON(), ","); // Field start_date
		$sFilterList = ew_Concat($sFilterList, $this->end_date->AdvancedSearch->ToJSON(), ","); // Field end_date
		$sFilterList = ew_Concat($sFilterList, $this->year_moth->AdvancedSearch->ToJSON(), ","); // Field year_moth
		$sFilterList = ew_Concat($sFilterList, $this->registerdate->AdvancedSearch->ToJSON(), ","); // Field registerdate
		$sFilterList = ew_Concat($sFilterList, $this->login_type->AdvancedSearch->ToJSON(), ","); // Field login_type
		$sFilterList = ew_Concat($sFilterList, $this->accountstatus->AdvancedSearch->ToJSON(), ","); // Field accountstatus
		$sFilterList = ew_Concat($sFilterList, $this->ispay->AdvancedSearch->ToJSON(), ","); // Field ispay
		$sFilterList = ew_Concat($sFilterList, $this->profilelink->AdvancedSearch->ToJSON(), ","); // Field profilelink
		$sFilterList = ew_Concat($sFilterList, $this->source->AdvancedSearch->ToJSON(), ","); // Field source
		$sFilterList = ew_Concat($sFilterList, $this->agree->AdvancedSearch->ToJSON(), ","); // Field agree
		$sFilterList = ew_Concat($sFilterList, $this->balance->AdvancedSearch->ToJSON(), ","); // Field balance
		$sFilterList = ew_Concat($sFilterList, $this->job_title->AdvancedSearch->ToJSON(), ","); // Field job_title
		$sFilterList = ew_Concat($sFilterList, $this->projects->AdvancedSearch->ToJSON(), ","); // Field projects
		$sFilterList = ew_Concat($sFilterList, $this->opportunities->AdvancedSearch->ToJSON(), ","); // Field opportunities
		$sFilterList = ew_Concat($sFilterList, $this->isconsaltant->AdvancedSearch->ToJSON(), ","); // Field isconsaltant
		$sFilterList = ew_Concat($sFilterList, $this->isagent->AdvancedSearch->ToJSON(), ","); // Field isagent
		$sFilterList = ew_Concat($sFilterList, $this->isinvestor->AdvancedSearch->ToJSON(), ","); // Field isinvestor
		$sFilterList = ew_Concat($sFilterList, $this->isbusinessman->AdvancedSearch->ToJSON(), ","); // Field isbusinessman
		$sFilterList = ew_Concat($sFilterList, $this->isprovider->AdvancedSearch->ToJSON(), ","); // Field isprovider
		$sFilterList = ew_Concat($sFilterList, $this->isproductowner->AdvancedSearch->ToJSON(), ","); // Field isproductowner
		$sFilterList = ew_Concat($sFilterList, $this->states->AdvancedSearch->ToJSON(), ","); // Field states
		$sFilterList = ew_Concat($sFilterList, $this->cities->AdvancedSearch->ToJSON(), ","); // Field cities
		$sFilterList = ew_Concat($sFilterList, $this->offers->AdvancedSearch->ToJSON(), ","); // Field offers
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

		// Field name
		$this->name->AdvancedSearch->SearchValue = @$filter["x_name"];
		$this->name->AdvancedSearch->SearchOperator = @$filter["z_name"];
		$this->name->AdvancedSearch->SearchCondition = @$filter["v_name"];
		$this->name->AdvancedSearch->SearchValue2 = @$filter["y_name"];
		$this->name->AdvancedSearch->SearchOperator2 = @$filter["w_name"];
		$this->name->AdvancedSearch->Save();

		// Field email
		$this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
		$this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
		$this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
		$this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
		$this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
		$this->_email->AdvancedSearch->Save();

		// Field companyname
		$this->companyname->AdvancedSearch->SearchValue = @$filter["x_companyname"];
		$this->companyname->AdvancedSearch->SearchOperator = @$filter["z_companyname"];
		$this->companyname->AdvancedSearch->SearchCondition = @$filter["v_companyname"];
		$this->companyname->AdvancedSearch->SearchValue2 = @$filter["y_companyname"];
		$this->companyname->AdvancedSearch->SearchOperator2 = @$filter["w_companyname"];
		$this->companyname->AdvancedSearch->Save();

		// Field servicetime
		$this->servicetime->AdvancedSearch->SearchValue = @$filter["x_servicetime"];
		$this->servicetime->AdvancedSearch->SearchOperator = @$filter["z_servicetime"];
		$this->servicetime->AdvancedSearch->SearchCondition = @$filter["v_servicetime"];
		$this->servicetime->AdvancedSearch->SearchValue2 = @$filter["y_servicetime"];
		$this->servicetime->AdvancedSearch->SearchOperator2 = @$filter["w_servicetime"];
		$this->servicetime->AdvancedSearch->Save();

		// Field country
		$this->country->AdvancedSearch->SearchValue = @$filter["x_country"];
		$this->country->AdvancedSearch->SearchOperator = @$filter["z_country"];
		$this->country->AdvancedSearch->SearchCondition = @$filter["v_country"];
		$this->country->AdvancedSearch->SearchValue2 = @$filter["y_country"];
		$this->country->AdvancedSearch->SearchOperator2 = @$filter["w_country"];
		$this->country->AdvancedSearch->Save();

		// Field phone
		$this->phone->AdvancedSearch->SearchValue = @$filter["x_phone"];
		$this->phone->AdvancedSearch->SearchOperator = @$filter["z_phone"];
		$this->phone->AdvancedSearch->SearchCondition = @$filter["v_phone"];
		$this->phone->AdvancedSearch->SearchValue2 = @$filter["y_phone"];
		$this->phone->AdvancedSearch->SearchOperator2 = @$filter["w_phone"];
		$this->phone->AdvancedSearch->Save();

		// Field skype
		$this->skype->AdvancedSearch->SearchValue = @$filter["x_skype"];
		$this->skype->AdvancedSearch->SearchOperator = @$filter["z_skype"];
		$this->skype->AdvancedSearch->SearchCondition = @$filter["v_skype"];
		$this->skype->AdvancedSearch->SearchValue2 = @$filter["y_skype"];
		$this->skype->AdvancedSearch->SearchOperator2 = @$filter["w_skype"];
		$this->skype->AdvancedSearch->Save();

		// Field website
		$this->website->AdvancedSearch->SearchValue = @$filter["x_website"];
		$this->website->AdvancedSearch->SearchOperator = @$filter["z_website"];
		$this->website->AdvancedSearch->SearchCondition = @$filter["v_website"];
		$this->website->AdvancedSearch->SearchValue2 = @$filter["y_website"];
		$this->website->AdvancedSearch->SearchOperator2 = @$filter["w_website"];
		$this->website->AdvancedSearch->Save();

		// Field linkedin
		$this->linkedin->AdvancedSearch->SearchValue = @$filter["x_linkedin"];
		$this->linkedin->AdvancedSearch->SearchOperator = @$filter["z_linkedin"];
		$this->linkedin->AdvancedSearch->SearchCondition = @$filter["v_linkedin"];
		$this->linkedin->AdvancedSearch->SearchValue2 = @$filter["y_linkedin"];
		$this->linkedin->AdvancedSearch->SearchOperator2 = @$filter["w_linkedin"];
		$this->linkedin->AdvancedSearch->Save();

		// Field facebook
		$this->facebook->AdvancedSearch->SearchValue = @$filter["x_facebook"];
		$this->facebook->AdvancedSearch->SearchOperator = @$filter["z_facebook"];
		$this->facebook->AdvancedSearch->SearchCondition = @$filter["v_facebook"];
		$this->facebook->AdvancedSearch->SearchValue2 = @$filter["y_facebook"];
		$this->facebook->AdvancedSearch->SearchOperator2 = @$filter["w_facebook"];
		$this->facebook->AdvancedSearch->Save();

		// Field twitter
		$this->twitter->AdvancedSearch->SearchValue = @$filter["x_twitter"];
		$this->twitter->AdvancedSearch->SearchOperator = @$filter["z_twitter"];
		$this->twitter->AdvancedSearch->SearchCondition = @$filter["v_twitter"];
		$this->twitter->AdvancedSearch->SearchValue2 = @$filter["y_twitter"];
		$this->twitter->AdvancedSearch->SearchOperator2 = @$filter["w_twitter"];
		$this->twitter->AdvancedSearch->Save();

		// Field active_code
		$this->active_code->AdvancedSearch->SearchValue = @$filter["x_active_code"];
		$this->active_code->AdvancedSearch->SearchOperator = @$filter["z_active_code"];
		$this->active_code->AdvancedSearch->SearchCondition = @$filter["v_active_code"];
		$this->active_code->AdvancedSearch->SearchValue2 = @$filter["y_active_code"];
		$this->active_code->AdvancedSearch->SearchOperator2 = @$filter["w_active_code"];
		$this->active_code->AdvancedSearch->Save();

		// Field identification
		$this->identification->AdvancedSearch->SearchValue = @$filter["x_identification"];
		$this->identification->AdvancedSearch->SearchOperator = @$filter["z_identification"];
		$this->identification->AdvancedSearch->SearchCondition = @$filter["v_identification"];
		$this->identification->AdvancedSearch->SearchValue2 = @$filter["y_identification"];
		$this->identification->AdvancedSearch->SearchOperator2 = @$filter["w_identification"];
		$this->identification->AdvancedSearch->Save();

		// Field link_expired
		$this->link_expired->AdvancedSearch->SearchValue = @$filter["x_link_expired"];
		$this->link_expired->AdvancedSearch->SearchOperator = @$filter["z_link_expired"];
		$this->link_expired->AdvancedSearch->SearchCondition = @$filter["v_link_expired"];
		$this->link_expired->AdvancedSearch->SearchValue2 = @$filter["y_link_expired"];
		$this->link_expired->AdvancedSearch->SearchOperator2 = @$filter["w_link_expired"];
		$this->link_expired->AdvancedSearch->Save();

		// Field isactive
		$this->isactive->AdvancedSearch->SearchValue = @$filter["x_isactive"];
		$this->isactive->AdvancedSearch->SearchOperator = @$filter["z_isactive"];
		$this->isactive->AdvancedSearch->SearchCondition = @$filter["v_isactive"];
		$this->isactive->AdvancedSearch->SearchValue2 = @$filter["y_isactive"];
		$this->isactive->AdvancedSearch->SearchOperator2 = @$filter["w_isactive"];
		$this->isactive->AdvancedSearch->Save();

		// Field pio
		$this->pio->AdvancedSearch->SearchValue = @$filter["x_pio"];
		$this->pio->AdvancedSearch->SearchOperator = @$filter["z_pio"];
		$this->pio->AdvancedSearch->SearchCondition = @$filter["v_pio"];
		$this->pio->AdvancedSearch->SearchValue2 = @$filter["y_pio"];
		$this->pio->AdvancedSearch->SearchOperator2 = @$filter["w_pio"];
		$this->pio->AdvancedSearch->Save();

		// Field google
		$this->google->AdvancedSearch->SearchValue = @$filter["x_google"];
		$this->google->AdvancedSearch->SearchOperator = @$filter["z_google"];
		$this->google->AdvancedSearch->SearchCondition = @$filter["v_google"];
		$this->google->AdvancedSearch->SearchValue2 = @$filter["y_google"];
		$this->google->AdvancedSearch->SearchOperator2 = @$filter["w_google"];
		$this->google->AdvancedSearch->Save();

		// Field instagram
		$this->instagram->AdvancedSearch->SearchValue = @$filter["x_instagram"];
		$this->instagram->AdvancedSearch->SearchOperator = @$filter["z_instagram"];
		$this->instagram->AdvancedSearch->SearchCondition = @$filter["v_instagram"];
		$this->instagram->AdvancedSearch->SearchValue2 = @$filter["y_instagram"];
		$this->instagram->AdvancedSearch->SearchOperator2 = @$filter["w_instagram"];
		$this->instagram->AdvancedSearch->Save();

		// Field account_type
		$this->account_type->AdvancedSearch->SearchValue = @$filter["x_account_type"];
		$this->account_type->AdvancedSearch->SearchOperator = @$filter["z_account_type"];
		$this->account_type->AdvancedSearch->SearchCondition = @$filter["v_account_type"];
		$this->account_type->AdvancedSearch->SearchValue2 = @$filter["y_account_type"];
		$this->account_type->AdvancedSearch->SearchOperator2 = @$filter["w_account_type"];
		$this->account_type->AdvancedSearch->Save();

		// Field logo
		$this->logo->AdvancedSearch->SearchValue = @$filter["x_logo"];
		$this->logo->AdvancedSearch->SearchOperator = @$filter["z_logo"];
		$this->logo->AdvancedSearch->SearchCondition = @$filter["v_logo"];
		$this->logo->AdvancedSearch->SearchValue2 = @$filter["y_logo"];
		$this->logo->AdvancedSearch->SearchOperator2 = @$filter["w_logo"];
		$this->logo->AdvancedSearch->Save();

		// Field profilepic
		$this->profilepic->AdvancedSearch->SearchValue = @$filter["x_profilepic"];
		$this->profilepic->AdvancedSearch->SearchOperator = @$filter["z_profilepic"];
		$this->profilepic->AdvancedSearch->SearchCondition = @$filter["v_profilepic"];
		$this->profilepic->AdvancedSearch->SearchValue2 = @$filter["y_profilepic"];
		$this->profilepic->AdvancedSearch->SearchOperator2 = @$filter["w_profilepic"];
		$this->profilepic->AdvancedSearch->Save();

		// Field mailref
		$this->mailref->AdvancedSearch->SearchValue = @$filter["x_mailref"];
		$this->mailref->AdvancedSearch->SearchOperator = @$filter["z_mailref"];
		$this->mailref->AdvancedSearch->SearchCondition = @$filter["v_mailref"];
		$this->mailref->AdvancedSearch->SearchValue2 = @$filter["y_mailref"];
		$this->mailref->AdvancedSearch->SearchOperator2 = @$filter["w_mailref"];
		$this->mailref->AdvancedSearch->Save();

		// Field deleted
		$this->deleted->AdvancedSearch->SearchValue = @$filter["x_deleted"];
		$this->deleted->AdvancedSearch->SearchOperator = @$filter["z_deleted"];
		$this->deleted->AdvancedSearch->SearchCondition = @$filter["v_deleted"];
		$this->deleted->AdvancedSearch->SearchValue2 = @$filter["y_deleted"];
		$this->deleted->AdvancedSearch->SearchOperator2 = @$filter["w_deleted"];
		$this->deleted->AdvancedSearch->Save();

		// Field deletefeedback
		$this->deletefeedback->AdvancedSearch->SearchValue = @$filter["x_deletefeedback"];
		$this->deletefeedback->AdvancedSearch->SearchOperator = @$filter["z_deletefeedback"];
		$this->deletefeedback->AdvancedSearch->SearchCondition = @$filter["v_deletefeedback"];
		$this->deletefeedback->AdvancedSearch->SearchValue2 = @$filter["y_deletefeedback"];
		$this->deletefeedback->AdvancedSearch->SearchOperator2 = @$filter["w_deletefeedback"];
		$this->deletefeedback->AdvancedSearch->Save();

		// Field account_id
		$this->account_id->AdvancedSearch->SearchValue = @$filter["x_account_id"];
		$this->account_id->AdvancedSearch->SearchOperator = @$filter["z_account_id"];
		$this->account_id->AdvancedSearch->SearchCondition = @$filter["v_account_id"];
		$this->account_id->AdvancedSearch->SearchValue2 = @$filter["y_account_id"];
		$this->account_id->AdvancedSearch->SearchOperator2 = @$filter["w_account_id"];
		$this->account_id->AdvancedSearch->Save();

		// Field start_date
		$this->start_date->AdvancedSearch->SearchValue = @$filter["x_start_date"];
		$this->start_date->AdvancedSearch->SearchOperator = @$filter["z_start_date"];
		$this->start_date->AdvancedSearch->SearchCondition = @$filter["v_start_date"];
		$this->start_date->AdvancedSearch->SearchValue2 = @$filter["y_start_date"];
		$this->start_date->AdvancedSearch->SearchOperator2 = @$filter["w_start_date"];
		$this->start_date->AdvancedSearch->Save();

		// Field end_date
		$this->end_date->AdvancedSearch->SearchValue = @$filter["x_end_date"];
		$this->end_date->AdvancedSearch->SearchOperator = @$filter["z_end_date"];
		$this->end_date->AdvancedSearch->SearchCondition = @$filter["v_end_date"];
		$this->end_date->AdvancedSearch->SearchValue2 = @$filter["y_end_date"];
		$this->end_date->AdvancedSearch->SearchOperator2 = @$filter["w_end_date"];
		$this->end_date->AdvancedSearch->Save();

		// Field year_moth
		$this->year_moth->AdvancedSearch->SearchValue = @$filter["x_year_moth"];
		$this->year_moth->AdvancedSearch->SearchOperator = @$filter["z_year_moth"];
		$this->year_moth->AdvancedSearch->SearchCondition = @$filter["v_year_moth"];
		$this->year_moth->AdvancedSearch->SearchValue2 = @$filter["y_year_moth"];
		$this->year_moth->AdvancedSearch->SearchOperator2 = @$filter["w_year_moth"];
		$this->year_moth->AdvancedSearch->Save();

		// Field registerdate
		$this->registerdate->AdvancedSearch->SearchValue = @$filter["x_registerdate"];
		$this->registerdate->AdvancedSearch->SearchOperator = @$filter["z_registerdate"];
		$this->registerdate->AdvancedSearch->SearchCondition = @$filter["v_registerdate"];
		$this->registerdate->AdvancedSearch->SearchValue2 = @$filter["y_registerdate"];
		$this->registerdate->AdvancedSearch->SearchOperator2 = @$filter["w_registerdate"];
		$this->registerdate->AdvancedSearch->Save();

		// Field login_type
		$this->login_type->AdvancedSearch->SearchValue = @$filter["x_login_type"];
		$this->login_type->AdvancedSearch->SearchOperator = @$filter["z_login_type"];
		$this->login_type->AdvancedSearch->SearchCondition = @$filter["v_login_type"];
		$this->login_type->AdvancedSearch->SearchValue2 = @$filter["y_login_type"];
		$this->login_type->AdvancedSearch->SearchOperator2 = @$filter["w_login_type"];
		$this->login_type->AdvancedSearch->Save();

		// Field accountstatus
		$this->accountstatus->AdvancedSearch->SearchValue = @$filter["x_accountstatus"];
		$this->accountstatus->AdvancedSearch->SearchOperator = @$filter["z_accountstatus"];
		$this->accountstatus->AdvancedSearch->SearchCondition = @$filter["v_accountstatus"];
		$this->accountstatus->AdvancedSearch->SearchValue2 = @$filter["y_accountstatus"];
		$this->accountstatus->AdvancedSearch->SearchOperator2 = @$filter["w_accountstatus"];
		$this->accountstatus->AdvancedSearch->Save();

		// Field ispay
		$this->ispay->AdvancedSearch->SearchValue = @$filter["x_ispay"];
		$this->ispay->AdvancedSearch->SearchOperator = @$filter["z_ispay"];
		$this->ispay->AdvancedSearch->SearchCondition = @$filter["v_ispay"];
		$this->ispay->AdvancedSearch->SearchValue2 = @$filter["y_ispay"];
		$this->ispay->AdvancedSearch->SearchOperator2 = @$filter["w_ispay"];
		$this->ispay->AdvancedSearch->Save();

		// Field profilelink
		$this->profilelink->AdvancedSearch->SearchValue = @$filter["x_profilelink"];
		$this->profilelink->AdvancedSearch->SearchOperator = @$filter["z_profilelink"];
		$this->profilelink->AdvancedSearch->SearchCondition = @$filter["v_profilelink"];
		$this->profilelink->AdvancedSearch->SearchValue2 = @$filter["y_profilelink"];
		$this->profilelink->AdvancedSearch->SearchOperator2 = @$filter["w_profilelink"];
		$this->profilelink->AdvancedSearch->Save();

		// Field source
		$this->source->AdvancedSearch->SearchValue = @$filter["x_source"];
		$this->source->AdvancedSearch->SearchOperator = @$filter["z_source"];
		$this->source->AdvancedSearch->SearchCondition = @$filter["v_source"];
		$this->source->AdvancedSearch->SearchValue2 = @$filter["y_source"];
		$this->source->AdvancedSearch->SearchOperator2 = @$filter["w_source"];
		$this->source->AdvancedSearch->Save();

		// Field agree
		$this->agree->AdvancedSearch->SearchValue = @$filter["x_agree"];
		$this->agree->AdvancedSearch->SearchOperator = @$filter["z_agree"];
		$this->agree->AdvancedSearch->SearchCondition = @$filter["v_agree"];
		$this->agree->AdvancedSearch->SearchValue2 = @$filter["y_agree"];
		$this->agree->AdvancedSearch->SearchOperator2 = @$filter["w_agree"];
		$this->agree->AdvancedSearch->Save();

		// Field balance
		$this->balance->AdvancedSearch->SearchValue = @$filter["x_balance"];
		$this->balance->AdvancedSearch->SearchOperator = @$filter["z_balance"];
		$this->balance->AdvancedSearch->SearchCondition = @$filter["v_balance"];
		$this->balance->AdvancedSearch->SearchValue2 = @$filter["y_balance"];
		$this->balance->AdvancedSearch->SearchOperator2 = @$filter["w_balance"];
		$this->balance->AdvancedSearch->Save();

		// Field job_title
		$this->job_title->AdvancedSearch->SearchValue = @$filter["x_job_title"];
		$this->job_title->AdvancedSearch->SearchOperator = @$filter["z_job_title"];
		$this->job_title->AdvancedSearch->SearchCondition = @$filter["v_job_title"];
		$this->job_title->AdvancedSearch->SearchValue2 = @$filter["y_job_title"];
		$this->job_title->AdvancedSearch->SearchOperator2 = @$filter["w_job_title"];
		$this->job_title->AdvancedSearch->Save();

		// Field projects
		$this->projects->AdvancedSearch->SearchValue = @$filter["x_projects"];
		$this->projects->AdvancedSearch->SearchOperator = @$filter["z_projects"];
		$this->projects->AdvancedSearch->SearchCondition = @$filter["v_projects"];
		$this->projects->AdvancedSearch->SearchValue2 = @$filter["y_projects"];
		$this->projects->AdvancedSearch->SearchOperator2 = @$filter["w_projects"];
		$this->projects->AdvancedSearch->Save();

		// Field opportunities
		$this->opportunities->AdvancedSearch->SearchValue = @$filter["x_opportunities"];
		$this->opportunities->AdvancedSearch->SearchOperator = @$filter["z_opportunities"];
		$this->opportunities->AdvancedSearch->SearchCondition = @$filter["v_opportunities"];
		$this->opportunities->AdvancedSearch->SearchValue2 = @$filter["y_opportunities"];
		$this->opportunities->AdvancedSearch->SearchOperator2 = @$filter["w_opportunities"];
		$this->opportunities->AdvancedSearch->Save();

		// Field isconsaltant
		$this->isconsaltant->AdvancedSearch->SearchValue = @$filter["x_isconsaltant"];
		$this->isconsaltant->AdvancedSearch->SearchOperator = @$filter["z_isconsaltant"];
		$this->isconsaltant->AdvancedSearch->SearchCondition = @$filter["v_isconsaltant"];
		$this->isconsaltant->AdvancedSearch->SearchValue2 = @$filter["y_isconsaltant"];
		$this->isconsaltant->AdvancedSearch->SearchOperator2 = @$filter["w_isconsaltant"];
		$this->isconsaltant->AdvancedSearch->Save();

		// Field isagent
		$this->isagent->AdvancedSearch->SearchValue = @$filter["x_isagent"];
		$this->isagent->AdvancedSearch->SearchOperator = @$filter["z_isagent"];
		$this->isagent->AdvancedSearch->SearchCondition = @$filter["v_isagent"];
		$this->isagent->AdvancedSearch->SearchValue2 = @$filter["y_isagent"];
		$this->isagent->AdvancedSearch->SearchOperator2 = @$filter["w_isagent"];
		$this->isagent->AdvancedSearch->Save();

		// Field isinvestor
		$this->isinvestor->AdvancedSearch->SearchValue = @$filter["x_isinvestor"];
		$this->isinvestor->AdvancedSearch->SearchOperator = @$filter["z_isinvestor"];
		$this->isinvestor->AdvancedSearch->SearchCondition = @$filter["v_isinvestor"];
		$this->isinvestor->AdvancedSearch->SearchValue2 = @$filter["y_isinvestor"];
		$this->isinvestor->AdvancedSearch->SearchOperator2 = @$filter["w_isinvestor"];
		$this->isinvestor->AdvancedSearch->Save();

		// Field isbusinessman
		$this->isbusinessman->AdvancedSearch->SearchValue = @$filter["x_isbusinessman"];
		$this->isbusinessman->AdvancedSearch->SearchOperator = @$filter["z_isbusinessman"];
		$this->isbusinessman->AdvancedSearch->SearchCondition = @$filter["v_isbusinessman"];
		$this->isbusinessman->AdvancedSearch->SearchValue2 = @$filter["y_isbusinessman"];
		$this->isbusinessman->AdvancedSearch->SearchOperator2 = @$filter["w_isbusinessman"];
		$this->isbusinessman->AdvancedSearch->Save();

		// Field isprovider
		$this->isprovider->AdvancedSearch->SearchValue = @$filter["x_isprovider"];
		$this->isprovider->AdvancedSearch->SearchOperator = @$filter["z_isprovider"];
		$this->isprovider->AdvancedSearch->SearchCondition = @$filter["v_isprovider"];
		$this->isprovider->AdvancedSearch->SearchValue2 = @$filter["y_isprovider"];
		$this->isprovider->AdvancedSearch->SearchOperator2 = @$filter["w_isprovider"];
		$this->isprovider->AdvancedSearch->Save();

		// Field isproductowner
		$this->isproductowner->AdvancedSearch->SearchValue = @$filter["x_isproductowner"];
		$this->isproductowner->AdvancedSearch->SearchOperator = @$filter["z_isproductowner"];
		$this->isproductowner->AdvancedSearch->SearchCondition = @$filter["v_isproductowner"];
		$this->isproductowner->AdvancedSearch->SearchValue2 = @$filter["y_isproductowner"];
		$this->isproductowner->AdvancedSearch->SearchOperator2 = @$filter["w_isproductowner"];
		$this->isproductowner->AdvancedSearch->Save();

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

		// Field offers
		$this->offers->AdvancedSearch->SearchValue = @$filter["x_offers"];
		$this->offers->AdvancedSearch->SearchOperator = @$filter["z_offers"];
		$this->offers->AdvancedSearch->SearchCondition = @$filter["v_offers"];
		$this->offers->AdvancedSearch->SearchValue2 = @$filter["y_offers"];
		$this->offers->AdvancedSearch->SearchOperator2 = @$filter["w_offers"];
		$this->offers->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->name, $Default, FALSE); // name
		$this->BuildSearchSql($sWhere, $this->_email, $Default, FALSE); // email
		$this->BuildSearchSql($sWhere, $this->companyname, $Default, FALSE); // companyname
		$this->BuildSearchSql($sWhere, $this->servicetime, $Default, FALSE); // servicetime
		$this->BuildSearchSql($sWhere, $this->country, $Default, FALSE); // country
		$this->BuildSearchSql($sWhere, $this->phone, $Default, FALSE); // phone
		$this->BuildSearchSql($sWhere, $this->skype, $Default, FALSE); // skype
		$this->BuildSearchSql($sWhere, $this->website, $Default, FALSE); // website
		$this->BuildSearchSql($sWhere, $this->linkedin, $Default, FALSE); // linkedin
		$this->BuildSearchSql($sWhere, $this->facebook, $Default, FALSE); // facebook
		$this->BuildSearchSql($sWhere, $this->twitter, $Default, FALSE); // twitter
		$this->BuildSearchSql($sWhere, $this->active_code, $Default, FALSE); // active_code
		$this->BuildSearchSql($sWhere, $this->identification, $Default, FALSE); // identification
		$this->BuildSearchSql($sWhere, $this->link_expired, $Default, FALSE); // link_expired
		$this->BuildSearchSql($sWhere, $this->isactive, $Default, FALSE); // isactive
		$this->BuildSearchSql($sWhere, $this->pio, $Default, FALSE); // pio
		$this->BuildSearchSql($sWhere, $this->google, $Default, FALSE); // google
		$this->BuildSearchSql($sWhere, $this->instagram, $Default, FALSE); // instagram
		$this->BuildSearchSql($sWhere, $this->account_type, $Default, FALSE); // account_type
		$this->BuildSearchSql($sWhere, $this->logo, $Default, FALSE); // logo
		$this->BuildSearchSql($sWhere, $this->profilepic, $Default, FALSE); // profilepic
		$this->BuildSearchSql($sWhere, $this->mailref, $Default, FALSE); // mailref
		$this->BuildSearchSql($sWhere, $this->deleted, $Default, FALSE); // deleted
		$this->BuildSearchSql($sWhere, $this->deletefeedback, $Default, FALSE); // deletefeedback
		$this->BuildSearchSql($sWhere, $this->account_id, $Default, FALSE); // account_id
		$this->BuildSearchSql($sWhere, $this->start_date, $Default, FALSE); // start_date
		$this->BuildSearchSql($sWhere, $this->end_date, $Default, FALSE); // end_date
		$this->BuildSearchSql($sWhere, $this->year_moth, $Default, FALSE); // year_moth
		$this->BuildSearchSql($sWhere, $this->registerdate, $Default, FALSE); // registerdate
		$this->BuildSearchSql($sWhere, $this->login_type, $Default, FALSE); // login_type
		$this->BuildSearchSql($sWhere, $this->accountstatus, $Default, FALSE); // accountstatus
		$this->BuildSearchSql($sWhere, $this->ispay, $Default, FALSE); // ispay
		$this->BuildSearchSql($sWhere, $this->profilelink, $Default, FALSE); // profilelink
		$this->BuildSearchSql($sWhere, $this->source, $Default, FALSE); // source
		$this->BuildSearchSql($sWhere, $this->agree, $Default, FALSE); // agree
		$this->BuildSearchSql($sWhere, $this->balance, $Default, FALSE); // balance
		$this->BuildSearchSql($sWhere, $this->job_title, $Default, FALSE); // job_title
		$this->BuildSearchSql($sWhere, $this->projects, $Default, FALSE); // projects
		$this->BuildSearchSql($sWhere, $this->opportunities, $Default, FALSE); // opportunities
		$this->BuildSearchSql($sWhere, $this->isconsaltant, $Default, FALSE); // isconsaltant
		$this->BuildSearchSql($sWhere, $this->isagent, $Default, FALSE); // isagent
		$this->BuildSearchSql($sWhere, $this->isinvestor, $Default, FALSE); // isinvestor
		$this->BuildSearchSql($sWhere, $this->isbusinessman, $Default, FALSE); // isbusinessman
		$this->BuildSearchSql($sWhere, $this->isprovider, $Default, FALSE); // isprovider
		$this->BuildSearchSql($sWhere, $this->isproductowner, $Default, FALSE); // isproductowner
		$this->BuildSearchSql($sWhere, $this->states, $Default, FALSE); // states
		$this->BuildSearchSql($sWhere, $this->cities, $Default, FALSE); // cities
		$this->BuildSearchSql($sWhere, $this->offers, $Default, FALSE); // offers

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->name->AdvancedSearch->Save(); // name
			$this->_email->AdvancedSearch->Save(); // email
			$this->companyname->AdvancedSearch->Save(); // companyname
			$this->servicetime->AdvancedSearch->Save(); // servicetime
			$this->country->AdvancedSearch->Save(); // country
			$this->phone->AdvancedSearch->Save(); // phone
			$this->skype->AdvancedSearch->Save(); // skype
			$this->website->AdvancedSearch->Save(); // website
			$this->linkedin->AdvancedSearch->Save(); // linkedin
			$this->facebook->AdvancedSearch->Save(); // facebook
			$this->twitter->AdvancedSearch->Save(); // twitter
			$this->active_code->AdvancedSearch->Save(); // active_code
			$this->identification->AdvancedSearch->Save(); // identification
			$this->link_expired->AdvancedSearch->Save(); // link_expired
			$this->isactive->AdvancedSearch->Save(); // isactive
			$this->pio->AdvancedSearch->Save(); // pio
			$this->google->AdvancedSearch->Save(); // google
			$this->instagram->AdvancedSearch->Save(); // instagram
			$this->account_type->AdvancedSearch->Save(); // account_type
			$this->logo->AdvancedSearch->Save(); // logo
			$this->profilepic->AdvancedSearch->Save(); // profilepic
			$this->mailref->AdvancedSearch->Save(); // mailref
			$this->deleted->AdvancedSearch->Save(); // deleted
			$this->deletefeedback->AdvancedSearch->Save(); // deletefeedback
			$this->account_id->AdvancedSearch->Save(); // account_id
			$this->start_date->AdvancedSearch->Save(); // start_date
			$this->end_date->AdvancedSearch->Save(); // end_date
			$this->year_moth->AdvancedSearch->Save(); // year_moth
			$this->registerdate->AdvancedSearch->Save(); // registerdate
			$this->login_type->AdvancedSearch->Save(); // login_type
			$this->accountstatus->AdvancedSearch->Save(); // accountstatus
			$this->ispay->AdvancedSearch->Save(); // ispay
			$this->profilelink->AdvancedSearch->Save(); // profilelink
			$this->source->AdvancedSearch->Save(); // source
			$this->agree->AdvancedSearch->Save(); // agree
			$this->balance->AdvancedSearch->Save(); // balance
			$this->job_title->AdvancedSearch->Save(); // job_title
			$this->projects->AdvancedSearch->Save(); // projects
			$this->opportunities->AdvancedSearch->Save(); // opportunities
			$this->isconsaltant->AdvancedSearch->Save(); // isconsaltant
			$this->isagent->AdvancedSearch->Save(); // isagent
			$this->isinvestor->AdvancedSearch->Save(); // isinvestor
			$this->isbusinessman->AdvancedSearch->Save(); // isbusinessman
			$this->isprovider->AdvancedSearch->Save(); // isprovider
			$this->isproductowner->AdvancedSearch->Save(); // isproductowner
			$this->states->AdvancedSearch->Save(); // states
			$this->cities->AdvancedSearch->Save(); // cities
			$this->offers->AdvancedSearch->Save(); // offers
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->companyname, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->servicetime, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->country, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->skype, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->website, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->linkedin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->facebook, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->twitter, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->active_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pio, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->google, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->instagram, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->account_type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->logo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->profilepic, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->mailref, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->deletefeedback, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->year_moth, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->registerdate, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->login_type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->accountstatus, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->profilelink, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->source, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->agree, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->job_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->states, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cities, $arKeywords, $type);
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
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->_email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->companyname->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->servicetime->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->country->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->phone->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->skype->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->website->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->linkedin->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->facebook->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->twitter->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->active_code->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->identification->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->link_expired->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isactive->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->pio->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->google->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->instagram->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->account_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->logo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->profilepic->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->mailref->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->deleted->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->deletefeedback->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->account_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->start_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->end_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->year_moth->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->registerdate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->login_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->accountstatus->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ispay->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->profilelink->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->source->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->agree->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->balance->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->job_title->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->projects->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->opportunities->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isconsaltant->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isagent->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isinvestor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isbusinessman->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isprovider->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->isproductowner->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->states->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->cities->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->offers->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->name->AdvancedSearch->UnsetSession();
		$this->_email->AdvancedSearch->UnsetSession();
		$this->companyname->AdvancedSearch->UnsetSession();
		$this->servicetime->AdvancedSearch->UnsetSession();
		$this->country->AdvancedSearch->UnsetSession();
		$this->phone->AdvancedSearch->UnsetSession();
		$this->skype->AdvancedSearch->UnsetSession();
		$this->website->AdvancedSearch->UnsetSession();
		$this->linkedin->AdvancedSearch->UnsetSession();
		$this->facebook->AdvancedSearch->UnsetSession();
		$this->twitter->AdvancedSearch->UnsetSession();
		$this->active_code->AdvancedSearch->UnsetSession();
		$this->identification->AdvancedSearch->UnsetSession();
		$this->link_expired->AdvancedSearch->UnsetSession();
		$this->isactive->AdvancedSearch->UnsetSession();
		$this->pio->AdvancedSearch->UnsetSession();
		$this->google->AdvancedSearch->UnsetSession();
		$this->instagram->AdvancedSearch->UnsetSession();
		$this->account_type->AdvancedSearch->UnsetSession();
		$this->logo->AdvancedSearch->UnsetSession();
		$this->profilepic->AdvancedSearch->UnsetSession();
		$this->mailref->AdvancedSearch->UnsetSession();
		$this->deleted->AdvancedSearch->UnsetSession();
		$this->deletefeedback->AdvancedSearch->UnsetSession();
		$this->account_id->AdvancedSearch->UnsetSession();
		$this->start_date->AdvancedSearch->UnsetSession();
		$this->end_date->AdvancedSearch->UnsetSession();
		$this->year_moth->AdvancedSearch->UnsetSession();
		$this->registerdate->AdvancedSearch->UnsetSession();
		$this->login_type->AdvancedSearch->UnsetSession();
		$this->accountstatus->AdvancedSearch->UnsetSession();
		$this->ispay->AdvancedSearch->UnsetSession();
		$this->profilelink->AdvancedSearch->UnsetSession();
		$this->source->AdvancedSearch->UnsetSession();
		$this->agree->AdvancedSearch->UnsetSession();
		$this->balance->AdvancedSearch->UnsetSession();
		$this->job_title->AdvancedSearch->UnsetSession();
		$this->projects->AdvancedSearch->UnsetSession();
		$this->opportunities->AdvancedSearch->UnsetSession();
		$this->isconsaltant->AdvancedSearch->UnsetSession();
		$this->isagent->AdvancedSearch->UnsetSession();
		$this->isinvestor->AdvancedSearch->UnsetSession();
		$this->isbusinessman->AdvancedSearch->UnsetSession();
		$this->isprovider->AdvancedSearch->UnsetSession();
		$this->isproductowner->AdvancedSearch->UnsetSession();
		$this->states->AdvancedSearch->UnsetSession();
		$this->cities->AdvancedSearch->UnsetSession();
		$this->offers->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->companyname->AdvancedSearch->Load();
		$this->servicetime->AdvancedSearch->Load();
		$this->country->AdvancedSearch->Load();
		$this->phone->AdvancedSearch->Load();
		$this->skype->AdvancedSearch->Load();
		$this->website->AdvancedSearch->Load();
		$this->linkedin->AdvancedSearch->Load();
		$this->facebook->AdvancedSearch->Load();
		$this->twitter->AdvancedSearch->Load();
		$this->active_code->AdvancedSearch->Load();
		$this->identification->AdvancedSearch->Load();
		$this->link_expired->AdvancedSearch->Load();
		$this->isactive->AdvancedSearch->Load();
		$this->pio->AdvancedSearch->Load();
		$this->google->AdvancedSearch->Load();
		$this->instagram->AdvancedSearch->Load();
		$this->account_type->AdvancedSearch->Load();
		$this->logo->AdvancedSearch->Load();
		$this->profilepic->AdvancedSearch->Load();
		$this->mailref->AdvancedSearch->Load();
		$this->deleted->AdvancedSearch->Load();
		$this->deletefeedback->AdvancedSearch->Load();
		$this->account_id->AdvancedSearch->Load();
		$this->start_date->AdvancedSearch->Load();
		$this->end_date->AdvancedSearch->Load();
		$this->year_moth->AdvancedSearch->Load();
		$this->registerdate->AdvancedSearch->Load();
		$this->login_type->AdvancedSearch->Load();
		$this->accountstatus->AdvancedSearch->Load();
		$this->ispay->AdvancedSearch->Load();
		$this->profilelink->AdvancedSearch->Load();
		$this->source->AdvancedSearch->Load();
		$this->agree->AdvancedSearch->Load();
		$this->balance->AdvancedSearch->Load();
		$this->job_title->AdvancedSearch->Load();
		$this->projects->AdvancedSearch->Load();
		$this->opportunities->AdvancedSearch->Load();
		$this->isconsaltant->AdvancedSearch->Load();
		$this->isagent->AdvancedSearch->Load();
		$this->isinvestor->AdvancedSearch->Load();
		$this->isbusinessman->AdvancedSearch->Load();
		$this->isprovider->AdvancedSearch->Load();
		$this->isproductowner->AdvancedSearch->Load();
		$this->states->AdvancedSearch->Load();
		$this->cities->AdvancedSearch->Load();
		$this->offers->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->name); // name
			$this->UpdateSort($this->_email); // email
			$this->UpdateSort($this->companyname); // companyname
			$this->UpdateSort($this->servicetime); // servicetime
			$this->UpdateSort($this->country); // country
			$this->UpdateSort($this->phone); // phone
			$this->UpdateSort($this->skype); // skype
			$this->UpdateSort($this->website); // website
			$this->UpdateSort($this->linkedin); // linkedin
			$this->UpdateSort($this->facebook); // facebook
			$this->UpdateSort($this->twitter); // twitter
			$this->UpdateSort($this->active_code); // active_code
			$this->UpdateSort($this->identification); // identification
			$this->UpdateSort($this->link_expired); // link_expired
			$this->UpdateSort($this->isactive); // isactive
			$this->UpdateSort($this->google); // google
			$this->UpdateSort($this->instagram); // instagram
			$this->UpdateSort($this->account_type); // account_type
			$this->UpdateSort($this->logo); // logo
			$this->UpdateSort($this->profilepic); // profilepic
			$this->UpdateSort($this->mailref); // mailref
			$this->UpdateSort($this->deleted); // deleted
			$this->UpdateSort($this->deletefeedback); // deletefeedback
			$this->UpdateSort($this->account_id); // account_id
			$this->UpdateSort($this->start_date); // start_date
			$this->UpdateSort($this->end_date); // end_date
			$this->UpdateSort($this->year_moth); // year_moth
			$this->UpdateSort($this->registerdate); // registerdate
			$this->UpdateSort($this->login_type); // login_type
			$this->UpdateSort($this->accountstatus); // accountstatus
			$this->UpdateSort($this->ispay); // ispay
			$this->UpdateSort($this->profilelink); // profilelink
			$this->UpdateSort($this->source); // source
			$this->UpdateSort($this->agree); // agree
			$this->UpdateSort($this->balance); // balance
			$this->UpdateSort($this->job_title); // job_title
			$this->UpdateSort($this->projects); // projects
			$this->UpdateSort($this->opportunities); // opportunities
			$this->UpdateSort($this->isconsaltant); // isconsaltant
			$this->UpdateSort($this->isagent); // isagent
			$this->UpdateSort($this->isinvestor); // isinvestor
			$this->UpdateSort($this->isbusinessman); // isbusinessman
			$this->UpdateSort($this->isprovider); // isprovider
			$this->UpdateSort($this->isproductowner); // isproductowner
			$this->UpdateSort($this->states); // states
			$this->UpdateSort($this->cities); // cities
			$this->UpdateSort($this->offers); // offers
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
				$this->name->setSort("");
				$this->_email->setSort("");
				$this->companyname->setSort("");
				$this->servicetime->setSort("");
				$this->country->setSort("");
				$this->phone->setSort("");
				$this->skype->setSort("");
				$this->website->setSort("");
				$this->linkedin->setSort("");
				$this->facebook->setSort("");
				$this->twitter->setSort("");
				$this->active_code->setSort("");
				$this->identification->setSort("");
				$this->link_expired->setSort("");
				$this->isactive->setSort("");
				$this->google->setSort("");
				$this->instagram->setSort("");
				$this->account_type->setSort("");
				$this->logo->setSort("");
				$this->profilepic->setSort("");
				$this->mailref->setSort("");
				$this->deleted->setSort("");
				$this->deletefeedback->setSort("");
				$this->account_id->setSort("");
				$this->start_date->setSort("");
				$this->end_date->setSort("");
				$this->year_moth->setSort("");
				$this->registerdate->setSort("");
				$this->login_type->setSort("");
				$this->accountstatus->setSort("");
				$this->ispay->setSort("");
				$this->profilelink->setSort("");
				$this->source->setSort("");
				$this->agree->setSort("");
				$this->balance->setSort("");
				$this->job_title->setSort("");
				$this->projects->setSort("");
				$this->opportunities->setSort("");
				$this->isconsaltant->setSort("");
				$this->isagent->setSort("");
				$this->isinvestor->setSort("");
				$this->isbusinessman->setSort("");
				$this->isprovider->setSort("");
				$this->isproductowner->setSort("");
				$this->states->setSort("");
				$this->cities->setSort("");
				$this->offers->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fuserslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fuserslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fuserslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_id"]);
		if ($this->id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// name
		$this->name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_name"]);
		if ($this->name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->name->AdvancedSearch->SearchOperator = @$_GET["z_name"];

		// email
		$this->_email->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x__email"]);
		if ($this->_email->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->_email->AdvancedSearch->SearchOperator = @$_GET["z__email"];

		// companyname
		$this->companyname->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_companyname"]);
		if ($this->companyname->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->companyname->AdvancedSearch->SearchOperator = @$_GET["z_companyname"];

		// servicetime
		$this->servicetime->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_servicetime"]);
		if ($this->servicetime->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->servicetime->AdvancedSearch->SearchOperator = @$_GET["z_servicetime"];

		// country
		$this->country->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_country"]);
		if ($this->country->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->country->AdvancedSearch->SearchOperator = @$_GET["z_country"];

		// phone
		$this->phone->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_phone"]);
		if ($this->phone->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->phone->AdvancedSearch->SearchOperator = @$_GET["z_phone"];

		// skype
		$this->skype->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_skype"]);
		if ($this->skype->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->skype->AdvancedSearch->SearchOperator = @$_GET["z_skype"];

		// website
		$this->website->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_website"]);
		if ($this->website->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->website->AdvancedSearch->SearchOperator = @$_GET["z_website"];

		// linkedin
		$this->linkedin->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_linkedin"]);
		if ($this->linkedin->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->linkedin->AdvancedSearch->SearchOperator = @$_GET["z_linkedin"];

		// facebook
		$this->facebook->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_facebook"]);
		if ($this->facebook->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->facebook->AdvancedSearch->SearchOperator = @$_GET["z_facebook"];

		// twitter
		$this->twitter->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_twitter"]);
		if ($this->twitter->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->twitter->AdvancedSearch->SearchOperator = @$_GET["z_twitter"];

		// active_code
		$this->active_code->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_active_code"]);
		if ($this->active_code->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->active_code->AdvancedSearch->SearchOperator = @$_GET["z_active_code"];

		// identification
		$this->identification->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_identification"]);
		if ($this->identification->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->identification->AdvancedSearch->SearchOperator = @$_GET["z_identification"];

		// link_expired
		$this->link_expired->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_link_expired"]);
		if ($this->link_expired->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->link_expired->AdvancedSearch->SearchOperator = @$_GET["z_link_expired"];

		// isactive
		$this->isactive->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isactive"]);
		if ($this->isactive->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isactive->AdvancedSearch->SearchOperator = @$_GET["z_isactive"];

		// pio
		$this->pio->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_pio"]);
		if ($this->pio->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->pio->AdvancedSearch->SearchOperator = @$_GET["z_pio"];

		// google
		$this->google->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_google"]);
		if ($this->google->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->google->AdvancedSearch->SearchOperator = @$_GET["z_google"];

		// instagram
		$this->instagram->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_instagram"]);
		if ($this->instagram->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->instagram->AdvancedSearch->SearchOperator = @$_GET["z_instagram"];

		// account_type
		$this->account_type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_account_type"]);
		if ($this->account_type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->account_type->AdvancedSearch->SearchOperator = @$_GET["z_account_type"];

		// logo
		$this->logo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_logo"]);
		if ($this->logo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->logo->AdvancedSearch->SearchOperator = @$_GET["z_logo"];

		// profilepic
		$this->profilepic->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_profilepic"]);
		if ($this->profilepic->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->profilepic->AdvancedSearch->SearchOperator = @$_GET["z_profilepic"];

		// mailref
		$this->mailref->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_mailref"]);
		if ($this->mailref->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->mailref->AdvancedSearch->SearchOperator = @$_GET["z_mailref"];

		// deleted
		$this->deleted->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_deleted"]);
		if ($this->deleted->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->deleted->AdvancedSearch->SearchOperator = @$_GET["z_deleted"];

		// deletefeedback
		$this->deletefeedback->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_deletefeedback"]);
		if ($this->deletefeedback->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->deletefeedback->AdvancedSearch->SearchOperator = @$_GET["z_deletefeedback"];

		// account_id
		$this->account_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_account_id"]);
		if ($this->account_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->account_id->AdvancedSearch->SearchOperator = @$_GET["z_account_id"];

		// start_date
		$this->start_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_start_date"]);
		if ($this->start_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->start_date->AdvancedSearch->SearchOperator = @$_GET["z_start_date"];

		// end_date
		$this->end_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_end_date"]);
		if ($this->end_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->end_date->AdvancedSearch->SearchOperator = @$_GET["z_end_date"];

		// year_moth
		$this->year_moth->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_year_moth"]);
		if ($this->year_moth->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->year_moth->AdvancedSearch->SearchOperator = @$_GET["z_year_moth"];

		// registerdate
		$this->registerdate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_registerdate"]);
		if ($this->registerdate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->registerdate->AdvancedSearch->SearchOperator = @$_GET["z_registerdate"];
		$this->registerdate->AdvancedSearch->SearchCondition = @$_GET["v_registerdate"];
		$this->registerdate->AdvancedSearch->SearchValue2 = ew_StripSlashes(@$_GET["y_registerdate"]);
		if ($this->registerdate->AdvancedSearch->SearchValue2 <> "") $this->Command = "search";
		$this->registerdate->AdvancedSearch->SearchOperator2 = @$_GET["w_registerdate"];

		// login_type
		$this->login_type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_login_type"]);
		if ($this->login_type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->login_type->AdvancedSearch->SearchOperator = @$_GET["z_login_type"];

		// accountstatus
		$this->accountstatus->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_accountstatus"]);
		if ($this->accountstatus->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->accountstatus->AdvancedSearch->SearchOperator = @$_GET["z_accountstatus"];

		// ispay
		$this->ispay->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ispay"]);
		if ($this->ispay->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->ispay->AdvancedSearch->SearchOperator = @$_GET["z_ispay"];

		// profilelink
		$this->profilelink->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_profilelink"]);
		if ($this->profilelink->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->profilelink->AdvancedSearch->SearchOperator = @$_GET["z_profilelink"];

		// source
		$this->source->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_source"]);
		if ($this->source->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->source->AdvancedSearch->SearchOperator = @$_GET["z_source"];

		// agree
		$this->agree->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_agree"]);
		if ($this->agree->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->agree->AdvancedSearch->SearchOperator = @$_GET["z_agree"];

		// balance
		$this->balance->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_balance"]);
		if ($this->balance->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->balance->AdvancedSearch->SearchOperator = @$_GET["z_balance"];

		// job_title
		$this->job_title->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_job_title"]);
		if ($this->job_title->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->job_title->AdvancedSearch->SearchOperator = @$_GET["z_job_title"];

		// projects
		$this->projects->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_projects"]);
		if ($this->projects->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->projects->AdvancedSearch->SearchOperator = @$_GET["z_projects"];

		// opportunities
		$this->opportunities->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_opportunities"]);
		if ($this->opportunities->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->opportunities->AdvancedSearch->SearchOperator = @$_GET["z_opportunities"];

		// isconsaltant
		$this->isconsaltant->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isconsaltant"]);
		if ($this->isconsaltant->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isconsaltant->AdvancedSearch->SearchOperator = @$_GET["z_isconsaltant"];
		if (is_array($this->isconsaltant->AdvancedSearch->SearchValue)) $this->isconsaltant->AdvancedSearch->SearchValue = implode(",", $this->isconsaltant->AdvancedSearch->SearchValue);
		if (is_array($this->isconsaltant->AdvancedSearch->SearchValue2)) $this->isconsaltant->AdvancedSearch->SearchValue2 = implode(",", $this->isconsaltant->AdvancedSearch->SearchValue2);

		// isagent
		$this->isagent->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isagent"]);
		if ($this->isagent->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isagent->AdvancedSearch->SearchOperator = @$_GET["z_isagent"];
		if (is_array($this->isagent->AdvancedSearch->SearchValue)) $this->isagent->AdvancedSearch->SearchValue = implode(",", $this->isagent->AdvancedSearch->SearchValue);
		if (is_array($this->isagent->AdvancedSearch->SearchValue2)) $this->isagent->AdvancedSearch->SearchValue2 = implode(",", $this->isagent->AdvancedSearch->SearchValue2);

		// isinvestor
		$this->isinvestor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isinvestor"]);
		if ($this->isinvestor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isinvestor->AdvancedSearch->SearchOperator = @$_GET["z_isinvestor"];
		if (is_array($this->isinvestor->AdvancedSearch->SearchValue)) $this->isinvestor->AdvancedSearch->SearchValue = implode(",", $this->isinvestor->AdvancedSearch->SearchValue);
		if (is_array($this->isinvestor->AdvancedSearch->SearchValue2)) $this->isinvestor->AdvancedSearch->SearchValue2 = implode(",", $this->isinvestor->AdvancedSearch->SearchValue2);

		// isbusinessman
		$this->isbusinessman->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isbusinessman"]);
		if ($this->isbusinessman->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isbusinessman->AdvancedSearch->SearchOperator = @$_GET["z_isbusinessman"];
		if (is_array($this->isbusinessman->AdvancedSearch->SearchValue)) $this->isbusinessman->AdvancedSearch->SearchValue = implode(",", $this->isbusinessman->AdvancedSearch->SearchValue);
		if (is_array($this->isbusinessman->AdvancedSearch->SearchValue2)) $this->isbusinessman->AdvancedSearch->SearchValue2 = implode(",", $this->isbusinessman->AdvancedSearch->SearchValue2);

		// isprovider
		$this->isprovider->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isprovider"]);
		if ($this->isprovider->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isprovider->AdvancedSearch->SearchOperator = @$_GET["z_isprovider"];
		if (is_array($this->isprovider->AdvancedSearch->SearchValue)) $this->isprovider->AdvancedSearch->SearchValue = implode(",", $this->isprovider->AdvancedSearch->SearchValue);
		if (is_array($this->isprovider->AdvancedSearch->SearchValue2)) $this->isprovider->AdvancedSearch->SearchValue2 = implode(",", $this->isprovider->AdvancedSearch->SearchValue2);

		// isproductowner
		$this->isproductowner->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_isproductowner"]);
		if ($this->isproductowner->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->isproductowner->AdvancedSearch->SearchOperator = @$_GET["z_isproductowner"];
		if (is_array($this->isproductowner->AdvancedSearch->SearchValue)) $this->isproductowner->AdvancedSearch->SearchValue = implode(",", $this->isproductowner->AdvancedSearch->SearchValue);
		if (is_array($this->isproductowner->AdvancedSearch->SearchValue2)) $this->isproductowner->AdvancedSearch->SearchValue2 = implode(",", $this->isproductowner->AdvancedSearch->SearchValue2);

		// states
		$this->states->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_states"]);
		if ($this->states->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->states->AdvancedSearch->SearchOperator = @$_GET["z_states"];

		// cities
		$this->cities->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cities"]);
		if ($this->cities->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->cities->AdvancedSearch->SearchOperator = @$_GET["z_cities"];

		// offers
		$this->offers->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_offers"]);
		if ($this->offers->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->offers->AdvancedSearch->SearchOperator = @$_GET["z_offers"];
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->AdvancedSearch->SearchValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->AdvancedSearch->SearchValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->AdvancedSearch->SearchValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// companyname
			$this->companyname->EditAttrs["class"] = "form-control";
			$this->companyname->EditCustomAttributes = "";
			$this->companyname->EditValue = ew_HtmlEncode($this->companyname->AdvancedSearch->SearchValue);
			$this->companyname->PlaceHolder = ew_RemoveHtml($this->companyname->FldCaption());

			// servicetime
			$this->servicetime->EditAttrs["class"] = "form-control";
			$this->servicetime->EditCustomAttributes = "";
			$this->servicetime->EditValue = ew_HtmlEncode($this->servicetime->AdvancedSearch->SearchValue);
			$this->servicetime->PlaceHolder = ew_RemoveHtml($this->servicetime->FldCaption());

			// country
			$this->country->EditAttrs["class"] = "form-control";
			$this->country->EditCustomAttributes = "";
			$this->country->EditValue = ew_HtmlEncode($this->country->AdvancedSearch->SearchValue);
			$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->AdvancedSearch->SearchValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// skype
			$this->skype->EditAttrs["class"] = "form-control";
			$this->skype->EditCustomAttributes = "";
			$this->skype->EditValue = ew_HtmlEncode($this->skype->AdvancedSearch->SearchValue);
			$this->skype->PlaceHolder = ew_RemoveHtml($this->skype->FldCaption());

			// website
			$this->website->EditAttrs["class"] = "form-control";
			$this->website->EditCustomAttributes = "";
			$this->website->EditValue = ew_HtmlEncode($this->website->AdvancedSearch->SearchValue);
			$this->website->PlaceHolder = ew_RemoveHtml($this->website->FldCaption());

			// linkedin
			$this->linkedin->EditAttrs["class"] = "form-control";
			$this->linkedin->EditCustomAttributes = "";
			$this->linkedin->EditValue = ew_HtmlEncode($this->linkedin->AdvancedSearch->SearchValue);
			$this->linkedin->PlaceHolder = ew_RemoveHtml($this->linkedin->FldCaption());

			// facebook
			$this->facebook->EditAttrs["class"] = "form-control";
			$this->facebook->EditCustomAttributes = "";
			$this->facebook->EditValue = ew_HtmlEncode($this->facebook->AdvancedSearch->SearchValue);
			$this->facebook->PlaceHolder = ew_RemoveHtml($this->facebook->FldCaption());

			// twitter
			$this->twitter->EditAttrs["class"] = "form-control";
			$this->twitter->EditCustomAttributes = "";
			$this->twitter->EditValue = ew_HtmlEncode($this->twitter->AdvancedSearch->SearchValue);
			$this->twitter->PlaceHolder = ew_RemoveHtml($this->twitter->FldCaption());

			// active_code
			$this->active_code->EditAttrs["class"] = "form-control";
			$this->active_code->EditCustomAttributes = "";
			$this->active_code->EditValue = ew_HtmlEncode($this->active_code->AdvancedSearch->SearchValue);
			$this->active_code->PlaceHolder = ew_RemoveHtml($this->active_code->FldCaption());

			// identification
			$this->identification->EditAttrs["class"] = "form-control";
			$this->identification->EditCustomAttributes = "";
			$this->identification->EditValue = ew_HtmlEncode($this->identification->AdvancedSearch->SearchValue);
			$this->identification->PlaceHolder = ew_RemoveHtml($this->identification->FldCaption());

			// link_expired
			$this->link_expired->EditAttrs["class"] = "form-control";
			$this->link_expired->EditCustomAttributes = "";
			$this->link_expired->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->link_expired->AdvancedSearch->SearchValue, 5), 5));
			$this->link_expired->PlaceHolder = ew_RemoveHtml($this->link_expired->FldCaption());

			// isactive
			$this->isactive->EditAttrs["class"] = "form-control";
			$this->isactive->EditCustomAttributes = "";
			$this->isactive->EditValue = ew_HtmlEncode($this->isactive->AdvancedSearch->SearchValue);
			$this->isactive->PlaceHolder = ew_RemoveHtml($this->isactive->FldCaption());

			// google
			$this->google->EditAttrs["class"] = "form-control";
			$this->google->EditCustomAttributes = "";
			$this->google->EditValue = ew_HtmlEncode($this->google->AdvancedSearch->SearchValue);
			$this->google->PlaceHolder = ew_RemoveHtml($this->google->FldCaption());

			// instagram
			$this->instagram->EditAttrs["class"] = "form-control";
			$this->instagram->EditCustomAttributes = "";
			$this->instagram->EditValue = ew_HtmlEncode($this->instagram->AdvancedSearch->SearchValue);
			$this->instagram->PlaceHolder = ew_RemoveHtml($this->instagram->FldCaption());

			// account_type
			$this->account_type->EditAttrs["class"] = "form-control";
			$this->account_type->EditCustomAttributes = "";
			$this->account_type->EditValue = ew_HtmlEncode($this->account_type->AdvancedSearch->SearchValue);
			$this->account_type->PlaceHolder = ew_RemoveHtml($this->account_type->FldCaption());

			// logo
			$this->logo->EditAttrs["class"] = "form-control";
			$this->logo->EditCustomAttributes = "";
			$this->logo->EditValue = ew_HtmlEncode($this->logo->AdvancedSearch->SearchValue);
			$this->logo->PlaceHolder = ew_RemoveHtml($this->logo->FldCaption());

			// profilepic
			$this->profilepic->EditAttrs["class"] = "form-control";
			$this->profilepic->EditCustomAttributes = "";
			$this->profilepic->EditValue = ew_HtmlEncode($this->profilepic->AdvancedSearch->SearchValue);
			$this->profilepic->PlaceHolder = ew_RemoveHtml($this->profilepic->FldCaption());

			// mailref
			$this->mailref->EditAttrs["class"] = "form-control";
			$this->mailref->EditCustomAttributes = "";
			$this->mailref->EditValue = ew_HtmlEncode($this->mailref->AdvancedSearch->SearchValue);
			$this->mailref->PlaceHolder = ew_RemoveHtml($this->mailref->FldCaption());

			// deleted
			$this->deleted->EditAttrs["class"] = "form-control";
			$this->deleted->EditCustomAttributes = "";
			$this->deleted->EditValue = ew_HtmlEncode($this->deleted->AdvancedSearch->SearchValue);
			$this->deleted->PlaceHolder = ew_RemoveHtml($this->deleted->FldCaption());

			// deletefeedback
			$this->deletefeedback->EditAttrs["class"] = "form-control";
			$this->deletefeedback->EditCustomAttributes = "";
			$this->deletefeedback->EditValue = ew_HtmlEncode($this->deletefeedback->AdvancedSearch->SearchValue);
			$this->deletefeedback->PlaceHolder = ew_RemoveHtml($this->deletefeedback->FldCaption());

			// account_id
			$this->account_id->EditAttrs["class"] = "form-control";
			$this->account_id->EditCustomAttributes = "";
			$this->account_id->EditValue = ew_HtmlEncode($this->account_id->AdvancedSearch->SearchValue);
			$this->account_id->PlaceHolder = ew_RemoveHtml($this->account_id->FldCaption());

			// start_date
			$this->start_date->EditAttrs["class"] = "form-control";
			$this->start_date->EditCustomAttributes = "";
			$this->start_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->start_date->AdvancedSearch->SearchValue, 5), 5));
			$this->start_date->PlaceHolder = ew_RemoveHtml($this->start_date->FldCaption());

			// end_date
			$this->end_date->EditAttrs["class"] = "form-control";
			$this->end_date->EditCustomAttributes = "";
			$this->end_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->end_date->AdvancedSearch->SearchValue, 5), 5));
			$this->end_date->PlaceHolder = ew_RemoveHtml($this->end_date->FldCaption());

			// year_moth
			$this->year_moth->EditAttrs["class"] = "form-control";
			$this->year_moth->EditCustomAttributes = "";
			$this->year_moth->EditValue = ew_HtmlEncode($this->year_moth->AdvancedSearch->SearchValue);
			$this->year_moth->PlaceHolder = ew_RemoveHtml($this->year_moth->FldCaption());

			// registerdate
			$this->registerdate->EditAttrs["class"] = "form-control";
			$this->registerdate->EditCustomAttributes = "";
			$this->registerdate->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->registerdate->AdvancedSearch->SearchValue, 5), 5));
			$this->registerdate->PlaceHolder = ew_RemoveHtml($this->registerdate->FldCaption());
			$this->registerdate->EditAttrs["class"] = "form-control";
			$this->registerdate->EditCustomAttributes = "";
			$this->registerdate->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->registerdate->AdvancedSearch->SearchValue2, 5), 5));
			$this->registerdate->PlaceHolder = ew_RemoveHtml($this->registerdate->FldCaption());

			// login_type
			$this->login_type->EditAttrs["class"] = "form-control";
			$this->login_type->EditCustomAttributes = "";
			$this->login_type->EditValue = ew_HtmlEncode($this->login_type->AdvancedSearch->SearchValue);
			$this->login_type->PlaceHolder = ew_RemoveHtml($this->login_type->FldCaption());

			// accountstatus
			$this->accountstatus->EditAttrs["class"] = "form-control";
			$this->accountstatus->EditCustomAttributes = "";
			$this->accountstatus->EditValue = ew_HtmlEncode($this->accountstatus->AdvancedSearch->SearchValue);
			$this->accountstatus->PlaceHolder = ew_RemoveHtml($this->accountstatus->FldCaption());

			// ispay
			$this->ispay->EditAttrs["class"] = "form-control";
			$this->ispay->EditCustomAttributes = "";
			$this->ispay->EditValue = ew_HtmlEncode($this->ispay->AdvancedSearch->SearchValue);
			$this->ispay->PlaceHolder = ew_RemoveHtml($this->ispay->FldCaption());

			// profilelink
			$this->profilelink->EditAttrs["class"] = "form-control";
			$this->profilelink->EditCustomAttributes = "";
			$this->profilelink->EditValue = ew_HtmlEncode($this->profilelink->AdvancedSearch->SearchValue);
			$this->profilelink->PlaceHolder = ew_RemoveHtml($this->profilelink->FldCaption());

			// source
			$this->source->EditAttrs["class"] = "form-control";
			$this->source->EditCustomAttributes = "";
			$this->source->EditValue = ew_HtmlEncode($this->source->AdvancedSearch->SearchValue);
			$this->source->PlaceHolder = ew_RemoveHtml($this->source->FldCaption());

			// agree
			$this->agree->EditAttrs["class"] = "form-control";
			$this->agree->EditCustomAttributes = "";
			$this->agree->EditValue = ew_HtmlEncode($this->agree->AdvancedSearch->SearchValue);
			$this->agree->PlaceHolder = ew_RemoveHtml($this->agree->FldCaption());

			// balance
			$this->balance->EditAttrs["class"] = "form-control";
			$this->balance->EditCustomAttributes = "";
			$this->balance->EditValue = ew_HtmlEncode($this->balance->AdvancedSearch->SearchValue);
			$this->balance->PlaceHolder = ew_RemoveHtml($this->balance->FldCaption());

			// job_title
			$this->job_title->EditAttrs["class"] = "form-control";
			$this->job_title->EditCustomAttributes = "";
			$this->job_title->EditValue = ew_HtmlEncode($this->job_title->AdvancedSearch->SearchValue);
			$this->job_title->PlaceHolder = ew_RemoveHtml($this->job_title->FldCaption());

			// projects
			$this->projects->EditAttrs["class"] = "form-control";
			$this->projects->EditCustomAttributes = "";
			$this->projects->EditValue = ew_HtmlEncode($this->projects->AdvancedSearch->SearchValue);
			$this->projects->PlaceHolder = ew_RemoveHtml($this->projects->FldCaption());

			// opportunities
			$this->opportunities->EditAttrs["class"] = "form-control";
			$this->opportunities->EditCustomAttributes = "";
			$this->opportunities->EditValue = ew_HtmlEncode($this->opportunities->AdvancedSearch->SearchValue);
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
			$this->states->EditValue = ew_HtmlEncode($this->states->AdvancedSearch->SearchValue);
			$this->states->PlaceHolder = ew_RemoveHtml($this->states->FldCaption());

			// cities
			$this->cities->EditAttrs["class"] = "form-control";
			$this->cities->EditCustomAttributes = "";
			$this->cities->EditValue = ew_HtmlEncode($this->cities->AdvancedSearch->SearchValue);
			$this->cities->PlaceHolder = ew_RemoveHtml($this->cities->FldCaption());

			// offers
			$this->offers->EditAttrs["class"] = "form-control";
			$this->offers->EditCustomAttributes = "";
			$this->offers->EditValue = ew_HtmlEncode($this->offers->AdvancedSearch->SearchValue);
			$this->offers->PlaceHolder = ew_RemoveHtml($this->offers->FldCaption());
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckDate($this->registerdate->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->registerdate->FldErrMsg());
		}
		if (!ew_CheckDate($this->registerdate->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->registerdate->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->name->AdvancedSearch->Load();
		$this->_email->AdvancedSearch->Load();
		$this->companyname->AdvancedSearch->Load();
		$this->servicetime->AdvancedSearch->Load();
		$this->country->AdvancedSearch->Load();
		$this->phone->AdvancedSearch->Load();
		$this->skype->AdvancedSearch->Load();
		$this->website->AdvancedSearch->Load();
		$this->linkedin->AdvancedSearch->Load();
		$this->facebook->AdvancedSearch->Load();
		$this->twitter->AdvancedSearch->Load();
		$this->active_code->AdvancedSearch->Load();
		$this->identification->AdvancedSearch->Load();
		$this->link_expired->AdvancedSearch->Load();
		$this->isactive->AdvancedSearch->Load();
		$this->pio->AdvancedSearch->Load();
		$this->google->AdvancedSearch->Load();
		$this->instagram->AdvancedSearch->Load();
		$this->account_type->AdvancedSearch->Load();
		$this->logo->AdvancedSearch->Load();
		$this->profilepic->AdvancedSearch->Load();
		$this->mailref->AdvancedSearch->Load();
		$this->deleted->AdvancedSearch->Load();
		$this->deletefeedback->AdvancedSearch->Load();
		$this->account_id->AdvancedSearch->Load();
		$this->start_date->AdvancedSearch->Load();
		$this->end_date->AdvancedSearch->Load();
		$this->year_moth->AdvancedSearch->Load();
		$this->registerdate->AdvancedSearch->Load();
		$this->login_type->AdvancedSearch->Load();
		$this->accountstatus->AdvancedSearch->Load();
		$this->ispay->AdvancedSearch->Load();
		$this->profilelink->AdvancedSearch->Load();
		$this->source->AdvancedSearch->Load();
		$this->agree->AdvancedSearch->Load();
		$this->balance->AdvancedSearch->Load();
		$this->job_title->AdvancedSearch->Load();
		$this->projects->AdvancedSearch->Load();
		$this->opportunities->AdvancedSearch->Load();
		$this->isconsaltant->AdvancedSearch->Load();
		$this->isagent->AdvancedSearch->Load();
		$this->isinvestor->AdvancedSearch->Load();
		$this->isbusinessman->AdvancedSearch->Load();
		$this->isprovider->AdvancedSearch->Load();
		$this->isproductowner->AdvancedSearch->Load();
		$this->states->AdvancedSearch->Load();
		$this->cities->AdvancedSearch->Load();
		$this->offers->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_users\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_users',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fuserslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
if (!isset($users_list)) $users_list = new cusers_list();

// Page init
$users_list->Page_Init();

// Page main
$users_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fuserslist = new ew_Form("fuserslist", "list");
fuserslist.FormKeyCountName = '<?php echo $users_list->FormKeyCountName ?>';

// Form_CustomValidate event
fuserslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuserslist.ValidateRequired = true;
<?php } else { ?>
fuserslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fuserslistsrch = new ew_Form("fuserslistsrch");

// Validate function for search
fuserslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_registerdate");
	if (elm && !ew_CheckDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($users->registerdate->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fuserslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuserslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fuserslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
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
<?php if ($users_list->TotalRecs > 0 && $users_list->ExportOptions->Visible()) { ?>
<?php $users_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->SearchOptions->Visible()) { ?>
<?php $users_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($users_list->FilterOptions->Visible()) { ?>
<?php $users_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($users->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $users_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($users_list->TotalRecs <= 0)
			$users_list->TotalRecs = $users->SelectRecordCount();
	} else {
		if (!$users_list->Recordset && ($users_list->Recordset = $users_list->LoadRecordset()))
			$users_list->TotalRecs = $users_list->Recordset->RecordCount();
	}
	$users_list->StartRec = 1;
	if ($users_list->DisplayRecs <= 0 || ($users->Export <> "" && $users->ExportAll)) // Display all records
		$users_list->DisplayRecs = $users_list->TotalRecs;
	if (!($users->Export <> "" && $users->ExportAll))
		$users_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$users_list->Recordset = $users_list->LoadRecordset($users_list->StartRec-1, $users_list->DisplayRecs);

	// Set no record found message
	if ($users->CurrentAction == "" && $users_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$users_list->setWarningMessage($Language->Phrase("NoPermission"));
		if ($users_list->SearchWhere == "0=101")
			$users_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$users_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$users_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($users->Export == "" && $users->CurrentAction == "") { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($users_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fuserslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$users_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$users->RowType = EW_ROWTYPE_SEARCH;

// Render row
$users->ResetAttrs();
$users_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($users->name->Visible) { // name ?>
	<div id="xsc_name" class="ewCell form-group">
		<label for="x_name" class="ewSearchCaption ewLabel"><?php echo $users->name->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_name" id="z_name" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($users->_email->Visible) { // email ?>
	<div id="xsc__email" class="ewCell form-group">
		<label for="x__email" class="ewSearchCaption ewLabel"><?php echo $users->_email->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z__email" id="z__email" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($users->country->Visible) { // country ?>
	<div id="xsc_country" class="ewCell form-group">
		<label for="x_country" class="ewSearchCaption ewLabel"><?php echo $users->country->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_country" id="z_country" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" data-table="users" data-field="x_country" name="x_country" id="x_country" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($users->country->getPlaceHolder()) ?>" value="<?php echo $users->country->EditValue ?>"<?php echo $users->country->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
<?php if ($users->phone->Visible) { // phone ?>
	<div id="xsc_phone" class="ewCell form-group">
		<label for="x_phone" class="ewSearchCaption ewLabel"><?php echo $users->phone->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_phone" id="z_phone" value="LIKE"></span>
		<span class="ewSearchField">
<input type="text" data-table="users" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->phone->getPlaceHolder()) ?>" value="<?php echo $users->phone->EditValue ?>"<?php echo $users->phone->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_5" class="ewRow">
<?php if ($users->registerdate->Visible) { // registerdate ?>
	<div id="xsc_registerdate" class="ewCell form-group">
		<label for="x_registerdate" class="ewSearchCaption ewLabel"><?php echo $users->registerdate->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("BETWEEN") ?><input type="hidden" name="z_registerdate" id="z_registerdate" value="BETWEEN"></span>
		<span class="ewSearchField">
<input type="text" data-table="users" data-field="x_registerdate" data-format="5" name="x_registerdate" id="x_registerdate" placeholder="<?php echo ew_HtmlEncode($users->registerdate->getPlaceHolder()) ?>" value="<?php echo $users->registerdate->EditValue ?>"<?php echo $users->registerdate->EditAttributes() ?>>
<?php if (!$users->registerdate->ReadOnly && !$users->registerdate->Disabled && !isset($users->registerdate->EditAttrs["readonly"]) && !isset($users->registerdate->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fuserslistsrch", "x_registerdate", "%Y/%m/%d");
</script>
<?php } ?>
</span>
		<span class="ewSearchCond btw1_registerdate">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
		<span class="ewSearchField btw1_registerdate">
<input type="text" data-table="users" data-field="x_registerdate" data-format="5" name="y_registerdate" id="y_registerdate" placeholder="<?php echo ew_HtmlEncode($users->registerdate->getPlaceHolder()) ?>" value="<?php echo $users->registerdate->EditValue2 ?>"<?php echo $users->registerdate->EditAttributes() ?>>
<?php if (!$users->registerdate->ReadOnly && !$users->registerdate->Disabled && !isset($users->registerdate->EditAttrs["readonly"]) && !isset($users->registerdate->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fuserslistsrch", "y_registerdate", "%Y/%m/%d");
</script>
<?php } ?>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_6" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($users_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $users_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($users_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($users_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $users_list->ShowPageHeader(); ?>
<?php
$users_list->ShowMessage();
?>
<?php if ($users_list->TotalRecs > 0 || $users->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<?php if ($users->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($users->CurrentAction <> "gridadd" && $users->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new cPrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs) ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserslist" id="fuserslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($users_list->TotalRecs > 0) { ?>
<table id="tbl_userslist" class="table ewTable">
<?php echo $users->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$users_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$users_list->RenderListOptions();

// Render list options (header, left)
$users_list->ListOptions->Render("header", "left");
?>
<?php if ($users->id->Visible) { // id ?>
	<?php if ($users->SortUrl($users->id) == "") { ?>
		<th data-name="id"><div id="elh_users_id" class="users_id"><div class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->id) ?>',1);"><div id="elh_users_id" class="users_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->name->Visible) { // name ?>
	<?php if ($users->SortUrl($users->name) == "") { ?>
		<th data-name="name"><div id="elh_users_name" class="users_name"><div class="ewTableHeaderCaption"><?php echo $users->name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->name) ?>',1);"><div id="elh_users_name" class="users_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->_email->Visible) { // email ?>
	<?php if ($users->SortUrl($users->_email) == "") { ?>
		<th data-name="_email"><div id="elh_users__email" class="users__email"><div class="ewTableHeaderCaption"><?php echo $users->_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->_email) ?>',1);"><div id="elh_users__email" class="users__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->companyname->Visible) { // companyname ?>
	<?php if ($users->SortUrl($users->companyname) == "") { ?>
		<th data-name="companyname"><div id="elh_users_companyname" class="users_companyname"><div class="ewTableHeaderCaption"><?php echo $users->companyname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="companyname"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->companyname) ?>',1);"><div id="elh_users_companyname" class="users_companyname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->companyname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->companyname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->companyname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->servicetime->Visible) { // servicetime ?>
	<?php if ($users->SortUrl($users->servicetime) == "") { ?>
		<th data-name="servicetime"><div id="elh_users_servicetime" class="users_servicetime"><div class="ewTableHeaderCaption"><?php echo $users->servicetime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="servicetime"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->servicetime) ?>',1);"><div id="elh_users_servicetime" class="users_servicetime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->servicetime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->servicetime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->servicetime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->country->Visible) { // country ?>
	<?php if ($users->SortUrl($users->country) == "") { ?>
		<th data-name="country"><div id="elh_users_country" class="users_country"><div class="ewTableHeaderCaption"><?php echo $users->country->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="country"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->country) ?>',1);"><div id="elh_users_country" class="users_country">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->country->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->country->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->country->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->phone->Visible) { // phone ?>
	<?php if ($users->SortUrl($users->phone) == "") { ?>
		<th data-name="phone"><div id="elh_users_phone" class="users_phone"><div class="ewTableHeaderCaption"><?php echo $users->phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="phone"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->phone) ?>',1);"><div id="elh_users_phone" class="users_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->skype->Visible) { // skype ?>
	<?php if ($users->SortUrl($users->skype) == "") { ?>
		<th data-name="skype"><div id="elh_users_skype" class="users_skype"><div class="ewTableHeaderCaption"><?php echo $users->skype->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="skype"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->skype) ?>',1);"><div id="elh_users_skype" class="users_skype">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->skype->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->skype->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->skype->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->website->Visible) { // website ?>
	<?php if ($users->SortUrl($users->website) == "") { ?>
		<th data-name="website"><div id="elh_users_website" class="users_website"><div class="ewTableHeaderCaption"><?php echo $users->website->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="website"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->website) ?>',1);"><div id="elh_users_website" class="users_website">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->website->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->website->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->website->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->linkedin->Visible) { // linkedin ?>
	<?php if ($users->SortUrl($users->linkedin) == "") { ?>
		<th data-name="linkedin"><div id="elh_users_linkedin" class="users_linkedin"><div class="ewTableHeaderCaption"><?php echo $users->linkedin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="linkedin"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->linkedin) ?>',1);"><div id="elh_users_linkedin" class="users_linkedin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->linkedin->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->linkedin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->linkedin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->facebook->Visible) { // facebook ?>
	<?php if ($users->SortUrl($users->facebook) == "") { ?>
		<th data-name="facebook"><div id="elh_users_facebook" class="users_facebook"><div class="ewTableHeaderCaption"><?php echo $users->facebook->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="facebook"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->facebook) ?>',1);"><div id="elh_users_facebook" class="users_facebook">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->facebook->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->facebook->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->facebook->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->twitter->Visible) { // twitter ?>
	<?php if ($users->SortUrl($users->twitter) == "") { ?>
		<th data-name="twitter"><div id="elh_users_twitter" class="users_twitter"><div class="ewTableHeaderCaption"><?php echo $users->twitter->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="twitter"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->twitter) ?>',1);"><div id="elh_users_twitter" class="users_twitter">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->twitter->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->twitter->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->twitter->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->active_code->Visible) { // active_code ?>
	<?php if ($users->SortUrl($users->active_code) == "") { ?>
		<th data-name="active_code"><div id="elh_users_active_code" class="users_active_code"><div class="ewTableHeaderCaption"><?php echo $users->active_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="active_code"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->active_code) ?>',1);"><div id="elh_users_active_code" class="users_active_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->active_code->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->active_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->active_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->identification->Visible) { // identification ?>
	<?php if ($users->SortUrl($users->identification) == "") { ?>
		<th data-name="identification"><div id="elh_users_identification" class="users_identification"><div class="ewTableHeaderCaption"><?php echo $users->identification->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="identification"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->identification) ?>',1);"><div id="elh_users_identification" class="users_identification">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->identification->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->identification->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->identification->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->link_expired->Visible) { // link_expired ?>
	<?php if ($users->SortUrl($users->link_expired) == "") { ?>
		<th data-name="link_expired"><div id="elh_users_link_expired" class="users_link_expired"><div class="ewTableHeaderCaption"><?php echo $users->link_expired->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="link_expired"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->link_expired) ?>',1);"><div id="elh_users_link_expired" class="users_link_expired">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->link_expired->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->link_expired->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->link_expired->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isactive->Visible) { // isactive ?>
	<?php if ($users->SortUrl($users->isactive) == "") { ?>
		<th data-name="isactive"><div id="elh_users_isactive" class="users_isactive"><div class="ewTableHeaderCaption"><?php echo $users->isactive->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isactive"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isactive) ?>',1);"><div id="elh_users_isactive" class="users_isactive">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isactive->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isactive->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isactive->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->google->Visible) { // google ?>
	<?php if ($users->SortUrl($users->google) == "") { ?>
		<th data-name="google"><div id="elh_users_google" class="users_google"><div class="ewTableHeaderCaption"><?php echo $users->google->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="google"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->google) ?>',1);"><div id="elh_users_google" class="users_google">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->google->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->google->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->google->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->instagram->Visible) { // instagram ?>
	<?php if ($users->SortUrl($users->instagram) == "") { ?>
		<th data-name="instagram"><div id="elh_users_instagram" class="users_instagram"><div class="ewTableHeaderCaption"><?php echo $users->instagram->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="instagram"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->instagram) ?>',1);"><div id="elh_users_instagram" class="users_instagram">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->instagram->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->instagram->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->instagram->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->account_type->Visible) { // account_type ?>
	<?php if ($users->SortUrl($users->account_type) == "") { ?>
		<th data-name="account_type"><div id="elh_users_account_type" class="users_account_type"><div class="ewTableHeaderCaption"><?php echo $users->account_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="account_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->account_type) ?>',1);"><div id="elh_users_account_type" class="users_account_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->account_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->account_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->account_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->logo->Visible) { // logo ?>
	<?php if ($users->SortUrl($users->logo) == "") { ?>
		<th data-name="logo"><div id="elh_users_logo" class="users_logo"><div class="ewTableHeaderCaption"><?php echo $users->logo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="logo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->logo) ?>',1);"><div id="elh_users_logo" class="users_logo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->logo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->logo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->logo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->profilepic->Visible) { // profilepic ?>
	<?php if ($users->SortUrl($users->profilepic) == "") { ?>
		<th data-name="profilepic"><div id="elh_users_profilepic" class="users_profilepic"><div class="ewTableHeaderCaption"><?php echo $users->profilepic->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="profilepic"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->profilepic) ?>',1);"><div id="elh_users_profilepic" class="users_profilepic">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->profilepic->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->profilepic->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->profilepic->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->mailref->Visible) { // mailref ?>
	<?php if ($users->SortUrl($users->mailref) == "") { ?>
		<th data-name="mailref"><div id="elh_users_mailref" class="users_mailref"><div class="ewTableHeaderCaption"><?php echo $users->mailref->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mailref"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->mailref) ?>',1);"><div id="elh_users_mailref" class="users_mailref">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->mailref->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->mailref->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->mailref->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->deleted->Visible) { // deleted ?>
	<?php if ($users->SortUrl($users->deleted) == "") { ?>
		<th data-name="deleted"><div id="elh_users_deleted" class="users_deleted"><div class="ewTableHeaderCaption"><?php echo $users->deleted->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="deleted"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->deleted) ?>',1);"><div id="elh_users_deleted" class="users_deleted">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->deleted->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->deleted->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->deleted->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->deletefeedback->Visible) { // deletefeedback ?>
	<?php if ($users->SortUrl($users->deletefeedback) == "") { ?>
		<th data-name="deletefeedback"><div id="elh_users_deletefeedback" class="users_deletefeedback"><div class="ewTableHeaderCaption"><?php echo $users->deletefeedback->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="deletefeedback"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->deletefeedback) ?>',1);"><div id="elh_users_deletefeedback" class="users_deletefeedback">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->deletefeedback->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->deletefeedback->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->deletefeedback->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->account_id->Visible) { // account_id ?>
	<?php if ($users->SortUrl($users->account_id) == "") { ?>
		<th data-name="account_id"><div id="elh_users_account_id" class="users_account_id"><div class="ewTableHeaderCaption"><?php echo $users->account_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="account_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->account_id) ?>',1);"><div id="elh_users_account_id" class="users_account_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->account_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->account_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->account_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->start_date->Visible) { // start_date ?>
	<?php if ($users->SortUrl($users->start_date) == "") { ?>
		<th data-name="start_date"><div id="elh_users_start_date" class="users_start_date"><div class="ewTableHeaderCaption"><?php echo $users->start_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="start_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->start_date) ?>',1);"><div id="elh_users_start_date" class="users_start_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->start_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->start_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->start_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->end_date->Visible) { // end_date ?>
	<?php if ($users->SortUrl($users->end_date) == "") { ?>
		<th data-name="end_date"><div id="elh_users_end_date" class="users_end_date"><div class="ewTableHeaderCaption"><?php echo $users->end_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="end_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->end_date) ?>',1);"><div id="elh_users_end_date" class="users_end_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->end_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->end_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->end_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->year_moth->Visible) { // year_moth ?>
	<?php if ($users->SortUrl($users->year_moth) == "") { ?>
		<th data-name="year_moth"><div id="elh_users_year_moth" class="users_year_moth"><div class="ewTableHeaderCaption"><?php echo $users->year_moth->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="year_moth"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->year_moth) ?>',1);"><div id="elh_users_year_moth" class="users_year_moth">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->year_moth->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->year_moth->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->year_moth->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->registerdate->Visible) { // registerdate ?>
	<?php if ($users->SortUrl($users->registerdate) == "") { ?>
		<th data-name="registerdate"><div id="elh_users_registerdate" class="users_registerdate"><div class="ewTableHeaderCaption"><?php echo $users->registerdate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="registerdate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->registerdate) ?>',1);"><div id="elh_users_registerdate" class="users_registerdate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->registerdate->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->registerdate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->registerdate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->login_type->Visible) { // login_type ?>
	<?php if ($users->SortUrl($users->login_type) == "") { ?>
		<th data-name="login_type"><div id="elh_users_login_type" class="users_login_type"><div class="ewTableHeaderCaption"><?php echo $users->login_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="login_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->login_type) ?>',1);"><div id="elh_users_login_type" class="users_login_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->login_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->login_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->login_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->accountstatus->Visible) { // accountstatus ?>
	<?php if ($users->SortUrl($users->accountstatus) == "") { ?>
		<th data-name="accountstatus"><div id="elh_users_accountstatus" class="users_accountstatus"><div class="ewTableHeaderCaption"><?php echo $users->accountstatus->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="accountstatus"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->accountstatus) ?>',1);"><div id="elh_users_accountstatus" class="users_accountstatus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->accountstatus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->accountstatus->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->accountstatus->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->ispay->Visible) { // ispay ?>
	<?php if ($users->SortUrl($users->ispay) == "") { ?>
		<th data-name="ispay"><div id="elh_users_ispay" class="users_ispay"><div class="ewTableHeaderCaption"><?php echo $users->ispay->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ispay"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->ispay) ?>',1);"><div id="elh_users_ispay" class="users_ispay">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->ispay->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->ispay->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->ispay->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->profilelink->Visible) { // profilelink ?>
	<?php if ($users->SortUrl($users->profilelink) == "") { ?>
		<th data-name="profilelink"><div id="elh_users_profilelink" class="users_profilelink"><div class="ewTableHeaderCaption"><?php echo $users->profilelink->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="profilelink"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->profilelink) ?>',1);"><div id="elh_users_profilelink" class="users_profilelink">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->profilelink->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->profilelink->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->profilelink->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->source->Visible) { // source ?>
	<?php if ($users->SortUrl($users->source) == "") { ?>
		<th data-name="source"><div id="elh_users_source" class="users_source"><div class="ewTableHeaderCaption"><?php echo $users->source->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="source"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->source) ?>',1);"><div id="elh_users_source" class="users_source">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->source->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->source->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->source->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->agree->Visible) { // agree ?>
	<?php if ($users->SortUrl($users->agree) == "") { ?>
		<th data-name="agree"><div id="elh_users_agree" class="users_agree"><div class="ewTableHeaderCaption"><?php echo $users->agree->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="agree"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->agree) ?>',1);"><div id="elh_users_agree" class="users_agree">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->agree->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->agree->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->agree->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->balance->Visible) { // balance ?>
	<?php if ($users->SortUrl($users->balance) == "") { ?>
		<th data-name="balance"><div id="elh_users_balance" class="users_balance"><div class="ewTableHeaderCaption"><?php echo $users->balance->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="balance"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->balance) ?>',1);"><div id="elh_users_balance" class="users_balance">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->balance->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->balance->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->balance->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->job_title->Visible) { // job_title ?>
	<?php if ($users->SortUrl($users->job_title) == "") { ?>
		<th data-name="job_title"><div id="elh_users_job_title" class="users_job_title"><div class="ewTableHeaderCaption"><?php echo $users->job_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="job_title"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->job_title) ?>',1);"><div id="elh_users_job_title" class="users_job_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->job_title->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->job_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->job_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->projects->Visible) { // projects ?>
	<?php if ($users->SortUrl($users->projects) == "") { ?>
		<th data-name="projects"><div id="elh_users_projects" class="users_projects"><div class="ewTableHeaderCaption"><?php echo $users->projects->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="projects"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->projects) ?>',1);"><div id="elh_users_projects" class="users_projects">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->projects->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->projects->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->projects->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->opportunities->Visible) { // opportunities ?>
	<?php if ($users->SortUrl($users->opportunities) == "") { ?>
		<th data-name="opportunities"><div id="elh_users_opportunities" class="users_opportunities"><div class="ewTableHeaderCaption"><?php echo $users->opportunities->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="opportunities"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->opportunities) ?>',1);"><div id="elh_users_opportunities" class="users_opportunities">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->opportunities->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->opportunities->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->opportunities->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isconsaltant->Visible) { // isconsaltant ?>
	<?php if ($users->SortUrl($users->isconsaltant) == "") { ?>
		<th data-name="isconsaltant"><div id="elh_users_isconsaltant" class="users_isconsaltant"><div class="ewTableHeaderCaption"><?php echo $users->isconsaltant->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isconsaltant"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isconsaltant) ?>',1);"><div id="elh_users_isconsaltant" class="users_isconsaltant">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isconsaltant->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isconsaltant->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isconsaltant->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isagent->Visible) { // isagent ?>
	<?php if ($users->SortUrl($users->isagent) == "") { ?>
		<th data-name="isagent"><div id="elh_users_isagent" class="users_isagent"><div class="ewTableHeaderCaption"><?php echo $users->isagent->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isagent"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isagent) ?>',1);"><div id="elh_users_isagent" class="users_isagent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isagent->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isagent->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isagent->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isinvestor->Visible) { // isinvestor ?>
	<?php if ($users->SortUrl($users->isinvestor) == "") { ?>
		<th data-name="isinvestor"><div id="elh_users_isinvestor" class="users_isinvestor"><div class="ewTableHeaderCaption"><?php echo $users->isinvestor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isinvestor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isinvestor) ?>',1);"><div id="elh_users_isinvestor" class="users_isinvestor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isinvestor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isinvestor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isinvestor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isbusinessman->Visible) { // isbusinessman ?>
	<?php if ($users->SortUrl($users->isbusinessman) == "") { ?>
		<th data-name="isbusinessman"><div id="elh_users_isbusinessman" class="users_isbusinessman"><div class="ewTableHeaderCaption"><?php echo $users->isbusinessman->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isbusinessman"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isbusinessman) ?>',1);"><div id="elh_users_isbusinessman" class="users_isbusinessman">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isbusinessman->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isbusinessman->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isbusinessman->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isprovider->Visible) { // isprovider ?>
	<?php if ($users->SortUrl($users->isprovider) == "") { ?>
		<th data-name="isprovider"><div id="elh_users_isprovider" class="users_isprovider"><div class="ewTableHeaderCaption"><?php echo $users->isprovider->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isprovider"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isprovider) ?>',1);"><div id="elh_users_isprovider" class="users_isprovider">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isprovider->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isprovider->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isprovider->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->isproductowner->Visible) { // isproductowner ?>
	<?php if ($users->SortUrl($users->isproductowner) == "") { ?>
		<th data-name="isproductowner"><div id="elh_users_isproductowner" class="users_isproductowner"><div class="ewTableHeaderCaption"><?php echo $users->isproductowner->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isproductowner"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->isproductowner) ?>',1);"><div id="elh_users_isproductowner" class="users_isproductowner">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->isproductowner->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->isproductowner->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->isproductowner->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->states->Visible) { // states ?>
	<?php if ($users->SortUrl($users->states) == "") { ?>
		<th data-name="states"><div id="elh_users_states" class="users_states"><div class="ewTableHeaderCaption"><?php echo $users->states->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="states"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->states) ?>',1);"><div id="elh_users_states" class="users_states">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->states->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->states->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->states->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->cities->Visible) { // cities ?>
	<?php if ($users->SortUrl($users->cities) == "") { ?>
		<th data-name="cities"><div id="elh_users_cities" class="users_cities"><div class="ewTableHeaderCaption"><?php echo $users->cities->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cities"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->cities) ?>',1);"><div id="elh_users_cities" class="users_cities">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->cities->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($users->cities->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->cities->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($users->offers->Visible) { // offers ?>
	<?php if ($users->SortUrl($users->offers) == "") { ?>
		<th data-name="offers"><div id="elh_users_offers" class="users_offers"><div class="ewTableHeaderCaption"><?php echo $users->offers->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="offers"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $users->SortUrl($users->offers) ?>',1);"><div id="elh_users_offers" class="users_offers">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $users->offers->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($users->offers->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($users->offers->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$users_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($users->ExportAll && $users->Export <> "") {
	$users_list->StopRec = $users_list->TotalRecs;
} else {

	// Set the last record to display
	if ($users_list->TotalRecs > $users_list->StartRec + $users_list->DisplayRecs - 1)
		$users_list->StopRec = $users_list->StartRec + $users_list->DisplayRecs - 1;
	else
		$users_list->StopRec = $users_list->TotalRecs;
}
$users_list->RecCnt = $users_list->StartRec - 1;
if ($users_list->Recordset && !$users_list->Recordset->EOF) {
	$users_list->Recordset->MoveFirst();
	$bSelectLimit = $users_list->UseSelectLimit;
	if (!$bSelectLimit && $users_list->StartRec > 1)
		$users_list->Recordset->Move($users_list->StartRec - 1);
} elseif (!$users->AllowAddDeleteRow && $users_list->StopRec == 0) {
	$users_list->StopRec = $users->GridAddRowCount;
}

// Initialize aggregate
$users->RowType = EW_ROWTYPE_AGGREGATEINIT;
$users->ResetAttrs();
$users_list->RenderRow();
while ($users_list->RecCnt < $users_list->StopRec) {
	$users_list->RecCnt++;
	if (intval($users_list->RecCnt) >= intval($users_list->StartRec)) {
		$users_list->RowCnt++;

		// Set up key count
		$users_list->KeyCount = $users_list->RowIndex;

		// Init row class and style
		$users->ResetAttrs();
		$users->CssClass = "";
		if ($users->CurrentAction == "gridadd") {
		} else {
			$users_list->LoadRowValues($users_list->Recordset); // Load row values
		}
		$users->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$users->RowAttrs = array_merge($users->RowAttrs, array('data-rowindex'=>$users_list->RowCnt, 'id'=>'r' . $users_list->RowCnt . '_users', 'data-rowtype'=>$users->RowType));

		// Render row
		$users_list->RenderRow();

		// Render list options
		$users_list->RenderListOptions();
?>
	<tr<?php echo $users->RowAttributes() ?>>
<?php

// Render list options (body, left)
$users_list->ListOptions->Render("body", "left", $users_list->RowCnt);
?>
	<?php if ($users->id->Visible) { // id ?>
		<td data-name="id"<?php echo $users->id->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_id" class="users_id">
<span<?php echo $users->id->ViewAttributes() ?>>
<?php echo $users->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $users_list->PageObjName . "_row_" . $users_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($users->name->Visible) { // name ?>
		<td data-name="name"<?php echo $users->name->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_name" class="users_name">
<span<?php echo $users->name->ViewAttributes() ?>>
<?php echo $users->name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->_email->Visible) { // email ?>
		<td data-name="_email"<?php echo $users->_email->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users__email" class="users__email">
<span<?php echo $users->_email->ViewAttributes() ?>>
<?php echo $users->_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->companyname->Visible) { // companyname ?>
		<td data-name="companyname"<?php echo $users->companyname->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_companyname" class="users_companyname">
<span<?php echo $users->companyname->ViewAttributes() ?>>
<?php echo $users->companyname->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->servicetime->Visible) { // servicetime ?>
		<td data-name="servicetime"<?php echo $users->servicetime->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_servicetime" class="users_servicetime">
<span<?php echo $users->servicetime->ViewAttributes() ?>>
<?php echo $users->servicetime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->country->Visible) { // country ?>
		<td data-name="country"<?php echo $users->country->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_country" class="users_country">
<span<?php echo $users->country->ViewAttributes() ?>>
<?php echo $users->country->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->phone->Visible) { // phone ?>
		<td data-name="phone"<?php echo $users->phone->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_phone" class="users_phone">
<span<?php echo $users->phone->ViewAttributes() ?>>
<?php echo $users->phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->skype->Visible) { // skype ?>
		<td data-name="skype"<?php echo $users->skype->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_skype" class="users_skype">
<span<?php echo $users->skype->ViewAttributes() ?>>
<?php echo $users->skype->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->website->Visible) { // website ?>
		<td data-name="website"<?php echo $users->website->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_website" class="users_website">
<span<?php echo $users->website->ViewAttributes() ?>>
<?php echo $users->website->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->linkedin->Visible) { // linkedin ?>
		<td data-name="linkedin"<?php echo $users->linkedin->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_linkedin" class="users_linkedin">
<span<?php echo $users->linkedin->ViewAttributes() ?>>
<?php echo $users->linkedin->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->facebook->Visible) { // facebook ?>
		<td data-name="facebook"<?php echo $users->facebook->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_facebook" class="users_facebook">
<span<?php echo $users->facebook->ViewAttributes() ?>>
<?php echo $users->facebook->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->twitter->Visible) { // twitter ?>
		<td data-name="twitter"<?php echo $users->twitter->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_twitter" class="users_twitter">
<span<?php echo $users->twitter->ViewAttributes() ?>>
<?php echo $users->twitter->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->active_code->Visible) { // active_code ?>
		<td data-name="active_code"<?php echo $users->active_code->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_active_code" class="users_active_code">
<span<?php echo $users->active_code->ViewAttributes() ?>>
<?php echo $users->active_code->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->identification->Visible) { // identification ?>
		<td data-name="identification"<?php echo $users->identification->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_identification" class="users_identification">
<span<?php echo $users->identification->ViewAttributes() ?>>
<?php echo $users->identification->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->link_expired->Visible) { // link_expired ?>
		<td data-name="link_expired"<?php echo $users->link_expired->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_link_expired" class="users_link_expired">
<span<?php echo $users->link_expired->ViewAttributes() ?>>
<?php echo $users->link_expired->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isactive->Visible) { // isactive ?>
		<td data-name="isactive"<?php echo $users->isactive->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isactive" class="users_isactive">
<span<?php echo $users->isactive->ViewAttributes() ?>>
<?php echo $users->isactive->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->google->Visible) { // google ?>
		<td data-name="google"<?php echo $users->google->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_google" class="users_google">
<span<?php echo $users->google->ViewAttributes() ?>>
<?php echo $users->google->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->instagram->Visible) { // instagram ?>
		<td data-name="instagram"<?php echo $users->instagram->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_instagram" class="users_instagram">
<span<?php echo $users->instagram->ViewAttributes() ?>>
<?php echo $users->instagram->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->account_type->Visible) { // account_type ?>
		<td data-name="account_type"<?php echo $users->account_type->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_account_type" class="users_account_type">
<span<?php echo $users->account_type->ViewAttributes() ?>>
<?php echo $users->account_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->logo->Visible) { // logo ?>
		<td data-name="logo"<?php echo $users->logo->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_logo" class="users_logo">
<span<?php echo $users->logo->ViewAttributes() ?>>
<?php echo $users->logo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->profilepic->Visible) { // profilepic ?>
		<td data-name="profilepic"<?php echo $users->profilepic->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_profilepic" class="users_profilepic">
<span<?php echo $users->profilepic->ViewAttributes() ?>>
<?php echo $users->profilepic->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->mailref->Visible) { // mailref ?>
		<td data-name="mailref"<?php echo $users->mailref->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_mailref" class="users_mailref">
<span<?php echo $users->mailref->ViewAttributes() ?>>
<?php echo $users->mailref->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->deleted->Visible) { // deleted ?>
		<td data-name="deleted"<?php echo $users->deleted->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_deleted" class="users_deleted">
<span<?php echo $users->deleted->ViewAttributes() ?>>
<?php echo $users->deleted->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->deletefeedback->Visible) { // deletefeedback ?>
		<td data-name="deletefeedback"<?php echo $users->deletefeedback->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_deletefeedback" class="users_deletefeedback">
<span<?php echo $users->deletefeedback->ViewAttributes() ?>>
<?php echo $users->deletefeedback->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->account_id->Visible) { // account_id ?>
		<td data-name="account_id"<?php echo $users->account_id->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_account_id" class="users_account_id">
<span<?php echo $users->account_id->ViewAttributes() ?>>
<?php echo $users->account_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->start_date->Visible) { // start_date ?>
		<td data-name="start_date"<?php echo $users->start_date->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_start_date" class="users_start_date">
<span<?php echo $users->start_date->ViewAttributes() ?>>
<?php echo $users->start_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->end_date->Visible) { // end_date ?>
		<td data-name="end_date"<?php echo $users->end_date->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_end_date" class="users_end_date">
<span<?php echo $users->end_date->ViewAttributes() ?>>
<?php echo $users->end_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->year_moth->Visible) { // year_moth ?>
		<td data-name="year_moth"<?php echo $users->year_moth->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_year_moth" class="users_year_moth">
<span<?php echo $users->year_moth->ViewAttributes() ?>>
<?php echo $users->year_moth->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->registerdate->Visible) { // registerdate ?>
		<td data-name="registerdate"<?php echo $users->registerdate->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_registerdate" class="users_registerdate">
<span<?php echo $users->registerdate->ViewAttributes() ?>>
<?php echo $users->registerdate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->login_type->Visible) { // login_type ?>
		<td data-name="login_type"<?php echo $users->login_type->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_login_type" class="users_login_type">
<span<?php echo $users->login_type->ViewAttributes() ?>>
<?php echo $users->login_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->accountstatus->Visible) { // accountstatus ?>
		<td data-name="accountstatus"<?php echo $users->accountstatus->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_accountstatus" class="users_accountstatus">
<span<?php echo $users->accountstatus->ViewAttributes() ?>>
<?php echo $users->accountstatus->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->ispay->Visible) { // ispay ?>
		<td data-name="ispay"<?php echo $users->ispay->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_ispay" class="users_ispay">
<span<?php echo $users->ispay->ViewAttributes() ?>>
<?php echo $users->ispay->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->profilelink->Visible) { // profilelink ?>
		<td data-name="profilelink"<?php echo $users->profilelink->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_profilelink" class="users_profilelink">
<span<?php echo $users->profilelink->ViewAttributes() ?>>
<?php echo $users->profilelink->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->source->Visible) { // source ?>
		<td data-name="source"<?php echo $users->source->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_source" class="users_source">
<span<?php echo $users->source->ViewAttributes() ?>>
<?php echo $users->source->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->agree->Visible) { // agree ?>
		<td data-name="agree"<?php echo $users->agree->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_agree" class="users_agree">
<span<?php echo $users->agree->ViewAttributes() ?>>
<?php echo $users->agree->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->balance->Visible) { // balance ?>
		<td data-name="balance"<?php echo $users->balance->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_balance" class="users_balance">
<span<?php echo $users->balance->ViewAttributes() ?>>
<?php echo $users->balance->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->job_title->Visible) { // job_title ?>
		<td data-name="job_title"<?php echo $users->job_title->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_job_title" class="users_job_title">
<span<?php echo $users->job_title->ViewAttributes() ?>>
<?php echo $users->job_title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->projects->Visible) { // projects ?>
		<td data-name="projects"<?php echo $users->projects->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_projects" class="users_projects">
<span<?php echo $users->projects->ViewAttributes() ?>>
<?php echo $users->projects->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->opportunities->Visible) { // opportunities ?>
		<td data-name="opportunities"<?php echo $users->opportunities->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_opportunities" class="users_opportunities">
<span<?php echo $users->opportunities->ViewAttributes() ?>>
<?php echo $users->opportunities->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isconsaltant->Visible) { // isconsaltant ?>
		<td data-name="isconsaltant"<?php echo $users->isconsaltant->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isconsaltant" class="users_isconsaltant">
<span<?php echo $users->isconsaltant->ViewAttributes() ?>>
<?php echo $users->isconsaltant->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isagent->Visible) { // isagent ?>
		<td data-name="isagent"<?php echo $users->isagent->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isagent" class="users_isagent">
<span<?php echo $users->isagent->ViewAttributes() ?>>
<?php echo $users->isagent->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isinvestor->Visible) { // isinvestor ?>
		<td data-name="isinvestor"<?php echo $users->isinvestor->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isinvestor" class="users_isinvestor">
<span<?php echo $users->isinvestor->ViewAttributes() ?>>
<?php echo $users->isinvestor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isbusinessman->Visible) { // isbusinessman ?>
		<td data-name="isbusinessman"<?php echo $users->isbusinessman->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isbusinessman" class="users_isbusinessman">
<span<?php echo $users->isbusinessman->ViewAttributes() ?>>
<?php echo $users->isbusinessman->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isprovider->Visible) { // isprovider ?>
		<td data-name="isprovider"<?php echo $users->isprovider->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isprovider" class="users_isprovider">
<span<?php echo $users->isprovider->ViewAttributes() ?>>
<?php echo $users->isprovider->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->isproductowner->Visible) { // isproductowner ?>
		<td data-name="isproductowner"<?php echo $users->isproductowner->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_isproductowner" class="users_isproductowner">
<span<?php echo $users->isproductowner->ViewAttributes() ?>>
<?php echo $users->isproductowner->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->states->Visible) { // states ?>
		<td data-name="states"<?php echo $users->states->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_states" class="users_states">
<span<?php echo $users->states->ViewAttributes() ?>>
<?php echo $users->states->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->cities->Visible) { // cities ?>
		<td data-name="cities"<?php echo $users->cities->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_cities" class="users_cities">
<span<?php echo $users->cities->ViewAttributes() ?>>
<?php echo $users->cities->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($users->offers->Visible) { // offers ?>
		<td data-name="offers"<?php echo $users->offers->CellAttributes() ?>>
<span id="el<?php echo $users_list->RowCnt ?>_users_offers" class="users_offers">
<span<?php echo $users->offers->ViewAttributes() ?>>
<?php echo $users->offers->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$users_list->ListOptions->Render("body", "right", $users_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($users->CurrentAction <> "gridadd")
		$users_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($users->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($users_list->Recordset)
	$users_list->Recordset->Close();
?>
<?php if ($users->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($users->CurrentAction <> "gridadd" && $users->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($users_list->Pager)) $users_list->Pager = new cPrevNextPager($users_list->StartRec, $users_list->DisplayRecs, $users_list->TotalRecs) ?>
<?php if ($users_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($users_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($users_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $users_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($users_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($users_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $users_list->PageUrl() ?>start=<?php echo $users_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $users_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $users_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $users_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $users_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($users_list->TotalRecs == 0 && $users->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($users_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($users->Export == "") { ?>
<script type="text/javascript">
fuserslistsrch.Init();
fuserslistsrch.FilterList = <?php echo $users_list->GetFilterList() ?>;
fuserslist.Init();
</script>
<?php } ?>
<?php
$users_list->ShowPageFooter();
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
$users_list->Page_Terminate();
?>
