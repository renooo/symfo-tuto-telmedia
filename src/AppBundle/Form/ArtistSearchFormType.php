<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $decades = range(1950, substr(date('Y'), 0, 3)*10, 10);
        $decades = array_combine($decades, $decades);

        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'artist.search.name',
                'attr' => ['class' => 'input-perso'],
                'label_attr' => ['class' => 'label-perso'],
            ])
            ->add('decade', ChoiceType::class, [
                'label' => 'artist.search.decade',
                'choices' => $decades,
                'required' => false,
            ])
            ->add('genres', EntityType::class, [
                'required' => false,
                'label' => 'artist.search.genres',
                'multiple' => true,
                'class' => 'AppBundle:Genre',
                'choice_label' => 'label',
                'query_builder' => function(EntityRepository $repo){
                    return $repo->createQueryBuilder('g')
                                ->orderBy('g.label', 'ASC');
                }
            ])
            ->add('search', SubmitType::class, [
                'label' => 'artist.search.search',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function getName()
    {
        return 'app_artist_search_form';
    }
}
