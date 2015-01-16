<?php
namespace TimKandel\PackagistFE\Domain\Service;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use Doctrine\ORM\Mapping as ORM;
use Packagist\Api\Result;
use TimKandel\PackagistFE\Domain\Model\Package;
use TimKandel\PackagistFE\Domain\Model\Package\Version;
use TYPO3\Flow\Annotations as Flow;

/**
 * A Package
 *
 * @Flow\Scope("singleton")
 */
class PackageService {

	public function mapPackageResult(Package $package, Result\Package $result) {
		$package->setName($result->getName());
		$package->setDescription($result->getDescription());

		$package->setTime($result->getTime());
		$maintainers = $result->getMaintainers();
		$package->setMaintainer($maintainers[0]->getName());
		$package->setType($result->getType());
		$package->setTotalDownloads($result->getDownloads()->getTotal());
		$package->setMonthlyDownloads($result->getDownloads()->getMonthly());
		$package->setDailyDownloads($result->getDownloads()->getDaily());

		$versions = array();
		/** @var Result\Package\Version $resultVersion */
		foreach ($result->getVersions() as $resultVersion) {
			if ($package->getVersion($resultVersion->getVersion())) {
				$version = $package->getVersion($resultVersion->getVersion());
			} else {
				$version = new Version();
			}

			$version->setVersion($resultVersion->getVersion());
			$version->setTime($resultVersion->getTime());
			$package->addVersion($version);
			$versions[] = $version->getVersion();
		}

		// clean up
		foreach ($package->getVersions() as $version) {
			if (!in_array($version->getVersion(), $versions)) {
				$package->removeVersion($version);
			}
		}
	}

}