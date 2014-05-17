<?php

namespace Ixoil\JVectorMapBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Description of RegionTransformer
 *
 * @author OXIND
 */
class RegionTransformer implements DataTransformerInterface
{  
    public function reverseTransform($value)
    {
        if (!$value && $value['regions'] && $value['codes'])
            return null;
        
        $arrRegions = (!empty($value['regions']) ? explode(',', $value['regions']) : array());
        $arrCodes = (!empty($value['regions']) ? explode(',', $value['codes']) : array());
        
        return (count($arrRegions) == count($arrCodes) ?
            array_combine($arrCodes, $arrRegions) :
            null
        );
    }

    public function transform($value)
    {
        if ( !$value || !is_array($value) )
            return null;
        
        $strCodes = implode(',', array_keys( $value ));
        $strRegions = implode(',', array_values( $value ));
        
        return ( array('codes' => $strCodes, 'regions' => $strRegions ));
    }
}
