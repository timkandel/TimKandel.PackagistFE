<?php
namespace TimKandel\Plugin\PackagistFE\Domain\Repository;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.Plugin.PackagistFE".*
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Packages
 *
 * @Flow\Scope("singleton")
 */
class PackageRepository extends \TYPO3\Flow\Persistence\Repository {

	public function findByType($type) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('type', $type)
		)->setOrderings(array('time' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
	}

}
?>