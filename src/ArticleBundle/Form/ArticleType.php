<?php

namespace trackBundle\Form;

use FamilleBundle\Entity\Famille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use trackBundle\Entity\Fournisseur;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refArticle')
            ->add('designation')
            ->add('code')
            ->add('prix_achat')
            ->add('prix_vente')
            ->add('unite')
            ->add('seuilMin')
            ->add('seuilMax')
            ->add('famille',EntityType::class, [
                'class'=> Famille::class,
                'choice_label'=> 'nomFamille'
            ])
            ->add('fournisseur',EntityType::class, [
                'class'=> Fournisseur::class,
                'choice_label'=> 'nomSociete'
            ]);




    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'trackBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_fournisseur';
    }


}
