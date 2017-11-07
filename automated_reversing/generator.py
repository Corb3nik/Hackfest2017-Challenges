#!/usr/bin/env python

from pwn import *
from random import *

text = """
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. The flag is HF-f1dc911096162fbfb1809a199a1c4446. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. I stole this idea directly from Defcon Quals 2016. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. 
"""

context(arch='amd64') 

for i, c in enumerate(text):
	key = randint(1, 100)
	check = key ^ ord(c)
	
	code = """
		push 0
		push 5
		mov rdi, rsp
		mov rax, 0x23
		syscall
		pop rax
		pop rax
		mov rax, [rsp + 0x10]
		mov dl, byte ptr [rax]

		xor dl, {}
		cmp dl, {}
		jne error
		mov rdi, 0 
		mov rax, 0x3c
		syscall
		error:
			mov rdi, 1 
			mov rax, 0x3c
			syscall
	""".format(key, check)

	with open("binaries/binary{}".format(i), "w") as f:
		elf = make_elf(asm(code))
		f.write(elf)

