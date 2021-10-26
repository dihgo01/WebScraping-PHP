<?php

use HeadlessChromium\BrowserFactory;

require_once 'vendor/autoload.php';

$browserFactory = new BrowserFactory();

// starts headless chrome
$browser = $browserFactory->createBrowser();

// creates a new page and navigate to an url
$page = $browser->createPage();
$page->navigate('https://www.icarros.com.br/ford')->waitForNavigation();

// get date the page
$title = $page->evaluate('(() => {
  const nodeListImg = document.querySelectorAll(".img-responsive")

  const nodeListRate = document.querySelectorAll(".price-results__rate")

  const listNode = document.querySelectorAll(".title--brand__highlight")
  const dataTitle = [...listNode]

    const listTitle = dataTitle.map(itens => ({
      title: itens.textContent.replace("\n", ""),
    }))

    const dataAvaible = [...nodeListRate]

    const listAvaible = dataAvaible.map(itens => ({
      avaible: itens.textContent.replace("\n", "").trim(),
    }))

    const ListArray = [...nodeListImg]

    const list = ListArray.map(items => ({
      src: items.src,
    }))

    return ({ list, listTitle, listAvaible })
    
})()')->getReturnValue();


$json_data = json_encode($title);
file_put_contents('data.json', $json_data);
    
