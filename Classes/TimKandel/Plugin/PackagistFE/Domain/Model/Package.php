<?php
namespace TimKandel\Plugin\PackagistFE\Domain\Model;

/*                                                                              *
 * This script belongs to the TYPO3 Flow package "TimKandel.Plugin.PackagistFE".*
 *                                                                              *
 *                                                                              */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Package
 *
 * @Flow\Entity
 */
class Package {

	/**
	 * The package's name.
	 *
	 * @var string
	 * @Flow\Validate(type="Text")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 */
	protected $name = '';

	/**
	 * The package's description.
	 *
	 * @var string
	 * @Flow\Validate(type="String")
	 */
	protected $description = '';

	/**
	 * The package's time.
	 *
	 * @var \DateTime
	 * @Flow\Validate(type="DateTime")
	 */
	protected $time = '';

	/**
	 * The package's maintainer.
	 *
	 * @var string
	 * @Flow\Validate(type="Text")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 */
	protected $maintainer = '';

	/**
	 * The package's type.
	 *
	 * @var string
	 * @Flow\Validate(type="Text")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=80 })
	 * @ORM\Column(length=80)
	 */
	protected $type = '';

	/**
	 * The package's total downloads.
	 *
	 * @var int
	 * @Flow\Validate(type="Integer")
	 */
	protected $totalDownloads = 0;

	/**
	 * The package's monthly downloads.
	 *
	 * @var int
	 * @Flow\Validate(type="Integer")
	 */
	protected $monthlyDownloads = 0;

	/**
	 * The package's daily downloads.
	 *
	 * @var int
	 * @Flow\Validate(type="Integer")
	 */
	protected $dailyDownloads = 0;

	/**
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection<\TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version>
	 * @ORM\OneToMany(mappedBy="package")
	 * @ORM\OrderBy({"time" = "DESC"})
	 */
	protected $versions;

	/**
	 *
	 */
	public function __construct() {
		$this->versions = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Gets the package's name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the package's name
	 *
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Gets the package's description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the package's description
	 *
	 * @param $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Gets the package's time
	 *
	 * @return \DateTime
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * Sets the package's time
	 *
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
	 * Gets the package's maintainer
	 *
	 * @return string
	 */
	public function getMaintainer() {
		return $this->maintainer;
	}

	/**
	 * Sets the package's maintainer
	 *
	 * @param $maintainer
	 */
	public function setMaintainer($maintainer) {
		$this->maintainer = $maintainer;
	}

	/**
	 * Gets the package's type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the package's type
	 *
	 * @param $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	public function getTotalDownloads() {
		return $this->totalDownloads;
	}

	public function setTotalDownloads($totalDownloads) {
		$this->totalDownloads = $totalDownloads;
	}

	public function getMonthlyDownloads() {
		return $this->monthlyDownloads;
	}

	public function setMonthlyDownloads($monthlyDownloads) {
		$this->monthlyDownloads = $monthlyDownloads;
	}

	public function getDailyDownloads() {
		return $this->dailyDownloads;
	}

	public function setDailyDownloads($dailyDownloads) {
		$this->dailyDownloads = $dailyDownloads;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getVersions() {
		return $this->versions;
	}

	/**
	 * @param $versionString
	 * @return null
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
	 * @param \TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version $version
	 */
	public function addVersion(\TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version $version) {
		$version->setPackage($this);
		$this->versions->add($version);
	}

	/**
	 * @param \TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version $version
	 */
	public function removeVersion(\TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version $version) {
		$this->versions->removeElement($version);
	}

	/**
	 * @param $json
	 */
	public function createFromJson($json) {
		$this->setName($json['package']['name']);
		if ($json['package']['description'] !== NULL) {
			$this->setDescription($json['package']['description']);
		}
		$this->setTime($json['package']['time']);
		$this->setMaintainer($json['package']['maintainers'][0]['name']);
		$this->setType($json['package']['type']);
		$this->setTotalDownloads($json['package']['downloads']['total']);
		$this->setMonthlyDownloads($json['package']['downloads']['monthly']);
		$this->setDailyDownloads($json['package']['downloads']['daily']);

		foreach ($json['package']['versions'] as $versionString => $versionEnvelope) {
			if ($this->getVersion($versionString)) {
				$version = $this->getVersion($versionString);
			} else {
				$version = new \TimKandel\Plugin\PackagistFE\Domain\Model\Package\Version();
			}

			$version->setVersion($versionString);
			$version->setTime($versionEnvelope['time']);
			$this->addVersion($version);
		}

		// clean up
		foreach ($this->getVersions() as $version) {
			if (!isset($json['package']['versions'][$version->getVersion()])) {
				$this->removeVersion($version);
			}
		}
	}

}
?>