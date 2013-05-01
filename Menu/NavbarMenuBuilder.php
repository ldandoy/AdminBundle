<?php

namespace StartPack\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

/**
 * Classe de génération du menu du BO
 */
class NavbarMenuBuilder extends AbstractNavbarMenuBuilder {
	protected $securityContext;
	protected $isAdmin;
	protected $isSuperAdmin;
	protected $isSociete;

	/**
	 * Contructeur de la classe
	 *
	 * @param FactoryInterface         $factory         tt
	 * @param SecurityContextInterface $securityContext tt
	 */
	public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext) {
		parent::__construct($factory);
		$this->securityContext = $securityContext;
		$this->isAdmin = $this->securityContext->isGranted('ROLE_ADMIN');
		$this->isSuperAdmin = $this->securityContext->isGranted('ROLE_SUPER_ADMIN');
	}

	/**
	 * Creation du menu principal
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return type
	 */
	public function createMainMenu(Request $request) {
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav');
		/*if ($this->isSuperAdmin) {
		    $dropdownSA = $this->createDropdownMenuItem($menu, "Gestion du site");
		    $dropdownSA->addChild('Actualités', array('route' => 'admin_actualite_index'));
		    $dropdownSA->addChild('Avantages', array('route' => 'admin_avantage_index'));
		    $dropdownSA->addChild('Evènements', array('route' => 'admin_event_index'));
		    $dropdownSA->addChild('Région', array('route' => 'admin_region_index'));
		    $dropdownSA->addChild('Slideshow', array('route' => 'admin_slideshow_index'));
		    $dropdownSA->addChild('Centre d\'intêret', array('route' => 'admin_interest_index'));
		}
		
		if ($this->isSuperAdmin || $this->isAdmin) {
		    $dropdownA = $this->createDropdownMenuItem($menu, "CRM");
		    $dropdownA->addChild('Distributeurs', array('route' => 'crm_distributeur_index'));
		    $dropdownA->addChild('Clients', array('route' => 'crm_fiche_index'));
		}*/

		if ($this->isAdmin) {
			$menu->addChild('Users', array('route' => 'admin_user_index'));
		}

		return $menu;
	}
}
