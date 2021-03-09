<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Gamefeeds;

use Arikaim\Core\Extension\Module;

/**
 * GameFeeds module class
 */
class GameFeeds extends Module
{   
    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Drivers\\GameArterFeedDriver');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Drivers\\GamepixFeedDriver');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Drivers\\GameDistributionFeed');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Drivers\\GameMonetizeFeed');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Drivers\\FamobiFeed');
    }
}
