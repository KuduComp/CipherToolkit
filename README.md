# CipherToolkit

<<<<<<< HEAD
####Description

PHP class library with plenty of hand ciphers. Hand ciphers where used in pre computer days to exchange secret communications. They could as simple as replacing on character with another. Hand ciphers were still in use in World War II. Using this ciphers can still be fun. One of the reasons I wrote this library is just for fun and in some cases it comes in handy. As a fanatical geocacher I often have to solve mysterie caches that are encoded with some archaic hand cipher.

####Example
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


####Available ciphers
=======
PHP class library with plenty of hand ciphers.
>>>>>>> 9b323570d1c02ab027a6bf6ec935b75537399708

Abstract class containing common functions, functions encode and decode should be implemented.

Dummy cipher - no encoding or decoding

<<<<<<< HEAD
Simple substitution cipher
=======
Simple 1 on 1 substitution cipher
>>>>>>> 9b323570d1c02ab027a6bf6ec935b75537399708
- Generic version using an alphabet
- Atbash cipher (reversed alphabet)
- Affine cipher (uses function y = ax + b)
- Caesar cipher (rotated alphabet, default 13)
<<<<<<< HEAD
- Ragbaby cipher (advanced substitution taking into account position)

Polygraphic substitution
- Playfair (replaces digrams)
- Foursquare cipher (replaces digrams)
- Condi cipher (advanced substitution working on consecutive digrams)

Simple 1 to many substitution ciphers (each character is substituted with two or more)
=======

Simple 1 to many substitution ciphers
- Generic version using an array of translations
>>>>>>> 9b323570d1c02ab027a6bf6ec935b75537399708
- Kenny code
- Morse code
- Polybius cipher (uses a square)
- Nihilist cipher (a variant of the Polybius cipher)

<<<<<<< HEAD
Polyalphabetic substitution ciphers
- Vigenere cipher
- Gronsfield cipher
- Beaufort cipher
- Autokey cipher
- Keyed vigenere cipher
- Quagmire I, II, III and IV
- Porta cipher (reciprocal cipher using 13 alphabets)

Transposition ciphers
- Double transposition cipher
- Swagman cipher
- Cadenus cipher
- Nicodemus cipher (Vigenere combined with columnar transposition)

More complex ciphers
- Bifid cipher    (Substitution cipher combined with fractionation)
- Trifid cipher   (Substitution cipher combined with fractionation)
- ADFG(V)X cipher (Polybius cipher combined with columnar transposition)
- One time pad    (the only truly unbreakable cipher)


=======
Polyalphabetic ciphers
- Vigenere cipher
- Gronsfield cipher
- Autokey cipher
- Keyed vigenere cipher
- Quagmire I, II, III and IV

Fractionating complex ciphers
- Bifid cipher
- Trifid cipher
- ADFG(V)X cipher

Polygraphic substitution
- Playfair (replaces digrams)
>>>>>>> 9b323570d1c02ab027a6bf6ec935b75537399708
