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
class ConfigController extends AbstractCoreController {

	/**
	 * @Route("/", name="admin_config_index")
	 * @Template()
	 */
	public function indexAction() {
		$configs = $this->getDoctrine()->getRepository('CoreBundle:Config')->findAll();
		$form = $this->createForm(new Form\ConfigType(), new Model\Config());
		
		foreach ($configs AS $config) {
			$configsForm[$config->getId()] = $this->createForm(new Form\ConfigLineType(), $config)->createView();
		}
		
		return array(
			"configs" => $configsForm,
			'activeConfig' => true,
			'form' => $form->createView()
		);
	}
	
	/**
	 * @Route("/{id}/save", name="admin_config_save")
	 * @Template()
	 */
	public function saveAction($id) {
		if ($id) {
			$config = $this->getDoctrine()->getRepository('CoreBundle:Config')->findOneById($id);
			$form = $this->createForm(new Form\ConfigLineType(), $config);
		} else {
			$config = new Model\Config();
			$form = $this->createForm(new Form\ConfigType(), $config);
		}
		
		if ($this->getRequest()->getMethod() == 'POST') {
			$form->bind($this->getRequest());
			if ($form->isValid()) {
				$this->get('session')->setFlash('success', "Configuration bien mise à jour");
				$this->saveAndFlush($config);
			} else {
				$this->get('session')->setFlash('error', $form->getErrorsAsString());
			}
		}
		
		return $this->redirect($this->generateUrl('admin_config_index'));
	}
	
	/**
	 * @Route("/{id}/del", name="admin_config_del")
	 * @Template()
	 */
	public function delAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		$config = $this->getDoctrine()->getRepository('CoreBundle:Config')->findOneById($id);
		
		if ($config) {
			$em->remove($config);
			$em->flush();
			$this->get('session')->setFlash('success', "Configuration bien supprimé");
		} else {
			$this->get('session')->setFlash('error', 'Configruration non supprimé');
		}
		
		
		return $this->redirect($this->generateUrl('admin_config_index'));
	}
}
