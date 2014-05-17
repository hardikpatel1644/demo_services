<?php

namespace Ixoil\CoreBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * Class DateExtension
 * @package Ixoil\CoreBundle\Twig\Extension
 */
class DateExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected $translator;
    
    /**
     * @param \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ixoil_core_date';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'datediff'        => new \Twig_Filter_Method($this, 'datediff'),
        );
    }

    /**
     * Compare 2 dates and return a diff string
     * @param string|\DateTime $from
     * @param string|\DateTime $to
     * @return string
     */
    public function datediff($from, $to)
    {
        // Create datetimes
        $dateFrom   = ($from instanceof \DateTime ? $from : new \DateTime($from));
        $dateTo     = ($to instanceof \DateTime ? $to : new \DateTime($to));
        
        // Get the interval
        $interval = $dateTo->diff($dateFrom);
        
        // Format string
        $format = "";
        $levels = array('y', 'm', 'd', 'h', 'i', 's');
        foreach ($levels as $i => $level) {
            // Display only 2 levels of diff (eg: hours and minutes)
            $diff = $interval->{$level};
            if ($diff) {
                $format = $this->translator->transChoice('format.level.'.$level, $diff, array('%value%' => $diff), 'twig_date');
                
                // If it's not the last level, add next one
                if ($i < count($levels) - 1) {
                    // Get next format
                    $nextLevel = $levels[$i + 1];
                    $diff2 = $interval->{$nextLevel};
                    $nextFormat = $this->translator->transChoice(
                        'format.level.'.$nextLevel, 
                        $diff2, 
                        array('%value%' => $diff2), 
                        'twig_date'
                    );
                    
                    // Concatenate both formats
                    $format = $this->translator->trans(
                        'format.and', 
                        array(
                            '%value1%' => $format,
                            '%value2' => $nextFormat,
                        ),
                        'twig_date'
                    );
                }
                
                break;
            }
        }
        
        // Return translation
        return $this->translator->transChoice(
            'format.period', 
            $interval->invert, 
            array('%date%' => $format), 
            'twig_date'
        );
    }
}