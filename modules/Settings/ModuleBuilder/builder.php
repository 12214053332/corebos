<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
* Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
* file except in compliance with the License. You can redistribute it and/or modify it
* under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
* granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
* the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
* warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
* applicable law or agreed to in writing, software distributed under the License is
* distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
* either express or implied. See the License for the specific language governing
* permissions and limitations under the License. You may obtain a copy of the License
* at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
*************************************************************************************************/

class ModuleBuilder {

	public $id = '';
	public $mode = '';
	public $column_data = array();
	private $path = 'modules/Settings/ModuleBuilder/modules/';

	private $typeofdata = array(
		'1' => array('VARCHAR(200)', 'V~'),
		'21' => array('VARCHAR(50)', 'V~'),
		'19' => array('VARCHAR(255)', 'V~'),
		'4' => array('VARCHAR(255)', 'V~'),
		'5' => array('DATE', 'D~'),
		'50' => array('DATETIME', 'DT~'),
		'14' => array('TIME', 'T~'),
		'7' => array('INT(100)', 'V~'),
		'71' => array('DECIMAL(10,2)', 'NN~'),
		'9' => array('VARCHAR(30)', 'V~'),
		'10' => array('INT(40)', 'V~'),
		'101' => array('VARCHAR(40)', 'V~'),
		'11' => array('VARCHAR(60)', 'V~'),
		'13' => array('VARCHAR(100)', 'V~'),
		'17' => array('VARCHAR(100)', 'V~'),
		'56' => array('VARCHAR(5)', 'V~'),
		'69' => array('VARCHAR(255)', 'V~'),
		'85' => array('VARCHAR(100)', 'V~'),
		'15' => array('VARCHAR(100)', 'V~'),
		'16' => array('VARCHAR(100)', 'V~'),
		'1613' => array('VARCHAR(100)', 'V~'),
		'1024' => array('VARCHAR(200)', 'V~'),
		'33' => array('VARCHAR(200)', 'V~'),
		'3313' => array('VARCHAR(200)', 'V~'),
	);

	private $defaultFields = array(
		'assigned_user_id' => array(
			'columnname' => 'smownerid',
			'fieldlabel' => 'Assigned To',
			'uitype' => '53',
			'readonly' => '1',
			'presence' => '0',
			'typeofdata' => 'V~M',
			'masseditable' => '0',
			'quickcreate' => '0',
			'displaytype' => '1',
		),
		'created_user_id' => array(
			'columnname' => 'smcreatorid',
			'fieldlabel' => 'Created By',
			'uitype' => '52',
			'readonly' => '1',
			'presence' => '0',
			'typeofdata' => 'V~O',
			'masseditable' => '0',
			'quickcreate' => '3',
			'displaytype' => '2',
		),
		'createdtime' => array(
			'columnname' => 'createdtime',
			'fieldlabel' => 'Created Time',
			'uitype' => '70',
			'presence' => '0',
			'typeofdata' => 'DT~O',
			'readonly' => '1',
			'masseditable' => '0',
			'quickcreate' => '3',
			'displaytype' => '2',
		),
		'modifiedtime' => array(
			'columnname' => 'modifiedtime',
			'fieldlabel' => 'Modified Time',
			'uitype' => '70',
			'presence' => '0',
			'typeofdata' => 'DT~O',
			'readonly' => '1',
			'masseditable' => '0',
			'quickcreate' => '3',
			'displaytype' => '2',
		),
		'description' => array(
			'columnname' => 'description',
			'fieldlabel' => 'Description',
			'uitype' => '19',
			'presence' => '2',
			'typeofdata' => 'V~O',
			'readonly' => '1',
			'masseditable' => '1',
			'quickcreate' => '1',
			'displaytype' => '1',
		),
	);

	private $files = array(
		'vtlib/ModuleDir/CallRelatedList.php',
		'vtlib/ModuleDir/CustomView.php',
		'vtlib/ModuleDir/Delete.php',
		'vtlib/ModuleDir/DetailView.php',
		'vtlib/ModuleDir/DetailViewAjax.php',
		'vtlib/ModuleDir/EditView.php',
		'vtlib/ModuleDir/ExportRecords.php',
		'vtlib/ModuleDir/FindDuplicateRecords.php',
		'vtlib/ModuleDir/Import.php',
		'vtlib/ModuleDir/index.php',
		'vtlib/ModuleDir/ListView.php',
		'vtlib/ModuleDir/ListViewPagging.php',
		'vtlib/ModuleDir/MassEdit.php',
		'vtlib/ModuleDir/MassEditSave.php',
		'vtlib/ModuleDir/ModuleFile.js',
		'vtlib/ModuleDir/ModuleFile.php',
		'vtlib/ModuleDir/ModuleFileAjax.php',
		'vtlib/ModuleDir/Popup.php',
		'vtlib/ModuleDir/ProcessDuplicates.php',
		'vtlib/ModuleDir/QuickCreate.php',
		'vtlib/ModuleDir/Save.php',
		'vtlib/ModuleDir/Settings.php',
		'vtlib/ModuleDir/TagCloud.php',
		'vtlib/ModuleDir/UnifiedSearch.php',
		'vtlib/ModuleDir/updateRelations.php',
		'language' => array(
			'de_de.lang.php',
			'en_gb.lang.php',
			'en_us.lang.php',
			'es_es.lang.php',
			'es_mx.lang.php',
			'fr_fr.lang.php',
			'hu_hu.lang.php',
			'it_it.lang.php',
			'nl_nl.lang.php',
			'pt_br.lang.php',
			'ro_ro.lang.php',
		)
	);

