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
            
        if(!is_array($this->session->getBag('contao_frontend')->get('cart')))
        { 
              $this->session->getBag('contao_frontend')->set('cart',[]);
            $this->sessionCart = $this->session->getBag('contao_frontend')->get('cart');
        }else{
            
                $this->session->getBag('contao_frontend')->set('cart',$this->session->getBag('contao_frontend')->get('cart'));
               $this->sessionCart = $this->session->getBag('contao_frontend')->get('cart');//$this->session->getBag('card');
      
        }
        $this->mailer = $this->container->get('mailer');
        
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
        $arrAllowedSteps = ['persoenliche-daten','persoenliche-daten-lg','versand','zahlung','uebersicht'];
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
            case 'persoenliche-daten':
                 
                   $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                    $data = ($this->session->get('order_personal_data'))??[];
                  
                    $form = $this->generatePersonalDataForm($this->container,true,$data); 
                        
                    $form->handleRequest(null);
                     
                     if(!Input::post('personal_data')&&!isset($data['use_for_shipment'])&&!empty($data)){
                        
                            return $this->redirectToStep('persoenliche-daten-lg','/persoenliche-daten')->send();
                       
                         
                         }
                     
                     
                   // var_dump($_POST,Input::post('personal_data'));exit;
                    if(!empty($data)&&Input::post('personal_data')&&!isset(Input::post('personal_data')['use_for_shipment'])){
                            
                        $this->session->set('order_personal_data', Input::post('personal_data'));
                            $this->session->save();
                        return $this->redirectToStep('persoenliche-daten-lg','/persoenliche-daten')->send();
                       
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
                           return $this->redirectToStep('versand','/persoenliche-daten')->send();
                            
                          }else{
                              
                              $this->session->set('order_personal_data', $data);
                            $this->session->save();
                            return $this->redirectToStep('persoenliche-daten-lg','/persoenliche-daten')->send();
                       
                              }
                        
                    }
                        
         
                     
                
               
                $formView = $form->createView();
              
           //var_dump($formView);exit;
           
                 $currentOutput =  $this->twig->render('@Contao/ordering_process/personal_data.html.twig', [
                    "headline" => 'Persönliche Daten',
                    "formular" => $formView,
                    "preview" => '',
                    "next" => 'versand'
            
                ]);
               
               break;
            case 'persoenliche-daten-lg':
                   $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                   
                    $data = ($this->session->get('order_personal_data'))??[];
                    
                  
                    $form = $this->generatePersonalDataForm($this->container,false,$data);  
                          
                    $form->handleRequest(null);

                   if(!Input::post('personal_data_shipment')&&isset($data['use_for_shipment'])
                        || !Input::post('personal_data_shipment')&&empty($data)){
                        
                            return $this->redirectToStep('persoenliche-daten','/persoenliche-daten-lg')->send();
                       
                         
                         }
                    if(!empty($data)&&Input::post('personal_data_shipment')&&isset(Input::post('personal_data_shipment')['use_for_shipment'])&&Input::post('personal_data_shipment')['use_for_shipment'] === '1'){
                            $data = Input::post('personal_data_shipment');
                            $data['use_for_shipment'] = true;
                        $this->session->set('order_personal_data', $data);
                            $this->session->save();
                        return $this->redirectToStep('persoenliche-daten','/persoenliche-daten-lg')->send();
                       
                        }
                   if (Input::post('personal_data_shipment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                          if(!isset(Input::post('personal_data_shipment')['use_for_shipment'])){  
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_personal_data', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep('versand','/persoenliche-daten-lg')->send();
                            
                          }else{
                              
                              $this->session->set('order_personal_data', $data);
                              
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep('persoenliche-daten','/persoenliche-daten-lg')->send();
                           
                              
                              
                            }
                    }
                  
                    
                    
                 $formView = $form->createView();
                 $currentOutput =  $this->twig->render('@Contao/ordering_process/personal_data.html.twig', [
                    "headline" => 'Persönliche Daten',
                    "formular" => $formView,
                    "preview" => '',
                    "next" => 'versand'
            
                ]);
            
                break;
            case 'versand':
               $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                
                $data = ($this->session->get('order_shipment'))??[];
                
                $form = $this->generateShipmentForm($this->container, $data);  
                          
                $form->handleRequest(null);
                
                if(!$this->session->get('order_personal_data')&&!in_array('uebersicht',$this->session->get('order_steps'))
                ||!array_key_exists('finished',$this->session->get('order_personal_data'))
                &&!in_array('uebersicht',$this->session->get('order_steps'))){
                 //  var_dump('test',in_array('overview',$this->session->get('order_steps')));exit; 
            return $this->redirectToStep('persoenliche-daten','/versand')->send();
                           
                    }
                    
                
                if (Input::post('shipment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                          
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_shipment', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep('zahlung','/versand')->send();
                            
                          
                    }
                    
                $formView = $form->createView();
                $currentOutput = $this->twig->render('@Contao/ordering_process/shipment.html.twig', [
                    "headline" => 'Versand',
                    "formular" => $formView,
                    "preview" => 'persoenliche-daten',
                    "next" => 'zahlung'
            
                ]);
               break;

            case 'zahlung':
               $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                   
                $data = ($this->session->get('order_payment'))??[];
                
                $form = $this->generatePaymentForm($this->container, $data);  
                          
                $form->handleRequest(null);
                if(!$this->session->get('order_shipment')||!array_key_exists('finished',$this->session->get('order_shipment'))){
                     return $this->redirectToStep('versand','/zahlung')->send();
                           
                    }
                    
                
                if (Input::post('payment')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                           
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_payment', $data);
                            $this->session->save();
                            //redirect
                            return $this->redirectToStep('uebersicht','/zahlung')->send();
                            
                          
                    }
                    
                $formView = $form->createView();
                $currentOutput = $this->twig->render('@Contao/ordering_process/payment.html.twig', [
                    "headline" => 'Zahlung',
                    "formular" => $formView,
                    "preview" => 'versand',
                    "next" => 'uebersicht'
            
                ]);
               break;

            case 'uebersicht':
                $this->session->set('order_steps',array_merge([$step],$this->session->get('order_steps')));
                  
                $data = ($this->session->get('order_overview'))??[];
                
                $form = $this->generateOverviewForm($this->container, $data);  
                          
                $form->handleRequest(null);
                if(!$this->session->get('order_payment')||!array_key_exists('finished',$this->session->get('order_payment'))){
                     return $this->redirectToStep('zahlung','/uebersicht')->send();
                           
                    }
                    
                
                if (Input::post('overview')&&$form->isSubmitted() && $form->isValid()) {
                             
                            $data = $form->getData();
                           
                            $data['finished'] = true;
                            //Store Data in Session
                            $this->session->set('order_overview', $data);
                            $this->session->save();
                            //Callback for Payment API
                            $paymentType = $this->session->get('order_payment')['payment'];
                            if (\is_array($GLOBALS['MM_SHOP']['ordering_process']['payment_callback']['api'] ?? null))
                            {
                                foreach ($GLOBALS['MM_SHOP']['ordering_process']['payment_callback']['api'] as $callback)
                                {
                                    if (\is_array($callback))
                                    {
                                        $this->session = System::importStatic($callback[0])->{$callback[1]}($paymentType,$this->session);
                                    }
                                    elseif (\is_callable($callback))
                                    {
                                        $this->session = $callback($paymentType,$this-session);
                                    }
                                }
                            }
                            
                            $paymentFeedback = ($this->session->get('order_payment_feedback'))?? false;
                            if($paymentFeedback === false){
                                //redirect
                                return $this->redirectToStep('bestaetigung','/uebersicht')->send();
                                }
                            elseif(isset($paymentFeedback['errors'])){
                                  //handle Error  
                            }
                            else{
                                //append Success Message 
                            }
                            
                            
                          
                    }
                    //var_dump($this->session->get('order_shipment'));exit;
                $formView = $form->createView();
                $salutation = $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_salutation WHERE id = ?', 
                            [$this->session->get('order_personal_data')['salutation']]);
                $shipment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_shipment WHERE id = ?', 
                            [$this->session->get('order_shipment')['shipment']]);
                $payment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_payment WHERE id = ?', 
                            [$this->session->get('order_payment')['payment']]);
                
                $arrPersonalData = $this->session->get('order_personal_data');
                $arrPersonalData['salutation'] = $salutation;
                $arrOrder = [
                        'personal_data' => $arrPersonalData,
                        'shipment' => $shipment[0]['name'],
                        'payment' => $payment[0]['name']
                
                ];
                
                $currentOutput = $this->twig->render('@Contao/ordering_process/overview.html.twig', [
                    "headline" => 'Übersicht',
                    "order" => $arrOrder,
                    "cart" => $this->generateCartOverview(),
                    "formular" => $formView,
                    "preview" => 'zahlung',
                    "next" => ''
            
                ]);
               break;
            case 'bestaetigung':
            
                if(!$this->session->get('order_overview')||!array_key_exists('finished',$this->session->get('order_payment'))){
                     return $this->redirectToStep('uebersicht','/bestaetigung')->send();
                           
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
                $this->saveOrder($arrOrder);
                $salutation = $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_salutation WHERE id = ?', 
                            [$this->session->get('order_personal_data')['salutation']]);
               
                $arrOrder['personal_data']['salutation'] = $salutation;
                $shipment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_shipment WHERE id = ?', 
                            [$this->session->get('order_shipment')['shipment']]);
                $payment =  $this->connection->fetchAllAssociative(
                            'SELECT name FROM mm_payment WHERE id = ?', 
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
                            'SELECT * FROM tl_files WHERE id = ?', 
                            [$shopConfig[0]['shop_logo']]);
                    var_dump($shopLogo);exit;
                $orderInvoice = $this->twig->render('@Contao/ordering_process/invoice.html.twig', [
                    "headline" => 'Rechnung',
                    "shop_config" => $shopConfig[0],
                    "shop_logo" => $shopLogo,
                    "order_number" => 'BE_'.$orderId[0].'_'.date("dmY"),
                    "order_date"=> date("dmY"),
                    "order" => $arrOrder,
                    "cart" => $this->generateCartOverview(), //Child-Template!!!
                ]);
                $mpdf->WriteHTML($orderInvoice);
                $pdfPath = '/files/Rechnungen/RG_'.$orderId[0].'_'.date("dmY").'.pdf';
                $mpdf->Output($pdfPath, Destination::FILE);
              
                    
                //  Email versenden
                $arrMail = [
                    'from' => 'info@monique-hahnefeld.de' ,// Shop-Mail
                    'to' => $this->session->get('order_personal_data')['email'],
                    'subject' => 'Bestellbestätigung', //+Shop-Name
                    'html' => $this->twig->render('@Contao/ordering_process/confirmation.html.twig', [
                        "headline" => 'Bestellbestätigung',
                        "order" => $arrOrder,
                        "cart" => $this->generateCartOverview()
                      
                
                    ])
                ];
                $this->sendConfirmation($arrMail);
                $this->session->getBag('contao_frontend')->remove('cart');
                $this->session->clear();
               // var_dump($arrOrder);exit;
                    //Session löschen
                   // Vielen Dank Nachricht
                 $currentOutput = $this->twig->render('@Contao/ordering_process/overview.html.twig', [
                    "headline" => 'Vielen Dank',
                    "order" => '<div class="confirmation">Sie erhalten in Kürze eine Bestellbestätigung per Email.</div>',
                    "formular" => '',
                    "preview" => '',
                    "next" => ''
            
                ]);  
                break;
            default:
            $this->redirectToStep('persoenliche-daten')->send();
            
            
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
    
       private function generateCartOverview()
    {
                // Deine Item-IDs:
                $itemIds = array_keys($this->sessionCart);

                // MetaModel-ID und RenderSetting-ID
                $metaModelId = 2;
                $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT checkout_rendering FROM mm_shop WHERE id = ?', 
                ['1']);
                

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
                $summary = $this->generateCartSummary($items);
                
                return $this->twig->render('@Contao/ordering_process/product_list.html.twig', [
            "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
            "items" => $items,
            "cart_count" => $this->sessionCart,
            "summary" => $summary 
     
        ]);
    
    }
    
    private function generateCartSummary($items)
     {
         $arrSummary = [];
         
                
         $arrSummary['tax'] = $this->connection->fetchAllAssociative(
                'SELECT * FROM mm_tax');
            $arrSummary['total'] = 0;
            $arrSummary['taxsubtotal'] = [];
         foreach($items as $key => $item){
       
            $price = str_replace(',','.',$item['raw']['price']);
             $arrSummary['total'] += $price* $this->sessionCart[$item['raw']['id']][$item['raw']['id'].'_count'];
                foreach($arrSummary['tax'] as $k => $tax){
                        
                        if($tax['id'] === $item['raw']['tax']["__SELECT_RAW__"]['id']){
                            if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                                $arrSummary['taxsubtotal'][$tax['id']] += $price/100*$tax['tax']*$this->sessionCart[$item['raw']['id']][$item['raw']['id'].'_count'];
                               
                        }
                    }
             
             
             }
             
             $arrSummary['taxtotal'] = 0;
            foreach($arrSummary['taxsubtotal'] as $id => $taxtotal){
                
                $arrSummary['taxtotal'] += $taxtotal;
                }
                
             $arrSummary['subtotal'] = $arrSummary['total'] - $arrSummary['taxtotal'];
               //Format 0,00
             $arrSummary['total'] = str_replace('.',',',number_format(round($arrSummary['total'],2),2));
             foreach($arrSummary['taxsubtotal'] as $key =>$tax){
                 $arrSummary['taxsubtotal'][$key] = str_replace('.',',',number_format(round($tax,2),2));
                 }
             $arrSummary['taxtotal'] = str_replace('.',',',number_format(round($arrSummary['taxtotal'],2),2));
             $arrSummary['subtotal'] = str_replace('.',',',number_format(round($arrSummary['subtotal'],2,PHP_ROUND_HALF_UP),2));
             
            
             return $arrSummary;
        }
        
        
          private function saveOrder($arrOrder)
        {
            //prepare cart data
            // Deine Item-IDs:
            $itemIds = array_keys($this->sessionCart);

            // MetaModel-ID und RenderSetting-ID
            $metaModelId = 2;
            $renderSettingId = 15;
            

            // Services laden
            $factory = $this->container->get('metamodels.factory');
            $renderFactory = $this->container->get('metamodels.render_setting_factory');
            $dispatcher = $this->container->get('event_dispatcher');

            // ItemList instanziieren
            $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
            $itemList->setMetaModel($metaModelId,$renderSettingId);
            $itemList->setLanguage('de'); // optional
            $itemList->addFilterRule(new StaticIdList($itemIds));
            $itemList->prepare();
            
            $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId);
            $items = $itemList->getItems()->parseAll('html5',$objView);
            $summary = $this->generateCartSummary($items);
            
            
            // mm_personal_data
            $arrPersonalData = array_filter(
                $arrOrder['personal_data'],
                fn($key) => stripos($key, 'invoice') === false,
                ARRAY_FILTER_USE_KEY
            );
            unset($arrPersonalData['finished']);
            $this->connection->insert('mm_personaldata',$arrPersonalData);
            $personalDataId = $this->connection->lastInsertId();
            
            
            
            // mm_order
            // get status id
             $statusId = $this->connection->fetchAllAssociative(
                'SELECT id FROM mm_order_status WHERE alias = ?', 
                ['not_paid']);
           // $orderId == fortlaufende Nr für Steuer
            
            //  var_dump($statusId,$summary['total'],'');exit;
         
            $arrOrder1 = [
                'customer_id' => $personalDataId,
                'order_datetime' => time(),
                'updated_datetime' => time(),
                'status' => $statusId[0]['id'],
                'payment' => $arrOrder['payment']['payment'],
                'shipment' => $arrOrder['shipment']['shipment'],
                'order_total' => $summary['total'],
                'sended_invoice' => ''
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
            // mm_adress_shipment
            $arrAdressShipment = array_filter(
                array_merge(['pid' => $orderId],$arrOrder['personal_data']),
                fn($key) => stripos($key, 'invoice') !== false,
                ARRAY_FILTER_USE_KEY
            );
            $this->connection->insert('mm_address_shipment',$arrAdressShipment);
            
            
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
