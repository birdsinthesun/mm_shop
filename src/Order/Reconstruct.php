<?php

namespace Bits\MmShopBundle\Order;


class Reconstruct
{
    protected $connection;
    
    protected $orderId;
    
    private $arrOrder;
    
    
    public function __construct($connection,$orderId)
    {
        $this->connection = $connection;
        
        $this->orderId = $orderId;
        
        $this->arrOrder = $this->connection->fetchAssociative(
                            'SELECT * FROM mm_order WHERE id = ?', 
                            [$this->orderId]);
    }
    
    public function getConfig()
    {
        return $this->connection->fetchAssociative(
                            'SELECT * FROM mm_shop WHERE id = ?', 
                            ['1']);
    }
    public function getLogo()
    {
        return $this->connection->fetchAssociative(
                            'SELECT * FROM tl_files WHERE uuid = ?', 
                            [$this->getConfig()[0]['shop_logo']]);
        
    }
    
    public function getOrder()
    {
                            
        return $this->arrOrder;
        
    }
    public function getOrderNumber()
    {
        return 'BE_'.$this->orderId.'_'.date('dmY',$this->arrOrder['order_datetime']);
        
    }
    public function getInvoiceNumber()
    {
        
        return 'RG_'.$this->orderId.'_'.date('dmY',$this->arrOrder['order_datetime']);
    }
 
     public function getCustomer()
    {
        return $this->connection->fetchAssociative(
                            'SELECT * FROM mm_personaldata WHERE id = ?', 
                            [$this->arrOrder['customer_id']]);
        
    }
    public function getProducts()
    {
        return $this->connection->fetchAllAssociative(
                            'SELECT * FROM mm_order_product WHERE pid = ?', 
                            [$this->orderId]);
        
    }
    public function getTax()
    {
        return $this->connection->fetchAllAssociative(
                            'SELECT * FROM mm_tax ORDER BY id ASC');
        
    }
    public function getShipment()
    {
        return $this->connection->fetchAssociative(
                            'SELECT * FROM mm_shipment WHERE id = ?', 
                            [$this->arrOrder['shipment']]);
        
    }
    public function getPayment()
    {
        return $this->connection->fetchAssociative(
                            'SELECT * FROM payment WHERE id = ?', 
                            [$this->arrOrder['payment']]);
        
    }
    public function getSalutation()
    {
        return $this->connection->fetchAllAssociative(
                            'SELECT * FROM mm_salutation ORDER BY id ASC');
        
    }
    
    
}