<?php

return array(
    'default'              => 'start/index',
    '404'                  => 'error/error_404',
    '(:any)'               => 'page/index/$1',
    'news'                 => 'news/index',
    'news/(:any)'          => 'news/test/$1'
);