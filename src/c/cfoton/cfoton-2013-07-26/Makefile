# Mój plik makefile - wpisz 'make all' aby skompilowaæ ca³y program
CC = gcc  

all : gen.o main.o 
	$(CC) gen.o main.o -lm -o gen
  
gen.o : gen.c
	$(CC) gen.c -c -o gen.o 

main.o : main.c
	$(CC) main.c -c -o main.o

clean:
	rm -f *.o gen
 
 