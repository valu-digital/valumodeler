<?php
namespace ValuModeler;

class Utils
{
    const CLASS_NS = 'ValuX';
    
    const CACHE_NS = 'ValuModeler_';
    
    public static function docNameToClass($docName)
    {
        return self::CLASS_NS . '\\' . $docName;
    }
    
    public static function classToDocName($className)
    {
        if(strpos($className, self::CLASS_NS . '\\') === 0){
            $documentName = substr($className, strlen(self::CLASS_NS)+1);
            
            return $documentName;
            //return str_replace('\\', '/', $documentName);
        }
        else{
            return false;
        }
    }
    
    public static function docNameToCacheId($docName)
    {
        return self::CACHE_NS . str_replace('\\', '_', $docName);
    }
}