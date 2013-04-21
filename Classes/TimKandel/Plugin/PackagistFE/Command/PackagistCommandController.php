<?php
namespace TimKandel\Plugin\PackagistFE\Command;

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
				$packageList = json_decode($this->browser->request($repository)->getContent());

				foreach ($packageList->results as $packageEnvelope) {
					$package = json_decode($this->browser->request($packageEnvelope->url . '.json')->getContent());
					if (in_array($package->package->type, $this->settings['packageTypes'])) {
						$this->packages[$package->package->type][] = $package;
					}
				}

				//$repository = (isset($packageList->next)) ? $packageList->next : NULL;
				// fix, because URLs provided by packagist.org are buggy atm
				if (isset($packageList->next)) {
					$uri = new \TYPO3\Flow\Http\Uri($packageList->next);
					//$query = array();
					parse_str($uri->getQuery(), $query);
					$repository .= '&page=' . intval($query['page']);
				} else {
					$repository = NULL;
				}
			} while(isset($repository));
		}

		if (!empty($this->packages)) {
			if (!is_dir(FLOW_PATH_DATA . 'Packages/')) {
				mkdir(FLOW_PATH_DATA . 'Packages/');
			}
			$basePath = FLOW_PATH_DATA . 'Packages/';
			foreach ($this->packages as $packagesType => $packages) {
				$packagesFile = $basePath . $packagesType . '.json';
				file_put_contents($packagesFile, json_encode($packages));
			}
		}
	}

}