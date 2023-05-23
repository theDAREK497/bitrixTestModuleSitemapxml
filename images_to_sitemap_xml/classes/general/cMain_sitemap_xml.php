<?
include_once(__DIR__.'/class_sitemap.php');

\Bitrix\Main\Loader::includeModule("iblock");

function GenerateSitemapXmlExt () {
    $context = \Bitrix\Main\Application::getInstance()->getContext();
    $server = $context->getServer();

    if ($server->getServerPort() !== 80) {
        $http = 'https://';
    } else {
        $http = 'http://';
    };

    if (trim(SITE_SERVER_NAME) == '') {
        $SERVER_HTTP_HOST = $server->getHttpHost();
        if (strpos($SERVER_HTTP_HOST,':')) {
            list($SERVER_HTTP_HOST, $port) = explode(':', $SERVER_HTTP_HOST);
        }
    } else {
        $SERVER_HTTP_HOST = SITE_SERVER_NAME;
    };

    $home_url = $http.$SERVER_HTTP_HOST;
    $document_root =  $server->getDocumentRoot();

    if ($document_root == '') {
        $dirs = realpath(dirname(__FILE__));
        if (strpos($dirs, '/local/') !== false) {
            list($document_root, $trash) = explode('/local/', $dirs);
        } elseif (strpos($dirs, '/bitrix/') !== false) {
            list($document_root, $trash) = explode('/bitrix/', $dirs);
        };
    };

    /* Максимально кол-во страниц в одном sitemap */
    $items_on_page = 50000; /* Максимальное кол-во по Google и Yandex - 50000 */

    $sitemap = new sitemapXmlExt($home_url);
    /* Добавим главную страницу */
    $sitemap->AddPage($home_url);
    /* Сгенерируем остальные страницы */
    $sitemap->generate();


    /* Запишем все в файл/ы */
    $total_items = count($sitemap->pages);
    $maxfiles = max(1, ceil($total_items / $items_on_page));
    if ($maxfiles == 1) {
        file_put_contents($document_root.'/sitemap.xml', $sitemap->Show());
    } else {
        while ($maxfiles >= 0) {
            $fileSitemap = $document_root.'/sitemap_'.$maxfiles.'.xml';
            $sitemap->AddToSitemapIndex($home_url.'/sitemap_'.$maxfiles.'.xml');
            file_put_contents($fileSitemap, $sitemap->Show($maxfiles * $items_on_page, $items_on_page));
            $maxfiles--;
        }
        file_put_contents($document_root.'/sitemap.xml', $sitemap->ShowSitemapIndex());
    }
    return "GenerateSitemapXmlExt();";
}
