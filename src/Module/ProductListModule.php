<?php

namespace Bits\MmShopBundle\Module;

use Contao\Module;
use Contao\System;
use Contao\Input;
use Contao\PageModel;
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
        
        $this->container = System::getContainer();
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->connection = $this->container->get('database_connection');
        $this->twig = $this->container->get('twig');
        $this->metamodelsFactory = $this->container->get('metamodels.factory');
        
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
                'wildcard' => '### ' . $GLOBALS['TL_LANG']['FMD']['product_list'][0] . ' ###',
                'title' => $this->name,
                'id' => $this->id
            ]);
            
		}
        var_dump('test');exit;
            //add to card
            $addId = Input::get('add');
            if($addId !== Null){
                $count = 1;
                if(isset($this->sessionCart[$addId][$addId.'_count'])){
                    $count =  $this->sessionCart[$addId][$addId.'_count']+1;
                }
                $this->sessionCart[$addId] = [$addId.'_count' => $count];
                $this->session->getBag('contao_frontend')->set('cart',$this->sessionCart);
            
                $this->session->save();
               
                return new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
            }
           
           // $alias = str_replace('.html','',$this->request->get('alias'));
            //$category = $this->request->get('category');

            // MetaModel-ID und RenderSetting-ID
            $metaModelId = 2;
            $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT product_detail_rendering FROM mm_shop WHERE id = ?', 
                ['1']);
            

            // Services laden
            $factory = $this->container->get('metamodels.factory');
            $renderFactory = $this->container->get('metamodels.render_setting_factory');
            $dispatcher = $this->container->get('event_dispatcher');

            // ItemList instanziieren
            $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
            $itemList->setMetaModel($metaModelId,$renderSettingId[0]);
            $itemList->setLanguage('de'); // optional
            $itemList->addFilterRule(new SimpleQuery('SELECT id FROM mm_product WHERE published = "1"'));
            $itemList->prepare();
            
            $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId[0]);
            $items = $itemList->getItems()->parseAll('html5',$objView);
            
           
            
            
            $currentContent =  $this->twig->render('@Contao/products/product_list.html.twig', [
                "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
                "items" => $items
         
            ]);
                
                
               
                
               
            
            
                  
                  
          return $this->twig->render('@Contao/mod_product_detail.html.twig', [
                "headline" => 'Produkt-Details',
                "content" => $currentContent
        
            ]);
        
        
    }
    
    protected function compile(): void
    {
      
    }
    
    
    
    
}