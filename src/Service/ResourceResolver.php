<?php

namespace Bits\MmShopBundle\Service;

use Doctrine\DBAL\Connection;

class ResourceResolver
{
    private Connection $db;

     public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function isProduct(string $category, string $alias): string
    {
        $alias = str_replace('.html','',$alias);
        $categoryId = $this->db->fetchAllAssociative(
                'SELECT id FROM mm_category WHERE alias = ? AND published = ?', 
                [$category,'1']);
        $productId = $this->db->fetchAllAssociative(
                'SELECT id FROM mm_product WHERE category = ? AND alias = ? AND published = ?', 
                [$categoryId[0]['id'],$alias,'1']);
                
                
        return (!$productId)?false:true;
    }
    
    public function hasCategoryProducts(string $category): string
    {
        $categoryId = $this->db->fetchAllAssociative(
                'SELECT id FROM mm_category WHERE alias = ? AND published = ?', 
                [$category,'1']);
        $productIds = $this->db->fetchAllAssociative(
                'SELECT id FROM mm_product WHERE category = ? AND published = ?', 
                [$categoryId[0]['id'],'1']);
                
        return (!$productIds)?false:true;
    }
    
     public function isProductCategory(string $category): string
    {
        $category = str_replace('.html','',$category);
        $categoryId = $this->db->fetchAllAssociative(
                'SELECT id FROM mm_category WHERE alias = ? AND published = ?', 
                [$category,'1']);
                
        return (!$categoryId)?false:true;
    }

}