# gc-coolstuff/ciphers

PHP class library with plenty of hand ciphers.

Abstract class containing common functions, functions encode and decode should be implemented.

Dummy cipher - no encoding or decoding

Simple 1 on 1 substitution cipher
- Generic version using an alphabet
- Atbash cipher (reversed alphabet)
- Caesar cipher (rotated alphabet, default 13)

Simple 1 to many substitution ciphers
- Generic version using an array of translations
- Kenny code
- Morse code
- Polybius cipher (uses a square)

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
