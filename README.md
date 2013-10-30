Couch-Beard
===========

Website connecting couchpotato and sickbeard into a single website. Using Wordpress CMS for greater user management, plugins etc.

Search for movies and TV shows with a single search bar. The search bar is using IMDB to search for movies and tv shows. 

Share your movie and TV collection from XBMC on the website and view server information.


Feel free to donate to the project or add issues. [![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=XJZJGF4U9SGHW&lc=DK&item_name=CouchBeard&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted)

![preview thumb](http://i.imgur.com/Mk4qKtO.png)

![preview thumb](http://i.imgur.com/XIeuwlb.png)

![preview thumb](http://i.imgur.com/RBupXCZ.png)

![preview thumb](http://i.imgur.com/KsFrWEG.png)


Installation
===========
First you need an apache server with PHP 5.3 or above and MySQL database. cURL has to be enabled in php.ini (;extension=php_curl.dll)

This could be more simple and should be in future releases.

1. Download this repo.
2. Open browser and connect go to host (e.g. localhost/<couchbeard_path>)
3. Enter database informations and site informations.
4. Login to the website.
5. Go to 'Tools/Import' and choose 'Wordpress'. Select 'backup.xml' from the repo directory and submit.
6. Go to 'Appearance/Themes' and activate 'couchbeard'
7. Go to 'Appearance/Menus' and add 'User' to 'User menu' and 'Guest' to 'Guest menu'
8. Go to 'Plugins' and activate following plugins:
 * jQuery Updater
 * Couch Beard APIs
9. Now go to CouchBeard to enter application informations.


License
===========
[CC BY-NC-SA 3.0](http://creativecommons.org/licenses/by-nc-sa/3.0/deed)

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/dk/cgi-bin/webscr?cmd=_flow&SESSION=D1UVPvXkDBbeUoW-pOIiviXJAFT2PmPIe7CjjuYi_MYkRgvAid0ZjL32lrG&dispatch=5885d80a13c0db1f8e263663d3faee8d14f86393d55a810282b64afed84968ec)

