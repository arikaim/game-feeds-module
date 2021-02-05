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
 * Gamepix.com game feed driver class
 */
class GamepixFeedDriver extends FeedCollection implements DriverInterface
{   
    use Driver;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('gamepix','feeds.games','Gamepix','Driver for Gamepix.com game feed');
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
            ->itemsKey('data')
            ->mapKey('type',function($item) {                           
                return 'html5'; 
            })
            ->mapKey('thumbnail',function($item) {                           
                return (empty($item['thumbnailUrl']) == true ) ? $item['thumbnailUrl100'] : $item['thumbnailUrl'];
            })
            ->mapKey('tags',function($item) {                
                return [];
            })                         
            ->mapKey('url',function($item) {                 
                return $item['url'];
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
        // Base url
        $properties->property('base_url',function($property) {
            $property
                ->title('Base Url')
                ->type('text')
                ->readonly(true)
                ->value('https://games.gamepix.com/games')
                ->default('https://games.gamepix.com/games');
        }); 
        // Sid
        $properties->property('sid',function($property) {
            $property
                ->title('Sid')
                ->type('text') 
                ->value(1)
                ->readonly(true)
                ->hidden(true)                              
                ->default('1');
        });   
    }
}
