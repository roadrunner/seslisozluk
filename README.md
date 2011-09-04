Seslisozluk PHP Library
=============

I have use terminal a lot. And it's really pain for me to look up definition of a word from a browser or other external programs.


Configuration
-------

Default ini configuration;

[general]
auto_play_pronounciation = false

[filter]
from = en
to = tr,es

[database]
dsn = sqlite:/opt/databases/seslisozluk.sq3



Contributing
------------

Want to contribute? Great! Fork the project.


Usage
-----
	First create alias for command-line script.
	
	alias seslisozluk='~/github/seslisozluk/src/seslisozluk'
	
	seslisozluk engaged en tr

	if you want to make default some options; create ini file /etc/seslisozluk.ini or ~/.seslisozluk.ini



Planned Features
-------

- long and short options for command-line tool.( ex; seslisozluk -f en -t tr,es --auto-play=false 'engaged')
- colored output
- maybe interactive shell? (like ruby's irb or PHP_Shell)
- local database; it will work as a local cache of the definitions and speed up the lookups.
- usage and lookup statistics; which will store some kind of datas for analyzing how often you look up a specific word and what you trying to learn.
- adding some notes and sample sentences for a phrase. and maybe search in them?
- adding support for more player to play files of pronunciation mp3s. 
