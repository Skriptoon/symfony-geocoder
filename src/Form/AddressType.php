<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', ChoiceType::class, [
            'label' => 'Адрес:',
            'attr' => [
                'class' => 'form-control address-search',
            ],
            'choices' => [
            ],
        ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();
                if (isset($data['address'])) {
                    $form->add('address', ChoiceType::class, [
                        'choices' => [
                            $data['address'],
                        ],
                    ])
                        ->add('coordinate', TextType::class);
                }
            }
        );
    }
}