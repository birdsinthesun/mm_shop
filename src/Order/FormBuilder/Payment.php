<?php

namespace Bits\MmShopBundle\Order\FormBuilder;


use Bits\MmShopBundle\Form\DescriptedChoiceType;
use Symfony\Component\Validator\Constraints\NotNull;
use Contao\Input;

class Payment
{
    
    protected $connection;
    
    protected $container;
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->connection = $this->container->get('database_connection');
        
        }
    
    public function fillBuilder($builder)
    {
            $tags = $this->connection->fetchAllAssociative('SELECT * FROM mm_payment');
            foreach ($tags as $tag) {
                    $choices[$tag['name']] = $tag['alias'];
                    $descriptions[$tag['id']] = $tag['description'];
                }
              
                 $builder->add('payment', DescriptedChoiceType::class, [
                    'choices' => $choices,
                    'descriptions' => $descriptions,
                    'label' => 'Zahlungsart',
                    'required' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'constraints' => [new NotNull([
                    'message' => 'Bitte wählen Sie eine Zahlungsart aus.'
                    ])]
                    
                ]);
            
            
          return $builder;
    }
}