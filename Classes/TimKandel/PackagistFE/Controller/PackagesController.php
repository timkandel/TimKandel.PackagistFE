<?php
namespace TimKandel\PackagistFE\Controller;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use TimKandel\PackagistFE\Domain\Repository\PackageRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

/**
 * @Flow\Scope("singleton")
 */
class PackagesController extends ActionController {

	/**
	 * @var PackageRepository
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
		$this->view->assignMultiple(array(
			'activePackageType' => $packageType,
			'packageTypes' => $this->settings['packageTypes'],
			'packages' => $packages
		));
	}

}