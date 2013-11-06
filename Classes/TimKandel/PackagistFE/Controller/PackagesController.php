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
	 * @param string $packageType
	 */
	public function indexAction($packageType = 'typo3-flow-plugin') {
		$packages = $this->packageRepository->findByType($packageType);
		$this->view->assign('packageTypes', $this->settings['packageTypes']);
		$this->view->assign('packages', $packages);
	}

}
?>