<?php

namespace Bits\MmShopBundle\Service;

use Contao\System;

class ResourceResolver
{
    private $connection;

    public function __construct()
    {
        $this->connection = System::getContainer()->get('database_connection');
    }

    public function isProduct(string $category, string $alias): string
    {
        
        $productId = $this->connection->fetchAllAssociative(
                'SELECT id FROM mm_product WHERE category = ? AND alias = ? AND published = ?', 
                [$category,$alias,'1']);
                
                
        return (!$productId)?false:true;
    }
    
    public function hasCategoryProducts(string $category): string
    {
        
        $productIds = $this->connection->fetchAllAssociative(
                'SELECT id FROM mm_product WHERE category = ? AND published = ?', 
                [$category,'1']);
                
        return (!$productIds)?false:true;
    }
    
     public function isProductCategory(string $category): string
    {
        
        $categoryId = $this->connection->fetchAllAssociative(
                'SELECT id FROM mm_category WHERE alias = ? AND published = ?', 
                [$category,'1']);
                
        return (!$categoryId)?false:true;
    }

}