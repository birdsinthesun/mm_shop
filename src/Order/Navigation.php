<?php

namespace Bits\MmShopBundle\Order;


class Navigation
{
    protected $container;
    
    protected $session;
    
    protected $twig;
    
    protected $translator;
    
    
    public function __construct($container)
    {
        $this->container = $container;
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->twig = $this->container->get('twig');
        $this->translator = $this->container->get('translator');
    }
    
    public function generate(string $currentStep)
    {

        $arrSteps = [
        
            'personal_data' => [
                'alias' => $this->translator->trans('mm_shop.checkout.steps.0'),
                'name' => 'Persönliche Daten',
                'url' => $this->generateStepUrl($this->translator->trans('mm_shop.checkout.steps.0'),'/'.$currentStep)
            ],
             'shipment' => [
                'alias' => $this->translator->trans('mm_shop.checkout.steps.2'),
                'name' => $this->translator->trans('mm_shop.checkout.headlines.2'),
                'url' => $this->generateStepUrl($this->translator->trans('mm_shop.checkout.steps.2'),'/'.$currentStep)
            ],
            'payment' => [
                'alias' => $this->translator->trans('mm_shop.checkout.steps.3'),
                'name' => $this->translator->trans('mm_shop.checkout.headlines.3'),
                'url' => $this->generateStepUrl($this->translator->trans('mm_shop.checkout.steps.3'),'/'.$currentStep)
            ],
            'overview' => [
                'alias' => $this->translator->trans('mm_shop.checkout.steps.4'),
                'name' => $this->translator->trans('mm_shop.checkout.headlines.4'),
                'url' => $this->generateStepUrl($this->translator->trans('mm_shop.checkout.steps.4'),'/'.$currentStep)
            ]
        ];
        if($currentStep == $this->translator->trans('mm_shop.checkout.steps.1')){
            $arrSteps['personal_data'] = [
                'alias' => $this->translator->trans('mm_shop.checkout.steps.1'),
                'name' => $this->translator->trans('mm_shop.checkout.headlines.1'),
                'url' => $this->generateStepUrl($this->translator->trans('mm_shop.checkout.steps.1'),'/'.$currentStep)
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