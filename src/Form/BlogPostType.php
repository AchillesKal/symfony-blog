<?php

namespace App\Form;

use App\Entity\BlogPost;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // check if form is create ore edit
        $builder
            ->add('title')
            ->add('banner', DropzoneType::class, [
                'attr' => [
                    'placeholder' => 'Drag and drop a file or click to browse',
                ],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('summary', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'tinymce'],
                'purify_html' => true,
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'tinymce'],
                'purify_html' => true,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'title',
                'multiple' => true,
                'autocomplete' => true,
                'required' => false,
            ])
            ->add('publishedAt', DateTimeType::class,[
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => [
                    'class' => 'app-datepicker',
                ],
            ])
        ;

        // Conditionally add the field only for the edit form
        if ($options['data']?->getBanner() !== null) {
            $builder->add('delete_banner', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}
