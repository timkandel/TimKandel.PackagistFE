<?php
namespace TimKandel\PackagistFE\Domain\Model;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.PackagistFE".       *
 *                                                                              *
 *                                                                              */

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Packagist\Api\Result;
use TimKandel\PackagistFE\Domain\Model\Package\Version;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Entity
 */
class Package {

	/**
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 * @var string
	 */
	protected $name = '';

	/**
	 * @ORM\Column(nullable=true)
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var \DateTime
	 */
	protected $time = '';

	/**
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 * @var string
	 */
	protected $maintainer = '';

	/**
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 * @var string
	 */
	protected $type = '';

	/**
	 * @var int
	 */
	protected $totalDownloads = 0;

	/**
	 * @var int
	 */
	protected $monthlyDownloads = 0;

	/**
	 * @var int
	 */
	protected $dailyDownloads = 0;

	/**
	 * @ORM\OneToMany(mappedBy="package")
	 * @ORM\OrderBy({"time" = "DESC"})
	 * @var ArrayCollection<Version>
	 */
	protected $versions;

	public function __construct() {
		$this->versions = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return \DateTime
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * @param string $time
	 */
	public function setTime($time) {
		if (is_string($time)) {
			$this->time = new \DateTime($time);
		} else {
			$this->time = $time;
		}
	}

	/**
	 * @return string
	 */
	public function getMaintainer() {
		return $this->maintainer;
	}

	/**
	 * @param $maintainer
	 */
	public function setMaintainer($maintainer) {
		$this->maintainer = $maintainer;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getTotalDownloads() {
		return $this->totalDownloads;
	}

	/**
	 * @param $totalDownloads
	 */
	public function setTotalDownloads($totalDownloads) {
		$this->totalDownloads = $totalDownloads;
	}

	/**
	 * @return int
	 */
	public function getMonthlyDownloads() {
		return $this->monthlyDownloads;
	}

	/**
	 * @param $monthlyDownloads
	 */
	public function setMonthlyDownloads($monthlyDownloads) {
		$this->monthlyDownloads = $monthlyDownloads;
	}

	/**
	 * @return int
	 */
	public function getDailyDownloads() {
		return $this->dailyDownloads;
	}

	/**
	 * @param $dailyDownloads
	 */
	public function setDailyDownloads($dailyDownloads) {
		$this->dailyDownloads = $dailyDownloads;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getVersions() {
		return $this->versions;
	}

	/**
	 * @param $versionString
	 * @return Version|null
	 */
	public function getVersion($versionString) {
		foreach ($this->getVersions() as $version) {
			if ($version->getVersion() === $versionString) {
				return $version;
			}
		}

		return NULL;
	}

	/**
	 * @param Version $version
	 */
	public function addVersion(Version $version) {
		$version->setPackage($this);
		$this->versions->add($version);
	}

	/**
	 * @param Version $version
	 */
	public function removeVersion(Version $version) {
		$this->versions->removeElement($version);
	}

}
