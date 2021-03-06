#https://gist.github.com/zekus/665115


## Start user editable variables
BACKUPDIR="/var/www/localhost/web/vietmy_sql"		# backup directory
BACKUPUPLOAD="/var/www/local/web"			# upload DIR
BACKUPUPNAME="upload"                                   # upload DIR
DBNAME="dbname"                                         # database name
DBUSER="username"					# database user
DBPASS="password"                                       # database password
TAR=`which tar`						# name and location of tar
ARG="-cjpSPf"		#sparse                         # tar arguments P = removed / 
tmpdir="/var/www/localhost/tmp"				# temp dir for database dump and other stuff
## End user editable variables

########### make needed directories if not exist #############
if [ ! -d $BACKUPDIR/ ] ; then
	exit 0
fi
if [ ! -d $tmpdir/ ] ; then
	mkdir $tmpdir/
fi
if [ ! -d $BACKUPDIR/db/ ] ; then
	mkdir $BACKUPDIR/db/
fi
if [ ! -d $BACKUPDIR/db/daily/ ] ; then
	mkdir $BACKUPDIR/db/daily/
fi
if [ ! -d $BACKUPDIR/db/weekly/ ] ; then
	mkdir $BACKUPDIR/db/weekly/
fi

FDATE=`date +%F`		# Full Date, YYYY-MM-DD, year sorted, eg. 2009-11-21
WDAY=`date +%w`			#Day of week (0 for sunday)

########### backup database #############

# check and fix any errors found
mysqlcheck -u$DBUSER -p$DBPASS --all-databases --optimize --auto-repair --silent 2>&1
# Starting database dumps
for i in `mysql -u$DBUSER -p$DBPASS -Bse 'show databases'`; do
	if [ $i = $DBNAME ] ; then
            `mysqldump -u$DBUSER -p$DBPASS $i --allow-keywords --comments=false --add-drop-table > $tmpdir/db-$i-$FDATE.sql`
            ### `mysqldump -u$DBUSER -p$DBPASS $i --allow-keywords --comments=false --add-drop-table=false --no-create-info --complete-insert > $tmpdir/db-$i-$FDATE.sql`
            ##backup file on date
            if [ -f $BACKUPDIR/db/daily/$i.tar.bz2 ] ; then
                    rm -rf $BACKUPDIR/db/daily/$i.tar.bz2
            fi
            $TAR $ARG $BACKUPDIR/db/daily/$i-$FDATE.tar.bz2 -C $tmpdir db-$i-$FDATE.sql -C $BACKUPUPLOAD $BACKUPUPNAME
            #remove file tmp
            rm -rf $tmpdir/db-$i-$FDATE.sql
	fi
done

# all done
# Remove older backups (> 8 days),
# unless you want to run out of drive space
 find $BACKUPDIR/db/daily -mtime +5 -print0 | xargs -0 rm -rf

exit 0