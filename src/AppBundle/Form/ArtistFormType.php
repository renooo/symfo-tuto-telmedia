<?php

namespace AppBundle\Form;

use AppBundle\Entity\Artist;
use Doctrine\ORM\EntityRepository;
use Elastica\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ArtistFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = range(1950, date('Y'));
        $years = array_combine($years, $years);

        $builder
            ->add('name', TextType::class, [
                'required' => true,
//                'constraints' => [
//                    new Constraints\Length([
//                        'min' => 3,
//                        'max' => 100,
//                        'minMessage' => "Bah alors ?! T'as pas envie d'écrire plus que {{ limit }} caractères ?",
//                    ]),
//                ]
            ])
            ->add('creationYear', ChoiceType::class, [
                'required' => false,
                'choices' => $years,
//                'constraints' => [
//                    new Constraints\GreaterThan([
//                        'value' => 1970,
//                    ])
//                ],
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
            ->add('biography', TextareaType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }

    public function getName()
    {
        return 'app_artist_form';
    }
}
