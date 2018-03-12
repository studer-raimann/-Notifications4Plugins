<?php

require_once("./Services/UIComponent/classes/class.ilUserInterfaceHookPlugin.php");

require_once('./Services/ActiveRecord/class.ActiveRecord.php');

/**
 * Class ilNotifications4PluginsPlugin
 *
 * @author Stefan Wanzenried <sw@studer-raimann.ch>
 */
class ilNotifications4PluginsPlugin extends ilUserInterfaceHookPlugin {

	/**
	 * @var ilNotifications4PluginsPlugin
	 */
	protected static $instance;


	/**
	 * Singleton Access to this plugin
	 *
	 * @return ilNotifications4PluginsPlugin
	 */
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @var ilDB
	 */
	protected $db;


	public function __construct() {
		parent::__construct();

		global $DIC;

		$this->db = $DIC->database();
	}


	/**
	 * Get Plugin Name. Must be same as in class name il<Name>Plugin
	 * and must correspond to plugins subdirectory name.
	 *
	 * Must be overwritten in plugin class of plugin
	 * (and should be made final)
	 *
	 * @return    string    Plugin Name
	 */
	public function getPluginName() {
		return 'Notifications4Plugins';
	}


	protected function beforeUninstall() {
		require_once './Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/Notifications4Plugins/classes/Notification/class.srNotification.php';
		require_once './Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/Notifications4Plugins/classes/Notification/class.srNotificationLanguage.php';

		$this->db->dropTable(srNotification::TABLE_NAME, false);
		$this->db->dropTable(srNotificationLanguage::TABLE_NAME, false);

		return true;
	}
}