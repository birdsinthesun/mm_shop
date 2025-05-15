<?php

namespace Bits\MmShopBundle\Order\FormBuilder;


use Symfony\Component\Form\Extension\Core\Type\RadioType;

use Symfony\Component\Validator\Constraints\NotNull;
use Contao\Input;

class Overview
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
            $tags = $this->connection->fetchAllAssociative('SELECT * FROM mm_overview');
            foreach ($tags as $tag) {
               
                    if($tag['alias'] === 'datenschutzerklarung'||$tag['alias'] === 'agbs'){
                        $required = [
                            'required' => true,
                            new NotNull([
                            'message' => 'Bitte wählen Sie eine Versandart aus.'
                            ])
                        ];
                    }else{
                        $required = [];
                        }
                     $builder->add($tag['alias'], CheckboxType::class, array_merge([
                        'label' => $tag['name'],
                        
                        'help_html' => true,
                        'help' => $tag['description']
                    ],$required));
                 }
            
            
          return $builder;
    }
}