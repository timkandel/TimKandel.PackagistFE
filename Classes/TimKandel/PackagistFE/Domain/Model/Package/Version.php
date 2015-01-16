<?php
namespace TimKandel\PackagistFE\Domain\Model\Package;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use Doctrine\ORM\Mapping as ORM;
use TimKandel\PackagistFE\Domain\Model\Package;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Version {

	/**
	 * @var string
	 */
	protected $version;

	/**
	 * @var \DateTime
	 */
	protected $time;

	/**
	 * @var Package
	 * @ORM\ManyToOne(inversedBy="versions")
	 */
	protected $package;

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @param string $version
	 */
	public function setVersion($version) {
		$this->version = $version;
	}

	/**
	 * @return \DateTime
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * @param string|\DateTime $time
	 */
	public function setTime($time) {
		if (is_string($time)) {
			$this->time = new \DateTime($time);
		} else {
			$this->time = $time;
		}
	}

	/**
	 * @return Package
	 */
	public function getPackage() {
		return $this->package;
	}

	/**
	 * @param Package $package
	 */
	public function setPackage(Package $package) {
		$this->package = $package;
	}

}