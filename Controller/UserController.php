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
 * @Route("/admin/user")
 */
class UserController extends AbstractCoreController {

	/**
	 * @Route("/", name="admin_user_index")
	 * @Template()
	 */
	public function listAction() {
		$users = $this->getDoctrine()->getRepository('CoreBundle:User')->findAll();

		return array(
			'users'         => $users,
			'config'	    => $this->getConfig(),
			'activeUser'    => true
		);
	}

	/**
	 * @Route("/{id}/view", name="admin_user_view")
	 * @Template()
	 */
	public function viewAction(Model\User $user) {
		return array(
			'user' 			=> $user,
			'config'		=> $this->getConfig(),
			'activeUser' 	=> true
		);
	}

	/**
	 * @Route("/edit/{id}", name="admin_user_edit")
	 * @Template()
	 */
	public function editAction(Model\User $user) {
		$form = $this->createForm(new Form\UserType(), $user);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($user);
				$em->flush();
				return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $user->getId())));
			}
		}
		return array(
			'user' 		    => $user,
			'config'	    => $this->getConfig(),
			'form' 		    => $form->createView(),
			'activeUser'    => true
		);
	}

	/**
	 * @Route("/add", name="admin_user_add")
	 * @Template()
	 */
	public function addAction() {
		$form = $this->createForm(new Form\UserType(), new Model\User());
		return array(
            "form"          => $form->createView(),
            "activeUser"    => true
        );
	}
}
