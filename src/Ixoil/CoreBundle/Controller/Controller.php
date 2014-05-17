<?php

namespace Ixoil\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of Controller
 *
 * @author fantoine
 */
class Controller extends BaseController
{
    // use Traits\FlashMessageControllerTrait; : Not required as it's already used with RouterControllerTrait
    use Traits\BreadcrumbControllerTrait;
    use Traits\RouterControllerTrait;
    use Traits\SeoControllerTrait;
    use Traits\TranslatorControllerTrait;
}
