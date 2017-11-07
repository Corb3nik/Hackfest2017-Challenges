# Repeater (50 points)

I've created `Repeater` as a very simple introduction to Burpsuite
and the internals of an HTTP request.

The challenge was pretty straightforward, the goal being to craft a request
with the following specifications :
- HTTP verb has to be `BURPSUITE`
- A request header `X-Flag` needs to be set to `true`

I'll spare you the details on how to get Burpsuite setup, so here's what
the request should look like.

```
BURPSUITE / HTTP/1.1
Host: localhost
X-Flag: true
```

Finally, you'll receive the flag :
```
HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 00:55:29 GMT
Server: Apache/2.4.10 (Debian)
X-Powered-By: PHP/7.0.23
Vary: Accept-Encoding
Content-Length: 422
Content-Type: text/html; charset=UTF-8


// Congratulations!

// There are 3 things to take away from this challenge.

// 1. There is such a thing called HTTP headers
// 2. There is such a thing called HTTP methods/verbs
// 3. Use Burpsuite, it'll be your best friend when doing web app security :)

HF-722011233aade2887366ab43848521a7

// ...

// If you didn't use Burpsuite for this challenge :
// https://portswigger.net/burp/help/suite_gettingstarted.html
```
