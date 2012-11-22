<?php

namespace StartPack\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use StartPack\CoreBundle\Entity as Model;
use StartPack\CoreBundle\Form as Form;

use StartPack\CoreBundle\Controller\AbstractCoreController;


/**
 * @Route("/admin/config")
 */
class ConfigController extends AbstractCoreController
{

	/**
	 * @Route("/", name="admin_config_index")
	 * @Template()
	 */
    public function indexAction()
    {
		$configs = $this->getDoctrine()->getRepository('CoreBundle:Config')->findAll();

        return array(
            "configs"  =>  $configs,
            'activeConfig' => true
        );
    }
}
