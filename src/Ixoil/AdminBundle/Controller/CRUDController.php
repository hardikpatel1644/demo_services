<?php

namespace Ixoil\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseController;
use Ixoil\CoreBundle\Controller\Traits;

/**
 * Description of CRUDController
 *
 * @author fantoine
 */
class CRUDController extends BaseController {
    use Traits\RouterControllerTrait;
    use Traits\TranslatorControllerTrait;
}
