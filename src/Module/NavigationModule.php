<?php

namespace Bits\MmShopBundle\Module;

use Contao\Module;
use Contao\System;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class NavigationModule extends Module
{

    private $container;
    
    private $request;
    
    private $session;
    
    private $connection;
    
    private $twig;
    
    private $isMember;
    
    private $urlGenerator;
    
    private $detailPageId;
    
    private $listPageId;
    
    private $arrTrailPages;
    
    private $currentPage;
    
    private $rootPage;
   

    public function __construct($module, $column = 'main')
    {
        parent::__construct($module, $column);
        $this->container = System::getContainer();
        $this->request = $this->container->get('request_stack')->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->connection = $this->container->get('database_connection');
        $this->twig = $this->container->get('twig');
        $this->isMember = System::getContainer()->get('security.helper')->isGranted('ROLE_MEMBER');
        $this->urlGenerator = System::getContainer()->get('contao.routing.content_url_generator');

            
        
    }
    
    public function generate(){
        
        
        if ($this->request && $this->container->get('contao.routing.scope_matcher')->isBackendRequest($this->request))
		{
			 return $this->twig->render('@Contao/backend/be_wildcard.html.twig', [
                'wildcard' => '### ' . $GLOBALS['TL_LANG']['FMD']['product_navigation'][0] . ' ###',
                'title' => $this->name,
                'id' => $this->id
            ]);
        } 
        
        //ToDos
        //Settings will given in the Modul 
        $useAsSiteMap = '';
        $levelStart = 0;
        $levelEnd = 0;
        
        $urlPieces = explode('/',$this->request->getPathInfo());
        $this->currentPage = $this->request->attributes->get('pageModel');
        // return if 404
        if(!$this->currentPage){
            return '';
            }
        //if Page === Detail
        $this->detailPageId = $this->connection->fetchFirstColumn(
                'SELECT product_detail_page FROM mm_shop WHERE id = ?', 
                ['1']);
        //if Page === List
        $this->listPageId = $this->connection->fetchFirstColumn(
                'SELECT product_list_page FROM mm_shop WHERE id = ?', 
                ['1']);
        //Skipp Cart & Checkout
        $cartPageId = $this->connection->fetchFirstColumn(
                'SELECT cart_page FROM mm_shop WHERE id = ?', 
                ['1']);
        $checkoutPageId = $this->connection->fetchFirstColumn(
                'SELECT checkout_page FROM mm_shop WHERE id = ?', 
                ['1']);
        //if Page === Category
    
      //if Page type==='forward'
      //if Page normal

      if($this->currentPage->__get('id') === $this->detailPageId[0]){
          
          $detailCategory = $this->connection->fetchAllAssociative(
                'SELECT * FROM mm_category WHERE alias = ?', 
                [$this->request->attributes->get('category')]);
          
          $currentParent = new PageModel;
          $currentParent->__set('alias',$this->request->attributes->get('category'));
          $currentParent->__set('title',$detailCategory[0]['name']);
          $currentParent->__set('urlPrefix','');
          $currentParent->__set('urlSuffix','.html');
          $href = $this->urlGenerator->generate($currentParent);
          // return '';
          // var_dump($href,$urlPieces,$this->request->attributes->get('pageModel'),$this->request->getPathInfo());exit;
     
          }
          
        //get Trail Array
        $this->arrTrailPages = $this->findRootPageAndDetectTrail($this->currentPage->__get('id'));
        
        
        $this->rootPage = $this->getPageById(end($this->arrTrailPages)['id']);

        $arrNavigationPages = $this->buildNavigationTree($this->rootPage['id'], 3);
     // echo('<pre>'); var_dump($arrNavigationPages);exit;
        $navigation = $this->twig->render('@Contao/navigation/navigation.html.twig', [
               'navigationItems' => $arrNavigationPages,
               'currentPageId' => $this->currentPage->__get('id')
            ]);
        
		

		
//
//			// Hide the page if it is only visible to guests
//			if ($objSubpage->guests && $isMember)
//			{
//				//continue;
//			}
//
//			
//			// PageModel->groups is an array after calling loadDetails()
//			if (!$objSubpage->protected || $this->showProtected || ($this instanceof ModuleSitemap && $objSubpage->sitemap == 'map_always') 
//            || $security->isGranted(ContaoCorePermissions::MEMBER_IN_GROUPS, $objSubpage->groups))
//			{
//				// Check whether there will be subpages
//				if ($blnHasSubpages && (!$this->showLevel || $this->showLevel >= $level || (!$this->hardLimit && ($objPage->id == $objSubpage->id || \in_array($objPage->id, $db->getChildRecords($objSubpage->id, 'tl_page'))))))
//				{
//				//	$subitems = $this->renderNavigation($objSubpage->id, $level, $host, $language);
//				}
//
//				if ($objSubpage->type == 'forward')
//				{
//					if ($objSubpage->jumpTo)
//					{
//						$objNext = PageModel::findPublishedById($objSubpage->jumpTo);
//					}
//					else
//					{
//						$objNext = PageModel::findFirstPublishedRegularByPid($objSubpage->id);
//					}
//
//					
//				}
//
//				try
//				{
//					$href = $urlGenerator->generate($objSubpage);
//				}
//				catch (ExceptionInterface)
//				{
//					//continue;
//				}
//
//				if (str_starts_with($href, 'mailto:'))
//				{
//					$href = StringUtil::encodeEmail($href);
//				}
//
//				//$items[] = $this->compileNavigationRow($objPage, $objSubpage, $subitems, $href);
//			
//		}

             
                  
          return $this->twig->render('@Contao/mod_navigation.html.twig', [
               'navigation' => $navigation
            ]);
        
        
    }
    
    protected function compile(): void
    {
      
    }
    
    public function findRootPageAndDetectTrail(int $pageId): ?array
    {
        $arrTrailPages = [];
        $currentLevel = 0;
        $page = $this->getPageById($pageId);

        while ($page && $page['type'] !== 'root') {
            $page = $this->getPageById((int) $page['pid']);
            $arrTrailPages[$page['pid']] = $page;
            $currentLevel++;
        }

        return $arrTrailPages;
    }
     private function getPageById(int $id): ?array
    {
        return $this->connection->fetchAssociative(
            'SELECT id, pid, type, alias, title, urlSuffix, cssClass, url, jumpTo, hide FROM tl_page WHERE id = ?',
            [$id]
        );
    }
    
     private function getSubPagesById(int $id): ?array
    {
        return $this->connection->fetchAllAssociative(
            'SELECT id, pid, type, alias, title, cssClass, url, jumpTo, hide FROM tl_page WHERE pid = ? AND published = "1" ORDER BY sorting ASC',
            [$id]
        );
    }
    
     private function getCategoryPages(): ?array
    {
        $arrCategories = $this->connection->fetchAllAssociative(
            'SELECT id, pid, alias, name FROM mm_category WHERE published = "1" ORDER BY sorting ASC'
        );
        $arrCategoriesFinal = [];
        foreach($arrCategories as $key => $category){
            $arrCategoriesFinal[$key]['title'] = $category['name'];
            $arrCategoriesFinal[$key]['type'] = 'category';
            $arrCategoriesFinal[$key] = array_merge($category,$arrCategoriesFinal[$key]);
            }
        
        return $arrCategoriesFinal;
    }
    
     private function getProductDetailPages(int $id): ?array
    {
        $arrProducts = $this->connection->fetchAllAssociative(
            'SELECT id, pid, alias, name, category FROM mm_product WHERE category = ? AND published = "1" ORDER BY sorting ASC',
            [$id]
        );
        
        $arrProductsFinal = [];
        
        foreach($arrProducts as $key => $product){
            $product['type'] = 'product';
            $arrProductsFinal[$key]['page']['url'] = $this->getUrl($product);
            $arrProductsFinal[$key]['page']['title'] = $product['name'];
            $arrProductsFinal[$key]['page']['type'] = 'product';
            $arrProductsFinal[$key]['page'] = array_merge($product,$arrProductsFinal[$key]['page']);
            }
        
        return $arrProductsFinal;
    }
    
        private function getUrl($page):string
        {
            $url = $this->request->getSchemeAndHttpHost().'/';
            
            switch($page['type']){
                case'forward':
                    $jumpToPageAlias = $this->connection->fetchAssociative(
                        'SELECT alias FROM tl_page WHERE id = ?',
                                [$page['jumpTo']]
                            );
                     if ($jumpToPageAlias) {
                            $url .= $jumpToPageAlias['alias'] . $this->rootPage['urlSuffix'];
                        }
                    break;
                case'redirect':
                    $url = $page['url'];
                    break;
                case'category':
                    $productRootAlias = $this->connection->fetchAssociative(
                            'SELECT alias FROM tl_page WHERE id = ?',
                            [$this->listPageId[0]]
                        );
                
                    $url .= $productRootAlias['alias'] .'/'. $page['alias'].$this->rootPage['urlSuffix'];
                    break;
                case'product':
                    $productRootAlias = $this->connection->fetchAssociative(
                            'SELECT alias FROM tl_page WHERE id = ?',
                            [$this->listPageId[0]]
                        );
                    $categoryAlias = $this->connection->fetchAssociative(
                            'SELECT alias FROM mm_category WHERE id = ?',
                            [$page['category']]
                        );
                    $url .= $productRootAlias['alias'] .'/'. $categoryAlias['alias'] .'/'. $page['alias'].$this->rootPage['urlSuffix'];
                    break;
                default:
                    $url .= $page['alias'].$this->rootPage['urlSuffix'];
                   
            }
            return $url;
        
        }
        
        private function getCssClass($page):string
        {
        //set trail and active 
        //$this->arrTrailPages , $this->currentPage
          $cssClass = (isset($page['cssClass']))?$page['cssClass']:'';
           if(in_array($page['id'],array_keys($this->arrTrailPages))){
               $cssClass .= ' trail';
                }
        if($page['id'] === $this->currentPage->__get('id')){
               $cssClass .= ' active';
                }
            
            return $cssClass;
        
        }
    
    public function buildNavigationTree(int $parentId, int $maxDepth = 4, int $currentLevel = 1): array
    {   $tree = [];
    
        if ($currentLevel > $maxDepth) {
            //if product pages handle mm_category or mm_product
            if($this->listPageId === $parentId){
                
            }elseif($this->detailPageId === $parentId){
                
            }else{
                
            }
            return $tree;
            
        }
        //if product pages handle mm_category or mm_product
        if($this->listPageId[0] === $parentId){
             $subPages = $this->getCategoryPages();
            }else{
            $subPages = $this->getSubPagesById($parentId);
        }
        
        
        

        foreach ($subPages as $page) {
            
            if(isset($page['hide'])&&$page['hide']=='1'
            ||str_contains($page['type'],'error')){
                continue;
            }
            $page['url'] = $this->getUrl($page);
            $page['cssClass'] = $this->getCssClass($page);
            $page['name'] = $page['title'];
            if($page['type'] === 'category'){
                
                $tree[$page['id']] = [
                    'page' => $page,
                    'children' => $this->getProductDetailPages($page['id'])
                ];
                
            }else{
                $tree[$page['id']] = [
                    'page' => $page,
                    'children' => $this->buildNavigationTree($page['id'], $maxDepth, $currentLevel + 1)
                ];
            
            }
           
        }

        return $tree;
    }
    
    
}