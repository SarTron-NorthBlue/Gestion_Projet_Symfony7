<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Enum\Status;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('status',ChoiceType::class,['choices'=>
            ['EN ATTENTE'=>Status::PENDING,
            'EN COURS'=>Status::IN_PROGRESS,
            'COMPLÉTÉ'=>Status::COMPLETED,
            'ÉCHOUÉ'=>Status::FAILED
            ]])
            ->add('createAt', null, [
                'widget' => 'single_text'
            ])
            ->add('dueDate', null, [
                'widget' => 'single_text'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'email',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
