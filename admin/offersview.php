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

$offers_view = NULL; // Initialize page object first

class coffers_view extends coffers {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'offers';

	// Page object name
	var $PageObjName = 'offers_view';

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

		// Table object (offers)
		if (!isset($GLOBALS["offers"]) || get_class($GLOBALS["offers"]) == "coffers") {
			$GLOBALS["offers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["offers"];
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
				$this->Page_Terminate(ew_GetUrl("offerslist.php"));
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
						$this->Page_Terminate("offerslist.php"); // Return to list page
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
						$sReturnUrl = "offerslist.php"; // No matching record, return to list
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
			$sReturnUrl = "offerslist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$item->Body = "<button id=\"emf_offers\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_offers',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.foffersview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, "offerslist.php", "", $this->TableVar, TRUE);
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
if (!isset($offers_view)) $offers_view = new coffers_view();

// Page init
$offers_view->Page_Init();

// Page main
$offers_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$offers_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($offers->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = foffersview = new ew_Form("foffersview", "view");

// Form_CustomValidate event
foffersview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
foffersview.ValidateRequired = true;
<?php } else { ?>
foffersview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($offers->Export == "") { ?>
<div class="ewToolbar">
<?php if ($offers->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php $offers_view->ExportOptions->Render("body") ?>
<?php
	foreach ($offers_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if ($offers->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $offers_view->ShowPageHeader(); ?>
<?php
$offers_view->ShowMessage();
?>
<?php if ($offers->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($offers_view->Pager)) $offers_view->Pager = new cPrevNextPager($offers_view->StartRec, $offers_view->DisplayRecs, $offers_view->TotalRecs) ?>
<?php if ($offers_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($offers_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($offers_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $offers_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($offers_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($offers_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $offers_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="foffersview" id="foffersview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($offers_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $offers_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="offers">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($offers->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_offers_id"><?php echo $offers->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $offers->id->CellAttributes() ?>>
<span id="el_offers_id">
<span<?php echo $offers->id->ViewAttributes() ?>>
<?php echo $offers->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->user_id->Visible) { // user_id ?>
	<tr id="r_user_id">
		<td><span id="elh_offers_user_id"><?php echo $offers->user_id->FldCaption() ?></span></td>
		<td data-name="user_id"<?php echo $offers->user_id->CellAttributes() ?>>
<span id="el_offers_user_id">
<span<?php echo $offers->user_id->ViewAttributes() ?>>
<?php echo $offers->user_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->offer_type_filed->Visible) { // offer_type_filed ?>
	<tr id="r_offer_type_filed">
		<td><span id="elh_offers_offer_type_filed"><?php echo $offers->offer_type_filed->FldCaption() ?></span></td>
		<td data-name="offer_type_filed"<?php echo $offers->offer_type_filed->CellAttributes() ?>>
<span id="el_offers_offer_type_filed">
<span<?php echo $offers->offer_type_filed->ViewAttributes() ?>>
<?php echo $offers->offer_type_filed->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->name->Visible) { // name ?>
	<tr id="r_name">
		<td><span id="elh_offers_name"><?php echo $offers->name->FldCaption() ?></span></td>
		<td data-name="name"<?php echo $offers->name->CellAttributes() ?>>
<span id="el_offers_name">
<span<?php echo $offers->name->ViewAttributes() ?>>
<?php echo $offers->name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->item_type->Visible) { // item_type ?>
	<tr id="r_item_type">
		<td><span id="elh_offers_item_type"><?php echo $offers->item_type->FldCaption() ?></span></td>
		<td data-name="item_type"<?php echo $offers->item_type->CellAttributes() ?>>
<span id="el_offers_item_type">
<span<?php echo $offers->item_type->ViewAttributes() ?>>
<?php echo $offers->item_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->item_brand->Visible) { // item_brand ?>
	<tr id="r_item_brand">
		<td><span id="elh_offers_item_brand"><?php echo $offers->item_brand->FldCaption() ?></span></td>
		<td data-name="item_brand"<?php echo $offers->item_brand->CellAttributes() ?>>
<span id="el_offers_item_brand">
<span<?php echo $offers->item_brand->ViewAttributes() ?>>
<?php echo $offers->item_brand->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->min_qty->Visible) { // min_qty ?>
	<tr id="r_min_qty">
		<td><span id="elh_offers_min_qty"><?php echo $offers->min_qty->FldCaption() ?></span></td>
		<td data-name="min_qty"<?php echo $offers->min_qty->CellAttributes() ?>>
<span id="el_offers_min_qty">
<span<?php echo $offers->min_qty->ViewAttributes() ?>>
<?php echo $offers->min_qty->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->price->Visible) { // price ?>
	<tr id="r_price">
		<td><span id="elh_offers_price"><?php echo $offers->price->FldCaption() ?></span></td>
		<td data-name="price"<?php echo $offers->price->CellAttributes() ?>>
<span id="el_offers_price">
<span<?php echo $offers->price->ViewAttributes() ?>>
<?php echo $offers->price->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->description->Visible) { // description ?>
	<tr id="r_description">
		<td><span id="elh_offers_description"><?php echo $offers->description->FldCaption() ?></span></td>
		<td data-name="description"<?php echo $offers->description->CellAttributes() ?>>
<span id="el_offers_description">
<span<?php echo $offers->description->ViewAttributes() ?>>
<?php echo $offers->description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->country->Visible) { // country ?>
	<tr id="r_country">
		<td><span id="elh_offers_country"><?php echo $offers->country->FldCaption() ?></span></td>
		<td data-name="country"<?php echo $offers->country->CellAttributes() ?>>
<span id="el_offers_country">
<span<?php echo $offers->country->ViewAttributes() ?>>
<?php echo $offers->country->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->states->Visible) { // states ?>
	<tr id="r_states">
		<td><span id="elh_offers_states"><?php echo $offers->states->FldCaption() ?></span></td>
		<td data-name="states"<?php echo $offers->states->CellAttributes() ?>>
<span id="el_offers_states">
<span<?php echo $offers->states->ViewAttributes() ?>>
<?php echo $offers->states->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->cities->Visible) { // cities ?>
	<tr id="r_cities">
		<td><span id="elh_offers_cities"><?php echo $offers->cities->FldCaption() ?></span></td>
		<td data-name="cities"<?php echo $offers->cities->CellAttributes() ?>>
<span id="el_offers_cities">
<span<?php echo $offers->cities->ViewAttributes() ?>>
<?php echo $offers->cities->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->contact_name->Visible) { // contact_name ?>
	<tr id="r_contact_name">
		<td><span id="elh_offers_contact_name"><?php echo $offers->contact_name->FldCaption() ?></span></td>
		<td data-name="contact_name"<?php echo $offers->contact_name->CellAttributes() ?>>
<span id="el_offers_contact_name">
<span<?php echo $offers->contact_name->ViewAttributes() ?>>
<?php echo $offers->contact_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->contact_phone->Visible) { // contact_phone ?>
	<tr id="r_contact_phone">
		<td><span id="elh_offers_contact_phone"><?php echo $offers->contact_phone->FldCaption() ?></span></td>
		<td data-name="contact_phone"<?php echo $offers->contact_phone->CellAttributes() ?>>
<span id="el_offers_contact_phone">
<span<?php echo $offers->contact_phone->ViewAttributes() ?>>
<?php echo $offers->contact_phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->contact_type->Visible) { // contact_type ?>
	<tr id="r_contact_type">
		<td><span id="elh_offers_contact_type"><?php echo $offers->contact_type->FldCaption() ?></span></td>
		<td data-name="contact_type"<?php echo $offers->contact_type->CellAttributes() ?>>
<span id="el_offers_contact_type">
<span<?php echo $offers->contact_type->ViewAttributes() ?>>
<?php echo $offers->contact_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->contact_email->Visible) { // contact_email ?>
	<tr id="r_contact_email">
		<td><span id="elh_offers_contact_email"><?php echo $offers->contact_email->FldCaption() ?></span></td>
		<td data-name="contact_email"<?php echo $offers->contact_email->CellAttributes() ?>>
<span id="el_offers_contact_email">
<span<?php echo $offers->contact_email->ViewAttributes() ?>>
<?php echo $offers->contact_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->picpath->Visible) { // picpath ?>
	<tr id="r_picpath">
		<td><span id="elh_offers_picpath"><?php echo $offers->picpath->FldCaption() ?></span></td>
		<td data-name="picpath"<?php echo $offers->picpath->CellAttributes() ?>>
<span id="el_offers_picpath">
<span<?php echo $offers->picpath->ViewAttributes() ?>>
<?php echo $offers->picpath->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->createdtime->Visible) { // createdtime ?>
	<tr id="r_createdtime">
		<td><span id="elh_offers_createdtime"><?php echo $offers->createdtime->FldCaption() ?></span></td>
		<td data-name="createdtime"<?php echo $offers->createdtime->CellAttributes() ?>>
<span id="el_offers_createdtime">
<span<?php echo $offers->createdtime->ViewAttributes() ?>>
<?php echo $offers->createdtime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->modifiedtime->Visible) { // modifiedtime ?>
	<tr id="r_modifiedtime">
		<td><span id="elh_offers_modifiedtime"><?php echo $offers->modifiedtime->FldCaption() ?></span></td>
		<td data-name="modifiedtime"<?php echo $offers->modifiedtime->CellAttributes() ?>>
<span id="el_offers_modifiedtime">
<span<?php echo $offers->modifiedtime->ViewAttributes() ?>>
<?php echo $offers->modifiedtime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->deleted->Visible) { // deleted ?>
	<tr id="r_deleted">
		<td><span id="elh_offers_deleted"><?php echo $offers->deleted->FldCaption() ?></span></td>
		<td data-name="deleted"<?php echo $offers->deleted->CellAttributes() ?>>
<span id="el_offers_deleted">
<span<?php echo $offers->deleted->ViewAttributes() ?>>
<?php echo $offers->deleted->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->views->Visible) { // views ?>
	<tr id="r_views">
		<td><span id="elh_offers_views"><?php echo $offers->views->FldCaption() ?></span></td>
		<td data-name="views"<?php echo $offers->views->CellAttributes() ?>>
<span id="el_offers_views">
<span<?php echo $offers->views->ViewAttributes() ?>>
<?php echo $offers->views->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->verified_code->Visible) { // verified_code ?>
	<tr id="r_verified_code">
		<td><span id="elh_offers_verified_code"><?php echo $offers->verified_code->FldCaption() ?></span></td>
		<td data-name="verified_code"<?php echo $offers->verified_code->CellAttributes() ?>>
<span id="el_offers_verified_code">
<span<?php echo $offers->verified_code->ViewAttributes() ?>>
<?php echo $offers->verified_code->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->pending->Visible) { // pending ?>
	<tr id="r_pending">
		<td><span id="elh_offers_pending"><?php echo $offers->pending->FldCaption() ?></span></td>
		<td data-name="pending"<?php echo $offers->pending->CellAttributes() ?>>
<span id="el_offers_pending">
<span<?php echo $offers->pending->ViewAttributes() ?>>
<?php echo $offers->pending->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->country_1->Visible) { // country_1 ?>
	<tr id="r_country_1">
		<td><span id="elh_offers_country_1"><?php echo $offers->country_1->FldCaption() ?></span></td>
		<td data-name="country_1"<?php echo $offers->country_1->CellAttributes() ?>>
<span id="el_offers_country_1">
<span<?php echo $offers->country_1->ViewAttributes() ?>>
<?php echo $offers->country_1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->num_send_sms->Visible) { // num_send_sms ?>
	<tr id="r_num_send_sms">
		<td><span id="elh_offers_num_send_sms"><?php echo $offers->num_send_sms->FldCaption() ?></span></td>
		<td data-name="num_send_sms"<?php echo $offers->num_send_sms->CellAttributes() ?>>
<span id="el_offers_num_send_sms">
<span<?php echo $offers->num_send_sms->ViewAttributes() ?>>
<?php echo $offers->num_send_sms->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->num_send_email->Visible) { // num_send_email ?>
	<tr id="r_num_send_email">
		<td><span id="elh_offers_num_send_email"><?php echo $offers->num_send_email->FldCaption() ?></span></td>
		<td data-name="num_send_email"<?php echo $offers->num_send_email->CellAttributes() ?>>
<span id="el_offers_num_send_email">
<span<?php echo $offers->num_send_email->ViewAttributes() ?>>
<?php echo $offers->num_send_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($offers->done->Visible) { // done ?>
	<tr id="r_done">
		<td><span id="elh_offers_done"><?php echo $offers->done->FldCaption() ?></span></td>
		<td data-name="done"<?php echo $offers->done->CellAttributes() ?>>
<span id="el_offers_done">
<span<?php echo $offers->done->ViewAttributes() ?>>
<?php echo $offers->done->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if ($offers->Export == "") { ?>
<?php if (!isset($offers_view->Pager)) $offers_view->Pager = new cPrevNextPager($offers_view->StartRec, $offers_view->DisplayRecs, $offers_view->TotalRecs) ?>
<?php if ($offers_view->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($offers_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($offers_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $offers_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($offers_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($offers_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $offers_view->PageUrl() ?>start=<?php echo $offers_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $offers_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
foffersview.Init();
</script>
<?php
$offers_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($offers->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$offers_view->Page_Terminate();
?>
