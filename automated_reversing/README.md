# Automated Reversing (100 points)

`Automated Reversing` is both a reversing and scripting challenge.

You're given a zip file containing 1000 64-bit ELF executables.

```
$ file binary0
binary0: ELF 64-bit LSB executable, x86-64, version 1 (SYSV), statically linked, stripped
```

By reversing 2 or 3 of them (statically and dynamically), you should
notice that the binaries are exactly the same with the exception of 2 bytes.
Let's take a look at the disassemby.

Below you'll find the offset in the file as the first column as well
as the hex representation and the actual instruction in the second
and third column respectfully.

```
00000000006000b0 <.shellcode>:
  6000b0:       6a 00                   push   0x0
  6000b2:       6a 05                   push   0x5
  6000b4:       48 89 e7                mov    rdi,rsp
  6000b7:       48 c7 c0 23 00 00 00    mov    rax,0x23
  6000be:       0f 05                   syscall
  6000c0:       58                      pop    rax
  6000c1:       58                      pop    rax
  6000c2:       48 8b 44 24 10          mov    rax,QWORD PTR [rsp+0x10]
  6000c7:       8a 10                   mov    dl,BYTE PTR [rax]
  6000c9:       80 f2 41                xor    dl,0x41
  6000cc:       80 fa 0d                cmp    dl,0xd
  6000cf:       75 10                   jne    0x6000e1
  6000d1:       48 c7 c7 00 00 00 00    mov    rdi,0x0
  6000d8:       48 c7 c0 3c 00 00 00    mov    rax,0x3c
  6000df:       0f 05                   syscall
  6000e1:       48 c7 c7 01 00 00 00    mov    rdi,0x1
  6000e8:       48 c7 c0 3c 00 00 00    mov    rax,0x3c
  6000ef:       0f 05                   syscall
```

Essentially, the binary sleeps for 5 secondes :

```
  6000b0:       6a 00                   push   0x0
  6000b2:       6a 05                   push   0x5
  6000b4:       48 89 e7                mov    rdi,rsp
  6000b7:       48 c7 c0 23 00 00 00    mov    rax,0x23
  6000be:       0f 05                   syscall
```

... takes the first character of `argv[1]` and loads it into `dl`:

```
  6000c2:       48 8b 44 24 10          mov    rax,QWORD PTR [rsp+0x10]
  6000c7:       8a 10                   mov    dl,BYTE PTR [rax]
```

... then does a bitwise `xor` with a certain number and compares it
against another number :
```
6000c9:       80 f2 41                xor    dl,0x41
6000cc:       80 fa 0d                cmp    dl,0xd
```

If both numbers match, the binary returns 0, which is a
[successful exit](https://stackoverflow.com/questions/9426045/difference-between-exit0-and-exit1-in-python).
In the example above, by doing the opposite operation, we can obtain the
value of `argv[1]` that needs to be given in order to pass the check.

Python snippet :
```
>>> chr(0x41 ^ 0xd)
'L'
```

## Automation

The whole process of disassembling the binary, reading the 2 values
(0x41 and 0xd) and doing the opposite operation is what we want to do
on all the 999 other binaries.

So the challenge becomes : How do we extract the values `0x41` and `0xd`?

If we look back at our disassembly :
```
6000c9:       80 f2 41                xor    dl,0x41
6000cc:       80 fa 0d                cmp    dl,0xd
```

The `0x41` value can be seen as the 3rd value starting from `c9`.

The `0xd` value can be seen as the 3rd value starting from `cc`.

(I'm ommiting the 6000 part, since we don't need them to get the
actual offsets)

This means that we can obtain both values by reading the binary
and getting the values from offsets (0xc9 + 2) and (0xcc + 2).

Finally, implement it in a python script :

```
#!/usr/bin/env python

flag = ""
for i in xrange(1000):
    path = "binaries/binary{}".format(i)
    print i
    with open(path, "r") as f:
        binary = f.read()
        key = binary[0xcb] # 0xc9 + 2
        check = binary[0xce] # 0xcc + 2
        flag += chr(ord(check) ^ ord(key))

print flag
```

Run it and get your flag :

```
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. The flag is HF-f1dc911096162fbfb1809a199a1c4446. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. I stole this idea directly from Defcon Quals 2016. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.
```
