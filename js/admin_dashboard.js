 var tileListContainer = document.querySelector(".tile_list");
 console.log(tileListContainer);

  // Get all div elements with class "tile" within the container
  var tiles = tileListContainer.querySelectorAll('.tile');

  // Assign an onclick event listener to each tile
  tiles.forEach(function(tile) {
    tile.onclick = function() {
      // Your onclick logic here
      var id = tile.getAttribute("tile-id");
      if (id == "ideas") {
        id = "ideas/index";
      } else if (id == "bugs") {
        id = "bugs/index";
      }
      var url = id+".php";
      console.log(url);
      window.location.href=url;
      //console.log('Tile clicked:', tile.textContent);
    };
  });