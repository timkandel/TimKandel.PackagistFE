<?php
namespace TimKandel\PackagistFE\Domain\Repository;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".		*
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
		$query->matching(
			$query->equals('type', $type)
		)->setOrderings(array('time' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute();
	}

}
?>