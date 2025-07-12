<?php

namespace Bits\MmShopBundle\Module;

use Contao\Module;
use Contao\System;
use Contao\Input;
use Contao\FrontendTemplate;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Bits\MmShopBundle\Order\Navigation;
use Bits\MmShopBundle\Order\FormBuilder\PersonalData;
use Bits\MmShopBundle\Order\FormBuilder\Shipment;
use Bits\MmShopBundle\Order\FormBuilder\Payment;
use Bits\MmShopBundle\Order\FormBuilder\Overview;
//Productlist
use MetaModels\Filter\Rules\StaticIdList;
use MetaModels\Filter\Setting\Collection;
use MetaModels\Factory;
use MetaModels\ItemList;
use MetaModels\Render\Setting\IRenderSettingFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
//Mail
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
//PDF
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
//Paypal
use Bits\MmShopBundle\Service\ClientService;
use Bits\MmShopBundle\Payment\Paypal;

class OrderingProcessModule extends Module
{
   
    private $container;
    
    private $request;
    
    private $session;
    
    private $connection;
    
    private $twig;
    
    private $metamodelsFactory;
    
    private $formFactory;
    
    private $tokenManager;
    
    private $arrCart;
    
    private $translator;
    
    private $client;
   

    public function __construct($module, $column = 'main')
    {
        parent::__construct($module, $column);
        $this->container = System::getContainer();
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->connection = $this->container->get('database_connection');
        $this->twig = $this->container->get('twig');
        $this->metamodelsFactory = $this->container->get('metamodels.factory');
        $this->tokenManager = $this->container->get('contao.csrf.token_manager');
        
        $validator = Validation::createValidator();
        $this->formFactory = Forms::createFormFactoryBuilder([ 'csrf_protection' => true,
    'csrf_field_name' => 'REQUEST_TOKEN',
    'csrf_token_manager' => $this->tokenManager,
    'csrf_token_id'   => 'ordering_process_form'])
            ->addExtension(new ValidatorExtension($validator))
            ->addExtension(new CoreExtension()) // Core Extension für Formulare
            ->getFormFactory();
            
      
        $this->mailer = $this->container->get('mailer');
        
        $this->translator = $this->container->get('translator');
        
        $this->client = $this->container->get(ClientService::class);
        
    }
    
    public function generate(){
        
        
        if ($this->request && $this->container->get('contao.routing.scope_matcher')->isBackendRequest($this->request))
		{
			 return $this->twig->render('@Contao/backend/be_wildcard.html.twig', [
                'wildcard' => '### ' . $GLOBALS['TL_LANG']['FMD']['ordering_process'][0] . ' ###',
                'title' => $this->name,
                'id' => $this->id
            ]);
            
		}
        global $objPage;
          if(is_array($this->session->getBag('contao_frontend')->get('cart')))
        { 
            
                $this->session->getBag('contao_frontend')->set('cart',$this->session->getBag('contao_frontend')->get('cart'));
               $this->sessionCart = $this->session->getBag('contao_frontend')->get('cart');
               
      
        }
        $arrAllowedSteps = [
                $this->translator->trans('mm_shop.checkout.steps.0'),
                $this->translator->trans('mm_shop.checkout.steps.1'),
                $this->translator->trans('mm_shop.checkout.steps.2'),
                $this->translator->trans('mm_shop.checkout.steps.3'),
                $this->translator->trans('mm_shop.checkout.steps.4'),
                $this->translator->trans('mm_shop.checkout.steps.5')
        ];
        $stepIsValid = (!in_array(Input::get('auto_item',true),$arrAllowedSteps));
        $step = Input::get('auto_item', false, $stepIsValid);///($this->request->attributes->get('auto_item'))??Null;
        if($this->session->get('order_steps') === Null){
            $this->session->set('order_steps',[]);
            }
        if($step){
            $objNavigation = new Navigation($this->container);
            $parsedNavigation = $objNavigation->generate($step);
        }else{
            $parsedNavigation = '';
            }
        $currentOutput = '';
        
        
        switch ($step) {
            case $arrAllowedSteps[0]:
                 
                   $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                    $data = ($this->session->get('order_personal_data'))??[];
                  
                    $form = $this->generatePersonalDataForm($this->container,true,$data); 
                        
                    $form->handleRequest(null);
                     
                     if(!Input::post('personal_data')&&!isset($data['use_for_shipment'])&&!empty($data)){
                        
                            return $this->redirectToStep($arrAllowedSteps[1],'/'.$arrAllowedSteps[0])->send();
                       
                         
                         }
                     
                     
                   // var_dump($_POST,Input::post('personal_data'));exit;
                    if(!empty($data)&&Input::post('personal_data')&&!isset(Input::post('personal_data')['use_for_shipment'])){
                            
                        $this->session->set('order_personal_data', Input::post('personal_data'));
                            $this->session->save();
                        return $this->redirectToStep($arrAllowedSteps[1],'/'.$arrAllowedSteps[0])->send();
                       
                        }

                    if ($form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                          if(isset(Input::post('personal_data')['use_for_shipment'])){  
                         //     var_dump($data);exit;
                            $data['finished'] = true;
                            //Store Data in Session
                           $this->session->set('order_personal_data', $data);
                            $this->session->save();
                           
                            //redirect
                           return $this->redirectToStep($arrAllowedSteps[2],'/'.$arrAllowedSteps[0])->send();
                            
                          }else{
                              
                              $this->session->set('order_personal_data', $data);
                            $this->session->save();
                            
                            $form->getErrors(true, false);
                
                  
                           // return $this->redirectToStep($arrAllowedSteps[1],'/'.$arrAllowedSteps[0])->send();
                       
                              }
                        
                    }
                        
         
                     
                
               
                $formView = $form->createView();
              
           //var_dump($formView);exit;
           
                 $currentOutput =  $this->twig->render('@Contao/ordering_process/personal_data.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.0'),
                    "formular" => $formView,
            
                ]);
               
