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
  6000c9:       80 f2 05                xor    dl,0x5
  6000cc:       80 fa 0f                cmp    dl,0xf
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

