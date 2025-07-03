<?php

namespace Bits\MmShopBundle\EventListener\Backend;

use ContaoCommunityAlliance\DcGeneral\Event\PrePersistModelEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Contao\System;
use Bits\MmShopBundle\Order\Reconstruct;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class MailSubmitListener
{
    
    public function __invoke(PrePersistModelEvent $event): void
    {
  
  
       if ('mm_order' !== $event->getEnvironment()->getDataDefinition()->getName()) {
            return;
        }
        $model = $event->getModel(); 
        $sendedInvoice = $model->getProperty('sended_invoice');
        $status = $model->getProperty('status');
        $event->getModel()->setProperty('updated_datetime',time());
        if ($sendedInvoice === '' && $status === 'paid')  {
        
           
            $container = System::getContainer();
            $connection = $container->get('database_connection');
            $twig = $container->get('twig');
            $metamodelsFactory = $container->get('metamodels.factory');
            $mailer = $container->get('mailer');
            $kernel = $container->get('kernel');
            
            $orderProducts = $this->connection->fetchAllAssociative(
                        'SELECT * FROM mm_order_product WHERE pid = ?',
                        [$model->getId()]
            
            );
            $shopEmail = $this->connection->fetchFirstColumn(
                        'SELECT owner_email FROM mm_shop WHERE id = ?',
                        ['1']
            
            );
            $customerEmail = $this->connection->fetchFirstColumn(
                        'SELECT email FROM mm_personaldata WHERE id = ?',
                        [$model->getProperty('customer_id')]
            
            );
            
            
            $arrMail = [
                    'from' => $shopEmail[0],// Shop-Mail
                    'to' => $customerEmail[0],
                    'subject' => 'Rechnung', //+Shop-Name
                    'html' => $twig->render('@Contao/mail/paid.html.twig', [
                        "headline" => 'Rechnung',
                        "content" => 'Wir haben Ihre Zahlung erhalten. Im Anhang finden Sie die Rechnung.'
                        ]),
                    'attach' => [$kernel->getProjectDir().'/files/Rechnungen/RG_'.$model->getId().'_'.date('dmY',$model->getProperty('order_datetime')).'.pdf', 'RG_'.$model->getId().'_'.date('dmY',$model->getProperty('order_datetime')).'.pdf', 'application/pdf']
                
                    
                ];
           
            $this->sendConfirmation($mailer,$arrMail);
            $event->getModel()->setProperty('sended_invoice','1');
           
            
            
            
        }
        if ($sendedInvoice === '1' && $status === 'canceled')  {
            
            
            $container = System::getContainer();
            $connection = $container->get('database_connection');
            $twig = $container->get('twig');
            $translator = $container->get('translator');
            $mailer = $container->get('mailer');
            $kernel = $container->get('kernel');
            
            $objReconstruct = new Reconstruct($connection,$model->getId());
            
            $arrOrder = [];
            $arrOrder['personal_data'] = $objReconstruct->getCustomer();
            $arrOrder['personal_data']['salutation'] = $objReconstruct->getSalutation()[$arrOrder['personal_data']['salutation']]['name'];
            $arrOrder['shipment'] = $objReconstruct->getShipment()['name'];
            $arrOrder['payment'] = $objReconstruct->getPayment()['name'];
            $arrItems = [];
            $arrCartCount = [];
            foreach($objReconstruct->getProducts() as $key => $Product){
                        
                        $arrItems[$key]['raw'] = $Product;
                        $arrItems[$key]['html5'] = $Product;
                        foreach($Product as $name => $Attribut){
                            $arrItems[$key]['attributes'][$name] =  $Attribut;
                            }
                        
                        $arrCartCount[$Product['id']] = [
                                    $Product['id'].'_count' => $Product['count']
                        ];
            } 
             
            $htmlOrder = $twig->render('@Contao/ordering_process/product_list.html.twig', [
                    "url" =>  '',
                    "items" => $arrItems,
                    "cart_count" => $arrCartCount,
                    "summary" => $this->generateCartSummary($arrItems,$objReconstruct->getShipment(),$objReconstruct->getPayment(),$objReconstruct->getTax())
                    ]);
            //Generate Document
            $mpdf = new Mpdf();
            $orderCanceled = $twig->render('@Contao/document/canceled.html.twig', [
                    "headline" => $translator->trans('mm_shop.mail.canceled.subject'),
                    "shop_config" => $objReconstruct->getConfig(),
                    "shop_logo" => $objReconstruct->getLogo()['path'],
                    "order_number" => 'BE_'.$model->getId().'_'.date("dmY",$model->getProperty('order_datetime')),
                    "invoice_number" => 'RG_'.$model->getId().'_'.date("dmY",$model->getProperty('order_datetime')),
                    "order_date"=> date("dmY",$model->getProperty('order_datetime')),
                    "order" => $arrOrder,
                    "cart" => $htmlOrder
            ]);
            $mpdf->WriteHTML($orderCanceled);
            $pdfPath = $kernel->getProjectDir(). '/files/Rechnungen/ST_'.$model->getId().'_'.date("dmY",$model->getProperty('order_datetime')).'.pdf';
            $mpdf->Output($pdfPath, Destination::FILE);
            
            //Send Mail
            $arrMail = [
                    'from' => $objReconstruct->getConfig()['owner_email'] ,// Shop-Mail
                    'to' => $objReconstruct->getCustomer()['email'],
                    'subject' => $translator->trans('mm_shop.mail.canceled.subject'), //+Shop-Name
                    'html' => $twig->render('@Contao/mail/canceled.html.twig', [
                        "headline" => $translator->trans('mm_shop.mail.canceled.headline'),
                        "order" => $arrOrder,
                        "cart" => $htmlOrder
                    ]),
                    'attach' => [$kernel->getProjectDir().'/files/Rechnungen/ST_'.$model->getId().'_'.date('dmY',$model->getProperty('order_datetime')).'.pdf', 'ST_'.$model->getId().'_'.date('dmY',$model->getProperty('order_datetime')).'.pdf', 'application/pdf']
                ];
            $this->sendConfirmation($mailer,$arrMail);
            
        }
    }
    
        
      private function sendConfirmation($mailer,array $arrData)
        {   //.ENV MAILER_DSN=native://default
            $email = (new Email())
                ->from($arrData['from'])
                ->to($arrData['to'])
                ->subject($arrData['subject'])
                ->html($arrData['html']) // Oder ->text('...');
                ->attachFromPath($arrData['attach'][0],$arrData['attach'][1],$arrData['attach'][2]);
            $mailer->send($email);
        }
    
    private function generateCartSummary($items,$arrShipment,$arrPayment,$arrTax)
     {
         $arrSummary = [];
         
         $arrSummary['shipment'] = $arrShipment;
         $arrSummary['payment'] = $arrPayment;
             
         $arrSummary['tax'] = $arrTax;
         $arrSummary['total'] = 0;
         $arrSummary['taxsubtotal'] = [];
         
         foreach($items as $key => $item){
       
            $price = str_replace(',','.',$item['raw']['price']);
             $arrSummary['total'] += $price* $item['raw']['count'];
             
                foreach($arrSummary['tax'] as $k => $tax){
                        $base = 100+$tax['tax'];
                        if($tax['id'] === $item['raw']['tax']){
                            if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                                $arrSummary['taxsubtotal'][$tax['id']] += $price/$base*$tax['tax']*$item['raw']['count'];
                               
                        }
                         if($tax['id'] === $arrSummary['shipment']['id']){
                             if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                             $arrSummary['taxsubtotal'][$tax['id']] += str_replace(',','.',$arrSummary['shipment']['costs'])/$base*$tax['tax'];
                         }
                         if($tax['id'] === $arrSummary['payment']['id']){
                             if(!isset($arrSummary['taxsubtotal'][$tax['id']])){
                                $arrSummary['taxsubtotal'][$tax['id']] = 0;
                                }
                             $arrSummary['taxsubtotal'][$tax['id']] += str_replace(',','.',
                             $arrSummary['payment']['costs'])/$base*
                             $tax['tax'];
                         }
                    }
             
             
             }
             $arrSummary['total'] += str_replace(',','.',$arrSummary['shipment']['costs']);
             $arrSummary['total'] += str_replace(',','.',$arrSummary['payment']['costs']);
             
             $arrSummary['taxtotal'] = 0;
            foreach($arrSummary['taxsubtotal'] as $id => $taxtotal){
                
                $arrSummary['taxtotal'] += $taxtotal;
                }
                
             $arrSummary['subtotal'] = $arrSummary['total'] - $arrSummary['taxtotal'];
               //Format 0,00
             $arrSummary['shipment']['costs'] = str_replace('.',',',number_format(round($arrSummary['shipment']['costs'],2),2));
             $arrSummary['payment']['costs'] = str_replace('.',',',number_format(round($arrSummary['payment']['costs'],2),2));
             
             $arrSummary['total'] = str_replace('.',',',number_format(round($arrSummary['total'],2),2));
             foreach($arrSummary['taxsubtotal'] as $key =>$tax){
                 $arrSummary['taxsubtotal'][$key] = str_replace('.',',',number_format(round($tax,2),2));
                 }
             $arrSummary['taxtotal'] = str_replace('.',',',number_format(round($arrSummary['taxtotal'],2),2));
             $arrSummary['subtotal'] = str_replace('.',',',number_format(round($arrSummary['subtotal'],2,PHP_ROUND_HALF_UP),2));
             
            
             return $arrSummary;
        }
}
