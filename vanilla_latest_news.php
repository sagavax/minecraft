<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minecraft IS</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  </head>
  
  <body>
    <?php include("includes/header.php") ?>
      <div class="main_wrap">
      <div class="tab_menu">
          <?php include("includes/menu.php"); ?>
        </div>
        
        <div class="content">
           
          <div class="list">
                  <?php
                // Specify the RSS feed URL
                $feedUrl = "https://www.windowscentral.com/rss.xml";

                // Namespaces for parsing RSS feed elements
                $namespaces = array(
                  'dc' => "http://purl.org/dc/elements/1.1/",
                );

                // Function to parse the RSS feed and return articles
                      function parseFeed($feedUrl, $namespaces) {
                      // Load the XML file
                      $xml = simplexml_load_file($feedUrl, null, LIBXML_NOCDATA, '', true);

                      $articles = array();
                      if ($xml) {
                          // Register namespaces
                          foreach ($namespaces as $prefix => $uri) {
                              $xml->registerXPathNamespace($prefix, $uri);
                          }

                          // Fetch channel items
                          $items = $xml->channel->item;
                          foreach ($items as $item) {
                              $article = array(
                                  "title" => (string) $item->title,
                                  "link" => (string) $item->link,
                                  "pubDate" => (string) $item->pubDate,
                                  "description" => (string) $item->description,
                                  "content" => (string) $item->children($namespaces['dc'])->content, // Access content within dc namespace
                              );
                              $articles[] = $article;
                          }
                      }
                      return $articles;
                  }


                // Get articles from the feed
                $articles = parseFeed($feedUrl, $namespaces);

                // Display article summaries
                if (count($articles) > 0) {
                  echo "<h2>Windows Central RSS Feed</h2>";
                  echo "<ul>";
                  foreach ($articles as $article) {
                    echo "<li>";
                    echo "<a href='" . $article["link"] . "'>" . $article["title"] . "</a>";
                    echo "<br>";
                    echo $article["description"];
                    echo "<br>";

                    // Check if content is available and display it
                    if (isset($article["content"]) && !empty($article["content"])) {
                      echo "<b>Content:</b>";
                      echo "<p>" . $article["content"] . "</p>";
                    }

                    echo "</li>";
                  }
                  echo "</ul>";
                } else {
                  echo "No articles found in the feed.";
                }

                ?>

       </div><!-- list -->
      </div><!-- content -->  
  </body>
 </html> 
    