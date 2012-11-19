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

    
    /**
     * @Route("/edit/{id}", name="user_edit")
     * @Template()
     */
    public function editAction(User $user)
    {
        $form = $this->createForm(new Form\UserType(),$user);
        
        $request = $this->get('request');
        if($request->getMethod() == 'POST'){
            $form->bind($request);
            die($form->getErrorsAsString());
            if($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('user_edit',array('id' => $user->getId())));
            }
        }
        return array(
            "user"  =>  $user,
            'form' => $form->createView()
        );
    }
    
    /**
     * @Route("/add", name="user_add")
     * @Template()
     */
    public function addAction()
    {
        $form = $this->createForm(new Form\UserType(), new Model\User());
        
        
        return array(
            "form"  =>  $form->createView(),
            'activeUser' => true
        );
    }
}
