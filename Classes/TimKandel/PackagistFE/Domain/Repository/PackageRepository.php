<?php
namespace TimKandel\PackagistFE\Domain\Repository;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class PackageRepository extends Repository {

	/**
	 * @param $type
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByType($type) {
		$query = $this->createQuery();
		$query->matching(
			$query->equals('type', $type)
		)->setOrderings(array('time' => QueryInterface::ORDER_DESCENDING));
		return $query->execute();
	}

}
