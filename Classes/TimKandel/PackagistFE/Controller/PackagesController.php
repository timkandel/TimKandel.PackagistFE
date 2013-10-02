<?php
namespace TimKandel\PackagistFE\Controller;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".		*
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the TimKandel.PackagistFE package
 *
 * @Flow\Scope("singleton")
 */
class PackagesController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var \TimKandel\PackagistFE\Domain\Repository\PackageRepository
	 * @Flow\Inject
	 */
	protected $packageRepository;

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
		$packagesList = array();
		foreach ($this->settings['packageTypes'] as $packageType) {
			$packagesList[$packageType] = $this->packageRepository->findByType($packageType)->execute();
		}

		$this->view->assign('packagesList', $packagesList);
	}

}
?>