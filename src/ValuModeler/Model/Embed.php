<?php
namespace ValuModeler\Model;

use Valu\Model\InputFilterTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class Embed
{
    use InputFilterTrait;
    
    const EMBED_ONE = 'embed_one';
    
    const EMBED_MANY = 'embed_many';

	/**
	 * @ODM\Id
	 * @var string
	 */
    private $id;
    
    /**
     * @ODM\String
     * @var string
     */
    private $name;
    
    /**
     * @ODM\String
     * @var string
     */
    private $type;

    /**
     * @ODM\ReferenceOne(targetDocument="ValuModeler\Model\Document")
     * @var Document
     */
    private $document;
    
    /**
     * Default input filter instance
     *
     * @var Zend\InputFilter\InputFilter
     */
    protected static $defaultInputFilter;
    
    public function __construct($name, $type, Document $document)
    {
        $this->setName($name);
        $this->setType($type);
        $this->setDocument($document);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType($type)
    {
        if(!in_array($type, array(self::EMBED_ONE, self::EMBED_MANY))){
            throw new \InvalidArgumentException('Invalid embed type, embed_one or embed_many expected');
        }
        
        $this->type = $type;
    }
    
    public function getDocument()
    {
        return $this->document;
    }
    
    public function setDocument(Document $document)
    {
        $this->document = $document;
    }
}