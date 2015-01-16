<?php
namespace TimKandel\PackagistFE\Command;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use Packagist\Api\Client;
use Packagist\Api\Result\Result;
use TimKandel\PackagistFE\Domain\Model\Package;
use TimKandel\PackagistFE\Domain\Service\PackageService;
use TimKandel\PackagistFE\Domain\Repository\PackageRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cli\CommandController;
use TYPO3\Flow\Configuration\ConfigurationManager;

/**
 * Class PackagistCommandController
 *
 * @package TimKandel\PackagistFE\Command
 */
class PackagistCommandController extends CommandController {

	/**
	 * @var ConfigurationManager
	 * @Flow\Inject
	 */
	protected $configurationManager;

	/**
	 * @var PackageRepository
	 * @Flow\Inject
	 */
	protected $packageRepository;

	/**
	 * @var PackageService
	 * @Flow\Inject
	 */
	protected $packageService;

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
	 * @return void
	 */
	public function importCommand() {
		$client = new Client();
		foreach ($this->settings['repositories'] as $repository) {
			$client->setPackagistUrl($repository['url']);
			/** @var Result $result */
			foreach ($client->search(NULL, $repository['filters']) as $result) {
				$resultPackage = $client->get($result->getName());
				if (in_array($resultPackage->getType(), $this->settings['packageTypes'])) {
					$package = $this->packageRepository->findOneByName($resultPackage->getName());
					if ($package) {
						$this->packageRepository->update($package);
					} else {
						$package = new Package();
						$this->packageRepository->add($package);
					}

					$this->packageService->mapPackageResult($package, $resultPackage);
				}
			}
		}
	}

}