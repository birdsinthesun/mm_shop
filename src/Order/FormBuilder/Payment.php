<?php

namespace Bits\MmShopBundle\Order\FormBuilder;


use Symfony\Component\Form\Extension\Core\Type\RadioType;

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
                    $choices[$tag['name']] = $tag['id']; 
                }
                 $builder->add('payment', RadioType::class, [
                    'choices' => $choices,
                    'label' => Versandart,
                    'required' => true,
                    new NotNull([
                    'message' => 'Bitte wählen Sie eine Zahlungsweise aus.'
                    ]),
                    'help_html' => true,
                    'help' => $tag['description']
                ]);
            
            
          return $builder;
    }
}