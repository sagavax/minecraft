const tileListContainer = document.querySelector(".tile_list");
const tiles = tileListContainer.querySelectorAll(".tile");

// mapa tile-id -> URL
const routes = {
  ideas: "ideas/index.php",
  bugs: "bugs/index.php",
  app_log: "app_log.php",
  maintenance: "maintenance.php",
  settings: "settings.php",
  dashboard_back: "../dashboard.php"
};

tiles.forEach((tile) => {
  tile.addEventListener("click", () => {
    const id = tile.getAttribute("tile-id");
    const url = routes[id];
    if (url) {
      window.location.href = url;
    } else {
      console.warn(`⚠️ Neznáma tile-id: ${id}`);
    }
  });
});