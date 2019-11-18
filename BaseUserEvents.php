<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User;

use BasicApp\Core\Event;

abstract class BaseUserEvents extends \CodeIgniter\Events\Events
{

    const EVENT_MENU = 'ba:user_menu';

    public static function onMenu($callback)
    {
        static::on(static::EVENT_MENU, $callback);
    }

    public static function menu()
    {
        $mainMenu = new Event;

        $mainMenu->items = [];

        static::trigger(static::EVENT_MENU, $mainMenu);

        $view = service('renderer');

        $data = $view->getData();

        $return = $mainMenu->items;

        if (array_key_exists('userMenu', $data))
        {
            $return = array_merge_recursive($return, $data['userMenu']);
        }

        foreach($return as $key => $value)
        {
            if (empty($value['url']) || ($value['url'] == '#'))
            {
                if (empty($value['items']))
                {
                    unset($return[$key]);
                }
            }
        }

        return $return;
    }

}