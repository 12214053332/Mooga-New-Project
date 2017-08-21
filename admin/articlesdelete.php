<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "articlesinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$articles_delete = NULL; // Initialize page object first

class carticles_delete extends carticles {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5101AD41-0E34-4393-9492-7002723D723A}";

	// Table name
	var $TableName = 'articles';

	// Page object name
	var $PageObjName = 'articles_delete';

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

		// Table object (articles)
		if (!isset($GLOBALS["articles"]) || get_class($GLOBALS["articles"]) == "carticles") {
			$GLOBALS["articles"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["articles"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'articles', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("articleslist.php"));
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
		global $EW_EXPORT, $articles;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($articles);
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
			$this->Page_Terminate("articleslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in articles class, articlesinfo.php

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
		$this->category_id->setDbValue($rs->fields('category_id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->description->setDbValue($rs->fields('description'));
		$this->picpath->Upload->DbValue = $rs->fields('picpath');
		$this->picpath->CurrentValue = $this->picpath->Upload->DbValue;
		$this->article_date->setDbValue($rs->fields('article_date'));
		$this->author_id->setDbValue($rs->fields('author_id'));
		$this->views->setDbValue($rs->fields('views'));
		$this->public->setDbValue($rs->fields('public'));
		$this->public_title->setDbValue($rs->fields('public_title'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->category_id->DbValue = $row['category_id'];
		$this->name->DbValue = $row['name'];
		$this->description->DbValue = $row['description'];
		$this->picpath->Upload->DbValue = $row['picpath'];
		$this->article_date->DbValue = $row['article_date'];
		$this->author_id->DbValue = $row['author_id'];
		$this->views->DbValue = $row['views'];
		$this->public->DbValue = $row['public'];
		$this->public_title->DbValue = $row['public_title'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// category_id
		// name
		// description
		// picpath
		// article_date
		// author_id
		// views
		// public
		// public_title

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// category_id
		if (strval($this->category_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `articles_category`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->category_id->ViewValue = $this->category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->category_id->ViewValue = $this->category_id->CurrentValue;
			}
		} else {
			$this->category_id->ViewValue = NULL;
		}
		$this->category_id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// picpath
		if (!ew_Empty($this->picpath->Upload->DbValue)) {
			$this->picpath->ImageAlt = $this->picpath->FldAlt();
			$this->picpath->ViewValue = $this->picpath->Upload->DbValue;
		} else {
			$this->picpath->ViewValue = "";
		}
		$this->picpath->ViewCustomAttributes = "";

		// article_date
		$this->article_date->ViewValue = $this->article_date->CurrentValue;
		$this->article_date->ViewValue = ew_FormatDateTime($this->article_date->ViewValue, 5);
		$this->article_date->ViewCustomAttributes = "";

		// author_id
		if (strval($this->author_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->author_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `author`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->author_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->author_id->ViewValue = $this->author_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->author_id->ViewValue = $this->author_id->CurrentValue;
			}
		} else {
			$this->author_id->ViewValue = NULL;
		}
		$this->author_id->ViewCustomAttributes = "";

		// views
		$this->views->ViewValue = $this->views->CurrentValue;
		$this->views->ViewCustomAttributes = "";

		// public_title
		$this->public_title->ViewValue = $this->public_title->CurrentValue;
		$this->public_title->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// category_id
			$this->category_id->LinkCustomAttributes = "";
			$this->category_id->HrefValue = "";
			$this->category_id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// picpath
			$this->picpath->LinkCustomAttributes = "";
			if (!ew_Empty($this->picpath->Upload->DbValue)) {
				$this->picpath->HrefValue = ew_GetFileUploadUrl($this->picpath, $this->picpath->Upload->DbValue); // Add prefix/suffix
				$this->picpath->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->picpath->HrefValue = ew_ConvertFullUrl($this->picpath->HrefValue);
			} else {
				$this->picpath->HrefValue = "";
			}
			$this->picpath->HrefValue2 = $this->picpath->UploadPath . $this->picpath->Upload->DbValue;
			$this->picpath->TooltipValue = "";
			if ($this->picpath->UseColorbox) {
				$this->picpath->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->picpath->LinkAttrs["data-rel"] = "articles_x_picpath";

				//$this->picpath->LinkAttrs["class"] = "ewLightbox ewTooltip img-thumbnail";
				//$this->picpath->LinkAttrs["data-placement"] = "bottom";
				//$this->picpath->LinkAttrs["data-container"] = "body";

				$this->picpath->LinkAttrs["class"] = "ewLightbox img-thumbnail";
			}

			// article_date
			$this->article_date->LinkCustomAttributes = "";
			$this->article_date->HrefValue = "";
			$this->article_date->TooltipValue = "";

			// author_id
			$this->author_id->LinkCustomAttributes = "";
			$this->author_id->HrefValue = "";
			$this->author_id->TooltipValue = "";

			// views
			$this->views->LinkCustomAttributes = "";
			$this->views->HrefValue = "";
			$this->views->TooltipValue = "";

			// public_title
			$this->public_title->LinkCustomAttributes = "";
			$this->public_title->HrefValue = "";
			$this->public_title->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, "articleslist.php", "", $this->TableVar, TRUE);
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
if (!isset($articles_delete)) $articles_delete = new carticles_delete();

// Page init
$articles_delete->Page_Init();

// Page main
$articles_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$articles_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = farticlesdelete = new ew_Form("farticlesdelete", "delete");

// Form_CustomValidate event
farticlesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
farticlesdelete.ValidateRequired = true;
<?php } else { ?>
farticlesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
farticlesdelete.Lists["x_category_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
farticlesdelete.Lists["x_author_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($articles_delete->Recordset = $articles_delete->LoadRecordset())
	$articles_deleteTotalRecs = $articles_delete->Recordset->RecordCount(); // Get record count
if ($articles_deleteTotalRecs <= 0) { // No record found, exit
	if ($articles_delete->Recordset)
		$articles_delete->Recordset->Close();
	$articles_delete->Page_Terminate("articleslist.php"); // Return to list
}
?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $articles_delete->ShowPageHeader(); ?>
<?php
$articles_delete->ShowMessage();
?>
<form name="farticlesdelete" id="farticlesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($articles_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $articles_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="articles">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($articles_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $articles->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($articles->id->Visible) { // id ?>
		<th><span id="elh_articles_id" class="articles_id"><?php echo $articles->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->category_id->Visible) { // category_id ?>
		<th><span id="elh_articles_category_id" class="articles_category_id"><?php echo $articles->category_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->name->Visible) { // name ?>
		<th><span id="elh_articles_name" class="articles_name"><?php echo $articles->name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->description->Visible) { // description ?>
		<th><span id="elh_articles_description" class="articles_description"><?php echo $articles->description->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->picpath->Visible) { // picpath ?>
		<th><span id="elh_articles_picpath" class="articles_picpath"><?php echo $articles->picpath->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->article_date->Visible) { // article_date ?>
		<th><span id="elh_articles_article_date" class="articles_article_date"><?php echo $articles->article_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->author_id->Visible) { // author_id ?>
		<th><span id="elh_articles_author_id" class="articles_author_id"><?php echo $articles->author_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->views->Visible) { // views ?>
		<th><span id="elh_articles_views" class="articles_views"><?php echo $articles->views->FldCaption() ?></span></th>
<?php } ?>
<?php if ($articles->public_title->Visible) { // public_title ?>
		<th><span id="elh_articles_public_title" class="articles_public_title"><?php echo $articles->public_title->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$articles_delete->RecCnt = 0;
$i = 0;
while (!$articles_delete->Recordset->EOF) {
	$articles_delete->RecCnt++;
	$articles_delete->RowCnt++;

	// Set row properties
	$articles->ResetAttrs();
	$articles->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$articles_delete->LoadRowValues($articles_delete->Recordset);

	// Render row
	$articles_delete->RenderRow();
?>
	<tr<?php echo $articles->RowAttributes() ?>>
<?php if ($articles->id->Visible) { // id ?>
		<td<?php echo $articles->id->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_id" class="articles_id">
<span<?php echo $articles->id->ViewAttributes() ?>>
<?php echo $articles->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->category_id->Visible) { // category_id ?>
		<td<?php echo $articles->category_id->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_category_id" class="articles_category_id">
<span<?php echo $articles->category_id->ViewAttributes() ?>>
<?php echo $articles->category_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->name->Visible) { // name ?>
		<td<?php echo $articles->name->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_name" class="articles_name">
<span<?php echo $articles->name->ViewAttributes() ?>>
<?php echo $articles->name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->description->Visible) { // description ?>
		<td<?php echo $articles->description->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_description" class="articles_description">
<span<?php echo $articles->description->ViewAttributes() ?>>
<?php echo $articles->description->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->picpath->Visible) { // picpath ?>
		<td<?php echo $articles->picpath->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_picpath" class="articles_picpath">
<span>
<?php echo ew_GetFileViewTag($articles->picpath, $articles->picpath->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($articles->article_date->Visible) { // article_date ?>
		<td<?php echo $articles->article_date->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_article_date" class="articles_article_date">
<span<?php echo $articles->article_date->ViewAttributes() ?>>
<?php echo $articles->article_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->author_id->Visible) { // author_id ?>
		<td<?php echo $articles->author_id->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_author_id" class="articles_author_id">
<span<?php echo $articles->author_id->ViewAttributes() ?>>
<?php echo $articles->author_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->views->Visible) { // views ?>
		<td<?php echo $articles->views->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_views" class="articles_views">
<span<?php echo $articles->views->ViewAttributes() ?>>
<?php echo $articles->views->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($articles->public_title->Visible) { // public_title ?>
		<td<?php echo $articles->public_title->CellAttributes() ?>>
<span id="el<?php echo $articles_delete->RowCnt ?>_articles_public_title" class="articles_public_title">
<span<?php echo $articles->public_title->ViewAttributes() ?>>
<?php echo $articles->public_title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$articles_delete->Recordset->MoveNext();
}
$articles_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $articles_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
farticlesdelete.Init();
</script>
<?php
$articles_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$articles_delete->Page_Terminate();
?>
