<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Gamefeeds\Driver;

use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Core\Collection\FeedCollection;

/**
 * Famobi.com game feed driver class
 */
class FamobiFeed extends FeedCollection implements DriverInterface
{   
    use Driver;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('famobi','feeds.games','Famobi','Driver for Famobi.com game feed');
        $this->itemsKey('games');
    }

    /**
     * Init driver
     *
     * @param Properties $properties
     * @return void
     */
    public function initDriver($properties)
    {     
        $baseUrl = $properties->getValue('base_url');      
        $properties->offsetUnset('base_url');

        $config = $properties->getValues(); 
        $this
            ->baseUrl($baseUrl)          
            ->params($config)
            ->mapKey('type',function($item) {                 
                return 'html5';    
            })
            ->mapKey('thumbnail','thumb') 
            ->mapKey('title','name') 
            ->mapKey('categories',function($item) {                
                return $item['categories'];       
            })
            ->mapKey('url',function($item) {                 
                return $item['link'];
            })  
            ->mapKey('tags',function($item) {                 
                return [];
            })  
            ->mapKey('width',function($item) {                 
                return 640;
            })
            ->mapKey('height',function($item) {                 
                return 640;
            });              
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return array
     */
    public function createDriverConfig($properties)
    {              
        // base url
        $properties->property('base_url',function($property) {
            $property
                ->title('Base Url')
                ->type('text')
                ->value('https://api.famobi.com/feed')
                ->default('https://api.famobi.com/feed');
        }); 
        // Affiliate ID
        $properties->property('a',function($property) {
            $property
                ->title('Affiliate ID')
                ->type('text')
                ->value(null)
                ->default(null);
        });       
    }
}
