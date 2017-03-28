<?php

namespace BackendBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CoreBundle\Entity\Connection;
use CoreBundle\Form\ConnectionType;

/**
 * Connection controller.
 *
 * @Route("/connection")
 */
class ConnectionController extends Controller
{

    /**
     * Lists all Connection entities.
     *
     * @Route("/", name="connection")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // Filter form
        $filterForm = $this->createFilterForm();
        $filterForm->handleRequest($request);
        $filterData = $filterForm->getData();

        // Filter by url params
        if($urlParams = $request->query->get('filter')) {
            foreach ($urlParams as $key => $urlParam) {
                $filterData[$key] = $urlParam;
            }
        }

        // Get data
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CoreBundle:Connection')->queryFilter($filterData);

        // Pagination
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($entities, $request->query->getInt('page', 1));

        return array(
            'entitiesPagination' => $pagination,
            'form' => $filterForm->createView()
        );
    }

    /**
     * Creates or updates a connection entity.
     *
     * @Route("/create", name="connection_create")
     * @Route("/update/{id}", name="connection_update")
     * @Template()
     */
    public function updateAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        // Get entity
        if (!is_null($id)) { /* edit mode */
            $connection = $em->getRepository('CoreBundle:Connection')->find($id);
        } else { /* create mode */
            $connection = new Connection();
        }

        // Get form
        $formUrl = $this->generateUrl($request->get('_route'), $request->get('_route_params'));
        $form = $this->createConnectionForm($connection, $formUrl);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                try {
                    $em->persist($connection);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('success', 'Acción realizada correctamente.');
                    return $this->redirect($this->generateUrl('connection', array('id' => $connection->getId())));

                } catch (\Exception $e) {
                    $this->get('session')->getFlashBag()->add('error', 'La entidad ya existe.');
                }

            } else {
                $this->get('session')->getFlashBag()->add('error', 'El formulario contiene errores.');
            }
        }

        return array(
            'connection' => $connection,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a connection form
     *
     * @param Connection $entity
     * @param $url
     * @return \Symfony\Component\Form\Form
     */
    private function createConnectionForm(Connection $entity, $url)
    {
        $form = $this->createForm(new ConnectionType(), $entity, array(
            'action' => $url,
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Deletes a Connection entity.
     *
     * @Route("/delete/{id}", name="connection_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CoreBundle:Connection')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Connection entity.');
        }

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Acción realizada correctamente.');
        return $this->redirect($this->generateUrl('connection'));
    }

    /**
     * @return Form
     */
    private function createFilterForm()
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder
            ->add('company', 'entity', array('label' => 'Empresa', 'class' => 'CoreBundle:Company', 'required' => false))
            ->add('type', 'choice', array('label' => 'Tipo de conexión', 'required' => false,
                'choices' => array('0' => 'Cliente', '1' => 'Proveedor')))
            ->add('save', 'submit', array('label' => 'Filtrar', 'attr' => array('class' => 'btn-default')))
            ->setAction($this->generateUrl('connection'))
            ->setMethod('GET');
        return $formBuilder->getForm();
    }
}
