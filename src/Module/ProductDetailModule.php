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


class ProductDetailModule extends Module
{
   

    private $container;
    
    private $request;
    
    private $session;
    
    private $connection;
    
    private $twig;
    
    private $metamodelsFactory;
    
    private $sessionCart;
    
    private $translator;
   

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
        
        $this->translator = $this->container->get('translator');
        
       

    }
    
    public function generate(){
        
        
        if ($this->request && $this->container->get('contao.routing.scope_matcher')->isBackendRequest($this->request))
		{
			 return $this->twig->render('@Contao/backend/be_wildcard.html.twig', [
                'wildcard' => '### ' . $GLOBALS['TL_LANG']['FMD']['product_detail'][0] . ' ###',
                'title' => $this->name,
                'id' => $this->id
            ]);
            
		}
        global $objPage;
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
                $redirect = new RedirectResponse($this->request->getSchemeAndHttpHost() . $this->request->getPathInfo());
                $redirect->send();
            }
           //ToDo warum htm und nicht html? (Kommt von Contao)
            $alias = str_replace('.html','',$this->request->get('alias'));
            $category = $this->request->get('category');

            // MetaModel-ID und RenderSetting-ID
            $metaModelId = 2;
            $shopConfigId = $this->connection->fetchFirstColumn(
                'SELECT mm_shop_config FROM tl_page WHERE id = ?', 
                [$objPage->rootId]);
            $renderSettingId = $this->connection->fetchFirstColumn(
                'SELECT product_detail_rendering FROM mm_shop WHERE id = ?', 
                [$shopConfigId[0]]);
            

            // Services laden
            $factory = $this->container->get('metamodels.factory');
            $renderFactory = $this->container->get('metamodels.render_setting_factory');
            $dispatcher = $this->container->get('event_dispatcher');

            // ItemList instanziieren
            $itemList = new ItemList($factory, null, $renderFactory, $dispatcher);
            $itemList->setMetaModel($metaModelId,$renderSettingId[0]);
            $itemList->setLanguage('de'); // optional
            $itemList->addFilterRule(new SimpleQuery('SELECT id FROM mm_product WHERE alias = "'.$alias.'"'));
            $itemList->prepare();
            
            $objView  = $renderFactory->createCollection($itemList->getMetaModel(), $renderSettingId[0]);
            $items = $itemList->getItems()->parseAll('html5',$objView);
            
           
            
            
            $currentContent =  $this->twig->render('@Contao/products/product_detail.html.twig', [
                "url" =>  $this->request->getSchemeAndHttpHost() . $this->request->getPathInfo(),
                "items" => $items
         
            ]);
                
                
               
                
               
            
            
                  
                  
          return $this->twig->render('@Contao/mod_product_detail.html.twig', [
                "headline" => $this->translator->trans('mm_shop.product_detail.headline'),
                "content" => $currentContent
        
            ]);
        
        
    }
    
    protected function compile(): void
    {
      
    }
    
    
    
    
}