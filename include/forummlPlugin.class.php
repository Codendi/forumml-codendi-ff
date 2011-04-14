<?php
/**
 * Copyright (c) STMicroelectronics, 2004-2009. All rights reserved
 *
 * This file is a part of Codendi.
 *
 * Codendi is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Codendi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Codendi. If not, see <http://www.gnu.org/licenses/>.
 */

require_once('common/plugin/Plugin.class.php');

class ForumMLPlugin extends Plugin {

	function __construct($id) {
        parent::__construct($id);

        $this->_addHook('browse_archives','forumml_browse_archives',false);
        $this->_addHook('cssfile','cssFile',false);
        $this->_addHook('javascript_file',                   'jsFile',                            false);
        $this->_addHook('search_type', 'search_type', false);
        $this->_addHook('layout_searchbox_options', 'forumml_searchbox_option', false);
        $this->_addHook('layout_searchbox_hiddenInputs', 'forumml_searchbox_hiddenInput', false);
        $this->_addHook('plugins_powered_search', 'forumml_search', false);
        // Set ForumML plugin scope to 'Projects' wide 
        $this->setScope(Plugin::SCOPE_PROJECT);
        $this->allowedForProject = array();
	}
	
    function &getPluginInfo() {
        if (!is_a($this->pluginInfo, 'ForumMLPluginInfo')) {
            require_once('ForumMLPluginInfo.class.php');
            $this->pluginInfo =& new ForumMLPluginInfo($this);
        }
        return $this->pluginInfo;
    }

    /**
     * Return true if current project has the right to use this plugin.
     */
    function isAllowed() {
        $request =& HTTPRequest::instance();
        $group_id = (int) $request->get('group_id');
        if(!isset($this->allowedForProject[$group_id])) {
            $pM =& PluginManager::instance();
            $this->allowedForProject[$group_id] = $pM->isPluginAllowedForProject($this, $group_id);
        }
        return $this->allowedForProject[$group_id];
    }

    function forumml_searchbox_option($params) {
        $request =& HTTPRequest::instance();
        $group_id = (int) $request->get('group_id');
        if(isset($_REQUEST['list']) && isset($group_id)) {
            $params['option_html'] .= "\t<OPTION value=\"mail\"".( $params['type_of_search'] == "mail" ? " SELECTED" : "" ).">".$GLOBALS['Language']->getText('plugin_forumml','this_list')."</OPTION>\n";
        }
    }
    
    function forumml_searchbox_hiddenInput($params) {
        if(isset($_REQUEST['list'])) {
            $params['input_html'] .= "\t<INPUT TYPE=\"HIDDEN\" VALUE=\"". $_REQUEST['list'] ."\" NAME=\"list\">\n";
        }
    }

    function forumml_browse_archives($params) {
    	if ($this->isAllowed()) {
    		$request =& HTTPRequest::instance();
    		$group_id = (int) $request->get('group_id');
			$params['html'] = '<A href="/plugins/forumml/message.php?group_id='.$group_id.'&list='.$params['group_list_id'].'"> '.$GLOBALS['Language']->getText('plugin_forumml','archives').'</A>';
    	}
    }

    function cssFile($params) {
    	$request =& HTTPRequest::instance();
        if (strpos($_SERVER['REQUEST_URI'], $this->getPluginPath()) === 0) {
            echo '<link rel="stylesheet" type="text/css" href="'.$this->getThemePath().'/css/style.css" />'."\n";
        }
    }

    function jsFile($params) {
    	//$request =& HTTPRequest::instance();
        if (strpos($_SERVER['REQUEST_URI'], $this->getPluginPath()) === 0) {
            //echo '<link rel="stylesheet" type="text/css" href="'.$this->getThemePath().'/css/style.css" />'."\n";
            echo '<script type="text/javascript" src="'.$this->getPluginPath().'/scripts/forumml.js"></script>'."\n";
        }
    }

    function forumml_search($params) {
        if($params['type_of_search'] == 'mail') {
            $params['plugins_powered_search'] = true;
        }
    }

    function search_type($params) {
        if(isset($params['type_of_search']) && $params['type_of_search'] == 'mail') {
            $request =& HTTPRequest::instance();
            $group_id = (int) $request->get('group_id');
            $list = (int) $request->get('list');
            util_return_to('/plugins/forumml/message.php?group_id='.$group_id.'&list='.$list.'&search='.urlencode($params['words']));
        }
    }
}

?>
