<?php
namespace Api\Config;

use Slim\App;
use Api\View\CoreView;
use Api\View\BankView;

return function (App $app) {
    $app->get('/', [CoreView::class, 'home']);
    $app->post('/reset', [BankView::class, 'reset']);
    $app->get('/balance', [BankView::class, 'balance']);
    $app->post('/event', [BankView::class, 'event']);
};

