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
use Arikaim\Core\Collection\Arrays;

/**
 * GameMonetize.com game feed driver class
 */
class GameMonetizeFeed extends FeedCollection implements DriverInterface
{   
    use Driver;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('gamemonetize','feeds.games','GameMonetize','Driver for GameMonetize game feed');        
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
            ->mapKey('categories',function($item) {                
                $category = $item['category'] ?? null;
                return (empty($category) == false) ? [$category] : [];       
            })  
            ->mapKey('tags',function($item) {  
                $tags = $item['tags'] ?? '';
                return Arrays::toArray($tags,',');   
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
                ->readonly(true)
                ->value('https://gamemonetize.com/feed.json')
                ->default('https://gamemonetize.com/feed.json');
        });       
    }
}
