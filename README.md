MiPi
=============

This repo has the source code to the MiPi site. mySQL connection information is omitted.

Model
-------

### People
![Person UML Diagram](http://yuml.me/569d1c3e)
<!---
[Person]^-[Member],
[Member]^-[AM],
[Member]^-[Brother],
[Member]^-[Alumni]
[Person]^-[Rushee]
-->

View
------------

![Page Build UML Diagram](http://yuml.me/f5c55af0)
<!---
[Template]++->[Page],
[Page]^-[AdminPage],
[Page]^-[PopupSplit],
[Page]++->[Box],
[Box]++->[<<BoxContent>>]
-->

### Commands
