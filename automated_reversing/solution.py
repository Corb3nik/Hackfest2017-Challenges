#!/usr/bin/env python

from pwn import *

flag = ""
for i in xrange(1000):
    path = "binaries/binary{}".format(i)
    print i
    with open(path, "r") as f:
        binary = f.read()
        key = binary[0xcb]
        check = binary[0xce]

        flag += chr(ord(check) ^ ord(key))

print flag
