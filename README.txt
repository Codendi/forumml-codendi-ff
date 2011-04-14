ForumML

ForumML is a contraction of "Forum - Mailing List".
The goal of the plugin is to add forum-like behaviors to mailing lists.

ForumML is a plugin that adds a web interface to mailing list archives.
It makes it easier to browse and search mailing lists.
It also provides a way to post to a list from the web interface.
In this case, Codendi uses your login email adress to post to the list.
The actual acceptance/distribution/archival of the message still 
depends on mailman configuration.


==== INSTALLATION ===

bin/install.sh should have installed the required PEAR packages.


==== Importing existing list archives ====

## To import ML archives of specific projects, into ForumML DB, 
run 'mail_2_DB.php' script.
1st argument: list name
2nd argument: 2
$> /usr/share/codendi/src/utils/php-launcher /usr/share/codendi/plugins/forumml/bin/mail_2_DB.php codex-support 2

## To import ML archives of all Codendi projects, for which the plugin is enabled
run 'ml_arch_2_DB.pl' script:
$> /usr/share/codendi/plugins/forumml/bin/ml_arch_2_DB.pl


