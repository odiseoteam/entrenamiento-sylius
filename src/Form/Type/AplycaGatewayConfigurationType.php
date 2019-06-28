<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AplycaGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('environment', TextType::class, [
                'label' => 'Environment',
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
            ])
            ->add('password', TextType::class, [
                'label' => 'Password',
            ])
        ;
    }
}
