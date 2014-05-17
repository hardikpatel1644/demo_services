<?php

namespace Ixoil\CoreBundle\Menu;

use Knp\Menu\ItemInterface;
use Ixoil\CoreBundle\Menu\Restricted;
use Ixoil\UserBundle\Model\AccountType;

/**
 * Description of RestrictedMenu
 *
 * @author OXIND
 */
class RestrictedMenu extends Menu
{
    /**
     *
     * @var type 
     */
    protected $securityContext;
    
    /**
     * 
     * @param type $securityContext
     */
    public function __construct($securityContext) {
        parent::__construct();
        
        $this->securityContext = $securityContext;
    }
    /**
     * @override
     * @return \Knp\Menu\ItemInterface
     */
    public function build(ItemInterface $menu)
    {
        // Add default menus
        $menu
            ->addChild(
                'restricted.dashboard',
                array('route' => 'ixoil_dashboard')
            )
            ->setExtra('icon', 'dashboard') // for <i> tag
            ->setExtra('color', 'danger'); // for <b> tag

        $myaccount = $menu
            ->addChild(
                'restricted.account.title'
            )
            ->setExtra('icon', 'cog')
            ->setExtra('color', 'warning');
        $myaccount
            ->addChild(
                'restricted.account.managemyaccount',
                array('route' => 'ixoil_index')
            );
        $myaccount
            ->addChild(
                'restricted.account.mysubscription',
                array('route' => 'ixoil_index')
            );
        
        $myusers = $menu
            ->addChild(
                'restricted.users.title'
            )
            ->setExtra('icon', 'users');
        $myusers->addChild(
            'restricted.users.create',
            array('route' => 'ixoil_user_subuser_create')
        );
        $myusers->addChild(
            'restricted.users.list',
            array('route' => 'ixoil_user_subuser_list')
        );
        
        // Add decorators
        $this->addDecorators();
    }
    
    protected function addDecorators()
    {
        // Determine user account type
        $user = $this->securityContext->getToken()->getUser();
        $accountType = ($user ? $user->getAccountType() : null);

        // Add specific menus
        switch ($accountType) {
            case AccountType::Provider:
                $this->addDecorator(new Restricted\ProviderMenu());
                break;

            case AccountType::Purchaser:
                $this->addDecorator(new Restricted\PurchaserMenu());
                break;

            case AccountType::Logistician:
                $this->addDecorator(new Restricted\LogisticianMenu());
                break;

            case AccountType::PurchaserLogistician:
                $this->addDecorator(new Restricted\PurchaserMenu());
                $this->addDecorator(new Restricted\LogisticianMenu());
                break;
        }
    }
}