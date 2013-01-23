<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * PHRentals\MainBundle\Entity\Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="PHRentals\MainBundle\Repository\AddressRepository")
 */
class Address
{	
	
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var AddressClass
     *
     * @ORM\ManyToOne(targetEntity="AddressClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_class_id", referencedColumnName="id")
     * })
     */
    private $class;
    
    /**
     * @var District
     *
     * @ORM\ManyToOne(targetEntity="District")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * })
     */
    private $district;
    
    /**
     * @var string $distanceToBeach
     *
     * @ORM\Column(name="distance_to_beach", type="string", length=255, nullable=true)
     */
    private $distanceToBeach;
    
    public static function getDistanceToBeachList()
    {
    	return array(
    			"beach front" => 'direct beach front',
    			"under 100" => 'under 100 m. to beach',
    			"100-200" => '100-200 m. to beach',
    			"100-300" => '100-300 m. to beach',
    			"200-300" => '200-300 m. to beach',
    			"250-400" => '250-400 m. to beach',
    			"400-more" => '450m, 500m or more'
    
    	);
    }
    
    /**
     * @var string $map
     *
     * @ORM\Column(name="map", type="string", length=255, nullable=true)
     */
    private $map;
    
    /**
     * @var string $gpsLon
     *
     * @ORM\Column(name="gps_lon", type="string", length=255, nullable=true)
     */
    private $gpsLon;
    
    /**
     * @var string $gpsLat
     *
     * @ORM\Column(name="gps_lat", type="string", length=255, nullable=true)
     */
    private $gpsLat;

    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="AddressTag", inversedBy="addresses")
     * @ORM\JoinTable(name="address_has_tags",
     *   joinColumns={
     *     @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *   }
     * )
     */
    private $tags;



    /**
     * @var string $text
     *
     * @ORM\Column(name="address_text", type="text", length=255, nullable=true)
     */
    private $text;    
    
    /**
     * @var string $adrStreet1
     *
     * @ORM\Column(name="adr_street_1", type="string", length=255, nullable=true)
     */
    private $adrStreet1;
    
    /**
     * @var string $adrStreet2
     *
     * @ORM\Column(name="adr_street_2", type="string", length=255, nullable=true)
     */
    private $adrStreet2;
    
    /**
     * @var string $adrStreet3
     *
     * @ORM\Column(name="adr_street_3", type="string", length=255, nullable=true)
     */
    private $adrStreet3;
    
    
    /**
     * @var string $adrStreet4
     *
     * @ORM\Column(name="adr_street_4", type="string", length=255, nullable=true)
     */
    private $adrStreet4;
    
    
    /**
     * @var string $adrStreet5
     *
     * @ORM\Column(name="adr_street_5", type="string", length=255, nullable=true)
     */
    private $adrStreet5;
    
    
    /**
     * @var string $adrStreet6
     *
     * @ORM\Column(name="adr_street_6", type="string", length=255, nullable=true)
     */
    private $adrStreet6;
    
    /**
     * @var string $adrCity
     *
     * @ORM\Column(name="adr_city", type="string", length=255, nullable=true)
     */
    private $adrCity;
    
    /**
     * @var string $adrProvince
     *
     * @ORM\Column(name="adr_province", type="string", length=255, nullable=true)
     */
    private $adrProvince;
    
    /**
     * @var string $adrZip
     *
     * @ORM\Column(name="adr_zip", type="string", length=255, nullable=true)
     */
    private $adrZip;
    
    /**
     * @var string $adrCountry
     *
     * @ORM\Column(name="adr_country", type="string", length=255, nullable=true)
     */
    private $adrCountry = "Thailand";
    
    /**
     * @var ArrayCollection $units
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="address")
     */
    private $units;
    
    /**
     * @ORM\Column(name="createdOn", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdOn;
    
    /**
     * @ORM\Column(name="updatedOn", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedOn;
      
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	if ($this->getText()) {
    	return $this->getText();
    	} else {
    		return 'Address';
    	}
    }
     

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set distanceToBeach
     *
     * @param string $distanceToBeach
     * @return Address
     */
    public function setDistanceToBeach($distanceToBeach)
    {
        $this->distanceToBeach = $distanceToBeach;
    
        return $this;
    }

    /**
     * Get distanceToBeach
     *
     * @return string 
     */
    public function getDistanceToBeach()
    {
        return $this->distanceToBeach;
    }

    /**
     * Set map
     *
     * @param string $map
     * @return Address
     */
    public function setMap($map)
    {
        $this->map = $map;
    
        return $this;
    }

    /**
     * Get map
     *
     * @return string 
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set gpsLon
     *
     * @param string $gpsLon
     * @return Address
     */
    public function setGpsLon($gpsLon)
    {
        $this->gpsLon = $gpsLon;
    
        return $this;
    }

    /**
     * Get gpsLon
     *
     * @return string 
     */
    public function getGpsLon()
    {
        return $this->gpsLon;
    }

    /**
     * Set gpsLat
     *
     * @param string $gpsLat
     * @return Address
     */
    public function setGpsLat($gpsLat)
    {
        $this->gpsLat = $gpsLat;
    
        return $this;
    }

    /**
     * Get gpsLat
     *
     * @return string 
     */
    public function getGpsLat()
    {
        return $this->gpsLat;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Address
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
    
    public function getFullAddress()
    {
    	$address = "";
    		$address .= ($this->adrStreet1? $this->adrStreet1." ":"");
    		$address .= ($this->adrStreet2? "Moo ".$this->adrStreet2.", ":"");
    		$address .= ($this->adrStreet3? $this->adrStreet3.", ":"");
    		$address .= ($this->adrStreet4? "Soi ".$this->adrStreet4.", ":"");
    		$address .= ($this->adrStreet5? $this->adrStreet5.", ":"");
    		$address .= ($this->adrStreet6? $this->adrStreet6.", ":"");
    		$address .= ($this->adrCity? $this->adrCity.", ":"");
    		$address .= ($this->adrProvince? $this->adrProvince.", ":"");
    		$address .= ($this->adrZip? $this->adrZip.", ":"");
    		$address .= ($this->adrCountry? $this->adrCountry:"");
    		
    		if ($address == "Thailand") {
    			$address = $this->text;
    		}
    		
    		return $address;
    }

    /**
     * Set adrStreet1
     *
     * @param string $adrStreet1
     * @return Address
     */
    public function setAdrStreet1($adrStreet1)
    {
        $this->adrStreet1 = $adrStreet1;
    
        return $this;
    }

    /**
     * Get adrStreet1
     *
     * @return string 
     */
    public function getAdrStreet1()
    {
        return $this->adrStreet1;
    }

    /**
     * Set adrStreet2
     *
     * @param string $adrStreet2
     * @return Address
     */
    public function setAdrStreet2($adrStreet2)
    {
        $this->adrStreet2 = $adrStreet2;
    
        return $this;
    }

    /**
     * Get adrStreet2
     *
     * @return string 
     */
    public function getAdrStreet2()
    {
        return $this->adrStreet2;
    }

    /**
     * Set adrStreet3
     *
     * @param string $adrStreet3
     * @return Address
     */
    public function setAdrStreet3($adrStreet3)
    {
        $this->adrStreet3 = $adrStreet3;
    
        return $this;
    }

    /**
     * Get adrStreet3
     *
     * @return string 
     */
    public function getAdrStreet3()
    {
        return $this->adrStreet3;
    }

    /**
     * Set adrStreet4
     *
     * @param string $adrStreet4
     * @return Address
     */
    public function setAdrStreet4($adrStreet4)
    {
        $this->adrStreet4 = $adrStreet4;
    
        return $this;
    }

    /**
     * Get adrStreet4
     *
     * @return string 
     */
    public function getAdrStreet4()
    {
        return $this->adrStreet4;
    }

    /**
     * Set adrStreet5
     *
     * @param string $adrStreet5
     * @return Address
     */
    public function setAdrStreet5($adrStreet5)
    {
        $this->adrStreet5 = $adrStreet5;
    
        return $this;
    }

    /**
     * Get adrStreet5
     *
     * @return string 
     */
    public function getAdrStreet5()
    {
        return $this->adrStreet5;
    }

    /**
     * Set adrStreet6
     *
     * @param string $adrStreet6
     * @return Address
     */
    public function setAdrStreet6($adrStreet6)
    {
        $this->adrStreet6 = $adrStreet6;
    
        return $this;
    }

    /**
     * Get adrStreet6
     *
     * @return string 
     */
    public function getAdrStreet6()
    {
        return $this->adrStreet6;
    }

    /**
     * Set adrCity
     *
     * @param string $adrCity
     * @return Address
     */
    public function setAdrCity($adrCity)
    {
        $this->adrCity = $adrCity;
    
        return $this;
    }

    /**
     * Get adrCity
     *
     * @return string 
     */
    public function getAdrCity()
    {
        return $this->adrCity;
    }

    /**
     * Set adrProvince
     *
     * @param string $adrProvince
     * @return Address
     */
    public function setAdrProvince($adrProvince)
    {
        $this->adrProvince = $adrProvince;
    
        return $this;
    }

    /**
     * Get adrProvince
     *
     * @return string 
     */
    public function getAdrProvince()
    {
        return $this->adrProvince;
    }

    /**
     * Set adrZip
     *
     * @param string $adrZip
     * @return Address
     */
    public function setAdrZip($adrZip)
    {
        $this->adrZip = $adrZip;
    
        return $this;
    }

    /**
     * Get adrZip
     *
     * @return string 
     */
    public function getAdrZip()
    {
        return $this->adrZip;
    }

    /**
     * Set adrCountry
     *
     * @param string $adrCountry
     * @return Address
     */
    public function setAdrCountry($adrCountry)
    {
        $this->adrCountry = $adrCountry;
    
        return $this;
    }

    /**
     * Get adrCountry
     *
     * @return string 
     */
    public function getAdrCountry()
    {
        return $this->adrCountry;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return Address
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    
        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedOn
     *
     * @param \DateTime $updatedOn
     * @return Address
     */
    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
    
        return $this;
    }

    /**
     * Get updatedOn
     *
     * @return \DateTime 
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set district
     *
     * @param PHRentals\MainBundle\Entity\District $district
     * @return Address
     */
    public function setDistrict(\PHRentals\MainBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return PHRentals\MainBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add tags
     *
     * @param PHRentals\MainBundle\Entity\AddressTag $tags
     * @return Address
     */
    public function addTag(\PHRentals\MainBundle\Entity\AddressTag $tags)
    {
    	$this->tags->removeElement($tags);
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param PHRentals\MainBundle\Entity\AddressTag $tags
     */
    public function removeTag(\PHRentals\MainBundle\Entity\AddressTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    public function hasTag($search)
    {
    	foreach($this->tags as $tag) {
    
    		if ($tag->getName() == $search) return true;
    	}
    	return false;
    }

    /**
     * Add units
     *
     * @param PHRentals\MainBundle\Entity\Unit $units
     * @return Address
     */
    public function addUnit(\PHRentals\MainBundle\Entity\Unit $unit)
    {
    	$unit->setAddress($this);
        $this->units[] = $unit;
    
        return $this;
    }

    /**
     * Remove units
     *
     * @param PHRentals\MainBundle\Entity\Unit $units
     */
    public function removeUnit(\PHRentals\MainBundle\Entity\Unit $unit)
    {
    	$unit->setAddress(null);
        $this->units->removeElement($unit);
    }

    /**
     * Get units
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Set class
     *
     * @param PHRentals\MainBundle\Entity\AddressClass $class
     * @return Address
     */
    public function setClass(\PHRentals\MainBundle\Entity\AddressClass $class = null)
    {
        $this->class = $class;
    
        return $this;
    }

    /**
     * Get class
     *
     * @return PHRentals\MainBundle\Entity\AddressClass 
     */
    public function getClass()
    {
        return $this->class;
    }
}