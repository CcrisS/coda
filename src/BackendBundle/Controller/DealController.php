<?php

namespace BackendBundle\Controller;

use CoreBundle\Entity\DealNode;
use CoreBundle\Form\DealNodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CoreBundle\Entity\Deal;
use CoreBundle\Form\DealType;

/**
 * Deal controller.
 *
 * @Route("/deal")
 */
class DealController extends Controller
{

    /**
     * Lists all Deal entities.
     *
     * @Route("/", name="deal")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        // Get data
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CoreBundle:Deal')->queryFilter();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates or updates a deal entity.
     *
     * @Route("/create", name="deal_create")
     * @Route("/update/{id}", name="deal_update")
     * @Template()
     */
    public function updateAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        // Get entity
        if (!is_null($id)) { /* edit mode */
            $deal = $em->getRepository('CoreBundle:Deal')->find($id);
        } else { /* create mode */
            $deal = new Deal();
        }

        // Get form
        $formUrl = $this->generateUrl($request->get('_route'), $request->get('_route_params'));
        $form = $this->createDealForm($deal, $formUrl);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($deal);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Acción realizada correctamente.');
                return $this->redirect($this->generateUrl('deal', array('id' => $deal->getId())));
            } else {
                $this->get('session')->getFlashBag()->add('error', 'El formulario contiene errores.');
            }
        }

        return array(
            'deal' => $deal,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a deal form
     *
     * @param Deal $entity
     * @param $url
     * @return \Symfony\Component\Form\Form
     */
    private function createDealForm(Deal $entity, $url)
    {
        $form = $this->createForm(new DealType(), $entity, array(
            'action' => $url,
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Deletes a Deal entity.
     *
     * @Route("/delete/{id}", name="deal_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CoreBundle:Deal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deal entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('deal'));
    }

    /**
     * Returns a deal node form
     *
     * @Route("/deal_node_form", name="deal_node_form")
     */
    public function getDealNodeFormAction(Request $request)
    {
        $previousConnection = null;
        if($previousConnectionId = $request->query->get('previousConnectionId')){
            $em = $this->getDoctrine()->getManager();
            $previousConnection = $em->getRepository('CoreBundle:Connection')->find($previousConnectionId);
        }

        $form = $this->createForm(new DealNodeType($previousConnection), new DealNode());
        return $this->render('BackendBundle:Form:show_form.html.twig', array('form' => $form->createView()));
    }

}
