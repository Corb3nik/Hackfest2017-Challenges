# EZ Flag Reloaded (25 points)

This challenge was an encoding exercice.
The goal was to access a file which name contained a few special characters.

```
http://localhost:17000/can_y#u_get_the_flag?!
```

In the HTTP specifications, a couple of characters are reserved and have
special meaning : https://www.w3.org/Protocols/HTTP/1.0/spec.html#URI-syntax

In our case, the characters `#` and `?` have a particular significance and
are interpreted differently by the browser and web server.

To prevent these characters from being interpreted, the solution is to
[URL-encode them](https://meyerweb.com/eric/tools/dencoder/).

By encoding them, we obtain `http://localhost:17000/can_y%23u_get_the_flag%3f!`,
which when visited will give you the flag.

```
// Good job!
// Keep this in mind when doing web challenges ;)
// https://www.w3.org/Protocols/HTTP/1.0/spec.html#URI-syntax
HF-4e30753d28058aab0b6f55c393195e9c
```
