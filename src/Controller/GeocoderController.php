<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Interfaces\GeocoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeocoderController extends AbstractController
{
    #[Route('/geocoder')]
    public function index(): Response
    {
        $address = new Address();

        $form = $this->createFormBuilder($address)
            ->add('name', ChoiceType::class, [
                'label' => 'Turno:',
                'attr' => [
                    'class' => 'form-control address-search',
                    'placeholder' => '-Seleccione un turno',
                ],
                'choices' => [
                ],
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        return $this->render('geocoder/index.html.twig', ['form' => $form]);
    }

    #[Route('geocoder/search')]
    public function search(Request $request, GeocoderInterface $geocoder): JsonResponse
    {
        $query = $request->get('q');
        return $geocoder->search($query);
    }
}