<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Interfaces\GeocoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeocoderController extends AbstractController
{
    #[Route('/addresses', name: 'addresses')]
    public function index(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Address::class);

        $addresses = $repo->findAll();

        return $this->render('geocoder/index.html.twig', ['addresses' => $addresses]);
    }

    #[Route('/addresses/create', name: 'create_address')]
    public function addAddress(
        Request $request,
        GeocoderInterface $geocoder,
        EntityManagerInterface $entityManager,
    ): Response {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        if ($request->isMethod('POST')) {
            $formData = $request->get($form->getName());

            $addressInfo = $geocoder->search($formData['address']);

            if (count($addressInfo) > 0 && $addressInfo[0]['exact'] === true) {
                $form->submit(
                    array_merge(
                        ['coordinate' => $addressInfo[0]['coordinate']],
                        $formData,
                    )
                );


                if ($form->isSubmitted()) {
                    $entityManager->persist($address);
                    $entityManager->flush();

                    return $this->redirectToRoute('addresses');
                }
            }
        }

        return $this->render('geocoder/create.html.twig', ['form' => $form]);
    }

    #[Route('geocoder/search')]
    public function search(Request $request, GeocoderInterface $geocoder): JsonResponse
    {
        $query = $request->get('q');
        $addresses = $geocoder->search($query);

        $searchResult = [];
        foreach ($addresses as $address) {
            $searchResult[] = [
                'text' => $address['address'],
                'id' => $address['address'],
            ];
        }

        return $this->json(['results' => $searchResult]);
    }
}