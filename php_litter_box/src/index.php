<!DOCTYPE HTML>

<html>
  <head>
    <title>PHP Litter Box</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
      body, html { height: 100%; }
      body {
        background: url("./img/sand.jpg") no-repeat center center fixed;
        background-size: cover;
      }

      .corb-centered {
        position: relative;
        left: 50%;

        /* bring your own prefixes */
        transform: translate(-50%, 25%);
      }

      .corb-php-litter-box {
        max-width: 50%;
      }

      .corb-big-ass-button {
        width: 50%;
      }
    </style>
   <meta charset="UTF-16">
  </head>
  <body>
    <div class="corb-centered corb-php-litter-box text-center">
      <h1>Welcome to the PHP Litter Box</h1>
      <button onclick="addDung(function(params) { createItem(params); })">Add dung</button>
      <button onclick="addCat(function(params) { createItem(params); })">Add cat</button>
    </div>
    <script src="./js/api.js"></script>
    <script>

      function createItem(params) {
        var el = document.createElement("img");
        el.style.position = "fixed";
        el.style.top = String(params.x) + "%";
        el.style.left = String(params.y) + "%";

        if (params.type == "dung") {
          var r = Math.floor((Math.random() * 10) + 1);
          params.type = r % 3 == 0 ? "logo" : "dung"
        }
        el.src = "./img/" + params.type + ".jpg"
        el.style.width = "100px"
        el.style.height = "100px"

        document.body.appendChild(el);
      }

      get_items(function(items) {
        items.forEach(function(item) {
          createItem(item);
        })
      });
    </script>
  </body>
</html>
