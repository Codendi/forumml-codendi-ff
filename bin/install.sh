#!/usr/bin/env bash


if [ "X${CAT}" == "X" ];then
CAT=/bin/cat
fi

if [ "X${INSTALL}" == "X" ];then
INSTALL=/usr/bin/install
fi

if [ "X${SERVICE}" == "X" ];then
SERVICE=/sbin/service
fi

if [ "X${PEAR}" == "X" ];then
PEAR=/usr/bin/pear
fi

if [ "X${USER_WWW}" == "X" ];then
USER_WWW=codendiadm
fi
if [ "X${GROUP_WWW}" == "X" ];then
GROUP_WWW=codendiadm
fi

echo "#################################"
echo "# #"
echo "# ForumML Plugin install #"
echo "# #"
echo "#################################"

SCRIPT_DIR=`dirname $0`

# Mailman rpms
#
# Already installed ?


## Install ForumMl temp dir
$INSTALL -d -g $GROUP_WWW -o $USER_WWW -m 00750 /var/run/forumml

## ForumMl data dir
$INSTALL -d -g $GROUP_WWW -o $USER_WWW -m 00750 /var/lib/codendi/forumml

## Install ForumMl hook
$INSTALL -g $GROUP_WWW -o $USER_WWW -m 06755 /usr/share/codendi/plugins/forumml/bin/mail_2_DB.pl /usr/lib/codendi/bin

## Install some pear packages
# What if no internet access?
cd $SCRIPT_DIR/../PEAR
$PEAR upgrade --force --offline PEAR-1.9.0.tgz Archive_Tar-1.3.3.tgz Console_Getopt-1.2.3.tgz XML_Util-1.2.1.tgz Structures_Graph-1.0.2.tgz 
$PEAR upgrade --force --offline Mail-1.1.14.tgz Mail_Mbox-0.6.1.tgz Mail_mimeDecode-1.5.0.tgz Mail_Mime-1.5.2.tgz

## Update Mailman config to enable the Hook
grep -q ^PUBLIC_EXTERNAL_ARCHIVER /usr/lib/mailman/Mailman/mm_cfg.py
if [ $? -ne 0 ]; then
  $CAT <<EOF >> /usr/lib/mailman/Mailman/mm_cfg.py
# ForumML Plugin
PUBLIC_EXTERNAL_ARCHIVER = '/usr/lib/codendi/bin/mail_2_DB.pl %(listname)s ;'
PRIVATE_EXTERNAL_ARCHIVER = '/usr/lib/codendi/bin/mail_2_DB.pl %(listname)s ;'

EOF

fi


## restart mailman
$SERVICE mailman restart

exit 0

