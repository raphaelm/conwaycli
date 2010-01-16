#!/usr/bin/env python
# Copyright 2009 Raphael Michel <http://www.raphaelmichel.de>
# It's public domain. But please do not remove this note
# Usage:
# ./gameoflife.py [timeout [width [height]]]
# Examples:
#      ./gameoflife.py
#      ./gameoflife.py 2
#      ./gameoflife.py 5 60
#      ./gameoflife.py 1 70 26

import sys
import random
import os
import time

class gol:
    def initfield(self, width, height):
        field = [False] * height
        for i in range(0, height):
            field[i] = [False] * width
            
        for y in range(0, height):
            for x in range(0, width):
                if random.randint(0,1):
                    field[y][x] = True
                else:
                    field[y][x] = False
        return field
    
    def print_field(self, field, width, height):
        if os.name == 'nt':
            os.system('cls')
        else:
            os.system('clear')
        for y in range(0, height):
            for x in range(0, width):
                if field[y][x]:
                    sys.stdout.write(' ')
                else:
                    sys.stdout.write('X')
            print ""
    
    def nextgen(self, field, width, height):
        newfield = field
        for y in range(0, height):
            for x in range(0, width):
                neighbours = 0
                cell = field[y][x]
                try:
                    if field[y-1][x-1]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y][x-1]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y-1][x]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y+1][x+1]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y+1][x]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y][x+1]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y-1][x+1]:
                        neighbours += 1
                except:
                    a = 1
                try:
                    if field[y+1][x-1]:
                        neighbours += 1
                except:
                    a = 1
                
                if (cell and (neighbours <= 1 or neighbours >= 4)): cell = False
                elif (not cell and neighbours == 3): cell = True
                else: cell = cell
                
                newfield[y][x] = cell
        return newfield
    def start(self, width, height, timeout):
        i = 0
        field = self.initfield(width, height)
        while True:
            field = self.nextgen(field, width, height)
            self.print_field(field, width, height)
            print("Generation "+str(i)+" | Conway's Game of Life | Python-Random-Implementation")
            i = i+1
            time.sleep(timeout)

g = gol()
if len(sys.argv) == 1:
    width = 50
    height = 20
    timeout = 2
elif len(sys.argv) == 1:
    width = 50
    height = 20
    timeout = int(sys.argv[1])
elif len(sys.argv) == 2:
    width = int(sys.argv[2])
    height = 20
    timeout = int(sys.argv[1])
elif len(sys.argv) == 3:
    width = int(sys.argv[2])
    height = int(sys.argv[3])
    timeout = int(sys.argv[1])

g.start(width, height, timeout)