               break;
            case $arrAllowedSteps[1]:
                   $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                   
                    $data = ($this->session->get('order_personal_data'))??[];
                    
                  
                    $form = $this->generatePersonalDataForm($this->container,false,$data);  
                          
                    $form->handleRequest(null);

                   if(!Input::post('personal_data_shipment')&&isset($data['use_for_shipment'])
                        || !Input::post('personal_data_shipment')&&empty($data)){
                        
                            return $this->redirectToStep($arrAllowedSteps[0],'/'.$arrAllowedSteps[1])->send();
                       
                         
                         }
                    if(!empty($data)&&Input::post('personal_data_shipment')&&isset(Input::post('personal_data_shipment')['use_for_shipment'])&&Input::post('personal_data_shipment')['use_for_shipment'] === '1'){
                            $data = Input::post('personal_data_shipment');
                            $data['use_for_shipment'] = true;
                        $this->session->set('order_personal_data', $data);
                            $this->session->save();
                        return $this->redirectToStep($arrAllowedSteps[0],'/'.$arrAllowedSteps[1])->send();
                       
                        }
                   if (Input::post('personal_data_shipment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                          if(!isset(Input::post('personal_data_shipment')['use_for_shipment'])){  
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_personal_data', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep($arrAllowedSteps[2],'/'.$arrAllowedSteps[1])->send();
                            
                          }else{
                              
                              $this->session->set('order_personal_data', $data);
                              
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep($arrAllowedSteps[0],'/'.$arrAllowedSteps[1])->send();
                           
                              
                              
                            }
                    }
                if (Input::post('personal_data_shipment')&&$form->isSubmitted() && !$form->isValid()) {
                    $form->getErrors(true, false);
                }
                  
                    
                    
