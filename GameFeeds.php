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
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Install module
     *
     * @return boolean
     */
    public function install()
    {
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Driver\\GameArterFeedDriver');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Driver\\GamepixFeedDriver');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Driver\\GameDistributionFeed');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Driver\\GameMonetizeFeed');
        $this->installDriver('Arikaim\\Modules\\Gamefeeds\\Driver\\FamobiFeed');

        return true;
    }
}
