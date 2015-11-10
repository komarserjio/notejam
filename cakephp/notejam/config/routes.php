<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Notes', 'action' => 'index'], ['_name' => 'index']);

    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup'], ['_name' => 'signup']);
    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin'], ['_name' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout'], ['_name' => 'signout']);
    $routes->connect('/settings', ['controller' => 'Users', 'action' => 'settings'], ['_name' => 'settings']);
    $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotpassword'], ['_name' => 'forgot_password']);


    $routes->scope('/pads', ['controller' => 'Pads'], function($routes) {
        $routes->connect('/create', ['controller' => 'Pads', 'action' => 'create'], ['_name' => 'create_pad']);
        $routes->connect('/:id/edit', ['controller' => 'Pads', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'edit_pad']);
        $routes->connect('/:id/delete', ['controller' => 'Pads', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'delete_pad']);
        $routes->connect('/:id', ['controller' => 'Pads', 'action' => 'view'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'view_pad']);
    });

    $routes->scope('/notes', ['controller' => 'Notes'], function($routes) {
        $routes->connect('/create', ['controller' => 'Notes', 'action' => 'create'], ['_name' => 'create_note']);
        $routes->connect('/:id/edit', ['controller' => 'Notes', 'action' => 'edit'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'edit_note']);
        $routes->connect('/:id', ['controller' => 'Notes', 'action' => 'view'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'view_note']);
        $routes->connect('/:id/delete', ['controller' => 'Notes', 'action' => 'delete'], ['id' => '\d+', 'pass' => ['id'], '_name' => 'delete_note']);
    });
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
