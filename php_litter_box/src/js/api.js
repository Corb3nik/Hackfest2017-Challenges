addDung = function(callback) {
  var req = new XMLHttpRequest()
  req.open("GET", "./api.php?action=addDung")
  req.onreadystatechange = function()
  {
      if (req.readyState == 4 && req.status == 200)
      {
          callback(JSON.parse(req.responseText)); // Another callback here
      }
  };
  req.send()
}

addCat = function(callback) {
  var req = new XMLHttpRequest()
  req.open("GET", "./api.php?action=addCat")
  req.onreadystatechange = function()
  {
      if (req.readyState == 4 && req.status == 200)
      {
          callback(JSON.parse(req.responseText)); // Another callback here
      }
  };
  req.send()
}

get_items = function(callback) {
  var req = new XMLHttpRequest()
  req.open("GET", "./api.php?action=items")
  req.onreadystatechange = function()
  {
      if (req.readyState == 4 && req.status == 200)
      {
          callback(JSON.parse(req.responseText)); // Another callback here
      }
  };
  req.send()
}
