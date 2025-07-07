<?php

namespace Bits\MmShopBundle\Module;

use Contao\Module;
use Contao\System;
use Contao\Input;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\NotBlank;
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
//Productlist
use MetaModels\Filter\Rules\StaticIdList;
use MetaModels\Filter\Setting\Collection;
use MetaModels\Factory;
use MetaModels\ItemList;
use MetaModels\Render\Setting\IRenderSettingFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CartModule extends Module
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
    'csrf_token_id'   => 'cart_form'])
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
        
        $this->translator = $this->container->get('translator');
         
        
        
    }
    
    public function generate(){
        
        global $objPage;
        if ($this->request && $this->container->get('contao.routing.scope_matcher')->isBackendRequest($this->request))
		{
			 return $this->twig->render('@Contao/backend/be_wildcard.html.twig', [
                'wildcard' => '### ' . $GLOBALS['TL_LANG']['FMD']['cart'][0] . ' ###',
                'title' => $this->name,
                'id' => $this->id
            ]);
            
		}
        //test
        
         if(empty(array_keys($this->sessionCart))){
             
             $currentContent = $this->translator->trans('mm_shop.cart.is_empty');
             
             }else{
                $data = [];
                foreach($this->sessionCart as $id =>$count){
                        $data[$id.'_count'] = $count[$id.'_count'];
                    }
                

 
                $removeId = Input::get('remove');
                // remove from session
                if($removeId !== Null){
                    $arrCart = $this->sessionCart;
                   unset($arrCart[$removeId]);
                
                $this->session->getBag('contao_frontend')->set('cart',$arrCart);
            
                $this->session->save();
                $redirect = new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
                $redirect->send();
                }
                
                
                 // Deine Item-IDs:
                $itemIds = array_keys($this->sessionCart);
                
                // MetaModel-ID und RenderSetting-ID
                $metaModelId = 2;
                $shopConfigId = $this->connection->fetchFirstColumn(
                'SELECT mm_shop_config FROM tl_page WHERE id = ?', 
                [$objPage->rootId]);
                $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT cart_rendering FROM mm_shop WHERE id = ?', 
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
                
                $isBToB = $this->connection->fetchAllAssociative(
                'SELECT shop_b2b FROM mm_shop WHERE id=?',
                ['1']);
                if($isBToB[0]['shop_b2b'] === '1'){
                    // ToDo
                    $summary = $this->generateCartSummaryBToB($items);
                }else{
                    $summary = $this->generateCartSummary($items);
                }
                
                $form = $this->generateForm($items,$data);
                $form->handleRequest(null);
                if($form->isSubmitted() && $form->isValid()){
                    $arrCart = [];
                    foreach($this->sessionCart as $id => $arrCount){
                            $arrCart[$id] = [$id.'_count' => $form->getData()[$id.'_count']];  
                              
                    }
                    $this->session->getBag('contao_frontend')->set('cart',$arrCart);
                    
                    $this->session->save();
                     return (new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo()))->send();
                   
                         
                         
                }
                //Checkout Url
                $checkoutId = $this->connection->fetchFirstColumn(
                'SELECT checkout_page FROM mm_shop WHERE id = ?', 
                ['1']);
                
                $checkoutPage = PageModel::findPublishedById($checkoutId[0]);
                $currentContent = $this->twig->render('@Contao/cart/product_list.html.twig', [
                    "checkout_url" => $checkoutPage->getFrontendUrl(),
                    "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
                    "items" => $items,
                    "summary" => $summary,
                    "form" => $form->createView()
             
                ]);
                

             }
                  
          return $this->twig->render('@Contao/mod_cart.html.twig', [
                "headline" => $this->translator->trans('mm_shop.cart.headline'),
                "content" => $currentContent
            ]);
        
        
    }
    
    protected function compile(): void
    {
      
    }
    
    private function generateForm($items,$data = [])
    {
    
        $builder = $this->formFactory->createNamedBuilder('cart',FormType::class, $data, [
                            'action' => $this->request->getUri(),
                            'method' => 'POST']);
            foreach($items as $i => $item){
                $builder->add($item['raw']['id'].'_count', NumberType::class, [
                        'label' => 'Anzahl',
                        'required' => true,
                            'constraints' => [new NotBlank([
                            'message' => 'Bitte geben Sie eine Anzahl ein.'
                            ])]
                    ]); 
            }  
        $builder->add('aktualisieren', SubmitType::class, [
                'label' => 'Aktualisieren'
                ])
                ->add('FORM_SUBMIT', HiddenType::class, [
                                    'data' => 'cart_form',
                                    'mapped' => false,
                                ])
                ->add('REQUEST_TOKEN', HiddenType::class, [
                            'data' => $this->tokenManager->getDefaultTokenValue(),
                            'mapped' => false,
                        ]);
        
        
        
        return $builder->getForm();
        
         
        
        
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
        
        
    // ToDo
     private function generateCartSummaryBToB($items)
     {
         
        }
        
    
    
}