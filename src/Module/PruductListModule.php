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

class ProductListModule extends Module
{
   
    protected $strTemplate = 'mod_cart';

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
        $this->session->set('cart_items',['1','2']);
        
        if($this->session->get('cart_items') === Null){
            $this->session->set('cart_items',[]);
            }
        
                $data = ($this->session->get('cart_items_data'))??[];

                //add to card
                $addId = Input::get('add');
                // remove from session
                if($addId !== Null){
                    
                    
                    return new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
                }
                
                
                 // Deine Item-IDs:
                $itemIds = [1, 2];

                // MetaModel-ID und RenderSetting-ID
                $metaModelId = 2;
                $renderSettingId = 13;
                

                // Services laden
                $factory = $this->container->get('metamodels.factory');
                $renderFactory = $this->container->get('metamodels.render_setting_factory');
                $dispatcher = $this->container->get('event_dispatcher');

                // ItemList instanziieren
                $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
                $itemList->setMetaModel($metaModelId,$renderSettingId);
                $itemList->setLanguage('de'); // optional
                $itemList->prepare();
                $itemList->addFilterRule(new StaticIdList('id', $itemIds));
                
                $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId);
                $items = $itemList->getItems()->parseAll('html5',$objView);
                
               
                
                
                $currentContent =  $this->twig->render('@Contao/products/product_list.html.twig', [
                    "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
                    "items" => $items
             
                ]);
                
                
               
                
               
            
            
                  
                  
          return $this->twig->render('@Contao/mod_product_list.html.twig', [
                "headline" => 'Produkte',
                "content" => $currentContent
        
            ]);
        
        
    }
    
    protected function compile(): void
    {
      
    }
    
    
}