                 $formView = $form->createView();
                 $currentOutput =  $this->twig->render('@Contao/ordering_process/personal_data.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.1'),
                    "formular" => $formView
            
                ]);
            
                break;
            case $arrAllowedSteps[2]:
               $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                
                $data = ($this->session->get('order_shipment'))??[];
                
                $form = $this->generateShipmentForm($this->container, $data);  
                          
                $form->handleRequest(null);
                
                if(!$this->session->get('order_personal_data')&&!in_array($arrAllowedSteps[4],$this->session->get('order_steps'))
                ||!array_key_exists('finished',$this->session->get('order_personal_data'))
                &&!in_array($arrAllowedSteps[4],$this->session->get('order_steps'))){
                 //  var_dump('test',in_array('overview',$this->session->get('order_steps')));exit; 
            return $this->redirectToStep($arrAllowedSteps[0],'/'.$arrAllowedSteps[2])->send();
                           
                    }
                    
                
                if (Input::post('shipment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                          
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_shipment', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep($arrAllowedSteps[3],'/'.$arrAllowedSteps[2])->send();
                            
                          
                    }
                if (Input::post('shipment')&&$form->isSubmitted() && !$form->isValid()) {
                    $form->getErrors(true, false);
                }
                    
                $formView = $form->createView();
              // var_dump(array_keys($formView ->children['shipment']->children[0]->vars));exit;
                $currentOutput = $this->twig->render('@Contao/ordering_process/shipment.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.2'),
                    "formular" => $formView,
            
                ]);
               break;

            case $arrAllowedSteps[3]:
               $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                   
                $data = ($this->session->get('order_payment'))??[];
                
                $form = $this->generatePaymentForm($this->container, $data);  
                          
                $form->handleRequest(null);
                if(!$this->session->get('order_shipment')||!array_key_exists('finished',$this->session->get('order_shipment'))){
                     return $this->redirectToStep($arrAllowedSteps[2],'/'.$arrAllowedSteps[3])->send();
                           
                    }
                    
                
                if (Input::post('payment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                           
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_payment', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep($arrAllowedSteps[4],'/'.$arrAllowedSteps[3])->send();
                            
                          
                    }
                if (Input::post('payment')&&$form->isSubmitted() && !$form->isValid()) {
                    $form->getErrors(true, false);
                }
                    
                $formView = $form->createView();
                $currentOutput = $this->twig->render('@Contao/ordering_process/payment.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.3'),
                    "formular" => $formView
            
                ]);
               break;

            case $arrAllowedSteps[4]:
                $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                  
                $data = ($this->session->get('order_overview'))??[];
                
                $form = $this->generateOverviewForm($this->container, $data);  
                          
                $form->handleRequest(null);
                if(!$this->session->get('order_payment')||!array_key_exists('finished',$this->session->get('order_payment'))){
                     return $this->redirectToStep($arrAllowedSteps[3],'/'.$arrAllowedSteps[4])->send();
                           
                    }
                    
                
                if (Input::post('overview')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                           
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_overview', $data);
                            $this->session->save();
                            //Class for Payment API
                            $paymentType = $this->session->get('order_payment')['payment'];
                           
                            switch($paymentType){
                                case'paypal':
                                    $summary = $this->getSummary($this->session->get('order_shipment')['shipment'],$this->session->get('order_payment')['payment'],$objPage->rootId);
                                    //var_dump($summary['total']);exit;
                                    
                                    $paypal = $this->connection->fetchAssociative('SELECT * FROM mm_payment WHERE alias = "paypal"');
                                    $apiPaypal = new Paypal($this->session,$this->client->getClient(),$paypal['paypal_client_id'],$paypal['paypal_secret'],$paypal['paypal_api_base']);
                                    $paypalRedirect = $apiPaypal->createOrder(
                                        $summary['total'],
                                        'EUR',
                                        $this->generateStepUrl($arrAllowedSteps[5],'/'.$arrAllowedSteps[4]),
                                        $this->generateStepUrl($arrAllowedSteps[3],'/'.$arrAllowedSteps[4])
                                    );
                            return (new RedirectResponse($paypalRedirect))->send();
                                    break;
                                default:
                                 return $this->redirectToStep($arrAllowedSteps[5],'/'.$arrAllowedSteps[4])->send();
                    
                                
                            }
                    if (Input::post('overview')&&$form->isSubmitted() && !$form->isValid()) {
                        $form->getErrors(true, false);
                    }       
                           
                            
                          
                    }
                    //var_dump($this->session->get('order_shipment'));exit;
                $formView = $form->createView();
                $salutation = $this->connection->fetchFirstColumn(
                            'SELECT name FROM mm_salutation WHERE id = ?', 
                            [$this->session->get('order_personal_data')['salutation']]);
                $shipment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_shipment WHERE id = ?', 
                            [$this->session->get('order_shipment')['shipment']]);
                $payment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_payment WHERE alias = ?', 
                            [$this->session->get('order_payment')['payment']]);
                
                $arrPersonalData = $this->session->get('order_personal_data');
                $arrPersonalData['salutation'] = $salutation[0];
                $arrPersonalData['use_for_shipment'] = (isset($this->session->get('order_personal_data')['use_for_shipment']))?$this->session->get('order_personal_data')['use_for_shipment']:'';
               // var_dump($arrPersonalData);exit;
                $arrOrder = [
                        'personal_data' => $arrPersonalData,
                        'shipment' => $shipment[0]['name'],
                        'payment' => $payment[0]['name'],
                        'edit' => [
                            'personal_data' => $this->generateStepUrl($arrAllowedSteps[0],'/'.$arrAllowedSteps[4]),
                            'shipment' => $this->generateStepUrl($arrAllowedSteps[2],'/'.$arrAllowedSteps[4]),
                            'payment' => $this->generateStepUrl($arrAllowedSteps[3],'/'.$arrAllowedSteps[4])
                            ]
                
                ];
                
                
                $currentOutput = $this->twig->render('@Contao/ordering_process/overview.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.4'),
                    "order" => $arrOrder,
                    "cart" => $this->generateCartOverview($this->session->get('order_shipment')['shipment'],$this->session->get('order_payment')['payment'],$objPage->rootId),
                    "formular" => $formView
            
                ]);
               break;
            case $arrAllowedSteps[5]:
            
                if(!$this->session->get('order_overview')||!array_key_exists('finished',$this->session->get('order_payment'))){
                     return $this->redirectToStep($arrAllowedSteps[4],'/'.$arrAllowedSteps[5])->send();
                           
                    }
                $parsedNavigation = '';
                  
                    // mm_order befüllen
                    // Übersicht als Html in mm_order.overview speichern
              
                $arrOrder = [
                        'personal_data' => $this->session->get('order_personal_data'),
                        'shipment' => $this->session->get('order_shipment'),
                        'payment' => $this->session->get('order_payment'),
                        'overview' => $this->session->get('order_overview')
                
                ];
               
                
                    // Rechnung in mm_order_invoice speichern und PDF generieren
                $this->saveOrder($arrOrder,$objPage->rootId);
                $salutation = $this->connection->fetchFirstColumn(
                            'SELECT name FROM mm_salutation WHERE id = ?', 
                            [$this->session->get('order_personal_data')['salutation']]);
               
                $arrOrder['personal_data']['salutation'] = $salutation[0];
                $shipment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_shipment WHERE id = ?', 
                            [$this->session->get('order_shipment')['shipment']]);
                $payment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_payment WHERE alias = ?', 
                            [$this->session->get('order_payment')['payment']]);
                            
                $arrOrder['shipment'] = $shipment[0]['name'];
                $arrOrder['payment'] = $payment[0]['name'];
                
                // PDF in files speichern unter Rechnungen/RG-Nr.pdf
                $orderId = $this->connection->fetchfirstColumn(
                        'SELECT id FROM mm_order ORDER BY id DESC LIMIT 1'
                    );
                    
                $mpdf = new Mpdf();
                $shopConfig =  $this->connection->fetchAllAssociative(
                            'SELECT * FROM mm_shop WHERE id = ?', 
                            ['1']);
                $shopLogo = $this->connection->fetchAllAssociative(
                            'SELECT * FROM tl_files WHERE uuid = ?', 
                            [$shopConfig[0]['shop_logo']]);
                   // var_dump($shopConfig[0]['shop_logo'],$shopLogo);exit;
                $orderInvoice = $this->twig->render('@Contao/document/invoice.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.mail.invoice.subject'),
                    "shop_config" => $shopConfig[0],
                    "shop_logo" => $shopLogo[0]['path'],
                    "order_number" => 'BE_'.$orderId[0].'_'.date("dmY"),
                    "invoice_number" => 'RG_'.$orderId[0].'_'.date("dmY"),
                    "order_date"=> date("dmY"),
                    "order" => $arrOrder,
                    "cart" => $this->generateCartOverview($this->session->get('order_shipment')['shipment'],$this->session->get('order_payment')['payment'],$objPage->rootId), //Child-Template!!!
                ]);
                $mpdf->WriteHTML($orderInvoice);
                $pdfPath = $this->container->get('kernel')->getProjectDir(). '/files/Rechnungen/RG_'.$orderId[0].'_'.date("dmY").'.pdf';
               // fopen($pdfPath, 'w');
                $mpdf->Output($pdfPath, Destination::FILE);
              
                    
                //  Email versenden
                $arrMail = [
                    'from' => $shopConfig[0]['owner_email'] ,// Shop-Mail
                    'to' => $this->session->get('order_personal_data')['email'],
                    'subject' => $this->translator->trans('mm_shop.mail.confirmation.subject'), //+Shop-Name
                    'html' => $this->twig->render('@Contao/mail/confirmation.html.twig', [
                        "headline" => $this->translator->trans('mm_shop.mail.confirmation.headline'),
                        "order" => $arrOrder,
                        "cart" => $this->generateCartOverview($this->session->get('order_shipment')['shipment'],$this->session->get('order_payment')['payment'],$objPage->rootId)
                      
                
                    ])
                ];
                $this->sendConfirmation($arrMail);
                $this->session->getBag('contao_frontend')->remove('cart');
                $this->session->clear();
               // var_dump($arrOrder);exit;
                    //Session löschen
                   // Vielen Dank Nachricht
                 $currentOutput = $this->twig->render('@Contao/ordering_process/overview.html.twig', [
                    "headline" => $this->translator->trans('mm_shop.checkout.headlines.5'),
                    "order" => '<div class="confirmation">'.$this->translator->trans('mm_shop.checkout.confirmation').'</div>',
                    "formular" => '',
                    "preview" => '',
                    "next" => ''
            
                ]);  
                break;
            default:
             if(!is_array($this->session->getBag('contao_frontend')->get('cart'))
                ||is_array($this->session->getBag('contao_frontend')->get('cart'))&&empty($this->session->getBag('contao_frontend')->get('cart')))
                { 
                    //Redirect to Start 
                    $this->redirectToStep('index', '/'.$this->request->attributes->get('pageModel')->__get('alias'))->send();
                }else{
                    $this->redirectToStep($arrAllowedSteps[0])->send();
            
                }
            
            
        }
        //var_dump($form->getData());exit;
       // var_dump('test',$currentOutput);exit;
        return $this->twig->render('@Contao/mod_ordering_process.html.twig', [
                'navigation' => $parsedNavigation,
                "currentOutput" => $currentOutput,
                'formular' => ''
            
        ]);
        
        
        
       
    }
    


    protected function compile(): void
    {
      
    }


    private function redirectToStep(string $step, string $prevStep = '')
    {
        $url = $this->generateStepUrl($step,$prevStep);

        return new RedirectResponse($url);
    }

    private function generateStepUrl(string $step, string $prevStep = ''): string
    {
        $url = $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo();
        return str_replace($prevStep.'.html','',$url). '/' . $step.'.html';
    }
    
    private function generatePersonalDataForm($container, $useForInvoice = true, array $data = [])
    {
            if($useForInvoice === true){
        
                $builder = $this->formFactory->createNamedBuilder('personal_data',FormType::class, $data, [
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
                
                $personalDataFormBuilder = new PersonalData($container);
                $builder = $personalDataFormBuilder->fillBuilder($builder,$useForInvoice);
                $prefix = 'shipment_';
                
                $builder->add('weiter', SubmitType::class, [
                'label' => 'Weiter'
                ])
                        ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'ordering_process_form',
                                    'mapped' => false,
                                ])
                        ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
            }
            elseif($useForInvoice === false){
                        $builder = $this->formFactory->createNamedBuilder('personal_data_shipment',FormType::class,$data,[
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
                        
                        $prefix = 'shipment_';
                        $personalDataFormBuilder = new PersonalData($container);
                        $builder = $personalDataFormBuilder->fillBuilder($builder,false);
                        $builder = $personalDataFormBuilder->fillBuilder($builder,'',$prefix);
                        //remove unnessesary fields
                        $builder->remove($prefix.'salutation');
                        $builder->remove($prefix.'surname');
                        $builder->remove($prefix.'lastname');
                        $builder->remove($prefix.'email');
                        $builder->remove($prefix.'use_for_shipment');
                        $builder->add($prefix.'weiter', SubmitType::class, [
                'label' => 'Weiter'
                ])
                          ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'ordering_process_form',
                                    'mapped' => false,
                                ])
                        ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
                
                }
        return $builder->getForm();
        
    }
    
        private function generateShipmentForm($container, array $data = [])
    {
            
        
                $builder = $this->formFactory->createNamedBuilder('shipment',FormType::class, $data, [
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
                
                $shipmentFormBuilder = new Shipment($container);
                $builder = $shipmentFormBuilder->fillBuilder($builder);
               
                
                $builder->add('weiter', SubmitType::class, [
                'label' => 'Weiter'
                ])
                        ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'ordering_process_form',
                                    'mapped' => false,
                                ])
                        ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
                 
        return $builder->getForm();
        
    }
    
       private function generatePaymentForm($container, array $data = [])
    {
            
        
                $builder = $this->formFactory->createNamedBuilder('payment',FormType::class, $data, [
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
                
                $paymentFormBuilder = new Payment($container);
                $builder = $paymentFormBuilder->fillBuilder($builder);
               
                
                $builder->add('weiter', SubmitType::class, [
                'label' => 'Weiter'
                ])
                        ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'ordering_process_form',
                                    'mapped' => false,
                                ])
                        ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
                 
        return $builder->getForm();
        
    }
    
         private function generateOverviewForm($container, array $data = [])
    {
            
        
                $builder = $this->formFactory->createNamedBuilder('overview',FormType::class, $data, [
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
                
                $overviewFormBuilder = new Overview($container);
                $builder = $overviewFormBuilder->fillBuilder($builder);
               
                
                $builder->add('ordner', SubmitType::class, [
                'label' => 'Zahlungspflichtig Bestellen'
                ])
                        ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'ordering_process_form',
                                    'mapped' => false,
                                ])
                        ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
                 
        return $builder->getForm();
        
    }
    
     private function getSummary($shipmentId,$paymentAlias,$rootId)
    {
                // Deine Item-IDs:
                $itemIds = array_keys($this->sessionCart);

                // MetaModel-ID und RenderSetting-ID
                $metaModelId = 2;
                $shopConfigId = $this->connection->fetchFirstColumn(
                'SELECT mm_shop_config FROM tl_page WHERE id = ?', 
                [$rootId]);
                $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT checkout_rendering FROM mm_shop WHERE id = ?', 
                [$shopConfigId[0]]);
                

                // Services laden
                $factory = $this->container->get('metamodels.factory');
                $renderFactory = $this->container->get('metamodels.render_setting_factory');
                $dispatcher = $this->container->get('event_dispatcher');

                // ItemList instanziieren
                $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
                $itemList->setMetaModel($metaModelId,$renderSettingId[0]);
                $itemList->setLanguage('de'); // optional
                $itemList->addFilterRule(new StaticIdList($itemIds));
                $itemList->prepare();
                
                $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId[0]);
                $items = $itemList->getItems()->parseAll('html5',$objView);
                return $this->generateCartSummary($items,$shipmentId,$paymentAlias);
                
        
        
    }
       private function generateCartOverview($shipmentId,$paymentAlias,$rootId)
    {           
                 // Deine Item-IDs:
                $itemIds = array_keys($this->sessionCart);

                // MetaModel-ID und RenderSetting-ID
                $metaModelId = 2;
                $shopConfigId = $this->connection->fetchFirstColumn(
                'SELECT mm_shop_config FROM tl_page WHERE id = ?', 
                [$rootId]);
                $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT checkout_rendering FROM mm_shop WHERE id = ?', 
                [$shopConfigId[0]]);
                

                // Services laden
                $factory = $this->container->get('metamodels.factory');
                $renderFactory = $this->container->get('metamodels.render_setting_factory');
                $dispatcher = $this->container->get('event_dispatcher');

                // ItemList instanziieren
                $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
                $itemList->setMetaModel($metaModelId,$renderSettingId[0]);
                $itemList->setLanguage('de'); // optional
                $itemList->addFilterRule(new StaticIdList($itemIds));
                $itemList->prepare();
                
                $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId[0]);
                $items = $itemList->getItems()->parseAll('html5',$objView);
                $summary = $this->generateCartSummary($items,$shipmentId,$paymentAlias);
                
               
                return $this->twig->render('@Contao/ordering_process/product_list.html.twig', [
            "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
            "items" => $items,
            "cart_count" => $this->sessionCart,
            "summary" => $summary 
     
        ]);
    
    }
    
    private function generateCartSummary($items,$shipmentId,$paymentAlias)
     {
         $arrSummary = [];
         
         $arrSummary['shipment'] = $this->connection->fetchAssociative(
                'SELECT * FROM mm_shipment WHERE id = ?',[$shipmentId]);
        $arrSummary['payment'] = $this->connection->fetchAssociative(
                'SELECT * FROM mm_payment WHERE alias = ?',[$paymentAlias]);
             //var_dump(        $arrSummary['payment']);   exit;
         $arrSummary['tax'] = $this->connection->fetchAllAssociative(
                'SELECT * FROM mm_tax');
            $arrSummary['total'] = 0;
            $arrSummary['taxsubtotal'] = [];
         foreach($items as $key => $item){
       
            $price = str_replace(',','.',$item['raw']['price']);
             $arrSummary['total'] += $price* $this->sessionCart[$item['raw']['id']][$item['raw']['id'].'_count'];
             
                foreach($arrSummary['tax'] as $k => $tax){
                        $base = 100+$tax['tax'];
                        if($tax['id'] === $item['raw']['tax']["__SELECT_RAW__"]['id']){
                            if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                                $arrSummary['taxsubtotal'][$tax['id']] += $price/$base*$tax['tax']*$this->sessionCart[$item['raw']['id']][$item['raw']['id'].'_count'];
                               
                        }
                         if($tax['id'] === $arrSummary['shipment']['id']){
                             if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                             $arrSummary['taxsubtotal'][$tax['id']] += str_replace(',','.',$arrSummary['shipment']['costs'])/$base*$tax['tax'];
                         }
                         if($tax['id'] === $arrSummary['payment']['id']){
                             if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                             $arrSummary['taxsubtotal'][$tax['id']] += str_replace(',','.',
                             $arrSummary['payment']['costs'])/$base*
                             $tax['tax'];
                         }
                    }
             
             
             }
             $arrSummary['total'] += str_replace(',','.',$arrSummary['shipment']['costs']);
             $arrSummary['total'] += str_replace(',','.',$arrSummary['payment']['costs']);
             
             $arrSummary['taxtotal'] = 0;
            foreach($arrSummary['taxsubtotal'] as $id => $taxtotal){
                
                $arrSummary['taxtotal'] += $taxtotal;
                }
                
             $arrSummary['subtotal'] = $arrSummary['total'] - $arrSummary['taxtotal'] ;
               //Format 0,00
             $arrSummary['shipment']['costs'] = str_replace('.',',',number_format(round($arrSummary['shipment']['costs'],2),2));
             $arrSummary['payment']['costs'] = str_replace('.',',',number_format(round($arrSummary['payment']['costs'],2),2));
             
             $arrSummary['total'] = str_replace('.',',',number_format(round($arrSummary['total'],2),2));
             foreach($arrSummary['taxsubtotal'] as $key =>$tax){
                 $arrSummary['taxsubtotal'][$key] = str_replace('.',',',number_format(round($tax,2),2));
                 }
             $arrSummary['taxtotal'] = str_replace('.',',',number_format(round($arrSummary['taxtotal'],2),2));
             $arrSummary['subtotal'] = str_replace('.',',',number_format(round($arrSummary['subtotal'],2,PHP_ROUND_HALF_UP),2));
             
            
             return $arrSummary;
        }
        
        
          private function saveOrder($arrOrder,$rootId)
        {
            //prepare cart data
            // Deine Item-IDs:
            $itemIds = array_keys($this->sessionCart);

            // MetaModel-ID und RenderSetting-ID
            $metaModelId = 2;
            $shopConfigId = $this->connection->fetchFirstColumn(
                'SELECT mm_shop_config FROM tl_page WHERE id = ?', 
                [$rootId]);
            $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT checkout_rendering FROM mm_shop WHERE id = ?', 
                [$shopConfigId[0]]);
            

            // Services laden
            $factory = $this->container->get('metamodels.factory');
            $renderFactory = $this->container->get('metamodels.render_setting_factory');
            $dispatcher = $this->container->get('event_dispatcher');

            // ItemList instanziieren
            $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
            $itemList->setMetaModel($metaModelId,$renderSettingId[0]);
            $itemList->setLanguage('de'); // optional
            $itemList->addFilterRule(new StaticIdList($itemIds));
            $itemList->prepare();
            
            $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId[0]);
            $items = $itemList->getItems()->parseAll('html5',$objView);
            $summary = $this->generateCartSummary($items,$this->session->get('order_shipment')['shipment'],$this->session->get('order_payment')['payment']);
            
            
            // mm_personal_data
            $arrPersonalData = array_filter(
                $arrOrder['personal_data'],
                fn($key) => stripos($key, 'shipment') === false,
                ARRAY_FILTER_USE_KEY
            );
           
            unset($arrPersonalData['finished']);
            unset($arrPersonalData['FORM_SUBMIT']);
            unset($arrPersonalData['REQUEST_TOKEN']);
            $useForShipment = (isset($arrPersonalData['use_for_shipment']))?$arrPersonalData['use_for_shipment']:'';
            unset($arrPersonalData['use_for_shipment']);
            $this->connection->insert('mm_personaldata',$arrPersonalData);
            $personalDataId = $this->connection->lastInsertId();
            
            
            
            // mm_order
            // get status id
             $statusId = $this->connection->fetchAllAssociative(
                'SELECT id FROM mm_order_status WHERE alias = ?', 
                ['not_paid']);
           // $orderId == fortlaufende Nr für Steuer
            $payment =  $this->connection->fetchFirstColumn(
                            'SELECT id FROM mm_payment WHERE alias = ?', 
                            [$this->session->get('order_payment')['payment']]);
            //  var_dump($statusId,$summary['total'],'');exit;
         // $this->session->get('paypal_order_id')
            $arrOrder1 = [
                'customer_id' => $personalDataId,
                'order_datetime' => time(),
                'updated_datetime' => time(),
                'status' => $statusId[0]['id'],
                'payment' => $payment[0],
                'shipment' => $arrOrder['shipment']['shipment'],
                'order_total' => $summary['total'],
                'sended_invoice' => '',
                'paypal_order_id' => ($this->session->get('paypal_order_id'))?$this->session->get('paypal_order_id'):'',
                'shop_config_id' => $shopConfigId[0],
                'agb_akzeptiert' => ($arrOrder['overview']['agb'])?'1':'',
                'datenschutzerklaerung_akzeptiert' => ($arrOrder['overview']['datenschutzerklarung'])?'1':'',
                'newsletter' => ($arrOrder['overview']['newsletter'])?'1':''
            ];
            $this->connection->insert('mm_order',$arrOrder1);
            $orderId = $this->connection->lastInsertId();
            // $orderId == fortlaufende Nr für Steuer
             $arrOrder2 = [
                'order_number' => 'BE_'.$orderId.'_'.date("dmY"),
                 'invoice_name' => 'RG_'.$orderId.'_'.date("dmY"),
                
            ];
            $this->connection->update(
                    'mm_order',             
                    $arrOrder2,            
                    ['id' => $orderId]      
                );
                
             if($useForShipment === false || $useForShipment === '') 
             {
                // mm_adress_shipment
                $arrAdressShipment = array_filter(
                    array_merge(['pid' => $orderId],$arrOrder['personal_data']),
                    fn($key) => stripos($key, 'shipment') !== false,
                    ARRAY_FILTER_USE_KEY
                );
                 $arrAdressShipment = array_combine(
                    array_map(fn($key) => str_replace('shipment_', '', $key), array_keys($arrAdressShipment)),
                    array_values($arrAdressShipment)
                );
                unset($arrAdressShipment['use_for_shipment']);
                $this->connection->insert('mm_address_shipment',$arrAdressShipment);
             }
            
            // mm_order_product
            foreach($items as $key => $item){
                $arrProduct = [
                    'pid' => $orderId,
                    'product_id' => $item['raw']['id'],
                    'name' => $item['raw']['name'],
                    'count' => $this->sessionCart[$item['raw']['id']][$item['raw']['id'].'_count'],
                    'tax' => $item['raw']['tax']["__SELECT_RAW__"]['id'],
                    'price' => $item['raw']['price']
                
                ];
                $this->connection->insert('mm_order_product',$arrProduct);
                
            }
            
        }
        
          private function sendConfirmation(array $arrData)
        {   //.ENV MAILER_DSN=native://default
            $email = (new Email())
                ->from($arrData['from'])
                ->to($arrData['to'])
                ->subject($arrData['subject'])
                ->html($arrData['html']); // Oder ->text('...');
            
            $this->mailer->send($email);
        }
    
}
