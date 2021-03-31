<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Gamefeeds\Drivers;

use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Core\Collection\FeedCollection;

/**
 * GameArter.com game feed driver class
 */
class GameArterFeedDriver extends FeedCollection implements DriverInterface
{   
    use Driver;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('gamearter','feeds.games','GameArter','Driver for GameArter.com game feed');
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
                $type = \strtolower($item['technology']);            
                return ($type == "webgl") ? 'html5' : $type;    
            })
            ->mapKey('thumbnail',function($item) { 
                $thumbnail = (empty($item['thumbnail']) == true ) ? $item['image'] : $item['thumbnail'];            
                return (empty($thumbnail) == true) ? null : $thumbnail;
            })
            ->mapKey('title','name') 
            ->mapKey('categories',function($item) {                
                $category = $item['category'];
                return [$category];             
            })->mapKey('width',function($item) {                 
                return $item['width'] ?? '800';
            })->mapKey('height',function($item) {                 
                return $item['height'] ?? '600';
            })
            ->mapKey('instructions','controls')             
            ->mapKey('url',function($item) {                 
                return $item['url'];
            });                         
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return void
     */
    public function createDriverConfig($properties)
    {              
        // base url
        $properties->property('base_url',function($property) {
            $property
                ->title('Base Url')
                ->type('text')
                ->readonly(true)
                ->value('https://www.gamearter.com/export/v1/games')
                ->default('https://www.gamearter.com/export/v1/games');
        });   
    }
}
