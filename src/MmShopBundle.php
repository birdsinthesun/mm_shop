<?php
namespace Bits\MmShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;




class MmShopBundle extends Bundle
{
    
     public function getPath(): string
    {
        return \dirname(__DIR__.'/Resources');
    }
    

}
