<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class LoginType
 * @package App\Form
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add(
                '_username',
                EmailType::class,
                [
                    'label'    => 'email',
                    'required' => true,
                ]
            )
            ->add(
                '_password',
                PasswordType::class,
                [
                    'label'    => 'password',
                    'required' => true,
                ]
            );
    }
}
