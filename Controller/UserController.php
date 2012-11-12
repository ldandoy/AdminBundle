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

use StartPack\CoreBundle\Entity\User;

use StartPack\CoreBundle\Controller\AbstractCoreController;


/**
 * @Route("/admin/user")
 */
class UserController extends AbstractCoreController
{

	/**
	 * @Route("/", name="user_index")
	 * @Template()
	 */
    public function indexAction()
    {
		$users = $this->getDoctrine()->getRepository('CoreBundle:User')->findAll();

        return array(
            "users"  =>  $users,
            'activeUser' => true
        );
    }
    
    /**
     * @Route("/{id}/view", name="user_view")
     * @Template()
     */
    public function viewAction(User $user)
    {
        return array(
            "user"  =>  $user,
            'activeUser' => true
        );
    }
}
