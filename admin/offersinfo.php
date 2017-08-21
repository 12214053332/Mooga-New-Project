<?php

// Global variable for table object
$offers = NULL;

//
// Table class for offers
//
class coffers extends cTable {
	var $id;
	var $user_id;
	var $offer_type_filed;
	var $name;
	var $item_type;
	var $item_brand;
	var $min_qty;
	var $price;
	var $description;
	var $country;
	var $states;
	var $cities;
	var $contact_name;
	var $contact_phone;
	var $contact_type;
	var $contact_email;
	var $picpath;
	var $createdtime;
	var $modifiedtime;
	var $deleted;
	var $views;
	var $verified_code;
	var $pending;
	var $country_1;
	var $num_send_sms;
	var $num_send_email;
	var $done;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'offers';
		$this->TableName = 'offers';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`offers`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('offers', 'offers', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// user_id
		$this->user_id = new cField('offers', 'offers', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;

		// offer_type_filed
		$this->offer_type_filed = new cField('offers', 'offers', 'x_offer_type_filed', 'offer_type_filed', '`offer_type_filed`', '`offer_type_filed`', 200, -1, FALSE, '`offer_type_filed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['offer_type_filed'] = &$this->offer_type_filed;

		// name
		$this->name = new cField('offers', 'offers', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['name'] = &$this->name;

		// item_type
		$this->item_type = new cField('offers', 'offers', 'x_item_type', 'item_type', '`item_type`', '`item_type`', 200, -1, FALSE, '`item_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['item_type'] = &$this->item_type;

		// item_brand
		$this->item_brand = new cField('offers', 'offers', 'x_item_brand', 'item_brand', '`item_brand`', '`item_brand`', 200, -1, FALSE, '`item_brand`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['item_brand'] = &$this->item_brand;

		// min_qty
		$this->min_qty = new cField('offers', 'offers', 'x_min_qty', 'min_qty', '`min_qty`', '`min_qty`', 3, -1, FALSE, '`min_qty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->min_qty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['min_qty'] = &$this->min_qty;

		// price
		$this->price = new cField('offers', 'offers', 'x_price', 'price', '`price`', '`price`', 131, -1, FALSE, '`price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['price'] = &$this->price;

		// description
		$this->description = new cField('offers', 'offers', 'x_description', 'description', '`description`', '`description`', 200, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['description'] = &$this->description;

		// country
		$this->country = new cField('offers', 'offers', 'x_country', 'country', '`country`', '`country`', 200, -1, FALSE, '`country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['country'] = &$this->country;

		// states
		$this->states = new cField('offers', 'offers', 'x_states', 'states', '`states`', '`states`', 200, -1, FALSE, '`states`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['states'] = &$this->states;

		// cities
		$this->cities = new cField('offers', 'offers', 'x_cities', 'cities', '`cities`', '`cities`', 200, -1, FALSE, '`cities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['cities'] = &$this->cities;

		// contact_name
		$this->contact_name = new cField('offers', 'offers', 'x_contact_name', 'contact_name', '`contact_name`', '`contact_name`', 200, -1, FALSE, '`contact_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['contact_name'] = &$this->contact_name;

		// contact_phone
		$this->contact_phone = new cField('offers', 'offers', 'x_contact_phone', 'contact_phone', '`contact_phone`', '`contact_phone`', 200, -1, FALSE, '`contact_phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['contact_phone'] = &$this->contact_phone;

		// contact_type
		$this->contact_type = new cField('offers', 'offers', 'x_contact_type', 'contact_type', '`contact_type`', '`contact_type`', 200, -1, FALSE, '`contact_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['contact_type'] = &$this->contact_type;

		// contact_email
		$this->contact_email = new cField('offers', 'offers', 'x_contact_email', 'contact_email', '`contact_email`', '`contact_email`', 200, -1, FALSE, '`contact_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['contact_email'] = &$this->contact_email;

		// picpath
		$this->picpath = new cField('offers', 'offers', 'x_picpath', 'picpath', '`picpath`', '`picpath`', 200, -1, FALSE, '`picpath`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['picpath'] = &$this->picpath;

		// createdtime
		$this->createdtime = new cField('offers', 'offers', 'x_createdtime', 'createdtime', '`createdtime`', 'DATE_FORMAT(`createdtime`, \'%Y/%m/%d\')', 135, 5, FALSE, '`createdtime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->createdtime->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['createdtime'] = &$this->createdtime;

		// modifiedtime
		$this->modifiedtime = new cField('offers', 'offers', 'x_modifiedtime', 'modifiedtime', '`modifiedtime`', 'DATE_FORMAT(`modifiedtime`, \'%Y/%m/%d\')', 135, 5, FALSE, '`modifiedtime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->modifiedtime->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateYMD"));
		$this->fields['modifiedtime'] = &$this->modifiedtime;

		// deleted
		$this->deleted = new cField('offers', 'offers', 'x_deleted', 'deleted', '`deleted`', '`deleted`', 3, -1, FALSE, '`deleted`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->deleted->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['deleted'] = &$this->deleted;

		// views
		$this->views = new cField('offers', 'offers', 'x_views', 'views', '`views`', '`views`', 3, -1, FALSE, '`views`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->views->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['views'] = &$this->views;

		// verified_code
		$this->verified_code = new cField('offers', 'offers', 'x_verified_code', 'verified_code', '`verified_code`', '`verified_code`', 3, -1, FALSE, '`verified_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->verified_code->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['verified_code'] = &$this->verified_code;

		// pending
		$this->pending = new cField('offers', 'offers', 'x_pending', 'pending', '`pending`', '`pending`', 3, -1, FALSE, '`pending`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pending->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pending'] = &$this->pending;

		// country_1
		$this->country_1 = new cField('offers', 'offers', 'x_country_1', 'country_1', '`country_1`', '`country_1`', 200, -1, FALSE, '`country_1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['country_1'] = &$this->country_1;

		// num_send_sms
		$this->num_send_sms = new cField('offers', 'offers', 'x_num_send_sms', 'num_send_sms', '`num_send_sms`', '`num_send_sms`', 3, -1, FALSE, '`num_send_sms`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->num_send_sms->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['num_send_sms'] = &$this->num_send_sms;

		// num_send_email
		$this->num_send_email = new cField('offers', 'offers', 'x_num_send_email', 'num_send_email', '`num_send_email`', '`num_send_email`', 3, -1, FALSE, '`num_send_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->num_send_email->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['num_send_email'] = &$this->num_send_email;

		// done
		$this->done = new cField('offers', 'offers', 'x_done', 'done', '`done`', '`done`', 3, -1, FALSE, '`done`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->done->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['done'] = &$this->done;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`offers`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "offerslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "offerslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("offersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("offersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "offersadd.php?" . $this->UrlParm($parm);
		else
			$url = "offersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("offersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("offersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("offersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			$arKeys[] = $isPost ? ew_StripSlashes(@$_POST["id"]) : ew_StripSlashes(@$_GET["id"]); // id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->EditAttrs["class"] = "form-control";
		$this->user_id->EditCustomAttributes = "";
		$this->user_id->EditValue = $this->user_id->CurrentValue;
		$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());

		// offer_type_filed
		$this->offer_type_filed->EditAttrs["class"] = "form-control";
		$this->offer_type_filed->EditCustomAttributes = "";
		$this->offer_type_filed->EditValue = $this->offer_type_filed->CurrentValue;
		$this->offer_type_filed->PlaceHolder = ew_RemoveHtml($this->offer_type_filed->FldCaption());

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// item_type
		$this->item_type->EditAttrs["class"] = "form-control";
		$this->item_type->EditCustomAttributes = "";
		$this->item_type->EditValue = $this->item_type->CurrentValue;
		$this->item_type->PlaceHolder = ew_RemoveHtml($this->item_type->FldCaption());

		// item_brand
		$this->item_brand->EditAttrs["class"] = "form-control";
		$this->item_brand->EditCustomAttributes = "";
		$this->item_brand->EditValue = $this->item_brand->CurrentValue;
		$this->item_brand->PlaceHolder = ew_RemoveHtml($this->item_brand->FldCaption());

		// min_qty
		$this->min_qty->EditAttrs["class"] = "form-control";
		$this->min_qty->EditCustomAttributes = "";
		$this->min_qty->EditValue = $this->min_qty->CurrentValue;
		$this->min_qty->PlaceHolder = ew_RemoveHtml($this->min_qty->FldCaption());

		// price
		$this->price->EditAttrs["class"] = "form-control";
		$this->price->EditCustomAttributes = "";
		$this->price->EditValue = $this->price->CurrentValue;
		$this->price->PlaceHolder = ew_RemoveHtml($this->price->FldCaption());
		if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) $this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -1, -2, 0);

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

		// country
		$this->country->EditAttrs["class"] = "form-control";
		$this->country->EditCustomAttributes = "";
		$this->country->EditValue = $this->country->CurrentValue;
		$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

		// states
		$this->states->EditAttrs["class"] = "form-control";
		$this->states->EditCustomAttributes = "";
		$this->states->EditValue = $this->states->CurrentValue;
		$this->states->PlaceHolder = ew_RemoveHtml($this->states->FldCaption());

		// cities
		$this->cities->EditAttrs["class"] = "form-control";
		$this->cities->EditCustomAttributes = "";
		$this->cities->EditValue = $this->cities->CurrentValue;
		$this->cities->PlaceHolder = ew_RemoveHtml($this->cities->FldCaption());

		// contact_name
		$this->contact_name->EditAttrs["class"] = "form-control";
		$this->contact_name->EditCustomAttributes = "";
		$this->contact_name->EditValue = $this->contact_name->CurrentValue;
		$this->contact_name->PlaceHolder = ew_RemoveHtml($this->contact_name->FldCaption());

		// contact_phone
		$this->contact_phone->EditAttrs["class"] = "form-control";
		$this->contact_phone->EditCustomAttributes = "";
		$this->contact_phone->EditValue = $this->contact_phone->CurrentValue;
		$this->contact_phone->PlaceHolder = ew_RemoveHtml($this->contact_phone->FldCaption());

		// contact_type
		$this->contact_type->EditAttrs["class"] = "form-control";
		$this->contact_type->EditCustomAttributes = "";
		$this->contact_type->EditValue = $this->contact_type->CurrentValue;
		$this->contact_type->PlaceHolder = ew_RemoveHtml($this->contact_type->FldCaption());

		// contact_email
		$this->contact_email->EditAttrs["class"] = "form-control";
		$this->contact_email->EditCustomAttributes = "";
		$this->contact_email->EditValue = $this->contact_email->CurrentValue;
		$this->contact_email->PlaceHolder = ew_RemoveHtml($this->contact_email->FldCaption());

		// picpath
		$this->picpath->EditAttrs["class"] = "form-control";
		$this->picpath->EditCustomAttributes = "";
		$this->picpath->EditValue = $this->picpath->CurrentValue;
		$this->picpath->PlaceHolder = ew_RemoveHtml($this->picpath->FldCaption());

		// createdtime
		$this->createdtime->EditAttrs["class"] = "form-control";
		$this->createdtime->EditCustomAttributes = "";
		$this->createdtime->EditValue = ew_FormatDateTime($this->createdtime->CurrentValue, 5);
		$this->createdtime->PlaceHolder = ew_RemoveHtml($this->createdtime->FldCaption());

		// modifiedtime
		$this->modifiedtime->EditAttrs["class"] = "form-control";
		$this->modifiedtime->EditCustomAttributes = "";
		$this->modifiedtime->EditValue = ew_FormatDateTime($this->modifiedtime->CurrentValue, 5);
		$this->modifiedtime->PlaceHolder = ew_RemoveHtml($this->modifiedtime->FldCaption());

		// deleted
		$this->deleted->EditAttrs["class"] = "form-control";
		$this->deleted->EditCustomAttributes = "";
		$this->deleted->EditValue = $this->deleted->CurrentValue;
		$this->deleted->PlaceHolder = ew_RemoveHtml($this->deleted->FldCaption());

		// views
		$this->views->EditAttrs["class"] = "form-control";
		$this->views->EditCustomAttributes = "";
		$this->views->EditValue = $this->views->CurrentValue;
		$this->views->PlaceHolder = ew_RemoveHtml($this->views->FldCaption());

		// verified_code
		$this->verified_code->EditAttrs["class"] = "form-control";
		$this->verified_code->EditCustomAttributes = "";
		$this->verified_code->EditValue = $this->verified_code->CurrentValue;
		$this->verified_code->PlaceHolder = ew_RemoveHtml($this->verified_code->FldCaption());

		// pending
		$this->pending->EditAttrs["class"] = "form-control";
		$this->pending->EditCustomAttributes = "";
		$this->pending->EditValue = $this->pending->CurrentValue;
		$this->pending->PlaceHolder = ew_RemoveHtml($this->pending->FldCaption());

		// country_1
		$this->country_1->EditAttrs["class"] = "form-control";
		$this->country_1->EditCustomAttributes = "";
		$this->country_1->EditValue = $this->country_1->CurrentValue;
		$this->country_1->PlaceHolder = ew_RemoveHtml($this->country_1->FldCaption());

		// num_send_sms
		$this->num_send_sms->EditAttrs["class"] = "form-control";
		$this->num_send_sms->EditCustomAttributes = "";
		$this->num_send_sms->EditValue = $this->num_send_sms->CurrentValue;
		$this->num_send_sms->PlaceHolder = ew_RemoveHtml($this->num_send_sms->FldCaption());

		// num_send_email
		$this->num_send_email->EditAttrs["class"] = "form-control";
		$this->num_send_email->EditCustomAttributes = "";
		$this->num_send_email->EditValue = $this->num_send_email->CurrentValue;
		$this->num_send_email->PlaceHolder = ew_RemoveHtml($this->num_send_email->FldCaption());

		// done
		$this->done->EditAttrs["class"] = "form-control";
		$this->done->EditCustomAttributes = "";
		$this->done->EditValue = $this->done->CurrentValue;
		$this->done->PlaceHolder = ew_RemoveHtml($this->done->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
					if ($this->offer_type_filed->Exportable) $Doc->ExportCaption($this->offer_type_filed);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->item_type->Exportable) $Doc->ExportCaption($this->item_type);
					if ($this->item_brand->Exportable) $Doc->ExportCaption($this->item_brand);
					if ($this->min_qty->Exportable) $Doc->ExportCaption($this->min_qty);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->states->Exportable) $Doc->ExportCaption($this->states);
					if ($this->cities->Exportable) $Doc->ExportCaption($this->cities);
					if ($this->contact_name->Exportable) $Doc->ExportCaption($this->contact_name);
					if ($this->contact_phone->Exportable) $Doc->ExportCaption($this->contact_phone);
					if ($this->contact_type->Exportable) $Doc->ExportCaption($this->contact_type);
					if ($this->contact_email->Exportable) $Doc->ExportCaption($this->contact_email);
					if ($this->picpath->Exportable) $Doc->ExportCaption($this->picpath);
					if ($this->createdtime->Exportable) $Doc->ExportCaption($this->createdtime);
					if ($this->modifiedtime->Exportable) $Doc->ExportCaption($this->modifiedtime);
					if ($this->deleted->Exportable) $Doc->ExportCaption($this->deleted);
					if ($this->views->Exportable) $Doc->ExportCaption($this->views);
					if ($this->verified_code->Exportable) $Doc->ExportCaption($this->verified_code);
					if ($this->pending->Exportable) $Doc->ExportCaption($this->pending);
					if ($this->country_1->Exportable) $Doc->ExportCaption($this->country_1);
					if ($this->num_send_sms->Exportable) $Doc->ExportCaption($this->num_send_sms);
					if ($this->num_send_email->Exportable) $Doc->ExportCaption($this->num_send_email);
					if ($this->done->Exportable) $Doc->ExportCaption($this->done);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
					if ($this->offer_type_filed->Exportable) $Doc->ExportCaption($this->offer_type_filed);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->item_type->Exportable) $Doc->ExportCaption($this->item_type);
					if ($this->item_brand->Exportable) $Doc->ExportCaption($this->item_brand);
					if ($this->min_qty->Exportable) $Doc->ExportCaption($this->min_qty);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->states->Exportable) $Doc->ExportCaption($this->states);
					if ($this->cities->Exportable) $Doc->ExportCaption($this->cities);
					if ($this->contact_name->Exportable) $Doc->ExportCaption($this->contact_name);
					if ($this->contact_phone->Exportable) $Doc->ExportCaption($this->contact_phone);
					if ($this->contact_type->Exportable) $Doc->ExportCaption($this->contact_type);
					if ($this->contact_email->Exportable) $Doc->ExportCaption($this->contact_email);
					if ($this->picpath->Exportable) $Doc->ExportCaption($this->picpath);
					if ($this->createdtime->Exportable) $Doc->ExportCaption($this->createdtime);
					if ($this->modifiedtime->Exportable) $Doc->ExportCaption($this->modifiedtime);
					if ($this->deleted->Exportable) $Doc->ExportCaption($this->deleted);
					if ($this->views->Exportable) $Doc->ExportCaption($this->views);
					if ($this->verified_code->Exportable) $Doc->ExportCaption($this->verified_code);
					if ($this->pending->Exportable) $Doc->ExportCaption($this->pending);
					if ($this->country_1->Exportable) $Doc->ExportCaption($this->country_1);
					if ($this->num_send_sms->Exportable) $Doc->ExportCaption($this->num_send_sms);
					if ($this->num_send_email->Exportable) $Doc->ExportCaption($this->num_send_email);
					if ($this->done->Exportable) $Doc->ExportCaption($this->done);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
						if ($this->offer_type_filed->Exportable) $Doc->ExportField($this->offer_type_filed);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->item_type->Exportable) $Doc->ExportField($this->item_type);
						if ($this->item_brand->Exportable) $Doc->ExportField($this->item_brand);
						if ($this->min_qty->Exportable) $Doc->ExportField($this->min_qty);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->states->Exportable) $Doc->ExportField($this->states);
						if ($this->cities->Exportable) $Doc->ExportField($this->cities);
						if ($this->contact_name->Exportable) $Doc->ExportField($this->contact_name);
						if ($this->contact_phone->Exportable) $Doc->ExportField($this->contact_phone);
						if ($this->contact_type->Exportable) $Doc->ExportField($this->contact_type);
						if ($this->contact_email->Exportable) $Doc->ExportField($this->contact_email);
						if ($this->picpath->Exportable) $Doc->ExportField($this->picpath);
						if ($this->createdtime->Exportable) $Doc->ExportField($this->createdtime);
						if ($this->modifiedtime->Exportable) $Doc->ExportField($this->modifiedtime);
						if ($this->deleted->Exportable) $Doc->ExportField($this->deleted);
						if ($this->views->Exportable) $Doc->ExportField($this->views);
						if ($this->verified_code->Exportable) $Doc->ExportField($this->verified_code);
						if ($this->pending->Exportable) $Doc->ExportField($this->pending);
						if ($this->country_1->Exportable) $Doc->ExportField($this->country_1);
						if ($this->num_send_sms->Exportable) $Doc->ExportField($this->num_send_sms);
						if ($this->num_send_email->Exportable) $Doc->ExportField($this->num_send_email);
						if ($this->done->Exportable) $Doc->ExportField($this->done);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
						if ($this->offer_type_filed->Exportable) $Doc->ExportField($this->offer_type_filed);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->item_type->Exportable) $Doc->ExportField($this->item_type);
						if ($this->item_brand->Exportable) $Doc->ExportField($this->item_brand);
						if ($this->min_qty->Exportable) $Doc->ExportField($this->min_qty);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->states->Exportable) $Doc->ExportField($this->states);
						if ($this->cities->Exportable) $Doc->ExportField($this->cities);
						if ($this->contact_name->Exportable) $Doc->ExportField($this->contact_name);
						if ($this->contact_phone->Exportable) $Doc->ExportField($this->contact_phone);
						if ($this->contact_type->Exportable) $Doc->ExportField($this->contact_type);
						if ($this->contact_email->Exportable) $Doc->ExportField($this->contact_email);
						if ($this->picpath->Exportable) $Doc->ExportField($this->picpath);
						if ($this->createdtime->Exportable) $Doc->ExportField($this->createdtime);
						if ($this->modifiedtime->Exportable) $Doc->ExportField($this->modifiedtime);
						if ($this->deleted->Exportable) $Doc->ExportField($this->deleted);
						if ($this->views->Exportable) $Doc->ExportField($this->views);
						if ($this->verified_code->Exportable) $Doc->ExportField($this->verified_code);
						if ($this->pending->Exportable) $Doc->ExportField($this->pending);
						if ($this->country_1->Exportable) $Doc->ExportField($this->country_1);
						if ($this->num_send_sms->Exportable) $Doc->ExportField($this->num_send_sms);
						if ($this->num_send_email->Exportable) $Doc->ExportField($this->num_send_email);
						if ($this->done->Exportable) $Doc->ExportField($this->done);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
