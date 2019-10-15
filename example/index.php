<?php
/**
 * phpWhois Example
 *
 * This class supposed to be instantiated for using the phpWhois library
 *
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @license
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * @link http://phpwhois.pw
 * @copyright Copyright (C)1999,2005 easyDNS Technologies Inc. & Mark Jeftovic
 * @copyright Maintained by David Saez
 * @copyright Copyright (c) 2014 Dmitry Lukashin
 * @copyright Copyright (c) 2019 Valeriy Stavitskiy
 */

header('Content-Type: text/html; charset=UTF-8');

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use phpWhois\Whois;
use phpWhois\Utils;

$whois = new Whois();

$data_out = [
    'self' => $_SERVER['PHP_SELF'] ?? '',
    'ver' => $whois->codeVersion ?? '',
];

if (isset($_GET['query'])) {

    $get_params['query'] = filter_input(INPUT_GET, 'query');
    $get_params['output'] = (!empty($_GET['output'])) ? filter_input(INPUT_GET, 'output') : '';
    $get_params['fast'] = (!empty($_GET['fast'])) ? filter_input(INPUT_GET, 'fast') : '';


    // Set to true if you want to allow proxy requests
    $allowproxy = false;

    // get faster but less acurate results
    $whois->deep_whois = empty($get_params['fast']);


    // To use special whois servers (see README)
    //$whois->UseServer('uk','whois.nic.uk:1043?{hname} {ip} {query}');
    //$whois->UseServer('au','whois-check.ausregistry.net.au');

    // Comment the following line to disable support for non ICANN tld's
    $whois->non_icann = true;

    $result = $whois->Lookup($get_params['query']);

    $data_out['query'] = $get_params['query'] ?? '';
    $data_out['get_params'] = $get_params ?? [];

    $winfo = '';

    switch ($get_params['output']) {
        case 'object':
            if ($whois->query['status'] < 0) {
                $winfo = implode($whois->query['errstr'], "\n<br />");
            } else {
                $utils = new Utils;
                $winfo = $utils->showObject($result);
            }
            break;

        case 'nice':
            if (!empty($result['rawdata'])) {
                $utils = new Utils;
                $winfo = $utils->showHTML($result);
            } else {
                if (isset($whois->query['errstr'])) {
                    $winfo = implode($whois->query['errstr'], "\n<br />");
                } else {
                    $winfo = 'Unexpected error';
                }
            }
            break;

        case 'proxy':
            if ($allowproxy) {
                ob_start();
                echo "<pre>";
                print_r(serialize($result));
                echo "</pre>";
                $winfo = ob_get_contents();
                ob_end_clean();
            }
            break;

        default:
            if (!empty($result['rawdata'])) {
                $winfo = '<pre>' . implode($result['rawdata'], "\n") . '</pre>';
            } else {
                $winfo = implode($whois->query['errstr'], "\n<br />");
            }
    }


    $data_out['winfo'] = $winfo ?? '';
}


exit(view($data_out, 'template.php'));

//-------------------------------------------------------------------------


function view(array $data, string $tpl): string
{
    $content = '';

    if (file_exists($tpl)) {
        ob_start();

        if (!empty($data)) {
            extract($data);
        }

        include $tpl;
        $content = ob_get_contents();
        ob_end_clean();
    }

    return $content;
}
