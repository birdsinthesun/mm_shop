<?php

namespace Bits\MmShopBundle\EventListener\Backend;

use ContaoCommunityAlliance\DcGeneral\Event\PrePersistModelEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Contao\System;

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
        if ($status === 'canceled')  {
            //ToDo
            
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
}
