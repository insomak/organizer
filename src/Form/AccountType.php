<?php

// src/Form/AccountType.php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa konta',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis konta',
                'required' => false,
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Kwota',
            ])
            ->add('bank_account', TextType::class, [
                'label' => 'Numer konta bankowego',
                'required' => false,
            ])
            ->add('users', ChoiceType::class, [
                'label' => 'Wybierz użytkowników',
                'choices' => $options['users'],  // Przekazujemy dostępnych użytkowników do formularza
                'multiple' => true,  // Pozwoli na wybór wielu użytkowników
                'expanded' => true,  // Renderowanie jako checkboxy
            ])
            ->add('account_number', TextType::class, [
                'label' => 'Numer konta',
                'required' => false,
            ])
            ->add('hidden', null, [
                'label' => 'Ukryte konto',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            'users' => [],  // Domyślna wartość dla 'users'
        ]);
    }
}
