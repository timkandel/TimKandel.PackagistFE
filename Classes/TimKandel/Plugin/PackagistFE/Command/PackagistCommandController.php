<?php
namespace TimKandel\Plugin\PackagistFE\Command;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.Plugin.PackagistFE".*
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;

class PackagistCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Http\Client\Browser
	 */
	protected $browser;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Http\Client\CurlEngine
	 */
	protected $browserRequestEngine;

	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @Flow\Inject
	 */
	protected $configurationManager;

	/**
	 * @var array
	 */
	protected $packages = array();

	/**
	 * @var \TimKandel\Plugin\PackagistFE\Domain\Repository\PackageRepository
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
	 * @return void
	 */
	public function importCommand() {
		$this->browserRequestEngine->setOption(CURLOPT_TIMEOUT, 120);
		$this->browser->setRequestEngine($this->browserRequestEngine);

		foreach ($this->settings['repositories'] as $repository) {
			do {
				$packagesList = json_decode($this->browser->request($repository)->getContent());

				foreach ($packagesList->results as $packageEnvelope) {
					$package = json_decode($this->browser->request($packageEnvelope->url . '.json')->getContent());
					if (in_array($package->package->type, $this->settings['packageTypes'])) {
						if ($this->packageRepository->findOneByName($package->package->name)) {
							$p = $this->packageRepository->findOneByName($package->package->name);
						} else {
							$p = new \TimKandel\Plugin\PackagistFE\Domain\Model\Package();
							$this->packageRepository->add($p);
						}

						$p->createFromJson($package);

					}
				}

				//$repository = (isset($packageList->next)) ? $packageList->next : NULL;
				// fix, because URLs provided by packagist.org are buggy atm
				if (isset($packagesList->next)) {
					$uri = new \TYPO3\Flow\Http\Uri($packagesList->next);
					//$query = array();
					parse_str($uri->getQuery(), $query);
					$repository .= '&page=' . intval($query['page']);
				} else {
					$repository = NULL;
				}
			} while(isset($repository));
		}
	}

}
?>