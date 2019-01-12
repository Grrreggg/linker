# linker
Installation:
1 - create database with table 'links' (InnoDB	utf16_general_ci would be fine)
2 - table 'links' shoud have 3 columns: id (int, primary, 10), url_short (text), url_real(text)
*or you can just import links.cs file*
3 - edit db.config file according to your host and database parameters
4 - edit .htaccess string RewriteRule (.*) [YOUR HOME URL]/index.php?$1 [QSA,L]
5 - done, now you can use linker


