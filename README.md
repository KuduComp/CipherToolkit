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
    $c->setkey("thisisakey");
    echo $c->getkey();
---


#### Available ciphers

Abstract class containing common functions, functions encode and decode should be implemented. It also contains all the functions for substitution, transposition, fractionation, formatting and cleaning message, generating keys and some other stuff. You can use these to build your own unique cipher.

###### Simple substitution ciphers, replace 1 by 1
- Generic version using an alphabet
- Atbash cipher (reversed alphabet)
- Affine cipher (uses function y = ax + b)
- Bazeries cipher (split message, reverse chunks and then substitute)
- Caesar cipher (shifted alphabet, default 13)
- Ragbaby cipher (more advanced substitution taking into account position)
- Vatsyayana or kamasutra cipher (13 paired letters)

###### Codes (not really ciphers)
- Base91 code (similar to Base64 or uuencode)
- Bibi-binary numbers
- Kenny code (as if Kenny from Southpark is talking)
- Morse code
- Shadok numbers (funny transcription of numbers based on a French cartoon)

###### Simple substitution ciphers, replace 1 with many
- Generic version using an array of substitutions
- Collon cipher (a variant on Polybius)
- Fractionated morse cipher (morse code with some fractionation)
- Monome-dinome (with a light version of fractionation)
- Morbit cipher (morse code with another fractionation)
- Nihilist substitution cipher (a variant on Polybius)
- Polybius cipher (using a square)
- Straddling checkerboard (with a light version of fractionation)

###### Polygraphic substitution (substitutes more than one character at a time)
- Condi cipher (substitution working on consecutive digrams)
- Digrafid cipher (digrams with fractionation)
- Foursquare cipher (replaces digrams)
- Hill cipher (uses a n x n matrix to convert n-grams)
- Playfair (replaces digrams)
- Portax cipher (polygraphic, polyalphabetical)
- Trisquare cipher (replaces digrams with trigrams)

###### Polyalphabetic substitution ciphers
- Autokey cipher
- Beaufort cipher
- Chaocipher (a cipher with dynamically changing alphabets)
- Gronsfield cipher
- Jefferson wheel cipher
- Keyed vigenere cipher
- Quagmire I, II, III and IV
- Phillips cipher (uses 8 Polybius squares)
- Pollux cipher (morse code encoded as digits/letters)
- Porta cipher (reciprocal cipher using 13 alphabets)
- Vigenere cipher
- Zygazyfa (a cipher with dynamically changing alphabets) 

###### Transposition ciphers
- Cadenus cipher
- Columnar transposition cipher
- Double transposition cipher
- Myszkowski transposition (a variant on columnar transposition)
- Nihilist transposition (transposition of columns followed by rows)
- Skytale (rows become columns, very easy)
- Swagman cipher

###### More complex ciphers (combinations of techniques above)
- ADFG(V)X cipher (Polybius cipher combined with columnar transposition)
- Bifid cipher    (Substitution cipher combined with fractionation)
- Nicodemus cipher (Vigenere combined with columnar transposition)
- One time pad    (the only truly unbreakable cipher)
- Trifid cipher   (Substitution cipher combined with fractionation)
