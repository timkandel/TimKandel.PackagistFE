<?php
namespace TimKandel\Plugin\PackagistFE\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TimKandel.Plugin.PackagistFE".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the TimKandel.Plugin.PackagistFE package
 *
 * @Flow\Scope("singleton")
 */
class PackagesController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$packageList = array();
		foreach ($this->settings['packageTypes'] as $packageType) {
			$fileContent = file_get_contents(FLOW_PATH_DATA . 'Packages/' . $packageType . '.json');
			$packageList[$packageType] = json_decode($fileContent, TRUE);
		}

		$this->view->assign('packagesList', $packageList);
	}

}

?>