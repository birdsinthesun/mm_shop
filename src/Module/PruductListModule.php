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
use MetaModels\Filter\Rules\SimpleQuery;
use MetaModels\Filter\Setting\Collection;
use MetaModels\Factory;
use MetaModels\ItemList;
use MetaModels\Render\Setting\IRenderSettingFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
//Cart
use Bits\MmShopBundle\Session\CartSessionBag;

class ProductListModule extends Module
{

    private $container;
    
    private $request;
    
    private $session;
    
    private $connection;
    
    private $twig;
    
    private $metamodelsFactory;
    
    private $sessionCart;
   

    public function __construct($module, $column = 'main')
    {
        parent::__construct($module, $column);
        $this->container = System::getContainer();
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->connection = $this->container->get('database_connection');
        $this->twig = $this->container->get('twig');
        $this->metamodelsFactory = $this->container->get('metamodels.factory');
        $this->sessionCart = $this->session->registerBag(new CartSessionBag);

            
        
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
       
        
        //add to card
        $addId = Input::get('add');
        if($addId !== Null){
            
            $this->sessionCart->set($addId,[$addId.'_count' => $this->sessionCart->get($addId)['count']+1]);
            return new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
        }
        
        $category = str_replace('.html','',$this->request->get('category'));
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
        $itemList->addFilterRule(new SimpleQuery('SELECT id FROM mm_product WHERE category = "'.$category.'"'));
        $itemList->prepare();
        
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