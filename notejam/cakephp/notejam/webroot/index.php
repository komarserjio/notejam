<?php
/**
 * The Front Controller for handling every request
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
 * @since         0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
// for built-in server
if (php_sapi_name() === 'cli-server') {
    $_SERVER['PHP_SELF'] = '/' . basename(__FILE__);

    $url = parse_url(urldecode($_SERVER['REQUEST_URI']));
    $file = __DIR__ . $url['path'];
    if (strpos($url['path'], '..') === false && strpos($url['path'], '.') !== false && is_file($file)) {
        return false;
    }
}
require dirname(__DIR__) . '/config/bootstrap.php';

use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFactory;

$dispatcher = DispatcherFactory::create();
$dispatcher->dispatch(
    Request::createFromGlobals(),
    new Response()
);
