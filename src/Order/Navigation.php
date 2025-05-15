<?php

namespace Bits\MmShopBundle\Order;


class Navigation
{
    
    protected $session;
    
    protected $twig;
    
    
    public function __construct($session,$twig)
    {
        $this->session = $session;
        
        $this->twig = $twig;
    }
    
    public function generate(string $strUrl, string $currentStep)
    {

        $arrSteps = [
        
            'personal_data' => [
                'alias' => 'persoenliche-daten',
                'name' => 'Persönliche Daten'
            ],
             'shipment' => [
                'alias' => 'versand',
                'name' => 'Versand'
            ],
            'payment' => [
                'alias' => 'zahlung',
                'name' => 'Zahlung'
            ],
            'overview' => [
                'alias' => 'uebersicht',
                'name' => 'Übersicht'
            ]
        ];
        if($currentStep == 'persoenliche-daten-lg'){
            $arrSteps['personal_data'] = [
                'alias' => 'persoenliche-daten-lg',
                'name' => 'Persönliche Daten'
            ];
            
            }

        $steps = [];

        foreach ($arrSteps as $key => $step) {
            $steps[$key] = array_merge($step,[
                'allowed' => ($key === 'personal_data' || $this->session->get('order_'.$key)||$this->session->get('order_'.$key)&&array_key_exists('finished',$this->session->get('order_'.$key))),
            ]);
        }

        return $this->twig->render('@Contao/ordering_process/navigation.html.twig', [
            'url' => $strUrl,
            'steps' => $steps,
            'current_step' => $currentStep
        ]);
    }
}