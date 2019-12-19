<?php

namespace App\Form;

use App\Entity\Comments;
use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;




class CommentsType extends AbstractType
{

    private $tokenStorage;
    private $authorizationChecker;

    private  $serie;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage; // le token utilisateur
        $this->authorizationChecker = $authorizationChecker; // le service de controle d'utilisateur
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->serie = $options['serie'];
        $builder
            ->add('content')
            ->add('positive')
            ->add('validated')
            ->add('created_at')
            ->add('User' )
            ->add('Series')
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm(); //récupération du formulaire

        /** @var $entity Comments */
        $entity = $event->getData(); //récupération de l'entité

        if($this->serie) {
            $form->remove('Series');
            $entity->setSeries($this->serie);
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN') === false)// Check les roles
        {
            $form->remove('validated');
        }

        // Si on est en création
        if($entity->getId() === null)
        {
            $entity->setUser($this->tokenStorage->getToken()->getUser());
        }

        $form->remove('User');


        $form->remove('created_at');
            $entity->setCreatedAt(new \DateTime('now'));
    }



        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
            'serie' => null
        ]);
    }
}
