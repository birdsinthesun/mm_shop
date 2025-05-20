<?php

namespace Bits\MmShopBundle\Order\FormBuilder;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Contao\Input;

class PersonalData
{
    
    protected $connection;
    
    protected $container;
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->connection = $this->container->get('database_connection');
        
        }
    
    public function fillBuilder($builder,$useForInvoice = true,$prefix='')
    {
        
        $dcaViewId = $this->connection->fetchAllAssociative(
                'SELECT checkout_personal_data_dca FROM mm_shop WHERE id = ?', 
                ['1']);
               // var_dump($dcaViewId[0]['personal_data_dca']);exit;
        $properties = $this->connection->fetchAllAssociative(
            'SELECT * FROM tl_metamodel_dcasetting WHERE pid = ? AND published = "1" ORDER BY sorting ASC',
           ['13'] //[$dcaViewId[0]['personal_data_dca']]
        );
        
        $attributeIDs = array_column($properties, 'attr_id');
        $placeholders = implode(',', array_fill(0, count($attributeIDs), '?'));
     
        $attributes = $this->connection->fetchAllAssociative(
            'SELECT * FROM tl_metamodel_attribute WHERE id IN ( '.$placeholders.' ) ORDER BY sorting ASC',
            $attributeIDs
        );
         
        

        $arrFormTypes = [];
        $arrFormTypes['select'] = ChoiceType::class;
        $arrFormTypes['country'] = ChoiceType::class;
        $arrFormTypes['text'] = TextType::class;
        $arrFormTypes['numeric'] = NumberType::class;
        $arrFormTypes['checkbox'] = CheckboxType::class;
        $arrFormTypes['email'] = EmailType::class;
    
        foreach ($attributes as $key => $attr) {
            $choices = [];
            if($attr['type'] === 'country'){
                
                $countries = $this->container->get('contao.intl.countries')?->getCountries();
                foreach ($countries as $k => $country) {
                        $choices[$country] = $k; 
                    }
                   // var_dump($properties[$key]['mandatory']);exit;
                     $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']], [
                         'choices' => $choices,
                         'data' => 'DE',
                        'label' => $attr['name'],
                        'required' => ($properties[$key]['mandatory'] ==='1')
                    ]);
                }
            elseif($attr['type'] === 'select'){
                
                $fieldType = [];
                if($attr['colname'] === 'type'){
                         $fieldType = ['data' => 'delivery', 
                        'attr' => [
                            'class' => 'invisible',
                            'hidden' => true
                        ],
                        'label_attr' => [
                            'class' => 'invisible'
                        ]
                    ];
                    }
                 
                $tags = $this->connection->fetchAllAssociative('SELECT * FROM '. $attr["select_table"]);
                foreach ($tags as $tag) {
                        $choices[$tag['name']] = $tag['id']; 
                    }
                     $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']], array_merge([
                         'choices' => $choices,
                        'label' => $attr['name'],
                        'required' => ($properties[$key]['mandatory'] ==='1')
                    ],$fieldType));
                }
            elseif($attr['type'] === 'text'){
                
                
                if($attr['colname'] !== $prefix.'street_number'&&$attr['colname'] !== $prefix.'email'){
                    
                        $constaints = ['constraints' => [
                            new NotBlank([
                                'message' => 'Bitte füllen Sie dieses Feld aus.',
                            ]),
                            new Length(min: 3)
                            ],
                        
                        ];
                    }
                elseif($attr['colname'] === $prefix.'street_number'){
                        
                        $constaints = ['constraints' => [
                            new NotBlank([
                                'message' => 'Bitte füllen Sie dieses Feld aus.',
                            ]),
                            new Length(min: 1)
                            ],
                        
                        ];
                        
                        
                }
                 elseif($attr['colname'] === $prefix.'email'){
                        
                        $constaints = ['constraints' => [
                            new Email([
                                'message' => 'Das ist keine gültige Email-Adresse',
                            ]),
                            new NotBlank([
                                'message' => 'Bitte füllen Sie dieses Feld aus.',
                            ]),
                            new Length(min:5),
                            
                            ],
                        
                        ];
                        
                        
                }
                    
                $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']],array_merge($constaints, [
                    'label' => $attr['name'],
                    'required' => ($properties[$key]['mandatory'] ==='1'),
                    
                ]));
            }
            elseif($attr['type'] === 'email'){
                
                    
                $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']], [
                    'label' => $attr['name'],
                    'required' => ($properties[$key]['mandatory'] ==='1'),
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Bitte füllen Sie dieses Feld aus.',
                        ]),
                        new Email(),
                    ],
                ]);
            } 
            elseif($attr['type'] === 'numeric'){
                
                    
                $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']], [
                    'label' => $attr['name'],
                    'required' => ($properties[$key]['mandatory'] ==='1'),
                    'invalid_message' => 'Bitte geben Sie nur Zahlen ein',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Bitte füllen Sie dieses Feld aus.',
                        ]),
                        new Length(min:5),
                    ],
                ]);
            }
            elseif($attr['type'] === 'checkbox'){
                
                if($useForInvoice === 'force'){
                    $checked = false;
                    }else{
                      $checked =    $useForInvoice;
                        }
                        
                $builder->add($prefix.'use_for_shipment', HiddenType::class, [
                        'attr' => [
                            'checked' =>  $useForInvoice,
                        ]
                   
                ]);
            
                $builder->add($prefix.$attr['colname'], $arrFormTypes[$attr['type']], [
                    
                    'label' => $attr['name'],
                    'required' => '',
                    'attr' => [
                            'onchange' => 'this.form.submit()',
                            'checked' =>  $useForInvoice,
                        ]
                   
                ]);
            }
        
        }
       
        
            
          return $builder;
    }
    
    
   
    
    
    
}