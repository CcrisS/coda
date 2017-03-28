<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CoreBundle\Entity\Company;
use CoreBundle\Form\CompanyType;

/**
 * Company controller.
 *
 * @Route("/company")
 */
class CompanyController extends Controller
{

    /**
     * Lists all Company entities.
     *
     * @Route("/", name="company")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CoreBundle:Company')->findAll();

        // Pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1));

        return array(
            'entitiesPagination' => $pagination,
        );
    }

    /**
     * Creates or updates a company entity.
     *
     * @Route("/create", name="company_create")
     * @Route("/update/{id}", name="company_update")
     * @Template()
     */
    public function updateAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        // Get entity
        if (!is_null($id)) { /* edit mode */
            $company = $em->getRepository('CoreBundle:Company')->find($id);
        } else { /* create mode */
            $company = new Company();
        }

        // Get form
        $formUrl = $this->generateUrl($request->get('_route'), $request->get('_route_params'));
        $form = $this->createCompanyForm($company, $formUrl);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                try {
                    $em->persist($company);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success', 'Acción realizada correctamente.');
                    return $this->redirect($this->generateUrl('company', array('id' => $company->getId())));

                } catch (\Exception $e) {
                    $this->get('session')->getFlashBag()->add('error', 'El formulario contiene errores.');
                }

            } else {
                $this->get('session')->getFlashBag()->add('error', 'El formulario contiene errores.');
            }
        }

        return array(
            'company' => $company,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a company form
     *
     * @param Company $entity
     * @param $url
     * @return \Symfony\Component\Form\Form
     */
    private function createCompanyForm(Company $entity, $url)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $url,
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Deletes a Company entity.
     *
     * @Route("/delete/{id}", name="company_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CoreBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Acción realizada correctamente.');
        return $this->redirect($this->generateUrl('company'));
    }

}
