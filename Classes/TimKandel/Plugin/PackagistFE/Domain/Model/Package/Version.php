<?php
namespace TimKandel\Plugin\PackagistFE\Domain\Model\Package;

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Version
 *
 * @Flow\Entity
 */
class Version {

	/**
	 * The Version's version string
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * The Version's time
	 *
	 * @var \DateTime
	 */
	protected $time;

	/**
	 * The Version's Package
	 *
	 * @var \TimKandel\Plugin\PackagistFE\Domain\Model\Package
	 * @ORM\ManyToOne(inversedBy="versions")
	 */
	protected $package;

	/**
	 * Gets the Version's version string
	 *
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * Sets the Version's version string
	 *
	 * @param string $version
	 */
	public function setVersion($version) {
		$this->version = $version;
	}

	/**
	 * Gets the Version's time
	 *
	 * @return \DateTime
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * Sets the Version's time
	 *
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
	 * Gets the Version's Package
	 *
	 * @return \TimKandel\Plugin\PackagistFE\Domain\Model\Package
	 */
	public function getPackage() {
		return $this->package;
	}

	/**
	 * Sets the Version's Package
	 *
	 * @param \TimKandel\Plugin\PackagistFE\Domain\Model\Package $package
	 */
	public function setPackage(\TimKandel\Plugin\PackagistFE\Domain\Model\Package $package) {
		$this->package = $package;
	}

}