	public function save($step) {
		global $adb, $current_user;
		if ($step == 1) {
			if ($this->mode == 'edit') {
				$adb->pquery('UPDATE vtiger_modulebuilder SET modulebuilder_name=?, modulebuilder_label=?, modulebuilder_parent=?, icon=?, sharingaccess=?, merge=?, import=?, export=? WHERE modulebuilderid=?', array(
					$this->column_data['modulename'],
					$this->column_data['modulelabel'],
					$this->column_data['parentmenu'],
					$this->column_data['moduleicon'],
					$this->column_data['sharingaccess'],
					$this->column_data['merge'],
					$this->column_data['import'],
					$this->column_data['export'],
					$this->id
				));
			} else {
				$adb->pquery('INSERT INTO vtiger_modulebuilder (modulebuilder_name, modulebuilder_label, modulebuilder_parent, status, icon, sharingaccess, merge, import, export) VALUES(?,?,?,?,?,?,?,?,?)', array(
					$this->column_data['modulename'],
					$this->column_data['modulelabel'],
					$this->column_data['parentmenu'],
					'active',
					$this->column_data['moduleicon'],
					$this->column_data['sharingaccess'],
					$this->column_data['merge'],
					$this->column_data['import'],
					$this->column_data['export']
				));
				$lastID = $adb->getLastInsertID();
				$adb->pquery('INSERT INTO vtiger_modulebuilder_name (modulebuilderid, date, completed, userid) VALUES (?,?,?,?)', array($lastID,date('Y-m-d'),'20',$current_user->id));
				$cookie_name = "ModuleBuilderID";
				setcookie($cookie_name, $lastID, time() + ((86400 * 30) * 7), "/");
			}
		} elseif ($step == 2) {
			foreach ($this->column_data['blocks'] as $key => $value) {
				if ($value != "") {
					$adb->pquery('INSERT INTO vtiger_modulebuilder_blocks (blocks_label, moduleid) VALUES (?,?)', array($value,$this->id));
				}
			}
		} elseif ($step == 3) {
			if (!isset($this->column_data['fieldsid'])) {
				$adb->pquery('INSERT INTO vtiger_modulebuilder_fields (blockid, moduleid,fieldname,uitype,columnname,tablename,fieldlabel,presence,sequence,typeofdata,quickcreate,displaytype,masseditable,relatedmodules, picklistvalues) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array(
					$this->column_data['blockid'],
					$this->id,
					$this->column_data['fieldname'],
					$this->column_data['uitype'],
					$this->column_data['columnname'],
					strtolower('vtiger_'.$this->column_data['modulename']),
					$this->column_data['fieldlabel'],
					$this->column_data['presence'],
					$this->column_data['sequence'],
					$this->column_data['typeofdata'],
					$this->column_data['quickcreate'],
					$this->column_data['displaytype'],
					$this->column_data['masseditable'],
					$this->column_data['relatedmodules'],
					$this->column_data['picklistvalues'],
				));
			} else {
				$adb->pquery('UPDATE vtiger_modulebuilder_fields SET fieldname=?,columnname=?,fieldlabel=?,uitype=?,tablename=?,presence=?,sequence=?,typeofdata=?,quickcreate=?,displaytype=?,masseditable=?,relatedmodules=?, picklistvalues=? WHERE fieldsid=? AND blockid=? AND moduleid=?', array(
					$this->column_data['fieldname'],
					$this->column_data['columnname'],
					$this->column_data['fieldlabel'],
					$this->column_data['uitype'],
					strtolower('vtiger_'.$this->column_data['modulename']),
					$this->column_data['presence'],
					$this->column_data['sequence'],
					$this->column_data['typeofdata'],
					$this->column_data['quickcreate'],
					$this->column_data['displaytype'],
					$this->column_data['masseditable'],
					$this->column_data['relatedmodules'],
					$this->column_data['picklistvalues'],
					$this->column_data['fieldsid'],
					$this->column_data['blockid'],
					$this->id
				));
			}
		} elseif ($step == 4) {
			if (isset($this->column_data['customview']['viewname']) && $this->column_data['customview']['viewname'] != '') {
				$viewname = $this->column_data['customview']['viewname'];
				$setdefault = (String)$this->column_data['customview']['setdefault'];
				$fields = substr((String)$this->column_data['customview']['fields'], 0, -1);
				$setmetrics = 'false';
				$adb->pquery('INSERT INTO vtiger_modulebuilder_customview (viewname, setdefault, setmetrics, fields, moduleid) VALUES(?,?,?,?,?)', array($viewname,$setdefault,$setmetrics,$fields,$this->id));
			}
		} elseif ($step == 5) {
			if (isset($this->column_data['name']) && $this->column_data['name'] != '') {
				$adb->pquery('INSERT INTO vtiger_modulebuilder_relatedlists (function, label, actions, relatedmodule, moduleid) VALUES(?,?,?,?,?)', array(
					$this->column_data['name'],
					$this->column_data['label'],
					$this->column_data['actions'],
					$this->column_data['relatedmodule'],
					$this->id
				));
			}
		}
		if (!$adb->database->_errorMsg) {
			return array('saved' => true);
		}
		return array('error' => $adb->database->_errorMsg);
	}

	public function retrieve($step, $id) {
		return $this->loadValues($step, $id);
	}

	public function checkForModule($modulename) {
		global $adb, $current_user;
		$sql = 'SELECT * FROM vtiger_tab WHERE name=?';
		$data = $adb->pquery($sql, array($modulename));
		if ($adb->num_rows($data) > 0) {
			return 1;
		}
		return 0;
	}

	public function loadModules($page, $perPage) {
		global $adb, $current_user, $mod_strings;
		$limit = ($page-1) * $perPage;
		$limitSql = ' LIMIT '.$limit.','.$perPage;
		$list_query = 'SELECT vtiger_modulebuilder.modulebuilder_name as modulebuilder_name, mb.date as date, mb.completed as completed, vtiger_modulebuilder.modulebuilderid as moduleid
			FROM vtiger_modulebuilder_name as mb
			JOIN vtiger_modulebuilder ON mb.modulebuilderid=vtiger_modulebuilder.modulebuilderid 
			WHERE userid=?';
		$modulesSql = $adb->pquery($list_query, array($current_user->id));
		$numOfRows = $adb->num_rows($modulesSql);
		$modules = $adb->pquery($list_query.$limitSql, array($current_user->id));
		$moduleLists = array();
		while ($row = $modules->FetchRow()) {
			$modInfo = array();
			$modInfo['modulebuilder_name'] = $row['modulebuilder_name'];
			$modInfo['moduleid'] = $row['moduleid'];
			$modInfo['date'] = $row['date'];
			if ($row['completed'] == 'Completed') {
				$modInfo['completed'] = $mod_strings['LBL_MB_COMPLETED'];
				$modInfo['export'] = 'Export';
			} else {
				$modInfo['completed'] = $row['completed'].'%';
				$modInfo['export'] = 'Start editing';
			}
			array_push($moduleLists, $modInfo);
		}
		if ($numOfRows > 0) {
			$entries_list = array(
				'data' => array(
					'contents' => $moduleLists,
					'pagination' => array(
						'page' => (int)$page,
						'totalCount' => (int)$numOfRows,
					),
				),
				'result' => true,
			);
		} else {
			$entries_list = array(
				'data' => array(
					'contents' => array(),
					'pagination' => array(
						'page' => 1,
						'totalCount' => 0,
					),
				),
				'result' => false,
			);
		}
		return $entries_list;
	}

	public function loadBlocks() {
		global $adb, $current_user;
		$blocks = $adb->pquery('SELECT blocksid, blocks_label FROM vtiger_modulebuilder LEFT JOIN vtiger_modulebuilder_blocks ON modulebuilderid=moduleid WHERE status=? AND modulebuilderid=?', array(
			'active',
			$_COOKIE['ModuleBuilderID']
		));
		$blockname = array();
		while ($row = $blocks->FetchRow()) {
			$blockInfo = array();
			$blockInfo['blocksid'] = $row['blocksid'];
			$blockInfo['blocks_label'] = $row['blocks_label'];
			array_push($blockname, $blockInfo);
		}
		return $blockname;
	}

	public function loadFields() {
		global $adb, $current_user;
		$field = $adb->pquery('SELECT fieldsid, fieldname FROM vtiger_modulebuilder_fields WHERE moduleid=?', array(
			$_COOKIE['ModuleBuilderID']
		));
		$fields = array();
		while ($row = $field->FetchRow()) {
			$fldInfo = array();
			$fldInfo['fieldsid'] = $row['fieldsid'];
			$fldInfo['fieldname'] = $row['fieldname'];
			array_push($fields, $fldInfo);
		}
		return $fields;
	}

	public function autocompleteName($query) {
		global $adb, $current_user;
		if ($query == '' || strlen($query) < 2) {
			return array();
		}
		$function = $adb->pquery('SELECT DISTINCT name FROM vtiger_relatedlists WHERE name LIKE "%'.$query.'%" LIMIT 5', array());
		$name = array();
		while ($row = $function->FetchRow()) {
			$nameInfo = array();
			$nameInfo['name'] = $row['name'];
			array_push($name, $nameInfo);
		}
		return $name;
	}

	public function autocompleteModule($query) {
		global $adb, $current_user;
		if ($query == '' || strlen($query) < 2) {
			return array();
		}
		$modId = vtlib_purify($_COOKIE['ModuleBuilderID']);
		$function = $adb->pquery("SELECT relatedmodules FROM vtiger_modulebuilder_fields WHERE uitype = 10 AND moduleid = ? ORDER BY fieldsid DESC", array($modId));
		$module = array();
		while ($row = $function->FetchRow()) {
			$relatedmodules = explode(',', $row['relatedmodules']);
			foreach ($relatedmodules as $key => $value) {
				if (strpos(strtolower($value), strtolower($query)) !== false) {
					array_push($module, $value);
				}
			}
		}
		return array_unique($module);
	}

	public function getCountFilter($modName) {
		global $adb;
		$sql = $adb->pquery("SELECT modulebuilderid FROM vtiger_modulebuilder WHERE modulebuilder_name=?", array($modName));
		while ($row = $sql->FetchRow()) {
			$modulebuilderid = $row['modulebuilderid'];
		}
		$getCnt = $adb->pquery("SELECT * FROM vtiger_modulebuilder_customview WHERE moduleid=?", array($modulebuilderid));
		$num_rows = $adb->num_rows($getCnt);
		return $num_rows;
	}

	public function loadValues($step, $moduleId) {
		global $adb;
		if ($moduleId == 0 || $moduleId == 'undefined') {
			$moduleid = $_COOKIE['ModuleBuilderID'];
			//var_dump($moduleid); // id + 1
		} else {
			$cookie_name = "ModuleBuilderID";
			$cookie_value = $moduleId;
			setcookie($cookie_name, $cookie_value, time() + ((86400 * 30) * 7), "/");
			$moduleid = $moduleId;
		}
		if ($step == 1) {
			$modSql = $adb->pquery('SELECT * FROM vtiger_modulebuilder WHERE modulebuilderid=? AND status=?', array(
				$moduleid,
				'active'
			));
			$module = array();
			$module['name'] = $adb->query_result($modSql, 0, 'modulebuilder_name');
			$module['label'] = $adb->query_result($modSql, 0, 'modulebuilder_label');
			$module['parent'] = $adb->query_result($modSql, 0, 'modulebuilder_parent');
			$module['icon'] = $adb->query_result($modSql, 0, 'icon');
			$module['sharingaccess'] = $adb->query_result($modSql, 0, 'sharingaccess');
			$module['actions'] = array(
				'merge' => $adb->query_result($modSql, 0, 'merge'),
				'import' => $adb->query_result($modSql, 0, 'import'),
				'export' => $adb->query_result($modSql, 0, 'export'),
			);
			return $module;
		} elseif ($step == 2) {
			$blockSql = $adb->pquery('SELECT * FROM vtiger_modulebuilder_blocks WHERE moduleid=?', array(
				$moduleid
			));
			$block = array();
			while ($row = $blockSql->FetchRow()) {
				$blockInfo = array();
				$blockInfo['blocksid'] = $row['blocksid'];
				$blockInfo['blocks_label'] = $row['blocks_label'];
				array_push($block, $blockInfo);
			}
			return $block;
		} elseif ($step == 3) {
			$fieldsdb = $adb->pquery('SELECT * FROM `vtiger_modulebuilder_fields` WHERE moduleid=?', array(
				$moduleid
			));
			$numOfRows = $adb->num_rows($fieldsdb);
			$fieldlst = array();
			while ($row = $fieldsdb->FetchRow()) {
				$fieldsInfo = array();
				$blockid = $row['blockid'];
				$blocksql = $adb->pquery('SELECT * FROM vtiger_modulebuilder_blocks WHERE blocksid=?', array($blockid));
				$blockname = $adb->query_result($blocksql, 0, 'blocks_label');
				$fieldsInfo['fieldsid'] = $row['fieldsid'];
				$fieldsInfo['fieldname'] = $row['fieldname'];
				$fieldsInfo['columnname'] = $row['columnname'];
				$fieldsInfo['fieldlabel'] = $row['fieldlabel'];
				$fieldsInfo['entityidentifier'] = $row['entityidentifier'];
				$fieldsInfo['relatedmodules'] = $row['relatedmodules'];
				$fieldsInfo['uitype'] = $row['uitype'];
				$fieldsInfo['presence'] = $row['presence'];
				$fieldsInfo['typeofdata'] = $row['typeofdata'];
				$fieldsInfo['masseditable'] = $row['masseditable'];
				$fieldsInfo['quickcreate'] = $row['quickcreate'];
				$fieldsInfo['picklistvalues'] = $row['picklistvalues'];
				$fieldsInfo['blockname'] = $blockname;
				array_push($fieldlst, $fieldsInfo);
			}
			if ($numOfRows > 0) {
				$entries_list = array(
					'data' => array(
						'contents' => $fieldlst,
						'pagination' => array(
							'page' => 1,
							'totalCount' => (int)$numOfRows,
						),
					),
					'result' => true,
				);
			} else {
				$entries_list = array(
					'data' => array(
						'contents' => array(),
						'pagination' => array(
							'page' => 1,
							'totalCount' => 0,
						),
					),
					'result' => false,
				);
			}
			return $entries_list;
		} elseif ($step == 4) {
			$viewSql = $adb->pquery('SELECT * FROM vtiger_modulebuilder_customview WHERE moduleid=?', array(
				$moduleid
			));
			$numOfRows = $adb->num_rows($viewSql);
			$view = array();
			while ($row = $viewSql->FetchRow()) {
				$viewInfo = array();
				$customviewid = $row['customviewid'];
				$viewname = $row['viewname'];
				$setdefault = $row['setdefault'];
				$fields = $row['fields'];
				$fields = explode(',', $fields);
				$fieldInfo = array();
				foreach ($fields as $key => $value) {
					$fieldSql = $adb->pquery('SELECT fieldname FROM vtiger_modulebuilder_fields WHERE fieldsid=?', array($value));
					$fieldname = $adb->query_result($fieldSql, 0, 'fieldname');
					array_push($fieldInfo, $fieldname);
				}
				$viewInfo['customviewid'] = $customviewid;
				$viewInfo['viewname'] = $viewname;
				$viewInfo['setdefault'] = $setdefault;
				$viewInfo['fields'] = $fieldInfo;
				array_push($view, $viewInfo);
			}
			if ($numOfRows > 0) {
				$entries_list = array(
					'data' => array(
						'contents' => $view,
						'pagination' => array(
							'page' => 1,
							'totalCount' => (int)$numOfRows,
						),
					),
					'result' => true,
				);
			} else {
				$entries_list = array(
					'data' => array(
						'contents' => array(),
						'pagination' => array(
							'page' => 1,
							'totalCount' => 0,
						),
					),
					'result' => false,
				);
			}
			return $entries_list;
		} elseif ($step == 5) {
			$listSql = $adb->pquery('SELECT * FROM vtiger_modulebuilder_relatedlists WHERE moduleid=?', array(
				$moduleid
			));
			$numOfRows = $adb->num_rows($listSql);
			$list = array();
			while ($row = $listSql->FetchRow()) {
				$listInfo = array();
				$listInfo['relatedlistid'] = $row['relatedlistid'];
				$listInfo['relatedmodule'] = $row['relatedmodule'];
				$listInfo['actions'] = $row['actions'];
				$listInfo['functionname'] = $row['function'];
				$listInfo['label'] = $row['label'];
				array_push($list, $listInfo);
			}
			if ($numOfRows > 0) {
				$entries_list = array(
					'data' => array(
						'contents' => $list,
						'pagination' => array(
							'page' => 1,
							'totalCount' => (int)$numOfRows,
						),
					),
					'result' => true,
				);
			} else {
				$entries_list = array(
					'data' => array(
						'contents' => array(),
						'pagination' => array(
							'page' => 1,
							'totalCount' => 0,
						),
					),
					'result' => false,
				);
			}
			return $entries_list;
		}
	}

	public function removeBlock($blockid) {
		global $adb;
		$delete = $adb->pquery('delete from vtiger_modulebuilder_blocks where blocksid=?', array($blockid));
		if ($delete) {
			return true;
		}
		return false;
	}

	public function removeField($fieldsid) {
		global $adb;
		$delete = $adb->pquery('delete from vtiger_modulebuilder_fields where fieldsid=?', array($fieldsid));
		if ($delete) {
			return true;
		}
		return false;
	}

	public function removeCustomView($viewid) {
		global $adb;
		$delete = $adb->pquery('delete from vtiger_modulebuilder_customview where customviewid=?', array($viewid));
		if ($delete) {
			return true;
		}
		return false;
	}

	public function removeRelatedLists($listid) {
		global $adb;
		$delete = $adb->pquery('delete from vtiger_modulebuilder_relatedlists where relatedlistid=?', array($listid));
		if ($delete) {
			return true;
		}
		return false;
	}

	public function loadDefaultBlocks() {
		global $adb;
		$blockSql = $adb->pquery('SELECT * FROM vtiger_modulebuilder_blocks WHERE moduleid=? AND blocks_label=?', array(
			$_COOKIE['ModuleBuilderID'],
			'LBL_DESCRIPTION_INFORMATION'
		));
		if ($adb->num_rows($blockSql) == 0) {
			return 'load';
		}
		return $_COOKIE['ModuleBuilderID'];
	}

	public function loadTemplate($modId = 0) {
		if (isset($modId) && $modId != 0) {
			$moduleid = $modId;
		} else {
			$moduleid = vtlib_purify($_COOKIE['ModuleBuilderID']);
		}

		return array(
			'info' => $this->loadValues(1, $moduleid),
			'blocks' => $this->loadValues(2, $moduleid),
			'fields' => $this->loadValues(3, $moduleid),
			'views' => $this->loadValues(4, $moduleid),
			'lists' => $this->loadValues(5, $moduleid)
		);
	}

	public function generateManifest() {
		global $adb;
		$xml = new SimpleXMLElement('<?xml version="1.0"?><module/>');
		$map = json_decode(urldecode($_REQUEST['map']), true);
		$xml->addChild('name', $map['name']);
		$xml->addChild('label', $map['label']);
		$xml->addChild('parent', $map['parent']);
		$xml->addChild('version', $map['version']);
		$xml->addChild('short_description', $map['short_description'].' module');
		$dependencies = $xml->addChild('dependencies');
		$dependencies->addChild('vtiger_version', $map['dependencies']['vtiger_version']);
		$dependencies->addChild('vtiger_max_version', $map['dependencies']['vtiger_max_version']);
		$license = $xml->addChild('license');
		$inline = $license->addChild('inline');
		$node = dom_import_simplexml($inline);
		$node->appendChild($node->ownerDocument->createCDATASection($this->licencseTemplate($map['name'])));
		$tables = $xml->addChild('tables');
		foreach ($map['tables']['table'] as $idx => $tabValue) {
			$table = $tables->addChild('table');
			$table->addChild('name', $tabValue['name']);
			$sql = $table->addChild('sql');
			$node = dom_import_simplexml($sql);
			$node->appendChild($node->ownerDocument->createCDATASection($this->generateSql($map['blocks'], $map['name'], $idx)));
		}

		$blocks = $xml->addChild('blocks');
		$sequence = 0;
		foreach ($map['blocks'] as $block => $blockInfo) {
			$block = $blocks->addChild('block');
			$block->addChild('label', $blockInfo['block']['label']);
			$fields = $block->addChild('fields');
			if ($sequence == 0) {
				$field = $fields->addChild('field');
				$field->addChild('fieldname', strtolower($map['name']).'no');
				$field->addChild('uitype', 4);
				$field->addChild('columnname', strtolower($map['name']).'no');
				$field->addChild('tablename', 'vtiger_'.strtolower($map['name']));
				$field->addChild('generatedtype', 1);
				$field->addChild('fieldlabel', $map['label'].' no');
				$field->addChild('presence', 2);
				$field->addChild('readonly', 1);
				$field->addChild('sequence', $sequence);
				$field->addChild('typeofdata', 'V~O');
				$field->addChild('quickcreate', 1);
				$field->addChild('displaytype', 1);
				$field->addChild('masseditable', 1);
				$entityidentifier = $field->addChild('entityidentifier');
				$entityidentifier->addChild('entityidfield', strtolower($map['name']).'no');
				$entityidentifier->addChild('entityidcolumn', strtolower($map['name']).'no');
			}
			foreach ($blockInfo['block']['fields'] as $kField => $fValue) {
				$field = $fields->addChild('field');
				$field->addChild('fieldname', $fValue['fieldname']);
				$field->addChild('uitype', $fValue['uitype']);
				$field->addChild('columnname', $fValue['columnname']);
				$field->addChild('tablename', 'vtiger_'.strtolower($map['name']));
				$field->addChild('generatedtype', 1);
				$field->addChild('fieldlabel', $fValue['fieldlabel']);
				$field->addChild('presence', $fValue['presence']);
				$field->addChild('readonly', 1);
				$field->addChild('sequence', $sequence);
				$field->addChild('typeofdata', $this->typeofdata($fValue['typeofdata'], $fValue['uitype']));
				$field->addChild('quickcreate', $fValue['quickcreate']);
				$field->addChild('displaytype', 1);
				$field->addChild('masseditable', $fValue['masseditable']);
				if ($fValue['uitype'] == 10) {
					$relatedmodules = $field->addChild('relatedmodules');
					$relModules = explode(',', $fValue['relatedmodules']);
					foreach ($relModules as $rel => $mod) {
						$relatedmodules->addChild('relatedmodule', $mod);
					}
				} elseif ($fValue['uitype'] == 15 || $fValue['uitype'] == 16) {
					$picklistvalues = $field->addChild('picklistvalues');
					$values = explode(',', $fValue['picklistvalues']);
					foreach ($values as $i => $list) {
						$picklistvalues->addChild('picklistvalue', $list);
					}
				}
				$sequence++;
			}
			if ($blockInfo['block']['label'] == 'LBL_'.strtoupper($map['name']).'_INFORMATION') {
				foreach ($this->defaultFields as $fieldname => $fieldInfo) {
					$field = $fields->addChild('field');
					$field->addChild('fieldname', $fieldname);
					$field->addChild('uitype', $fieldInfo['uitype']);
					$field->addChild('columnname', $fieldInfo['columnname']);
					$field->addChild('tablename', 'vtiger_crmentity');
					$field->addChild('generatedtype', 1);
					$field->addChild('fieldlabel', $fieldInfo['fieldlabel']);
					$field->addChild('presence', $fieldInfo['presence']);
					$field->addChild('readonly', $fieldInfo['readonly']);
					$field->addChild('sequence', $sequence);
					$field->addChild('typeofdata', $fieldInfo['typeofdata']);
					$field->addChild('quickcreate', $fieldInfo['quickcreate']);
					$field->addChild('displaytype', $fieldInfo['displaytype']);
					$field->addChild('masseditable', $fieldInfo['masseditable']);
					$sequence++;
				}
			} elseif ($blockInfo['block']['label'] == 'LBL_DESCRIPTION_INFORMATION') {
				foreach ($this->defaultFields as $fieldname => $fieldInfo) {
					if ($fieldname == 'description') {
						$field = $fields->addChild('field');
						$field->addChild('fieldname', $fieldname);
						$field->addChild('uitype', $fieldInfo['uitype']);
						$field->addChild('columnname', $fieldInfo['columnname']);
						$field->addChild('tablename', 'vtiger_crmentity');
						$field->addChild('generatedtype', 1);
						$field->addChild('fieldlabel', $fieldInfo['fieldlabel']);
						$field->addChild('presence', $fieldInfo['presence']);
						$field->addChild('readonly', $fieldInfo['readonly']);
						$field->addChild('sequence', $sequence);
						$field->addChild('typeofdata', $fieldInfo['typeofdata']);
						$field->addChild('quickcreate', $fieldInfo['quickcreate']);
						$field->addChild('displaytype', $fieldInfo['displaytype']);
						$field->addChild('masseditable', $fieldInfo['masseditable']);
						$sequence++;
					}
				}
			}
		}

		$views = $xml->addChild('customviews');
		foreach ($map['customviews'] as $view => $viewInfo) {
			$customview = $views->addChild('customview');
			$customview->addChild('viewname', $viewInfo['viewname']);
			$customview->addChild('setdefault', $viewInfo['setdefault']);
			$customview->addChild('setmetrics', 'false');
			$fields = $customview->addChild('fields');
			foreach ($viewInfo['fields'] as $kField => $name) {
				$field = $fields->addChild('field');
				$field->addChild('fieldname', $name);
				$field->addChild('columnindex', $kField);
			}
		}

		$sharingaccess = $xml->addChild('sharingaccess');
		$sharingaccess->addChild('default', $map['sharingaccess']);

		$relatedlists = $xml->addChild('relatedlists');
		foreach ($map['relatedlists'] as $rList => $rInfo) {
			$relatedlist = $relatedlists->addChild('relatedlist');
			$relatedlist->addChild('function', $rInfo['function']);
			$relatedlist->addChild('label', $rInfo['label']);
			$relatedlist->addChild('sequence', $rList);
			$relatedlist->addChild('presence', 0);
			$relatedlist->addChild('relatedmodule', $rInfo['relatedmodule']);
			$actions = $relatedlist->addChild('actions');
			foreach ($rInfo['actions'] as $kAction => $actionVal) {
				$action = $actions->addChild('action', $actionVal);
			}
		}

		$actions = $xml->addChild('actions');
		foreach ($map['actions'] as $actionKey => $actionVal) {
			$action = $actions->addChild('action');
			$name = $action->addChild('name');
			$node = dom_import_simplexml($name);
			$node->appendChild($node->ownerDocument->createCDATASection($actionKey));
			$status = 'enabled';
			if ($actionVal == 'false') {
				$status = 'disabled';
			}
			$action->addChild('status', $status);
		}
		$xml->addChild('events', "\n\t");
		$xml->addChild('customlinks', "\n\t");
		$xml->addChild('crons', "\n\t");
		$dom = dom_import_simplexml($xml)->ownerDocument;
		$dom->formatOutput = true;
		$formatted = $dom->saveXML();
		$ret = $this->generateModule($formatted, $map['name'], $map);
		return $ret;
	}

	public function generateModule($XML, $module, $map) {
		$template = $this->loadTemplate();
		$path = $this->path.$module;
		if (file_exists($path)) {
			$this->deleteDirectory($path);
		}
		mkdir($path);
		$manifest = fopen($path."/manifest.xml", "w");
		//copy all files from vtlib.module
		mkdir($path.'/modules/');
		mkdir($path.'/modules/'.$module);
		foreach ($this->files as $index => $name) {
			if (is_array($name)) {
				mkdir($path.'/modules/'.$module.'/language');
				foreach ($name as $lang => $lName) {
					copy('vtlib/ModuleDir/language/'.$lName, $path.'/modules/'.$module.'/language/'.$lName);
				}
			} else {
				$newName = explode('/', $name)[2];
				copy($name, $path.'/modules/'.$module.'/'.$newName);
			}
		}
		rename($path.'/modules/'.$module.'/ModuleFile.php', $path.'/modules/'.$module.'/'.$module.'.php');
		rename($path.'/modules/'.$module.'/ModuleFile.js', $path.'/modules/'.$module.'/'.$module.'.js');
		rename($path.'/modules/'.$module.'/ModuleFileAjax.php', $path.'/modules/'.$module.'/'.$module.'Ajax.php');
		fwrite($manifest, $XML);
		fclose($manifest);
		copy($path.'/manifest.xml', $path.'/modules/'.$module.'/manifest.xml');
		//create modulename.php file
		$moduleFile = fopen($path.'/modules/'.$module.'/'.$module.'.php', "r");
		$content = '';
		while (!feof($moduleFile)) {
			$content .= fgetc($moduleFile);
		}
		fclose($moduleFile);
		$replist_fields = '';
		$replist_fields_name = '';
		$fields = $template['fields']['data']['contents'];
		$block = $map['blocks'][0]['block'];
		$customviews = $map['customviews'][0]['fields'];
		$list_fields = "'MODULE_NAME_LABEL'=> array('MODULE_NAME_LOWERCASE' => 'MODULE_REFERENCE_FIELD'),";
		$search_fields = "'MODULE_NAME_LABEL'=> array('MODULE_NAME_LOWERCASE' => 'MODULE_REFERENCE_FIELD')";
		$list_fields_name = "'MODULE_NAME_LABEL'=> 'MODULE_REFERENCE_FIELD',";
		$search_fields_name = "'MODULE_NAME_LABEL'=> 'MODULE_REFERENCE_FIELD'";
		$replist_fields .= "'".$map['name']."'=> array('MODULE_NAME_LOWERCASE' => '".$map['name']."no'),";
		$replist_fields_name .= "'".$map['label']."'=> '".$map['name']."no',";
		foreach ($customviews as $key => $value) {
			foreach ($fields as $f => $name) {
				if ($name['fieldname'] == $value) {
					$replist_fields .= "'".$name['fieldlabel']."'=> array('MODULE_NAME_LOWERCASE' => '".$value."'),\n\t\t";
					$replist_fields_name .= "'".$name['fieldlabel']."'=> '".$value."',\n\t\t";
				}
			}
		}
		$newContent = str_replace($list_fields, $replist_fields, $content);
		$newContent = str_replace($search_fields, $replist_fields, $newContent);
		$newContent = str_replace($list_fields_name, $replist_fields_name, $newContent);
		$newContent = str_replace($search_fields_name, $replist_fields_name, $newContent);
		$newContent = str_replace("'Assigned To' => array('crmentity' => 'smownerid')", '', $newContent);
		$newContent = str_replace("'Assigned To' => 'assigned_user_id'", '', $newContent);
		//TO DO module reference field
		$newContent = str_replace('MODULE_NAME_LOWERCASE', strtolower($module), $newContent);
		$newContent = str_replace('ModuleClass', $module, $newContent);
		$newContent = str_replace('MODULE_REFERENCE_FIELD', $map['name'].'no', $newContent);
		$newContent = str_replace('MODULE_NAME_LABEL', $map['label'], $newContent);
		$newContent = str_replace("'icon'=>'account'", "'icon'=>'".$map['icon']."'", $newContent);
		$moduleFile = fopen($path.'/modules/'.$module.'/'.$module.'.php', "w");
		fwrite($moduleFile, $newContent);
		fclose($moduleFile);
		$this->zipModule($path, $module);
		return array('success'=>true, 'module'=>$module);
	}

	public function zipModule($modPath, $module) {
		$rootPath = realpath($modPath);
		$zip = new ZipArchive();
		$zip->open($this->path.$module.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($files as $name => $file) {
			if (!$file->isDir()) {
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $relativePath);
			}
		}
		$zip->close();
	}

	public function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}
		if (!is_dir($dir)) {
			return unlink($dir);
		}
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}
			if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
				return false;
			}
		}
		return rmdir($dir);
	}

	public function VerifyModule($modulename) {
		global $adb;
		$sql = $adb->pquery('SELECT * FROM vtiger_modulebuilder WHERE modulebuilder_name=?', array($modulename));
		if ($adb->num_rows($sql) > 0) {
			return array('moduleid' => (Int)$adb->query_result($sql, 0, 'modulebuilderid'));
		}
		return 0;
	}

	public function licencseTemplate($module) {
		global $current_user;
		return $template = '*************************************************************************************************
	 * Copyright '.date('Y').' JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
	 * You can copy, adapt and distribute the work under the "Attribution-NonCommercial-ShareAlike"
	 * Vizsage Public License (the "License"). You may not use this file except in compliance with the
	 * License. Roughly speaking, non-commercial users may share and modify this code, but must give credit
	 * and share improvements. However, for proper details please read the full License, available at
	 * http://vizsage.com/license/Vizsage-License-BY-NC-SA.html and the handy reference for understanding
	 * the full license at http://vizsage.com/license/Vizsage-Deed-BY-NC-SA.html. Unless required by
	 * applicable law or agreed to in writing, any software distributed under the License is distributed
	 * on an  "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	 * See the License for the specific language governing permissions and limitations under the
	 * License terms of Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (the License).
	 *************************************************************************************************
	 *  Module       : '.$module.'
	 *  Version      : 5.4.0
	 *  Author       : '.$current_user->first_name.' '.$current_user->last_name.'
	 *************************************************************************************************
		';
	}

	public function generateSql($blocks, $module, $idx) {
		$fields = array();
		if ($idx == 0) {
			$table = "CREATE TABLE IF NOT EXISTS `vtiger_".strtolower($module)."` (\n";
			$table .= "`".strtolower($module)."id` INT(11) NOT NULL,\n";
			$table .= "`".strtolower($module)."no` VARCHAR(255) DEFAULT NULL,\n";
			foreach ($blocks as $key => $value) {
				foreach ($value['block']['fields'] as $field => $info) {
					$fieldname = $info['fieldname'];
					$uitype = $info['uitype'];
					$table .= "`".strtolower($fieldname)."` ".$this->typeofdata[$uitype][0]." DEFAULT NULL,\n";
				}
			}
			$table .= "PRIMARY KEY (`".strtolower($module)."id`)\n";
		} else {
			$table = "CREATE TABLE IF NOT EXISTS `vtiger_".strtolower($module)."cf` (\n";
			$table .= "`".strtolower($module)."id` INT(11) NOT NULL,\nPRIMARY KEY (`".strtolower($module)."id`)\n";
		}
		$table .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $table;
	}

	public function typeofdata($typeofdata, $uitype) {
		return $this->typeofdata[$uitype][1].$typeofdata;
	}

	public function getModules() {
		global $adb;
		$mods = $adb->pquery('SELECT modulename FROM vtiger_entityname', array());
		$list = array();
		while ($row = $mods->FetchRow()) {
			array_push($list, $row['modulename']);
		}
		return $list;
	}
}
?>