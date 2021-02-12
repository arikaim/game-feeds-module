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
 * Gamedistribution game feed driver class
 */
class GameDistributionFeed extends FeedCollection implements DriverInterface
{   
    use Driver;
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('gamedistribution','feeds.games','GameDistribution','Driver for Gamedistribution game feed');        
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
            ->pageKey('page')
            ->perPageKey('amount')
            ->params($config)
            ->mapKey('type','Type')
            ->mapKey('title','Title')
            ->mapKey('description','Description')
            ->mapKey('instructions','Instructions')
            ->mapKey('width','Width')
            ->mapKey('height','Height')
            ->mapKey('url','Url')
            ->mapKey('tags',function($item) {   
                $list = (isset($item['Tag']) == true) ? $item['Tag'] : [];
                $result = [];
                foreach ($list as $item) {
                    $result[] = \trim($item,'#');
                }
                return $result;       
            }) 
            ->mapKey('thumbnail',function($item) {           
                return (isset($item['Asset']) == true) ? $item['Asset'][0] : null;           
            })
            ->mapKey('categories',function($item) {   
                $list = (isset($item['Category']) == true) ? $item['Category'] : [];
                $result = [];
                foreach ($list as $item) {
                    $result[] = $item;
                }
                return $result;       
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
                ->value('https://catalog.api.gamedistribution.com/api/v1.0/rss/All/')
                ->default('https://catalog.api.gamedistribution.com/api/v1.0/rss/All/');
        });
        // format
        $properties->property('format',function($property) {
            $property
                ->title('Format')
                ->type('text')     
                ->value('json')     
                ->readonly(true)      
                ->default('json');
        });
        // page
        $properties->property('page',function($property) {
            $property
                ->title('Page')
                ->type('number')
                ->value(1)
                ->default(1);
        });
        // collection
        $properties->property('collection',function($property) {
            $property
                ->title('Collection')
                ->type('text')
                ->value('all')
                ->default('all');
        });
        // company
        $properties->property('company',function($property) {
            $property
                ->title('Company')
                ->type('text')
                ->value('all')
                ->default('all');
        });        
        // categories
        $properties->property('categories',function($property) {
            $property
                ->title('Categories')
                ->type('text')
                ->value('all')
                ->default('all');                
        });
        // Game Type
        $properties->property('type',function($property) {
            $property
                ->title('Game Type')
                ->type('text')
                ->value('all')
                ->default('all');
        });
        // Game Type
        $properties->property('type',function($property) {
            $property
                ->title('Game Type')
                ->type('text')
                ->value('all')
                ->default('all');
        });
        // Per page
        $properties->property('amount',function($property) {
            $property
                ->title('Items per page')
                ->type('number')
                ->value(10)
                ->default(10);
        });
    }
}
