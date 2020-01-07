# CipherToolkit

#### Description

PHP class library with plenty of hand ciphers. Hand ciphers where used in pre computer days to exchange secret communications. They could be as simple as replacing one character with another. Hand ciphers were still in use in World War II and even in use during the Cold War. Using these ciphers can still be fun. One of the reasons I wrote this library is for fun and in some cases it comes in handy. As a fanatical geocacher I often have to solve mysterie caches that are encoded with some archaic hand cipher.

#### Example
---
    use cipher\caesarcipher;
    $c = new caesarcipher();
    echo $c->encode("the quick brown fox jumps over the lazy dog");
    echo $c->decode("gur dhvpx oebja sbk whzcf bire gur ynml qbt");
---

All ciphers use defaults which can be accessed using get and set functions

---
    $c->setalphabet("aeioubcdfghjklmnpqrstvwxyz");
    echo $c->getalphabet();
---


#### Available ciphers

Abstract class containing common functions, functions encode and decode should be implemented. It also contains all the functions for substitution, transposition, fractionation, formatting and cleaning message, generating keys and some other stuff. You can use these to build your own unique cipher.

###### Simple substitution ciphers, replace 1 by 1
- Generic version using an alphabet
- Caesar cipher (shifted alphabet, default 13)
- Vatsyayana or kamasutra cipher (13 paired letters)
- Atbash cipher (reversed alphabet)
- Affine cipher (uses function y = ax + b)
- Ragbaby cipher (more advanced substitution taking into account position)

###### Simple substitution ciphers, replace 1 with many
- Generic version using an array of substitutions
- Kenny code
- Morse code
- Shadok numbers (funny transcription of numbers based on a French cartoon)
- Fractionated morse cipher (morse code with some fractionation)
- Morbit cipher (morse code with another fractionation)
- Polybius cipher (using a square)
- Nihilist substitution cipher (a variant on Polybius)
- Collon cipher (a variant on Polybius)
- Straddling checkerboard (with a light version of fractionation)
- Monome-dinome (with a light version of fractionation)

###### Polygraphic substitution (substitutes more than one character at a time)
- Playfair (replaces digrams)
- Foursquare cipher (replaces digrams)
- Condi cipher (substitution working on consecutive digrams)
- Portax cipher (polygraphic, polyalphabetical)
- Digraphfid cipher (digrams with fractionation)

###### Polyalphabetic substitution ciphers
- Vigenere cipher
- Gronsfield cipher
- Beaufort cipher
- Autokey cipher
- Keyed vigenere cipher
- Quagmire I, II, III and IV
- Phillips cipher (uses 8 Polybius squares)
- Porta cipher (reciprocal cipher using 13 alphabets)
- Pollux cipher (morse code encoded as digits/letters)
- Jefferson wheel cipher
- Chaocipher (a cipher with dynamically changing alphabets)
- Zygazyfa (a cipher with dynamically changing alphabets) 

###### Transposition ciphers
- Skytale (rows become columns, very easy)
- Columnar transposition cipher
- Double transposition cipher
- Swagman cipher
- Cadenus cipher
- Nihilist transposition (transposition of columns followed by rows)

###### More complex ciphers (combinations of techniques above)
- Nicodemus cipher (Vigenere combined with columnar transposition)
- Bifid cipher    (Substitution cipher combined with fractionation)
- Trifid cipher   (Substitution cipher combined with fractionation)
- ADFG(V)X cipher (Polybius cipher combined with columnar transposition)
- One time pad    (the only truly unbreakable cipher)
