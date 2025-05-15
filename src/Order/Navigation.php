<?php

namespace Bits\MmShopBundle\Order;


class Navigation
{
    protected $container;
    
    protected $session;
    
    protected $twig;
    
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->twig = $this->container->get('twig');
    }
    
    public function generate(string $currentStep)
    {

        $arrSteps = [
        
            'personal_data' => [
                'alias' => 'persoenliche-daten',
                'name' => 'Persönliche Daten',
                'url' => $this->generateStepUrl('persoenliche-daten','/'.$currentStep)
            ],
             'shipment' => [
                'alias' => 'versand',
                'name' => 'Versand',
                'url' => $this->generateStepUrl('versand','/'.$currentStep)
            ],
            'payment' => [
                'alias' => 'zahlung',
                'name' => 'Zahlung',
                'url' => $this->generateStepUrl('zahlung','/'.$currentStep)
            ],
            'overview' => [
                'alias' => 'uebersicht',
                'name' => 'Übersicht',
                'url' => $this->generateStepUrl('uebersicht','/'.$currentStep)
            ]
        ];
        if($currentStep == 'persoenliche-daten-lg'){
            $arrSteps['personal_data'] = [
                'alias' => 'persoenliche-daten-lg',
                'name' => 'Persönliche Daten',
                'url' => $this->generateStepUrl('persoenliche-daten-lg','/'.$currentStep)
            ];
            
            }

        $steps = [];
        $prevKey = 'personal_data';
        foreach ($arrSteps as $key => $step) {
            $steps[$key] = array_merge($step,[
                'allowed' => (in_array($step['alias'],$this->session->get('order_steps')) || $key === 'personal_data' || $this->session->get('order_'.$key))
            ]);
            $prevKey = 'personal_data'; 
        }

        return $this->twig->render('@Contao/ordering_process/navigation.html.twig', [
            'steps' => $steps,
            'current_step' => $currentStep
        ]);
    }
    
      private function generateStepUrl(string $step, string $prevStep = ''): string
    {
        $url = $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo();
        return str_replace($prevStep.'.html','',$url). '/' . $step.'.html';
    }
}