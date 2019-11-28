# CipherToolkit

#### Description

PHP class library with plenty of hand ciphers. Hand ciphers where used in pre computer days to exchange secret communications. They could as simple as replacing on character with another. Hand ciphers were still in use in World War II. Using this ciphers can still be fun. One of the reasons I wrote this library is just for fun and in some cases it comes in handy. As a fanatical geocacher I often have to solve mysterie caches that are encoded with some archaic hand cipher.

#### Example
---
    use cipher;
    $c = new Caesarcipher();
    echo $c->encode("the quick brown fox jumps over the lazy dog");
    echo $c->decode("gur dhvpx oebja sbk whzcf bire gur ynml qbt");
---

All ciphers use defaults which can be accessed using get and set functions

---
    $c->setalphabet("aeioubcdfghjklmnpqrstvwxyz");
    echo $c->getalphabet();
---


#### Available ciphers

Abstract class containing common functions, functions encode and decode should be implemented.
Dummy cipher - no encoding or decoding

###### Simple substitution ciphers, replace 1 by 1
- Generic version using an alphabet
- Atbash cipher (reversed alphabet)
- Affine cipher (uses function y = ax + b)
- Caesar cipher (rotated alphabet, default 13)
- Ragbaby cipher (more advanced substitution taking into account position)

###### Simple substitution ciphers, replace 1 with many
- Generic version using an array of substitutions
- Kenny code
- Morse code

###### Polygraphic substitution (substitutes more than one character at a time)
- Playfair (replaces digrams)
- Foursquare cipher (replaces digrams)
- Condi cipher (advanced substitution working on consecutive digrams)

###### Polyalphabetic substitution ciphers
- Vigenere cipher
- Gronsfield cipher
- Beaufort cipher
- Autokey cipher
- Keyed vigenere cipher
- Quagmire I, II, III and IV
- Porta cipher (reciprocal cipher using 13 alphabets)

###### Transposition ciphers
- Double transposition cipher
- Swagman cipher
- Cadenus cipher
- Nicodemus cipher (Vigenere combined with columnar transposition)

###### More complex ciphers (combinations of techniques above)
- Bifid cipher    (Substitution cipher combined with fractionation)
- Trifid cipher   (Substitution cipher combined with fractionation)
- ADFG(V)X cipher (Polybius cipher combined with columnar transposition)
- One time pad    (the only truly unbreakable cipher)
