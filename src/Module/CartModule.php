<?php

namespace Bits\MmShopBundle\Module;

use Contao\Module;
use Contao\System;
use Contao\Input;
use Contao\FrontendTemplate;
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
//Cart
use Bits\MmShopBundle\Session\CartSessionBag;

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
            
        
    }
    
    public function generate(){
        
        
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
             
             $currentContent = 'Der Warenkorb ist leer.';
             
             }else{
                $data = $this->sessionCart;

 
                $removeId = Input::get('remove');
                // remove from session
                if($removeId !== Null){
                    
                   unset($this->sessionCart[$removeId]);
                }
                
                $this->session->getBag('contao_frontend')->set('cart',$this->sessionCart);
            
                $this->session->save();
               
                    return new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
                }
                
                
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
                $form = $this->generateForm($items,$data);
                $form->handleRequest(null);
                
                
                $currentContent =  $this->twig->render('@Contao/cart/product_list.html.twig', [
                    "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
                    "items" => $items,
                    "summary" => $summary,
                    "form" => $form->createView()
             
                ]);
                
                
               
                
               
            }
            
                  
                  
          return $this->twig->render('@Contao/mod_cart.html.twig', [
                "headline" => 'Warenkorb',
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
                $builder->add($item['raw']['id'].'count', NumberType::class, [
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
         $shopConfigTaxId =  $this->connection->fetchAllAssociative(
                'SELECT tax FROM mm_shop WHERE id = ?', 
                ['1']);
                
         $arrSummary['tax'] = $this->connection->fetchAllAssociative(
                'SELECT * FROM mm_tax WHERE id = ?', 
                [$shopConfigTaxId[0]['tax']]);
         
         foreach($items as $key => $item){
             $arrSummary['total'] += $item['raw']['price'];
             
             
             }
         $arrSummary['subtotal'] = $arrSummary['total'] *100/81;
         
         return $arrSummary;
        }
    
    
}