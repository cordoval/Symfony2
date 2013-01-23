<?php

namespace PHRentals\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PHPImageWorkshop\ImageWorkshop;

/**
 * PHRentals\MainBundle\Entity\UnitImage
 *
 * @ORM\Table(name="unit_image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks 
 */
class UnitImage
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
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank
	 */
	public $name;
	
	/**
	 * @Assert\File(maxSize="6000000")
	 */
	public $file;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Unit", inversedBy="images")
	 * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
	 */
	protected $unit;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	public $path;
	
	public function getAbsolutePath()
	{
		return null === $this->path
		? null
		: __DIR__.'/../../../../../'.$this->path;
	}
	
	public function getWebPath()
	{
		return null === $this->path
		? null
		: $this->getUploadDir().'/'.$this->path;
	}
	
	protected function getUploadRootDir()
	{
		// the absolute directory path where uploaded
		// documents should be saved
		return __DIR__.'/../../../../../'.$this->getUploadDir();
	}
	
	protected function getUploadDir()
	{
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		return 'uploaded_file/property/'.$this->getUnit()->getPRef();
	}
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if (null !== $this->file) {
			// do whatever you want to generate a unique name
			//$filename = sha1(uniqid(mt_rand(), true));
		$filename = 0;
			
		if(count($this->getUnit()->getImages())>1) {
			foreach($this->getUnit()->getImages() as $image) {
				$image_split = explode(".",$image->getName());
				if(is_numeric($image_split[0]) && $image_split[0] >= $filename) {
					$filename = intval($image_split[0]);
					$filename++;
				}
			}
		}
		if($filename == "") {
			$filename = 0;
		}
		$filename = $filename.".jpg";
		$this->name = $filename;
		$this->path = $this->getUploadDir().'/'.$filename;
		}
	}
	
	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if (null === $this->file) {
			return;
		}
	
		// if there is an error when moving the file, an exception will
		// be automatically thrown by move(). This will properly prevent
		// the entity from being persisted to the database on error
		$this->file->move($this->getUploadRootDir(), $this->path);
		
		$resized = ImageWorkshop::initFromPath($this->getUploadRootDir().'/'.$this->name);
		$thumbnail = clone $resized;
		
		$resized->resizeInPixel('465', '350');
		$thumbnail->resizeInPixel('154', '115');
		
		$resized->save($this->getUploadRootDir(), $this->name, true, null, '70');
		$thumbnail->save(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$this->getUnit()->getPRef(), $this->name, true, null, '70');

		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/'.$this->getUnit()->getPRef(), 0777);
		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$this->getUnit()->getPRef(), 0777);
		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/'.$this->getUnit()->getPRef().'/'.$this->name, 0777);
		chmod(__DIR__.'/../../../../../'.'uploaded_file/property/thumb/'.$this->getUnit()->getPRef().'/'.$this->name, 0777);
		
		unset($this->file);
	}
	
	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		if ($file = $this->getAbsolutePath()) {
			$thumb = str_replace("property", "property/thumb", $file);
			unlink($file);
			unlink($thumb);
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
     * Set name
     *
     * @param string $name
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set unit
     *
     * @param PHRentals\MainBundle\Entity\Unit $unit
     * @return Image
     */
    public function setUnit(\PHRentals\MainBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return PHRentals\MainBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}