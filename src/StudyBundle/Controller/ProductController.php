<?php

namespace StudyBundle\Controller;

use StudyBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product/create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add("description", TextType::class, [
                "label" => "Descrição",
                "required" => true,
                "attr" => [
                    "class" => "input-text",
                    "placeholder" => "Descrição",
                    "title" => "Descrição"
                ]
            ])->add("name", TextType::class, [
                "label" => "Nome",
                "required" => true,
                "attr" => [
                    "class" => "input-text",
                    "placeholder" => "Nome",
                    "title" => "Nome"
                ]
            ])->add("price", NumberType::class, [
                "label" => "Preço",
                "required" => true,
                "attr" => [
                    "class" => "input-text",
                    "placeholder" => "Preço",
                    "title" => "Preço"
                ]
            ])->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('task_success');
        }

        return $this->render('StudyBundle:Product:create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
