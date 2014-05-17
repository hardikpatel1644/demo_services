<?php

namespace Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of TranslatorControllerTrait
 *
 * @author fantoine
 */
trait TranslatorControllerTrait {
    /**
     * Translator
     */
    private $translator;
    
    /**
     * Translate the given message
     * @param string $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     * @return string
     */
    protected function trans($id, $parameters = array(), $domain = null, $locale = null)
    {
        if (!$this->translator)
            $this->translator = $this->get('translator');
        
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
    
    /**
     * Translates the given choice message by choosing a translation according to a number.
     * @param string $id
     * @param integer $number
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     */
    protected function transChoice($id, $number, $parameters = array(), $domain = null, $locale = null)
    {
        if (!$this->translator)
            $this->translator = $this->get('translator');
        
        return $this->translator->transChoice($id, $number, $parameters, $domain, $locale);
    }
}
