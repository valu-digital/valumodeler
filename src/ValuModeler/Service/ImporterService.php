<?php
namespace ValuModeler\Service;

use ValuModeler\Model;
use ValuModeler\Service\Exception;
use ValuSo\Annotation as ValuService;
use ValuSo\Feature;
use ValuSo\Broker\ServiceBroker;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Zend\InputFilter\Factory;

/**
 * Import service
 * 
 * @Annotation\Context("native")
 */
 class ImporterService 
    implements  Feature\ServiceBrokerAwareInterface,
                Feature\ProxyAwareInterface
{
    
    use Feature\ServiceBrokerTrait;
    
    /**
     * @var ImporterService
     */
    protected $proxy;
    
    /**
     * Import documents
     * 
     * @param array $specs
     */
    public function import(array $specs)
    {
        $result = array();
        
        foreach ($specs as $key => $docSpecs) {
            $name = isset($docSpecs['name']) ? $docSpecs['name'] : null;
            $fields = isset($docSpecs['fields']) ? $docSpecs['fields'] : null;
            unset($docSpecs['fields']);
            
            $associations = isset($docSpecs['associations']) ? $docSpecs['associations'] : null;
            unset($docSpecs['associations']);
            
            $document = $this->getDocumentService()->upsert($name, $docSpecs);
            
            if ($document && !empty($fields)) {
                $this->getFieldService()->upsertMany($document, $fields);
            }
            
            if ($document && !empty($associations)) {
                $this->getAssociationService()->upsertMany($document, $associations);
            }
            
            $result[$key] = $document;
        }
        
        return $result;
    }

    /**
     * @see \ValuSo\Feature\ProxyAwareInterface
     */
    public function setServiceProxy($serviceProxy)
    {
        $this->proxy = $serviceProxy;
    }
    
    /**
     * @return \ValuModeler\Service\DocumentService
     */
    protected function getDocumentService()
    {
        return $this->getServiceBroker()->service('Modeler.Document');
    }
    
    /**
     * @return \ValuModeler\Service\FieldService
     */
    protected function getFieldService()
    {
        return $this->getServiceBroker()->service('Modeler.Field');
    }
    
    /**
     * @return \ValuModeler\Service\AssociationService
     */
    protected function getAssociationService()
    {
        return $this->getServiceBroker()->service('Modeler.Association');
    }
}