<?php


namespace Bits\MmShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DescriptedChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [],
            'choice_attr' => null,
            'expanded' => true,
            'multiple' => false,
            'descriptions' => [], 
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Übertrage Beschreibungen in die View
        $descriptions = $options['descriptions'];

        foreach ($view->children as $choiceView) {
            $value = $choiceView->vars['value'];
            $choiceView->vars['description'] = $descriptions[$value] ?? null;
        }
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'descripted_method';
    }
}
